@extends('layouts.worker')

@section('content')
<div class="p-6 md:p-12 mt-16 md:mt-0 min-h-screen">
    
    <!-- HEADER -->
    <div class="mb-10">
        <h1 class="text-4xl font-black tracking-tight text-slate-900">Animal <span class="text-green-600">Registry</span></h1>
        <p id="pageSubtitle" class="text-slate-500 font-medium mt-2 text-sm uppercase tracking-wide">Select a pen to manage individual animals.</p>
    </div>

    <!-- VIEW A: THE PEN GRID -->
    <div id="penGridView" class="animate-fade-in grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($pens as $pen)
            <div onclick="enterPen({{ $pen->id }}, '{{ $pen->name }}', {{ json_encode($pen->pigs) }})" 
                 class="group relative p-8 rounded-[2.5rem] bg-white border border-slate-200 hover:border-green-500/50 hover:shadow-2xl hover:shadow-green-500/5 transition-all cursor-pointer overflow-hidden shadow-sm">
                <div class="absolute top-0 right-0 w-32 h-32 bg-green-500/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 rounded-3xl bg-green-600 text-white flex items-center justify-center mb-6 shadow-xl shadow-green-500/20">
                        <i class='bx bxs-grid-alt text-3xl'></i>
                    </div>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tighter mb-1">{{ $pen->name }}</h3>
                    <p class="text-[10px] font-black text-green-600 uppercase tracking-[0.2em]">{{ count($pen->pigs) }} Animals Active</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- VIEW B: THE PIG LIST -->
    <div id="pigListView" class="hidden animate-fade-in space-y-8 pb-32">
        <div class="flex items-center gap-4">
            <button onclick="exitPen()" class="w-12 h-12 rounded-2xl bg-slate-200/50 text-slate-600 flex items-center justify-center hover:bg-slate-300 transition-all shadow-sm">
                <i class='bx bx-left-arrow-alt text-2xl'></i>
            </button>
            <div>
                <h2 id="currentPenName" class="text-3xl font-black text-slate-900 tracking-tighter">Pen 01</h2>
                <p id="currentPigCount" class="text-[10px] font-bold text-green-600 uppercase tracking-widest">Inventory List</p>
            </div>
        </div>

        <div id="pigsContainer" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Dynamically populated -->
        </div>
    </div>

    <!-- THE LITERAL FLOATING CARD -->
    <div id="floatingCardOverlay" class="fixed inset-0 z-[100] hidden items-start justify-center p-4 pt-20 sm:pt-28 pointer-events-none">
        <div onclick="hideFloatingCard()" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm pointer-events-auto"></div>
        <div class="w-full max-w-lg bg-white rounded-[3rem] shadow-[0_40px_100px_rgba(0,0,0,0.2)] overflow-hidden animate-scale-in relative z-10 pointer-events-auto max-h-[75vh] flex flex-col border border-white/20">
            <button onclick="hideFloatingCard()" class="absolute top-6 right-6 w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:text-slate-900 flex items-center justify-center z-50 shadow-sm border border-slate-100">
                <i class='bx bx-x text-2xl'></i>
            </button>
            <div id="floatingCardContent" class="flex-1 overflow-y-auto custom-scrollbar">
                 <div class="flex flex-col items-center justify-center py-24 gap-3">
                     <i class='bx bx-loader-alt bx-spin text-4xl text-slate-200'></i>
                     <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Opening Detail HUD...</p>
                 </div>
            </div>
        </div>
    </div>
</div>

<script>
    function enterPen(id, name, pigs) {
        document.getElementById('penGridView').classList.add('hidden');
        document.getElementById('pigListView').classList.remove('hidden');
        document.getElementById('currentPenName').innerText = name;
        hideFloatingCard();

        const container = document.getElementById('pigsContainer');
        container.innerHTML = pigs.map(p => {
            const hColor = p.health_status === 'Sick' ? 'red' : (p.health_status === 'Warning' ? 'amber' : 'green');
            return `
                <div onclick="showFloatingCard(${p.id})" class="group p-6 rounded-[2.5rem] bg-white border border-slate-100 hover:border-green-500/50 hover:shadow-2xl hover:shadow-green-500/5 transition-all cursor-pointer flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-300 group-hover:bg-green-600 group-hover:text-white transition-all shadow-sm">
                            <i class='bx bx-hash text-2xl'></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-black text-slate-900 tracking-tighter">#${p.tag}</h4>
                            <span class="text-[9px] font-black uppercase text-${hColor}-500 tracking-widest">${p.health_status}</span>
                        </div>
                    </div>
                    <i class='bx bxs-chevron-right text-2xl text-slate-200 group-hover:text-slate-400 transition-all'></i>
                </div>
            `;
        }).join('');
    }

    function exitPen() {
        document.getElementById('penGridView').classList.remove('hidden');
        document.getElementById('pigListView').classList.add('hidden');
        hideFloatingCard();
    }

    function showFloatingCard(pigId) {
        const overlay = document.getElementById('floatingCardOverlay');
        const content = document.getElementById('floatingCardContent');
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        
        content.innerHTML = `<div class="flex flex-col items-center justify-center py-24 gap-3"><i class='bx bx-loader-alt bx-spin text-4xl text-slate-200'></i><p class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Opening Detail HUD...</p></div>`;

        fetch(`/worker/pigs/${pigId}`)
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const card = doc.querySelector('.bg-white.rounded-\\[3rem\\]'); 
                if(card) {
                    content.innerHTML = card.innerHTML;
                }
            });
    }

    function hideFloatingCard() {
        const overlay = document.getElementById('floatingCardOverlay');
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
    }

    window.logQuickAction = (type, action, details, pigId) => {
        Swal.fire({
            title: `Log ${action}`,
            input: 'textarea',
            inputValue: details,
            confirmButtonColor: '#0f172a',
            preConfirm: (note) => {
                return fetch(`/worker/pigs/${pigId}/log-activity`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ type: type, action: action, details: note })
                });
            }
        }).then(res => res.isConfirmed && window.location.reload());
    }

    window.openMedicalLogger = (pigId) => {
        Swal.fire({
            title: 'Medical Entry',
            html: `<select id="mdl-act" class="swal2-input"><option value="Vaccination">Vaccination</option><option value="Medication">Medication</option></select><input id="mdl-det" class="swal2-input" placeholder="Details">`,
            preConfirm: () => {
                const action = document.getElementById('mdl-act').value;
                const details = document.getElementById('mdl-det').value;
                return fetch(`/worker/pigs/${pigId}/log-activity`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ type: 'Medical', action: action, details: details })
                });
            }
        }).then(res => res.isConfirmed && window.location.reload());
    }

    window.managePig = (pig) => {
        Swal.fire({
            title: 'Update Stats',
            html: `<input id="sw-w" type="number" class="swal2-input" value="${pig.weight}"><select id="sw-h" class="swal2-input"><option value="Healthy" ${pig.health_status=='Healthy'?'selected':''}>Healthy</option><option value="Warning" ${pig.health_status=='Warning'?'selected':''}>Warning</option><option value="Sick" ${pig.health_status=='Sick'?'selected':''}>Sick</option></select>`,
            preConfirm: () => {
                return fetch(`/worker/pigs/${pig.id}/update`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ weight: document.getElementById('sw-w').value, health_status: document.getElementById('sw-h').value, target_weight: pig.target_weight, breed: pig.breed, bcs_score: pig.bcs_score, feeding_status: pig.feeding_status, symptoms: pig.symptoms, remarks: pig.remarks })
                });
            }
        }).then(res => res.isConfirmed && window.location.reload());
    }
</script>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes scaleIn { from { opacity: 0; transform: scale(0.9) translateY(-20px); } to { opacity: 1; transform: scale(1) translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
    .animate-scale-in { animation: scaleIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.05); border-radius: 10px; }
</style>
@endsection
