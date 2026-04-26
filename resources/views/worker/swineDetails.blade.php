@extends('layouts.worker')

@section('content')
<style>
    /* Uses same dark system as dashboard */
    .worker-dash { background: linear-gradient(to bottom right, #0a180e, #0d2214, #0a180e); }
</style>

<div class="worker-dash min-h-screen">
<div class="p-6 md:p-12 mt-16 md:mt-0">
    
    <!-- HEADER -->
    <div class="mb-10">
        <h1 class="text-4xl font-black tracking-tight text-slate-900">Animal <span class="text-green-600">Registry</span></h1>
        <p class="text-slate-400 font-medium mt-2 text-sm uppercase tracking-wide">Select a pen to manage individual animals.</p>
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

<!-- FLOATING CARD -->
<div id="floatingCardOverlay" class="fixed inset-0 z-[100] hidden items-start justify-center p-4 pt-20 sm:pt-28">
    <div onclick="hideFloatingCard()" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <div class="dash-card backdrop-blur-2xl bg-white/80 w-full max-w-lg rounded-[3rem] overflow-hidden shadow-2xl relative z-10 max-h-[75vh] flex flex-col">
        
        <button onclick="hideFloatingCard()" class="absolute top-6 right-6 w-10 h-10 rounded-xl dash-inner flex items-center justify-center">
            <i class='bx bx-x text-2xl text-white'></i>
        </button>

        <div id="floatingCardContent" class="flex-1 overflow-y-auto p-6">
            <div class="flex flex-col items-center justify-center py-24 gap-3">
                <i class='bx bx-loader-alt bx-spin text-4xl text-white/30'></i>
                <p class="text-[10px] text-white/40 uppercase">Loading...</p>
            </div>
        </div>
    </div>
</div>

<script>
function enterPen(id, name, pigs) {
    document.getElementById('penGridView').classList.add('hidden');
    document.getElementById('pigListView').classList.remove('hidden');
    document.getElementById('currentPenName').innerText = name;

    const container = document.getElementById('pigsContainer');
    container.innerHTML = pigs.map(p => {
        const color = p.health_status === 'Sick' ? 'red' : (p.health_status === 'Warning' ? 'amber' : 'green');

        return `
        <div onclick="showFloatingCard(${p.id})"
            class="dash-card backdrop-blur-2xl bg-white/80 p-6 rounded-[2rem] flex justify-between items-center cursor-pointer hover:border-green-500/50 transition">

            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl dash-inner flex items-center justify-center">
                    <i class='bx bx-hash text-white'></i>
                </div>
                <div>
                    <h4 class="text-lg font-black text-slate-900">#${p.tag}</h4>
                    <span class="text-xs text-${color}-400 uppercase">${p.health_status}</span>
                </div>
            </div>

            <i class='bx bx-chevron-right text-white/40 text-xl'></i>
        </div>`;
    }).join('');
}

function exitPen() {
    document.getElementById('penGridView').classList.remove('hidden');
    document.getElementById('pigListView').classList.add('hidden');
}

function showFloatingCard(id) {
    const overlay = document.getElementById('floatingCardOverlay');
    overlay.classList.remove('hidden');
    overlay.classList.add('flex');

    fetch(`/worker/pigs/${id}`)
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const card = doc.querySelector('#pig-record-card');
            if(card) document.getElementById('floatingCardContent').innerHTML = card.innerHTML;
        });
}

function hideFloatingCard() {
    const overlay = document.getElementById('floatingCardOverlay');
    overlay.classList.add('hidden');
    overlay.classList.remove('flex');
}
</script>

<style>
@keyframes fadeIn { from { opacity:0; transform: translateY(10px);} to {opacity:1;} }
.animate-fade-in { animation: fadeIn .4s ease; }
</style>

@endsection