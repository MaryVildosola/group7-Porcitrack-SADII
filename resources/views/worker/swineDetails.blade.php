@extends('layouts.worker')

@section('content')
<style>
    /* Clean white/slate field-grade background */
    .worker-dash { background: #f8fafc; }
</style>

<div class="worker-dash min-h-screen">
<div class="p-6 md:p-12 mt-16 md:mt-0">
    
    <!-- HEADER -->
    <div class="mb-10 flex items-start justify-between gap-4 flex-wrap">
        <div>
            <h1 class="text-4xl font-black tracking-tight text-slate-900">Animal <span class="text-green-600">Registry</span></h1>
            <p class="text-slate-400 font-medium mt-2 text-sm uppercase tracking-wide">Select a pen to manage individual animals.</p>
        </div>
        <!-- CONNECTION STATUS -->
        <div id="conn-status" class="flex items-center gap-2 px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-widest bg-green-50 text-green-700 border border-green-200">
            <span id="conn-dot" class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
            <span id="conn-label">Online</span>
        </div>
    </div>

    <!-- OFFLINE SYNC BANNER (hidden when online) -->
    <div id="offline-banner" class="hidden mb-6 p-4 rounded-2xl flex items-center gap-4"
         style="background:#fffbeb; border:2px solid #fde68a;">
        <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
            <i class='bx bx-wifi-off text-amber-600 text-xl'></i>
        </div>
        <div class="flex-1">
            <p class="font-black text-amber-800 text-sm uppercase tracking-wide">You're Offline</p>
            <p class="text-amber-700 text-xs font-bold mt-0.5">Check-ins are saved on this device. They will sync automatically when you reconnect.</p>
        </div>
        <div id="pending-count" class="shrink-0 px-3 py-1.5 rounded-xl bg-amber-200 text-amber-800 font-black text-sm">0 pending</div>
    </div>

    <!-- PEN GRID -->
    <div id="penGridView" class="animate-fade-in grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($pens as $pen)
        <div onclick="enterPen({{ $pen->id }}, '{{ $pen->name }}', {{ json_encode($pen->pigs) }})"
            class="dash-card backdrop-blur-2xl bg-white/80 border border-slate-100 p-8 rounded-[2.5rem] hover:border-green-500/50 hover:shadow-xl transition-all cursor-pointer">
            
            <div class="w-16 h-16 rounded-3xl bg-green-600 text-white flex items-center justify-center mb-6 shadow-xl">
                <i class='bx bxs-grid-alt text-3xl'></i>
            </div>

            <h3 class="text-3xl font-black text-slate-900 tracking-tighter mb-1">{{ $pen->name }}</h3>
            <p class="text-[10px] font-black text-green-500 uppercase tracking-[0.2em]">{{ count($pen->pigs) }} Animals Active</p>
        </div>
        @endforeach
    </div>

    <!-- PIG LIST -->
    <div id="pigListView" class="hidden animate-fade-in space-y-8 pb-32">
        <div class="flex items-center gap-4">
            <button onclick="exitPen()" class="w-12 h-12 rounded-2xl dash-inner flex items-center justify-center">
                <i class='bx bx-left-arrow-alt text-2xl text-white'></i>
            </button>
            <div>
                <h2 id="currentPenName" class="text-3xl font-black text-slate-900">Pen</h2>
                <p class="text-[10px] font-bold text-green-500 uppercase tracking-widest">Inventory List</p>
            </div>
        </div>

        <div id="pigsContainer" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
    </div>

</div>
</div>

<!-- PIG RECORD MODAL (LARGER FORMAT) -->
<div id="pigModalOverlay" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 md:p-8">
    <div onclick="hidePigModal()" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

    <div id="modalLoader" class="absolute inset-0 z-[110] hidden flex flex-col items-center justify-center gap-6 animate-fade-in pointer-events-none">
        <div class="w-16 h-16 border-4 border-green-500 border-t-transparent rounded-full animate-spin shadow-[0_0_50px_rgba(34,197,94,0.3)]"></div>
        <p class="text-[10px] font-black text-white uppercase tracking-[0.5em] drop-shadow-[0_2px_4px_rgba(0,0,0,0.5)]">Loading...</p>
    </div>

    <div id="pigModalContent" class="relative z-10 w-full max-w-5xl animate-fade-in shadow-[0_50px_100px_rgba(0,0,0,0.5)] flex flex-col overflow-hidden">
        {{-- Injected via JS --}}
    </div>
</div>


<script>

// ═══════════════════════════════════════════════
// PAGE-SPECIFIC OFFLINE UI
// ═══════════════════════════════════════════════
function updateOfflineUI() {
    const q = getQueue();
    const banner  = document.getElementById('offline-banner');
    const pending = document.getElementById('pending-count');
    const dot     = document.getElementById('conn-dot');
    const label   = document.getElementById('conn-label');
    const status  = document.getElementById('conn-status');

    if(!banner) return;
    const online = navigator.onLine;

    // Status pill
    if (online) {
        status.className = 'flex items-center gap-2 px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-widest bg-green-50 text-green-700 border border-green-200';
        dot.className = 'w-2 h-2 rounded-full bg-green-500 animate-pulse';
        label.textContent = 'Online';
    } else {
        status.className = 'flex items-center gap-2 px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-widest bg-amber-50 text-amber-700 border border-amber-200';
        dot.className = 'w-2 h-2 rounded-full bg-amber-500 animate-pulse';
        label.textContent = 'Offline';
    }

    // Banner
    if (!online || q.length > 0) {
        banner.classList.remove('hidden');
        pending.textContent = q.length + ' pending';
        if (online && q.length > 0) {
            banner.style.background = '#eff6ff';
            banner.style.border = '2px solid #bfdbfe';
            banner.querySelector('p').textContent = 'Back Online — Click Synced badge to upload.';
        }
    } else {
        banner.classList.add('hidden');
    }
}

// Connectivity events are handled globally, but we refresh local UI
window.addEventListener('online',  updateOfflineUI);
window.addEventListener('offline', updateOfflineUI);
document.addEventListener('DOMContentLoaded', updateOfflineUI);

// ═══════════════════════════════════════════════
// MODAL LOGIC
// ═══════════════════════════════════════════════
let activePigId = null;

function switchPigTab(tab) {
    const actBtn = document.getElementById('tab-btn-activity');
    const medBtn = document.getElementById('tab-btn-medical');
    const actTab = document.getElementById('pig-tab-activity');
    const medTab = document.getElementById('pig-tab-medical');

    const activeStyle   = 'background:#f0fdf4; color:#15803d; border:1.5px solid #bbf7d0;';
    const inactiveStyle = 'background:#f1f5f9; color:#94a3b8; border:1.5px solid #e2e8f0;';

    if (tab === 'activity') {
        actTab.classList.remove('hidden');
        medTab.classList.add('hidden');
        actBtn.style.cssText = activeStyle;
        medBtn.style.cssText = inactiveStyle;
    } else {
        medTab.classList.remove('hidden');
        actTab.classList.add('hidden');
        medBtn.style.cssText = activeStyle;
        actBtn.style.cssText = inactiveStyle;
    }
}

let activePigsData = [];

function enterPen(id, name, pigs) {
    activePigsData = pigs; // Cache for instant modal shell
    document.getElementById('penGridView').classList.add('hidden');
    document.getElementById('pigListView').classList.remove('hidden');
    document.getElementById('currentPenName').innerText = name;

    const container = document.getElementById('pigsContainer');
    container.innerHTML = pigs.map(p => {
        const color = p.health_status === 'Sick' ? 'red' : (p.health_status === 'Warning' ? 'amber' : 'green');

        return `
        <div onclick="showFloatingCard(${p.id}, '${name}')"
            class="dash-card backdrop-blur-2xl bg-white/80 p-6 rounded-[2rem] flex justify-between items-center cursor-pointer hover:border-green-500/50 transition">

            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl dash-inner flex items-center justify-center">
                    <i class='bx bx-hash text-white'></i>
                </div>
                <div>
                    <h4 class="text-lg font-black text-slate-900">#${p.tag}</h4>
                    <span id="pig-list-health-${p.id}" class="text-xs text-${color}-400 uppercase font-black tracking-widest transition-colors">${p.health_status}</span>
                </div>
            </div>

            <i class='bx bx-chevron-right text-slate-400 text-xl'></i>
        </div>`;
    }).join('');
}

function exitPen() {
    document.getElementById('penGridView').classList.remove('hidden');
    document.getElementById('pigListView').classList.add('hidden');
}

function showFloatingCard(id, penName) {
    activePigId = id;
    const pig = activePigsData.find(p => p.id === id);
    const overlay = document.getElementById('pigModalOverlay');
    const content = document.getElementById('pigModalContent');
    const loader = document.getElementById('modalLoader');

    overlay.classList.remove('hidden');
    overlay.classList.add('flex');
    
    // INSTANT SHELL: Show profile immediately while syncing history
    content.innerHTML = `
        <div id="pig-record-card" class="bg-white w-full flex flex-col overflow-hidden" style="border-radius:2rem; box-shadow: 0 32px 80px rgba(0,0,0,0.25); max-height:88vh;">
            <div class="h-2 w-full shrink-0" style="background:#16a34a;"></div>
            <div class="flex-1 flex flex-col">
                <div class="px-8 pt-8 pb-4">
                    <p class="text-xs font-black uppercase tracking-[0.3em] mb-2" style="color:#16a34a">Animal Record</p>
                    <h1 class="font-black leading-none text-slate-900 mb-1" style="font-size:3.5rem;letter-spacing:-0.04em">#${pig.tag}</h1>
                    <p class="text-slate-400 font-bold text-sm uppercase tracking-widest">${pig.breed || 'Yorkshire'}</p>
                </div>
                <div class="flex-1 flex items-center justify-center pb-16">
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-10 h-10 border-[3px] border-green-600 border-t-transparent rounded-full animate-spin"></div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-300">Loading history...</p>
                    </div>
                </div>
            </div>
        </div>
    `;

    fetch(`/worker/pigs/${id}`)
        .then(res => res.text())
        .then(html => {
            // pigCard is a pure fragment — inject directly, no parsing needed
            content.innerHTML = html;
        })
        .catch(() => {
            content.innerHTML = '<div class="p-8 text-center text-red-500 font-black">Could not load record. Please try again.</div>';
        });
}

function hidePigModal() {
    document.getElementById('pigModalOverlay').classList.add('hidden');
    activePigId = null;
}

function openDailyCheckIn(pig) {
    Swal.fire({
        title: `<div class="text-left">
            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-green-600 mb-1">Daily Operations</p>
            <p class="font-black tracking-tighter text-3xl text-slate-900">#${pig.tag} · Check-In</p>
        </div>`,
        background: '#ffffff',
        width: '700px',
        html: `
            <div class="text-left py-4 space-y-5 max-h-[65vh] overflow-y-auto px-1">

                <!-- 🚨 URGENT ESCALATION BUTTON -->
                <div id="urgent-banner" class="rounded-2xl p-5 border-2 border-red-200 bg-red-50">
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-red-500 mb-3">🚨 Needs Immediate Attention?</p>
                    <button type="button" onclick="flagMedicalEmergency(${pig.id}, '${pig.tag}')" 
                        class="w-full py-4 rounded-xl bg-red-600 text-white font-black text-sm uppercase tracking-widest hover:bg-red-700 transition-all"
                        style="box-shadow: 0 8px 24px rgba(239,68,68,0.35)">
                        🚨 Flag as Medical Emergency — Alert Admin Now
                    </button>
                    <p class="text-[9px] text-red-400 font-bold mt-2 text-center uppercase tracking-wider">Does NOT wait for weekly report · Sends critical alert immediately</p>
                </div>

                <!-- 1. FEEDING -->
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200">
                    <label class="block text-[10px] font-black uppercase text-slate-500 mb-3 tracking-[0.2em]">1. Feeding Status</label>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" onclick="setCheckVal('feed','Active')" id="btn-feed-Active"
                            class="check-btn flex flex-col items-center py-4 px-2 bg-white border-2 border-slate-200 rounded-xl transition-all">
                            <i class='bx bx-bowl-hot text-2xl mb-1 text-green-500'></i>
                            <span class="text-[9px] font-black uppercase">Finished All</span>
                        </button>
                        <button type="button" onclick="setCheckVal('feed','Normal')" id="btn-feed-Normal"
                            class="check-btn flex flex-col items-center py-4 px-2 bg-green-50 border-2 border-green-500 rounded-xl transition-all">
                            <i class='bx bx-dish text-2xl mb-1 text-green-600'></i>
                            <span class="text-[9px] font-black uppercase">Normal</span>
                        </button>
                        <button type="button" onclick="setCheckVal('feed','Poor')" id="btn-feed-Poor"
                            class="check-btn flex flex-col items-center py-4 px-2 bg-white border-2 border-slate-200 rounded-xl transition-all">
                            <i class='bx bx-error text-2xl mb-1 text-red-400'></i>
                            <span class="text-[9px] font-black uppercase">Leftovers</span>
                        </button>
                    </div>
                    <input type="hidden" id="val-feed" value="Normal">
                </div>

                <!-- 2. WATER -->
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200">
                    <label class="block text-[10px] font-black uppercase text-slate-500 mb-3 tracking-[0.2em]">2. Water Supply</label>
                    <select id="val-water" class="w-full p-4 rounded-xl bg-white border border-slate-200 font-bold text-slate-900 outline-none">
                        <option value="Operational">Nipple / Bowl Working & Clean</option>
                        <option value="Low Pressure">Low Pressure / Needs Fixing</option>
                        <option value="Dirty">Bowl Dirty — Needs Cleaning</option>
                    </select>
                </div>

                <!-- 3. PHYSICAL -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        <label class="block text-[10px] font-black uppercase text-slate-500 mb-2 tracking-[0.2em]">3. Skin & Body</label>
                        <select id="val-skin" class="w-full p-3 rounded-xl bg-white border border-slate-200 font-bold text-slate-900 text-sm outline-none">
                            <option value="Clean & Pink">Clean & Pink — Good</option>
                            <option value="Minor Scratches">Minor Scratches</option>
                            <option value="Parasites Suspected">Parasites Suspected</option>
                            <option value="Rash / Discoloration">Rash / Skin Discoloration</option>
                        </select>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        <label class="block text-[10px] font-black uppercase text-slate-500 mb-2 tracking-[0.2em]">4. Behavior</label>
                        <select id="val-behavior" class="w-full p-3 rounded-xl bg-white border border-slate-200 font-bold text-slate-900 text-sm outline-none">
                            <option value="Active & Social">Active & Social — Normal</option>
                            <option value="Lethargic">Lethargic / Lying Down</option>
                            <option value="Not Eating">Refusing to Eat</option>
                            <option value="Aggressive">Unusually Aggressive</option>
                            <option value="Isolated">Isolating from Group</option>
                        </select>
                    </div>
                </div>

                <!-- 4. WEIGHT -->
                <div class="bg-slate-900 p-6 rounded-2xl text-white">
                    <label class="block text-[10px] font-black uppercase text-white/40 mb-4 tracking-[0.2em]">5. Weight This Shift (KG)</label>
                    <div class="relative">
                        <input id="swal-weight" type="number" step="0.1" min="0"
                            class="w-full p-5 pr-16 rounded-xl bg-white/10 border-2 border-white/10 font-black text-white text-4xl outline-none focus:border-green-500 transition-all"
                            value="${pig.weight || 0}">
                        <span class="absolute right-5 top-1/2 -translate-y-1/2 font-black text-white/25 text-xl">KG</span>
                    </div>
                </div>

                <!-- 5. HEALTH VERDICT -->
                <div class="p-5 rounded-2xl border-2 border-slate-200">
                    <label class="block text-[10px] font-black uppercase text-slate-500 mb-3 tracking-[0.2em]">6. Overall Health Verdict</label>
                    <div class="grid grid-cols-3 gap-2 mb-3">
                        <button type="button" onclick="setSwalHealth('Healthy')" id="health-btn-Healthy"
                            class="py-4 rounded-xl border-2 border-green-500 bg-green-50 text-green-700 font-black text-xs uppercase tracking-widest">
                            ✓ Healthy
                        </button>
                        <button type="button" onclick="setSwalHealth('Warning')" id="health-btn-Warning"
                            class="py-4 rounded-xl border-2 border-slate-200 bg-white text-slate-400 font-black text-xs uppercase tracking-widest">
                            ⚠ Warning
                        </button>
                        <button type="button" onclick="setSwalHealth('Sick')" id="health-btn-Sick"
                            class="py-4 rounded-xl border-2 border-slate-200 bg-white text-slate-400 font-black text-xs uppercase tracking-widest">
                            🔴 Sick
                        </button>
                    </div>
                    <div id="symptoms-box" class="hidden">
                        <textarea id="val-symptoms" rows="2"
                            class="w-full p-3 rounded-xl bg-red-50 border border-red-200 font-bold text-slate-900 text-sm outline-none"
                            placeholder="Describe symptoms observed (e.g. diarrhea, fever, limping, discharge...)"></textarea>
                    </div>
                    <input type="hidden" id="swal-health-val" value="Healthy">
                </div>

                <!-- 6. NOTES -->
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-[0.2em]">7. Shift Notes (Optional)</label>
                    <textarea id="val-notes" rows="2"
                        class="w-full p-4 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-600 text-sm outline-none"
                        placeholder="Any other observations for this shift..."></textarea>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Submit Assessment',
        confirmButtonColor: '#16a34a',
        cancelButtonText: 'Cancel',
        cancelButtonColor: '#94a3b8',
        preConfirm: () => {
            const weight   = document.getElementById('swal-weight').value;
            const health   = document.getElementById('swal-health-val').value;
            const feed     = document.getElementById('val-feed').value;
            const water    = document.getElementById('val-water').value;
            const skin     = document.getElementById('val-skin').value;
            const behavior = document.getElementById('val-behavior').value;
            const symptoms = document.getElementById('val-symptoms')?.value || '';
            const notes    = document.getElementById('val-notes').value;

            const isCritical = health === 'Sick';

            const details = [
                `Feeding: ${feed}`,
                `Water: ${water}`,
                `Skin: ${skin}`,
                `Behavior: ${behavior}`,
                symptoms ? `Symptoms: ${symptoms}` : null,
                notes ? `Notes: ${notes}` : null,
                `Weight: ${weight}kg`,
            ].filter(Boolean).join(' · ');

            const payload = {
                weight, health_status: health, feeding_status: feed,
                remarks: `Daily Check-In · ${details}`,
                bcs_score: pig.bcs_score ?? 3,
                symptoms: symptoms || null,
            };

            return offlineSafeFetch(
                `/worker/pigs/${pig.id}/update`,
                payload,
                `Check-in #${pig.tag}`
            ).then(data => {
                if (data?.offline) return data; // queued offline
                if (isCritical) {
                    return offlineSafeFetch(
                        `/worker/pigs/${pig.id}/log-activity`,
                        { type: 'Medical', action: '🚨 CRITICAL — Pig Flagged as Sick', details: `Reported during daily check-in. Symptoms: ${symptoms || 'Not specified'}. ${details}`, is_critical_alert: true },
                        `Emergency flag #${pig.tag}`
                    ).then(() => data);
                }
                return data;
            })
            .catch(err => Swal.showValidationMessage(`Error: ${err}`));
        }
    }).then(res => {
        if (res.isConfirmed) {
            const health = document.getElementById('swal-health-val')?.value;
            const wasOffline = res.value?.offline;

            // Instantly update the list state in the background
            const pigInState = activePigsData.find(p => p.id === pig.id);
            if (pigInState) {
                pigInState.health_status = health;
                const badge = document.getElementById(`pig-list-health-${pig.id}`);
                if (badge) {
                    badge.innerText = health;
                    badge.className = `text-xs uppercase font-black tracking-widest transition-colors text-${health === 'Sick' ? 'red' : (health === 'Warning' ? 'amber' : 'green')}-400`;
                }
            }

            if (wasOffline) {
                Swal.fire({ icon: 'info', title: 'Saved Offline', text: 'No internet detected. This check-in is saved on your device and will sync automatically when you reconnect.', confirmButtonColor: '#d97706', confirmButtonText: 'OK' });
            } else if (health === 'Sick') {
                Swal.fire({ icon: 'warning', title: 'Critical Alert Sent', text: 'Admin has been notified immediately. This pig is flagged as Sick.', confirmButtonColor: '#dc2626' })
                    .then(() => showFloatingCard(pig.id));
            } else {
                showFloatingCard(pig.id);
            }
        }
    });
}

function setCheckVal(type, val) {
    // Reset all buttons for this type
    const btns = document.querySelectorAll(`[id^="btn-${type}-"]`);
    btns.forEach(b => {
        b.classList.remove('border-green-500', 'bg-green-50');
        b.classList.add('border-slate-100', 'bg-white');
    });

    // Set active button
    const active = document.getElementById(`btn-${type}-${val}`);
    active.classList.remove('border-slate-100', 'bg-white');
    active.classList.add('border-green-500', 'bg-green-50');
    
    // Set hidden input
    document.getElementById(`val-${type}`).value = val;
}

function setSwalHealth(status) {
    ['Healthy','Warning','Sick'].forEach(s => {
        const btn = document.getElementById(`health-btn-${s}`);
        if (!btn) return;
        const colors = { Healthy: 'border-green-500 bg-green-50 text-green-700', Warning: 'border-amber-500 bg-amber-50 text-amber-700', Sick: 'border-red-500 bg-red-50 text-red-700' };
        btn.className = `py-4 rounded-xl border-2 font-black text-xs uppercase tracking-widest transition-all ${ s === status ? colors[s] : 'border-slate-200 bg-white text-slate-400' }`;
    });
    document.getElementById('swal-health-val').value = status;
    const sb = document.getElementById('symptoms-box');
    if (sb) sb.classList.toggle('hidden', status === 'Healthy');
}

function flagMedicalEmergency(id, tag) {
    Swal.fire({
        title: `<div class="text-left"><p class="text-red-600 font-black text-2xl">🚨 Flag Emergency</p><p class="text-slate-400 text-sm font-bold">#${tag}</p></div>`,
        html: `
            <div class="text-left space-y-4 py-3">
                <div class="p-4 bg-red-50 rounded-2xl border border-red-200">
                    <p class="text-xs font-black text-red-600 uppercase tracking-widest mb-1">⚡ This sends an immediate critical alert to admin</p>
                    <p class="text-xs text-red-500 font-bold">Admin will be notified right now — no need to wait for weekly report.</p>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Describe the Emergency</label>
                    <textarea id="emergency-desc" rows="3"
                        class="w-full p-4 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-900 text-sm outline-none"
                        placeholder="e.g. Pig is not moving, heavy breathing, visible injury, bleeding..."></textarea>
                </div>
                <select id="emergency-type" class="w-full p-4 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-900 outline-none">
                    <option value="Illness Suspected">Illness Suspected</option>
                    <option value="Injury">Injury / Wound</option>
                    <option value="Not Eating / Lethargic">Not Eating / Lethargic</option>
                    <option value="Breathing Difficulty">Breathing Difficulty</option>
                    <option value="Seizure / Collapse">Seizure / Collapse</option>
                    <option value="Other Emergency">Other Emergency</option>
                </select>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: '🚨 Send Alert to Admin Now',
        confirmButtonColor: '#dc2626',
        preConfirm: () => {
            const desc = document.getElementById('emergency-desc').value.trim();
            const type = document.getElementById('emergency-type').value;
            if (!desc) { Swal.showValidationMessage('Please describe what you observed.'); return false; }
            return offlineSafeFetch(
                `/worker/pigs/${id}/update`,
                { health_status: 'Sick', bcs_score: 3, feeding_status: 'Poor', remarks: `EMERGENCY: ${type} — ${desc}` },
                `Emergency: ${type} #${id}`
            ).then(r => {
                if (r?.offline) return r;
                return offlineSafeFetch(
                    `/worker/pigs/${id}/log-activity`,
                    { type: 'Medical', action: `🚨 CRITICAL ALERT — ${type}`, details: `Emergency flagged by worker. ${desc}`, is_critical_alert: true },
                    `Emergency log #${id}`
                );
            })
            .catch(err => Swal.showValidationMessage(`Error: ${err}`));
        }
    }).then(res => {
        if (res.isConfirmed) {
            Swal.close();

            // Update list state background
            const pigInState = activePigsData.find(p => p.id === id);
            if (pigInState) {
                pigInState.health_status = 'Sick';
                const badge = document.getElementById(`pig-list-health-${id}`);
                if (badge) {
                    badge.innerText = 'Sick';
                    badge.className = `text-xs uppercase font-black tracking-widest transition-colors text-red-400`;
                }
            }

            if (res.value?.offline) {
                Swal.fire({ icon: 'info', title: '⚠ Saved Offline', text: 'No internet. Emergency saved locally. Please also call your supervisor directly. It will sync when you reconnect.', confirmButtonColor: '#d97706' })
                    .then(() => showFloatingCard(id));
            } else {
                Swal.fire({ icon: 'warning', title: '🚨 Admin Alerted', text: 'Critical medical flag sent. Admin has been notified immediately.', confirmButtonColor: '#dc2626' })
                    .then(() => showFloatingCard(id));
            }
        }
    });
}

function openMedicalLogger(id) {
    Swal.fire({
        title: '<div class="text-left font-black tracking-tighter text-4xl text-red-600">Medical Entry</div>',
        html: `
            <div class="text-left py-6 space-y-6">
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Treatment Action</label>
                    <select id="mdl-action" class="w-full p-4 rounded-2xl bg-slate-50 border border-slate-100 font-bold text-slate-900">
                        <option value="Vaccination">Vaccination</option>
                        <option value="Medication">Medication</option>
                        <option value="Checkup">General Checkup</option>
                        <option value="Quarantine">Quarantine</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Medical Details / Meds Given</label>
                    <textarea id="mdl-details" class="w-full p-4 rounded-2xl bg-slate-50 border border-slate-100 font-bold text-slate-900 h-24" placeholder="e.g. Parvo Vaccine or Specific Meds administered..."></textarea>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Record Medical Event',
        confirmButtonColor: '#dc2626',
        preConfirm: () => {
            const action = document.getElementById('mdl-action').value;
            const details = document.getElementById('mdl-details').value;
            return offlineSafeFetch(
                '/worker/pigs/' + id + '/log-activity',
                { type: 'Medical', action: action, details: details },
                `Medical Log #${id}`
            )
            .then(r => {
                if (r?.offline) return r;
                return r;
            })
            .catch(error => Swal.showValidationMessage(`Sync Error: ${error}`));
        }
    }).then((result) => { if (result.isConfirmed) showFloatingCard(id); });
}
</script>

<style>
@keyframes fadeIn { from { opacity:0; transform: translateY(10px);} to {opacity:1;} }
.animate-fade-in { animation: fadeIn .4s ease; }
</style>

@endsection
