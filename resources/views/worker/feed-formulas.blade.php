@extends('layouts.worker')

@section('content')
<div class="p-6 md:p-12 max-w-full">

    {{-- Header --}}
    <div class="mb-8 md:mb-10">
        <p class="text-sm font-medium text-white/70 mb-1">Today's</p>
        <h1 class="text-3xl md:text-5xl font-bold text-white tracking-tight">Feed Formulas</h1>
        <p class="text-white/40 text-sm mt-2">View the approved mixing instructions for each pig life stage.</p>
    </div>

    {{-- Stage Filter Pills --}}
    <div class="flex gap-3 overflow-x-auto pb-2 mb-8 no-scrollbar">
        <button onclick="filterStage('all', this)"
            class="stage-pill shrink-0 px-5 py-2.5 rounded-full bg-green-500/30 text-green-300 border border-green-400/40 font-bold text-xs uppercase tracking-widest transition active:scale-95">
            All Stages
        </button>
        <button onclick="filterStage('starter', this)"
            class="stage-pill shrink-0 px-5 py-2.5 rounded-full bg-white/10 text-white/60 border border-white/15 font-bold text-xs uppercase tracking-widest transition active:scale-95">
            🐷 Starter
        </button>
        <button onclick="filterStage('grower', this)"
            class="stage-pill shrink-0 px-5 py-2.5 rounded-full bg-white/10 text-white/60 border border-white/15 font-bold text-xs uppercase tracking-widest transition active:scale-95">
            🐖 Grower
        </button>
        <button onclick="filterStage('finisher', this)"
            class="stage-pill shrink-0 px-5 py-2.5 rounded-full bg-white/10 text-white/60 border border-white/15 font-bold text-xs uppercase tracking-widest transition active:scale-95">
            🥩 Finisher
        </button>
        <button onclick="filterStage('breeder', this)"
            class="stage-pill shrink-0 px-5 py-2.5 rounded-full bg-white/10 text-white/60 border border-white/15 font-bold text-xs uppercase tracking-widest transition active:scale-95">
            🐽 Breeder
        </button>
    </div>

    {{-- Stats Row --}}
    <div class="flex flex-row gap-4 mb-8 overflow-x-auto pb-2 no-scrollbar">
        <div class="glass-panel min-w-[150px] rounded-3xl p-5 shadow-xl border border-white/5">
            <p class="text-[10px] font-bold text-white/40 mb-2 uppercase tracking-[0.2em]">Total Formulas</p>
            <div class="flex items-end gap-2">
                <h3 class="text-4xl font-black text-white leading-none">{{ $formulas->count() }}</h3>
                <span class="text-[10px] text-white/30 mb-1 font-bold">Available</span>
            </div>
        </div>
        <div class="glass-panel min-w-[150px] rounded-3xl p-5 shadow-xl border border-white/5">
            <p class="text-[10px] font-bold text-white/40 mb-2 uppercase tracking-[0.2em]">Meeting Targets</p>
            <div class="flex items-end gap-2">
                <h3 class="text-4xl font-black text-emerald-400 leading-none">{{ $formulas->where('all_pass', true)->count() }}</h3>
                <span class="text-[10px] text-emerald-500/40 mb-1 font-bold">Approved</span>
            </div>
        </div>
    </div>

    @if($formulas->isEmpty())
        {{-- Empty State --}}
        <div class="glass-panel rounded-3xl p-12 text-center border border-white/5">
            <div class="w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center mx-auto mb-4">
                <i class='bx bx-bowl-hot text-3xl text-white/30'></i>
            </div>
            <p class="text-white/50 font-medium">No feed formulas yet.</p>
            <p class="text-white/25 text-sm mt-1">Ask your admin to create one.</p>
        </div>
    @else
        {{-- Formula Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6" id="formula-grid">
            @foreach($formulas as $formula)
            @php
                $stageEmoji = ['starter'=>'🐷','grower'=>'🐖','finisher'=>'🥩','breeder'=>'🐽'];
                $stageColor = [
                    'starter'  => 'bg-blue-500/20 text-blue-300 border-blue-500/30',
                    'grower'   => 'bg-green-500/20 text-green-300 border-green-500/30',
                    'finisher' => 'bg-amber-500/20 text-amber-300 border-amber-500/30',
                    'breeder'  => 'bg-purple-500/20 text-purple-300 border-purple-500/30',
                ];
                $borderColor = [
                    'starter'  => 'border-l-blue-400',
                    'grower'   => 'border-l-green-400',
                    'finisher' => 'border-l-amber-400',
                    'breeder'  => 'border-l-purple-400',
                ];
            @endphp
            <div class="formula-card glass-panel rounded-2xl p-5 md:p-6 border border-white/5 border-l-4 {{ $borderColor[$formula->life_stage] ?? '' }} shadow-lg cursor-pointer hover:bg-white/10 transition active:scale-[0.98]"
                 data-stage="{{ $formula->life_stage }}"
                 onclick="openFormula({{ $formula->id }})">

                {{-- Card Header --}}
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1 min-w-0 pr-3">
                        <h3 class="text-lg font-black text-white truncate">{{ $formula->name }}</h3>
                        <p class="text-white/40 text-xs mt-0.5">{{ $formula->formulaIngredients->count() }} ingredient(s) · {{ $formula->total_batch_sacks }} sack(s) per batch</p>
                    </div>
                    <span class="shrink-0 px-3 py-1 rounded-full text-[10px] font-black border uppercase tracking-widest {{ $stageColor[$formula->life_stage] ?? '' }}">
                        {{ $stageEmoji[$formula->life_stage] ?? '' }} {{ ucfirst($formula->life_stage) }}
                    </span>
                </div>

                {{-- Ingredient Preview --}}
                <div class="space-y-1.5 mb-4">
                    @foreach($formula->formulaIngredients->take(3) as $item)
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-white/60">{{ $item->ingredient->name }}</span>
                        <span class="text-white/40 font-bold">{{ $item->quantity_sacks }} sack(s)</span>
                    </div>
                    @endforeach
                    @if($formula->formulaIngredients->count() > 3)
                    <p class="text-white/25 text-xs">+{{ $formula->formulaIngredients->count() - 3 }} more ingredient(s)</p>
                    @endif
                </div>

                {{-- Nutrient Status --}}
                <div class="flex items-center justify-between mt-4 pt-4 border-t border-white/5">
                    @if($formula->all_pass)
                        <span class="flex items-center gap-1.5 text-emerald-400 text-xs font-black">
                            <i class='bx bx-check-circle text-base'></i> Meets all nutrient targets
                        </span>
                    @else
                        <span class="flex items-center gap-1.5 text-amber-400 text-xs font-black">
                            <i class='bx bx-error-circle text-base'></i> Some nutrients deficient
                        </span>
                    @endif
                    <button class="px-3 py-1.5 bg-white/5 text-white/50 border border-white/10 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-white/10 transition">
                        View →
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Formula Detail Slide-Up Panel --}}
<div id="formulaBackdrop" class="fixed inset-0 z-[150] hidden bg-black/60 backdrop-blur-sm" onclick="closeFormula()"></div>

<div id="formulaPanel" class="fixed bottom-0 left-0 right-0 z-[200] transform translate-y-full transition-transform duration-300 ease-out"
     style="max-height: 92vh; overflow-y: auto;">
    <div class="bg-[#071510] border-t border-white/10 rounded-t-[2rem] shadow-2xl p-6 md:p-10">

        {{-- Handle --}}
        <div class="w-12 h-1 bg-white/20 rounded-full mx-auto mb-6"></div>

        <div id="panelContent">
            {{-- Populated by JS --}}
        </div>
    </div>
</div>

{{-- Preload formula data as JSON --}}
<script>
const FORMULAS = @json($formulasData);


const STAGE_LABELS = { starter: 'Starter (10–25 kg)', grower: 'Grower (25–60 kg)', finisher: 'Finisher (60–100 kg)', breeder: 'Breeder / Sow' };
const STAGE_EMOJI  = { starter: '🐷', grower: '🐖', finisher: '🥩', breeder: '🐽' };

function openFormula(id) {
    const f = FORMULAS.find(x => x.id === id);
    if (!f) return;

    const req = f.requirements || {};
    const n   = f.nutrients   || {};

    const nutrientRows = [
        { label: 'Crude Protein',   key: 'cp',    unit: '%',       val: n.cp    !== undefined ? n.cp.toFixed(2) + '%'           : '—', req: req.cp    ? '≥ ' + req.cp + '%'                           : '—', pass: n.cp    >= req.cp },
        { label: 'Metab. Energy',   key: 'me',    unit: 'kcal/kg', val: n.me    !== undefined ? Math.round(n.me) + ' kcal/kg'   : '—', req: req.me    ? '≥ ' + req.me.toLocaleString() + ' kcal/kg'   : '—', pass: n.me    >= req.me },
        { label: 'Crude Fat',       key: 'fat',   unit: '%',       val: n.fat   !== undefined ? n.fat.toFixed(2) + '%'          : '—', req: req.fat_min ? req.fat_min + '–' + req.fat_max + '%'        : '—', pass: n.fat   >= (req.fat_min||0) && n.fat <= (req.fat_max||100) },
        { label: 'Crude Fiber',     key: 'fiber', unit: '%',       val: n.fiber !== undefined ? n.fiber.toFixed(2) + '%'        : '—', req: req.fiber_max ? '≤ ' + req.fiber_max + '%'                : '—', pass: n.fiber <= (req.fiber_max||100) },
        { label: 'Calcium',         key: 'ca',    unit: '%',       val: n.ca    !== undefined ? n.ca.toFixed(3) + '%'           : '—', req: req.ca    ? '≥ ' + req.ca + '%'                           : '—', pass: n.ca    >= req.ca },
        { label: 'Phosphorus',      key: 'p',     unit: '%',       val: n.p     !== undefined ? n.p.toFixed(3) + '%'            : '—', req: req.p     ? '≥ ' + req.p + '%'                            : '—', pass: n.p     >= req.p },
    ];

    const ingRows = f.ingredients.map(i => `
        <div class="flex items-center justify-between py-3 border-b border-white/5 last:border-0">
            <span class="text-white/80 font-medium text-sm">${i.name}</span>
            <div class="flex items-center gap-3 text-right">
                <span class="text-white font-black text-sm">${i.sacks} sack(s)</span>
                <span class="text-white/30 text-xs">${i.pct}%</span>
            </div>
        </div>
    `).join('');

    const nutrientHtml = nutrientRows.map(r => `
        <div class="flex items-center justify-between py-2.5 border-b border-white/5 last:border-0">
            <span class="text-white/60 text-xs font-medium">${r.label}</span>
            <div class="flex items-center gap-2">
                <span class="font-black text-sm ${r.pass ? 'text-emerald-400' : 'text-red-400'}">${r.val}</span>
                <span class="text-white/25 text-[10px]">${r.req}</span>
                <span class="text-base">${r.pass ? '✅' : '❌'}</span>
            </div>
        </div>
    `).join('');

    document.getElementById('panelContent').innerHTML = `
        <div class="flex items-start justify-between mb-6">
            <div>
                <div class="inline-block px-3 py-1 rounded-full bg-white/10 text-white/60 text-[10px] font-black uppercase tracking-widest border border-white/10 mb-2">
                    ${STAGE_EMOJI[f.life_stage] || ''} ${STAGE_LABELS[f.life_stage] || f.life_stage}
                </div>
                <h2 class="text-2xl md:text-3xl font-black text-white">${f.name}</h2>
                <p class="text-white/40 text-sm mt-1">Total batch: <strong class="text-white">${f.total_sacks} sack(s)</strong> = ${(f.total_sacks * 50).toLocaleString()} kg</p>
            </div>
            <div class="shrink-0 ml-4 px-3 py-2 rounded-2xl text-center ${f.all_pass ? 'bg-emerald-500/20 border border-emerald-500/30' : 'bg-amber-500/20 border border-amber-500/30'}">
                <span class="text-xl">${f.all_pass ? '✅' : '⚠️'}</span>
                <p class="text-[9px] font-black uppercase tracking-widest mt-1 ${f.all_pass ? 'text-emerald-400' : 'text-amber-400'}">${f.all_pass ? 'Approved' : 'Deficient'}</p>
            </div>
        </div>

        ${f.notes ? `<div class="mb-6 p-4 rounded-2xl bg-white/5 border border-white/10 text-white/60 text-sm leading-relaxed"><i class='bx bx-note mr-1'></i> ${f.notes}</div>` : ''}

        <div class="mb-6">
            <p class="text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-3">🧂 Mixing Instructions (per batch)</p>
            <div class="glass-panel rounded-2xl p-4 border border-white/5">
                ${ingRows}
            </div>
        </div>

        <div>
            <p class="text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-3">📊 Nutrient Analysis</p>
            <div class="glass-panel rounded-2xl p-4 border border-white/5">
                ${nutrientHtml}
            </div>
        </div>

        <button onclick="closeFormula()" class="w-full mt-6 py-4 rounded-2xl bg-white/5 border border-white/10 text-white/60 font-bold text-sm hover:bg-white/10 transition">
            Close
        </button>
    `;

    document.getElementById('formulaBackdrop').classList.remove('hidden');
    document.getElementById('formulaPanel').classList.remove('translate-y-full');
    document.body.style.overflow = 'hidden';
}

function closeFormula() {
    document.getElementById('formulaPanel').classList.add('translate-y-full');
    document.getElementById('formulaBackdrop').classList.add('hidden');
    document.body.style.overflow = '';
}

function filterStage(stage, btn) {
    document.querySelectorAll('.stage-pill').forEach(b => {
        b.classList.remove('bg-green-500/30','text-green-300','border-green-400/40');
        b.classList.add('bg-white/10','text-white/60','border-white/15');
    });
    btn.classList.remove('bg-white/10','text-white/60','border-white/15');
    btn.classList.add('bg-green-500/30','text-green-300','border-green-400/40');

    document.querySelectorAll('.formula-card').forEach(card => {
        card.style.display = (stage === 'all' || card.dataset.stage === stage) ? '' : 'none';
    });
}
</script>

<style>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection
