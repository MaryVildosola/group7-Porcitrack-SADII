@extends('layouts.worker')

@section('content')
<div class="p-5 md:p-10 max-w-full">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <p class="text-sm font-semibold text-white/40 mb-1 uppercase tracking-widest">Worker Report</p>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight">Weekly Report</h1>
            <p class="text-white/40 text-sm mt-2 font-medium">
                {{ \Carbon\Carbon::parse($thisWeek)->format('M d') }} — {{ \Carbon\Carbon::parse($thisWeek)->endOfWeek()->format('M d, Y') }}
            </p>
        </div>
        <div class="flex items-center gap-3 px-5 py-3 rounded-2xl border {{ $existingReport ? 'border-green-500/30 bg-green-500/10' : 'border-yellow-500/30 bg-yellow-500/10' }}">
            <i class='bx {{ $existingReport ? "bxs-badge-check text-green-400" : "bx-time text-yellow-400" }} text-2xl'></i>
            <div>
                <p class="text-white font-black text-base">{{ $existingReport ? 'Submitted' : 'Pending Submission' }}</p>
                <p class="text-white/40 text-xs">{{ $existingReport ? 'HQ received this week\'s report' : 'Submit before end of week' }}</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="flex items-center gap-4 p-5 rounded-2xl bg-green-500/15 border border-green-500/30 mb-8">
        <i class='bx bxs-check-shield text-3xl text-green-400 shrink-0'></i>
        <div>
            <p class="text-white font-bold text-base">Report Sent to HQ Successfully</p>
            <p class="text-white/50 text-sm">Your weekly report has been transmitted and recorded.</p>
        </div>
    </div>
    @endif

    <!-- Stats Strip -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
        <div class="glass-panel p-4 rounded-2xl">
            <p class="text-white/40 text-xs font-bold uppercase tracking-widest mb-1">Total Pigs</p>
            <p class="text-3xl font-black text-white">{{ $analytics['total_pigs'] }}</p>
        </div>
        <div class="glass-panel p-4 rounded-2xl border-l-4 border-red-500/40">
            <p class="text-white/40 text-xs font-bold uppercase tracking-widest mb-1">Health Alerts</p>
            <p class="text-3xl font-black text-red-400">{{ $analytics['sick_pigs'] }}</p>
        </div>
        <div class="glass-panel p-4 rounded-2xl">
            <p class="text-white/40 text-xs font-bold uppercase tracking-widest mb-1">Avg. Weight</p>
            <p class="text-3xl font-black text-blue-400">{{ $analytics['avg_weight'] }}<span class="text-base ml-1">kg</span></p>
        </div>
        <div class="glass-panel p-4 rounded-2xl">
            <p class="text-white/40 text-xs font-bold uppercase tracking-widest mb-1">Pens Active</p>
            <p class="text-3xl font-black text-emerald-400">3</p>
        </div>
    </div>

    <!-- ===== PENS & PIGS LIST ===== -->
    @php
        $pens = [
            [
                'id' => 1, 'name' => 'Pen 1', 'type' => 'Piglets', 'status' => 'Good',
                'statusColor' => 'green', 'progress' => 30,
                'pigs' => [
                    ['tag' => '001', 'weight' => 12, 'bcs' => 3, 'condition' => 'Healthy', 'feeding' => 'Active',  'lastCheck' => '2 days ago'],
                    ['tag' => '002', 'weight' => 11, 'bcs' => 2, 'condition' => 'Healthy', 'feeding' => 'Normal',  'lastCheck' => '2 days ago'],
                    ['tag' => '003', 'weight' => 13, 'bcs' => 3, 'condition' => 'Healthy', 'feeding' => 'Active',  'lastCheck' => '3 days ago'],
                    ['tag' => '004', 'weight' => 10, 'bcs' => 2, 'condition' => 'Healthy', 'feeding' => 'Normal',  'lastCheck' => '1 day ago'],
                    ['tag' => '005', 'weight' => 12, 'bcs' => 3, 'condition' => 'Healthy', 'feeding' => 'Active',  'lastCheck' => '3 days ago'],
                ],
            ],
            [
                'id' => 5, 'name' => 'Pen 5', 'type' => 'Fattening', 'status' => 'Fair',
                'statusColor' => 'yellow', 'progress' => 59,
                'pigs' => [
                    ['tag' => '021', 'weight' => 68, 'bcs' => 3, 'condition' => 'Healthy',   'feeding' => 'Active',    'lastCheck' => '1 day ago'],
                    ['tag' => '022', 'weight' => 63, 'bcs' => 2, 'condition' => 'Lethargic', 'feeding' => 'Poor/None', 'lastCheck' => 'Today'],
                    ['tag' => '023', 'weight' => 70, 'bcs' => 4, 'condition' => 'Healthy',   'feeding' => 'Normal',    'lastCheck' => '2 days ago'],
                    ['tag' => '024', 'weight' => 61, 'bcs' => 2, 'condition' => 'Coughing',  'feeding' => 'Poor/None', 'lastCheck' => 'Today'],
                    ['tag' => '025', 'weight' => 66, 'bcs' => 3, 'condition' => 'Healthy',   'feeding' => 'Active',    'lastCheck' => '1 day ago'],
                ],
            ],
            [
                'id' => 12, 'name' => 'Pen 12', 'type' => 'Breeding', 'status' => 'Excellent',
                'statusColor' => 'emerald', 'progress' => 82,
                'pigs' => [
                    ['tag' => '101', 'weight' => 92, 'bcs' => 4, 'condition' => 'Healthy', 'feeding' => 'Active',  'lastCheck' => '1 day ago'],
                    ['tag' => '102', 'weight' => 89, 'bcs' => 3, 'condition' => 'Healthy', 'feeding' => 'Normal',  'lastCheck' => '2 days ago'],
                    ['tag' => '103', 'weight' => 91, 'bcs' => 4, 'condition' => 'Healthy', 'feeding' => 'Active',  'lastCheck' => '1 day ago'],
                ],
            ],
        ];

        $statusConfig = [
            'green'   => ['badge' => 'bg-green-500/20 text-green-300 border-green-500/30',   'bar' => 'bg-green-500',   'penBorder' => 'border-green-500/20'],
            'yellow'  => ['badge' => 'bg-yellow-500/20 text-yellow-300 border-yellow-500/30', 'bar' => 'bg-yellow-500',  'penBorder' => 'border-yellow-500/20'],
            'emerald' => ['badge' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30','bar' => 'bg-emerald-500','penBorder' => 'border-emerald-500/20'],
        ];
    @endphp

    <h2 class="text-xl font-black text-white mb-5">All Pens & Pigs</h2>
    <div class="space-y-5 mb-10" id="pensList">

        @foreach($pens as $pen)
        @php
            $sc  = $statusConfig[$pen['statusColor']];
            $sickCount = count(array_filter($pen['pigs'], fn($p) => $p['condition'] !== 'Healthy'));
        @endphp

        <div class="glass-panel rounded-2xl border {{ $sc['penBorder'] }} overflow-hidden">

            <!-- Pen Header (Tap to expand) -->
            <button onclick="togglePen({{ $pen['id'] }})"
                class="w-full flex items-center gap-4 p-5 text-left hover:bg-white/5 transition active:scale-[0.99]">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-1">
                        <h3 class="text-xl font-black text-white">{{ $pen['name'] }}</h3>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase border {{ $sc['badge'] }}">{{ $pen['status'] }}</span>
                        @if($sickCount > 0)
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-red-500/20 text-red-300 border border-red-500/30">{{ $sickCount }} sick</span>
                        @endif
                    </div>
                    <p class="text-white/40 text-xs font-semibold">{{ $pen['type'] }} · {{ count($pen['pigs']) }} pigs · Avg weight {{ round(array_sum(array_column($pen['pigs'], 'weight')) / count($pen['pigs'])) }}kg</p>
                </div>
                <div class="text-right shrink-0 mr-2">
                    <p class="text-white/30 text-xs font-semibold mb-1">Progress</p>
                    <p class="text-white font-black text-lg">{{ $pen['progress'] }}%</p>
                </div>
                <i class='bx bx-chevron-down text-white/40 text-2xl transition-transform duration-300' id="pen-chevron-{{ $pen['id'] }}"></i>
            </button>

            <!-- Progress Bar -->
            <div class="w-full h-1.5 bg-white/5">
                <div class="{{ $sc['bar'] }} h-full transition-all" style="width:{{ $pen['progress'] }}%"></div>
            </div>

            <!-- Pigs List (collapsible) -->
            <div id="pen-body-{{ $pen['id'] }}" class="hidden">
                <div class="p-4 space-y-3">
                    @foreach($pen['pigs'] as $pig)
                    @php
                        $isSick   = $pig['condition'] !== 'Healthy';
                        $condColor = $isSick ? 'text-red-300' : 'text-green-300';
                        $condBg    = $isSick ? 'bg-red-500/10 border-red-500/20' : 'bg-green-500/10 border-green-500/20';
                        $feedColor = $pig['feeding'] === 'Poor/None' ? 'text-red-400' : ($pig['feeding'] === 'Active' ? 'text-green-400' : 'text-blue-400');
                    @endphp

                    <!-- Individual Pig Row — tap to see full details -->
                    <div onclick="togglePig('pig-{{ $pen['id'] }}-{{ $pig['tag'] }}')"
                        class="rounded-xl border {{ $condBg }} cursor-pointer hover:bg-white/5 transition active:scale-[0.99] overflow-hidden">

                        <div class="flex items-center gap-3 p-3">
                            <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                                <i class='bx bxs-circle text-lg {{ $condColor }}'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-black text-sm">Ear Tag #{{ $pig['tag'] }}</p>
                                <p class="text-white/40 text-xs">{{ $pig['condition'] }} · {{ $pig['lastCheck'] }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-white font-bold text-sm">{{ $pig['weight'] }}kg</p>
                                <p class="text-white/30 text-[10px]">BCS {{ $pig['bcs'] }}</p>
                            </div>
                            <i class='bx bx-chevron-down text-white/30 text-lg ml-1 transition-transform duration-300' id="pig-chevron-pig-{{ $pen['id'] }}-{{ $pig['tag'] }}"></i>
                        </div>

                        <!-- Expanded Pig Details -->
                        <div id="pig-pig-{{ $pen['id'] }}-{{ $pig['tag'] }}" class="hidden border-t border-white/10">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 p-4">
                                <div class="bg-white/5 rounded-xl p-3 text-center">
                                    <p class="text-white/30 text-[9px] uppercase font-black mb-1">Condition</p>
                                    <p class="font-black text-sm {{ $condColor }}">{{ $pig['condition'] }}</p>
                                </div>
                                <div class="bg-white/5 rounded-xl p-3 text-center">
                                    <p class="text-white/30 text-[9px] uppercase font-black mb-1">Feeding</p>
                                    <p class="font-black text-sm {{ $feedColor }}">{{ $pig['feeding'] }}</p>
                                </div>
                                <div class="bg-white/5 rounded-xl p-3 text-center">
                                    <p class="text-white/30 text-[9px] uppercase font-black mb-1">Weight</p>
                                    <p class="text-white font-black text-sm">{{ $pig['weight'] }} kg</p>
                                </div>
                                <div class="bg-white/5 rounded-xl p-3 text-center">
                                    <p class="text-white/30 text-[9px] uppercase font-black mb-1">BCS Score</p>
                                    <p class="text-white font-black text-sm">{{ $pig['bcs'] }} / 5</p>
                                </div>
                            </div>
                            @if($isSick)
                            <div class="mx-4 mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500/20 flex items-center gap-2">
                                <i class='bx bx-error text-red-400 text-lg shrink-0'></i>
                                <p class="text-red-300 text-xs font-semibold">This pig has been flagged. Condition: <strong>{{ $pig['condition'] }}</strong>. Feeding: <strong>{{ $pig['feeding'] }}</strong>. Follow up required.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    <!-- Additional logs from localStorage for this pen -->
                    <div id="pen-local-logs-{{ $pen['id'] }}" class="space-y-2 mt-2"></div>
                </div>
            </div>
        </div>
        @endforeach

    </div>

    <!-- Feed & Notes -->
    @if(!$existingReport)
    <div class="glass-panel rounded-2xl border border-white/10 p-6 mb-8">
        <h3 class="text-base font-black text-white mb-5">Report Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-black text-white/40 uppercase tracking-widest mb-2">Total Feed Consumed This Week (kg)</label>
                <div class="relative">
                    <input type="number" id="reportFeedKg" placeholder="0"
                        class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-5 pr-14 text-white text-2xl font-black focus:outline-none focus:border-green-500/50 transition">
                    <span class="absolute right-5 top-1/2 -translate-y-1/2 text-white/30 font-bold">kg</span>
                </div>
            </div>
            <div>
                <label class="block text-xs font-black text-white/40 uppercase tracking-widest mb-2">Operational Notes</label>
                <textarea id="reportNotes" rows="3" placeholder="Any notable observations, mortalities, or infrastructure issues this week..."
                    class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-5 text-white text-sm font-medium focus:outline-none focus:border-green-500/50 transition resize-none leading-relaxed"></textarea>
            </div>
        </div>
    </div>

    <!-- Generate Report Button -->
    <button onclick="generateReport()"
        class="w-full flex items-center justify-center gap-4 py-6 rounded-2xl bg-gradient-to-r from-green-600 to-emerald-500 text-white font-black text-xl hover:shadow-[0_15px_40px_rgba(34,197,94,0.35)] transition active:scale-[0.98] mb-10">
        <i class='bx bx-file-find text-3xl'></i>
        Generate Weekly Report
    </button>

    @else
    <div class="flex items-center gap-4 p-5 rounded-2xl bg-green-500/10 border border-green-500/30 mb-10">
        <i class='bx bxs-badge-check text-3xl text-green-400 shrink-0'></i>
        <div>
            <p class="text-white font-black text-base">Report already submitted for this week</p>
            <p class="text-white/40 text-sm">Revision is locked. A new report can be submitted next week.</p>
        </div>
    </div>
    @endif

</div>

<!-- ===== REPORT PREVIEW MODAL ===== -->
<div id="reportModal" class="fixed inset-0 z-[220] hidden bg-black/80 backdrop-blur-md flex items-start justify-center p-4 overflow-y-auto">
    <div class="w-full max-w-lg bg-[#070e08] border border-white/10 rounded-3xl shadow-2xl my-6 overflow-hidden">

        <!-- Modal Header -->
        <div class="p-6 border-b border-white/10 flex justify-between items-center bg-white/5">
            <div>
                <h2 class="text-2xl font-black text-white">Report Preview</h2>
                <p class="text-white/40 text-xs font-semibold mt-0.5">Review carefully before submitting to HQ</p>
            </div>
            <button onclick="closeReport()" class="w-12 h-12 rounded-2xl bg-white/5 text-white flex items-center justify-center hover:bg-white/10 transition text-2xl">
                <i class='bx bx-x'></i>
            </button>
        </div>

        <!-- Report Content -->
        <div class="p-6 space-y-5" id="reportContent">
            <!-- Populated by JS -->
        </div>

        <!-- Action Buttons -->
        <div class="p-6 pt-0 space-y-3">
            <button onclick="submitReport()"
                class="w-full flex items-center justify-center gap-3 py-5 rounded-2xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-black text-lg hover:shadow-[0_10px_30px_rgba(34,197,94,0.3)] transition active:scale-[0.98]">
                <i class='bx bxs-cloud-upload text-2xl'></i>
                Submit to HQ
            </button>
            <button onclick="closeReport()"
                class="w-full py-4 rounded-2xl bg-white/5 text-white/50 font-bold text-sm hover:bg-white/10 transition">
                Go Back & Edit
            </button>
        </div>
    </div>
</div>

<!-- Hidden Submission Form -->
<form id="hiddenReportForm" action="{{ route('worker.reports.store') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="total_pigs"    value="{{ $analytics['total_pigs'] }}">
    <input type="hidden" name="sick_pigs"     value="{{ $analytics['sick_pigs'] }}">
    <input type="hidden" name="avg_weight"    value="{{ $analytics['avg_weight'] }}">
    <input type="hidden" name="feed_consumed" id="hiddenFeed">
    <input type="hidden" name="details"       id="hiddenNotes">
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ---- Pen Accordion ----
    function togglePen(id) {
        const body    = document.getElementById(`pen-body-${id}`);
        const chevron = document.getElementById(`pen-chevron-${id}`);
        const isOpen  = !body.classList.contains('hidden');
        body.classList.toggle('hidden', isOpen);
        chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
    }

    // ---- Individual Pig Toggle ----
    function togglePig(id) {
        const detail  = document.getElementById(`pig-${id}`);
        const chevron = document.getElementById(`pig-chevron-${id}`);
        const isOpen  = !detail.classList.contains('hidden');
        detail.classList.toggle('hidden', isOpen);
        chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
    }

    // ----------------------------------------------------------------
    // DEDUPLICATION HELPER
    // Multiple evaluations of the same pig in the same week are normal.
    // For the REPORT we only want the LATEST status per pig.
    // For the PEN VIEW we show ALL checks as history (audit trail).
    // ----------------------------------------------------------------
    function getLatestPerPig(logs) {
        const map = {};
        // Logs are stored newest-first (unshift), so first seen = latest
        logs.forEach(log => {
            if (!map[log.pigId]) {
                map[log.pigId] = log; // keep only the first occurrence (= latest)
            }
        });
        return Object.values(map);
    }

    function assignToPen(pigId) {
        const n = parseInt(pigId);
        if (n >= 1  && n <= 20) return 1;
        if (n >= 21 && n <= 60) return 5;
        return 12;
    }

    // ---- Inject ALL logs into pen accordion (full history — not deduplicated) ----
    document.addEventListener('DOMContentLoaded', () => {
        const allLogs = JSON.parse(localStorage.getItem('recent_monitoring') || '[]');

        [1, 5, 12].forEach(penId => {
            const penLogs   = allLogs.filter(l => assignToPen(l.pigId) === penId);
            const container = document.getElementById(`pen-local-logs-${penId}`);
            if (!container || !penLogs.length) return;

            // Group by pigId so we can show "Pig #xxx — N checks this week"
            const grouped = {};
            penLogs.forEach(log => {
                if (!grouped[log.pigId]) grouped[log.pigId] = [];
                grouped[log.pigId].push(log);
            });

            Object.entries(grouped).forEach(([pigId, pigLogs]) => {
                const latest  = pigLogs[0]; // newest first
                const isSick  = latest.symptom !== 'Healthy' || latest.feed === 'Poor/None';
                const bdr     = isSick ? 'border-red-500/20 bg-red-500/5' : 'border-green-500/15 bg-green-500/5';
                const badge   = isSick
                    ? `<span class="px-2 py-0.5 bg-red-500/20 text-red-300 rounded text-[9px] font-black border border-red-500/30 uppercase">Alert</span>`
                    : `<span class="px-2 py-0.5 bg-green-500/15 text-green-300 rounded text-[9px] font-black border border-green-500/20 uppercase">Healthy</span>`;
                const checkNote = pigLogs.length > 1
                    ? `<p class="text-blue-400/70 text-[10px] mt-0.5">${pigLogs.length} evaluations this week — showing latest</p>`
                    : '';

                container.insertAdjacentHTML('beforeend', `
                    <div class="flex gap-3 items-start p-3 rounded-xl border ${bdr}">
                        <div class="flex-1">
                            <p class="text-white text-xs font-bold">Pig #${pigId} — ${latest.symptom}</p>
                            <p class="text-white/40 text-[10px] mt-0.5">BCS: ${latest.bcs||'—'} · Weight: ${latest.weight?latest.weight+'kg':'—'} · Feeding: ${latest.feed||'—'} · Checks: ${latest.physicalChecks}</p>
                            ${latest.notes ? `<p class="text-white/30 text-[10px] italic mt-0.5">"${latest.notes}"</p>` : ''}
                            ${checkNote}
                        </div>
                        ${badge}
                    </div>`);
            });
        });
    });

    // ---- Generate Report (uses DEDUPLICATED data per pig) ----
    function generateReport() {
        const feed  = document.getElementById('reportFeedKg').value.trim();
        const notes = document.getElementById('reportNotes').value.trim();

        if (!feed) {
            Swal.fire({ title: 'Missing Feed Data', text: 'Please enter the total feed consumed this week.', icon: 'warning', background: '#070e08', color: '#fff', confirmButtonColor: '#22c55e' });
            return;
        }

        const allLogs   = JSON.parse(localStorage.getItem('recent_monitoring') || '[]');
        const totalChecks = allLogs.length; // total evaluations done (for audit info)

        // DEDUPLICATION — latest evaluation per pig only
        const latestPerPig = getLatestPerPig(allLogs);
        const sickPigs     = latestPerPig.filter(l => l.symptom !== 'Healthy' || l.feed === 'Poor/None');
        const healthyPigs  = latestPerPig.filter(l => l.symptom === 'Healthy' && l.feed !== 'Poor/None');
        const uniquePigsChecked = latestPerPig.length;

        const weekStart = '{{ \Carbon\Carbon::parse($thisWeek)->format("M d") }}';
        const weekEnd   = '{{ \Carbon\Carbon::parse($thisWeek)->endOfWeek()->format("M d, Y") }}';

        const pensData = [
            { name: 'Pen 1',  type: 'Piglets',   count: 24, avgKg: 12, sick: 0, progress: 30 },
            { name: 'Pen 5',  type: 'Fattening', count: 48, avgKg: 65, sick: 2, progress: 59 },
            { name: 'Pen 12', type: 'Breeding',  count: 12, avgKg: 90, sick: 0, progress: 82 },
        ];

        const reportContent = document.getElementById('reportContent');
        reportContent.innerHTML = `

            <!-- Period -->
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-white/5 border border-white/10">
                <i class='bx bx-calendar text-blue-400 text-2xl shrink-0'></i>
                <div>
                    <p class="text-white/40 text-xs font-black uppercase tracking-widest">Report Period</p>
                    <p class="text-white font-bold">${weekStart} — ${weekEnd}</p>
                </div>
            </div>

            <!-- Farm Stats -->
            <div>
                <p class="text-white/40 text-xs font-black uppercase tracking-widest mb-3">Farm Overview</p>
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-white/5 rounded-xl p-3 text-center border border-white/10">
                        <p class="text-white/30 text-[9px] uppercase font-black mb-1">Total Pigs</p>
                        <p class="text-white font-black text-2xl">{{ $analytics['total_pigs'] }}</p>
                    </div>
                    <div class="bg-red-500/10 rounded-xl p-3 text-center border border-red-500/20">
                        <p class="text-white/30 text-[9px] uppercase font-black mb-1">Flagged</p>
                        <p class="text-red-400 font-black text-2xl">{{ $analytics['sick_pigs'] }}</p>
                    </div>
                    <div class="bg-blue-500/10 rounded-xl p-3 text-center border border-blue-500/20">
                        <p class="text-white/30 text-[9px] uppercase font-black mb-1">Avg. Weight</p>
                        <p class="text-blue-400 font-black text-2xl">{{ $analytics['avg_weight'] }}<span class="text-xs">kg</span></p>
                    </div>
                </div>
            </div>

            <!-- Pen Summary -->
            <div>
                <p class="text-white/40 text-xs font-black uppercase tracking-widest mb-3">Pen Summary</p>
                <div class="space-y-2">
                    ${pensData.map(p => `
                    <div class="flex items-center justify-between p-3 rounded-xl bg-white/5 border border-white/10">
                        <div>
                            <p class="text-white font-bold text-sm">${p.name} — <span class="text-white/50 font-normal">${p.type}</span></p>
                            <p class="text-white/40 text-xs">${p.count} pigs · Avg ${p.avgKg}kg · ${p.progress}% to target</p>
                        </div>
                        <span class="px-2 py-1 rounded-lg text-[10px] font-black border ${p.sick > 0 ? 'bg-yellow-500/15 text-yellow-300 border-yellow-500/25' : 'bg-green-500/15 text-green-300 border-green-500/25'} uppercase">
                            ${p.sick > 0 ? p.sick+' sick' : 'Good'}
                        </span>
                    </div>`).join('')}
                </div>
            </div>

            <!-- Monitoring Summary (deduplicated) -->
            <div>
                <p class="text-white/40 text-xs font-black uppercase tracking-widest mb-1">Monitoring Summary</p>
                <p class="text-blue-400/60 text-[10px] font-semibold mb-3">Each pig counted once using their most recent evaluation.</p>
                <div class="space-y-2">
                    <div class="flex justify-between p-3 rounded-xl bg-white/5 border border-white/10 text-sm">
                        <span class="text-white/60">Total evaluations done</span>
                        <span class="text-white/60 font-black">${totalChecks} <span class="text-white/30 font-normal text-xs">(audit history)</span></span>
                    </div>
                    <div class="flex justify-between p-3 rounded-xl bg-white/5 border border-white/10 text-sm">
                        <span class="text-white/60">Unique pigs evaluated</span>
                        <span class="text-white font-black">${uniquePigsChecked}</span>
                    </div>
                    <div class="flex justify-between p-3 rounded-xl bg-green-500/10 border border-green-500/20 text-sm">
                        <span class="text-white/60">Currently healthy</span>
                        <span class="text-green-400 font-black">${healthyPigs.length}</span>
                    </div>
                    <div class="flex justify-between p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-sm">
                        <span class="text-white/60">Currently flagged / sick</span>
                        <span class="text-red-400 font-black">${sickPigs.length}</span>
                    </div>
                    <div class="flex justify-between p-3 rounded-xl bg-white/5 border border-white/10 text-sm">
                        <span class="text-white/60">Feed consumed this week</span>
                        <span class="text-white font-black">${feed} kg</span>
                    </div>
                </div>
            </div>

            ${sickPigs.length > 0 ? `
            <div class="p-4 rounded-2xl bg-red-500/10 border border-red-500/20">
                <p class="text-red-300 text-xs font-black uppercase tracking-widest mb-3">Flagged Pigs — Requires Follow-Up</p>
                <div class="space-y-2">
                    ${sickPigs.map(l => `
                    <div class="flex gap-2 items-start">
                        <i class='bx bx-error-circle text-red-400 text-sm shrink-0 mt-0.5'></i>
                        <p class="text-white/70 text-xs">Pig #${l.pigId} — <strong>${l.symptom}</strong>, Feeding: ${l.feed||'—'}${l.notes ? ' — "'+l.notes+'"' : ''}</p>
                    </div>`).join('')}
                </div>
            </div>` : `
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-green-500/10 border border-green-500/20">
                <i class='bx bxs-check-circle text-green-400 text-xl shrink-0'></i>
                <p class="text-green-300 text-sm font-semibold">All evaluated pigs are currently healthy.</p>
            </div>`}

            <!-- Notes -->
            <div class="p-4 rounded-2xl bg-white/5 border border-white/10">
                <p class="text-white/40 text-xs font-black uppercase tracking-widest mb-2">Operational Notes</p>
                <p class="text-white/70 text-sm leading-relaxed">${notes || 'No additional notes provided.'}</p>
            </div>

            <div class="flex items-center gap-3 p-3 rounded-xl bg-yellow-500/10 border border-yellow-500/20">
                <i class='bx bx-info-circle text-yellow-400 text-lg shrink-0'></i>
                <p class="text-yellow-300 text-xs font-semibold">Once submitted, this report cannot be edited until next week.</p>
            </div>
        `;

        document.getElementById('reportModal').classList.remove('hidden');
        document.getElementById('reportModal').classList.add('flex');
        document.getElementById('reportModal').scrollTop = 0;
    }

    function closeReport() {
        document.getElementById('reportModal').classList.add('hidden');
        document.getElementById('reportModal').classList.remove('flex');
    }

    function submitReport() {
        const feed  = document.getElementById('reportFeedKg').value.trim();
        const notes = document.getElementById('reportNotes').value.trim();
        document.getElementById('hiddenFeed').value  = feed;
        document.getElementById('hiddenNotes').value = notes;
        closeReport();
        document.getElementById('hiddenReportForm').submit();
    }
</script>
@endsection
