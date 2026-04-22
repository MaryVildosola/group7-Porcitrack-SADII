@extends('layouts.worker')

@section('content')
<div class="px-6 py-10 md:p-12 min-h-screen flex items-center justify-center">
    <!-- Centered Digital Record Card -->
    <div class="w-full max-w-2xl animate-fade-in">
        
        <!-- Back Button -->
        <a href="{{ route('worker.swineDetails') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-green-600 font-black text-[10px] uppercase tracking-widest mb-6 transition-all group">
            <i class='bx bx-left-arrow-alt text-xl group-hover:-translate-x-1 transition-transform'></i>
            Back to Inventory
        </a>

        <!-- THE ANIMAL RECORD CARD -->
        <div class="bg-white rounded-[3rem] shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-slate-100 overflow-hidden">
            
            <!-- Card Header: Identity -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 p-8 md:p-10 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-48 h-48 bg-green-500/10 rounded-full blur-3xl -mr-24 -mt-24"></div>
                
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                             <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                             <span class="text-[10px] font-black uppercase text-white/40 tracking-[0.2em]">Active Record</span>
                        </div>
                        <h1 class="text-5xl font-black text-white tracking-tighter mb-2">Pig #{{ $pig->tag }}</h1>
                        <p class="text-green-400 font-black text-sm uppercase tracking-widest">{{ $pig->breed ?? 'Mixed Breed' }}</p>
                    </div>
                    <div class="w-20 h-20 rounded-[2rem] bg-white/5 border border-white/10 flex items-center justify-center text-white/20">
                        <i class='bx bx-pig text-5xl'></i>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2 mt-6 pt-4 border-t border-white/5">
                    <div class="text-center">
                        <p class="text-[8px] font-black text-white/30 uppercase mb-1">Health</p>
                        @php $hc = match($pig->health_status) { 'Sick' => 'red', 'Warning' => 'amber', default => 'green' }; @endphp
                        <p class="text-{{ $hc }}-400 font-black text-[10px] uppercase">{{ $pig->health_status }}</p>
                    </div>
                    <div class="text-center border-x border-white/5 px-2">
                        <p class="text-[8px] font-black text-white/30 uppercase mb-1">Area</p>
                        <p class="text-white font-black text-[10px] uppercase">{{ $pig->pen->name }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-[8px] font-black text-white/30 uppercase mb-1">Age</p>
                        <p class="text-white font-black text-[10px] uppercase">{{ round(\Carbon\Carbon::parse($pig->birth_date)->diffInWeeks(null, true), 1) }} Weeks</p>
                    </div>
                </div>
            </div>

            <!-- Card Body: Performance & Stats -->
            <div class="p-6 space-y-6">
                <!-- Weight & BCS Section -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Growth</p>
                        <div class="flex items-end gap-1">
                            <span class="text-3xl font-black text-slate-900 leading-none">{{ $pig->weight }}</span>
                            <span class="text-xs font-bold text-slate-300 mb-0.5">KG</span>
                        </div>
                        @php $progress = ($pig->target_weight > 0) ? min(100, round(($pig->weight / $pig->target_weight) * 100)) : 0; @endphp
                        <div class="w-full h-1 bg-slate-50 rounded-full overflow-hidden border border-slate-100">
                            <div class="h-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.4)]" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Clinical</p>
                        <div class="flex items-end gap-1">
                            <span class="text-3xl font-black text-slate-900 leading-none">{{ $pig->bcs_score || 3 }}</span>
                            <span class="text-xs font-bold text-slate-300 mb-0.5">/ 5 BCS</span>
                        </div>
                        @php $fs = $pig->feeding_status ?: 'Normal'; @endphp
                        <div class="flex items-center gap-1.5">
                             <div class="w-1.5 h-1.5 rounded-full bg-{{ $fs === 'Active' ? 'green' : ($fs === 'Poor' ? 'red' : 'blue') }}-500"></div>
                             <p class="text-[8px] font-black text-slate-600 uppercase">{{ $fs }} Vigor</p>
                        </div>
                    </div>
                </div>

                <!-- Recent History Section -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-50 pb-2">
                         <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Activity History</p>
                         <button onclick="openMedicalLogger({{ $pig->id }})" class="text-indigo-600 font-black text-[8px] uppercase ring-1 ring-indigo-50 px-2 py-1 rounded-md hover:bg-indigo-50">+ Medical</button>
                    </div>
                    
                    <div class="space-y-2 max-h-[180px] overflow-y-auto pr-1 custom-scrollbar">
                        @forelse($pig->activities as $activity)
                            <div class="flex gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 items-start">
                                @php 
                                    $icon = match($activity->type) { 
                                        'Medical' => 'bx-plus-medical', 'Care' => 'bx-heart', 
                                        'Growth' => 'bx-trending-up', default => 'bx-check-circle' 
                                    };
                                    $iconBg = $activity->type === 'Medical' ? 'red' : ($activity->type === 'Growth' ? 'blue' : 'green');
                                @endphp
                                <div class="w-10 h-10 rounded-xl bg-{{ $iconBg }}-50 text-{{ $iconBg }}-600 flex items-center justify-center shrink-0 border border-{{ $iconBg }}-100">
                                    <i class='bx {{ $icon }} text-lg'></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-black text-slate-900 text-xs uppercase">{{ $activity->action }}</h4>
                                        <span class="text-[8px] font-bold text-slate-300 uppercase shrink-0">{{ $activity->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 font-medium leading-relaxed mt-1 line-clamp-2">{{ $activity->details ?: 'Activity recorded by ' . ($activity->user->name ?? 'System') }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="h-full flex flex-col items-center justify-center opacity-30">
                                <i class='bx bx-history text-4xl mb-2'></i>
                                <p class="text-[10px] font-black uppercase">No logged history</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Detailed Health Reports Section -->
                <div class="space-y-4 pt-4 border-t border-slate-50">
                    <div class="flex items-center justify-between">
                         <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Medical Reports</p>
                         <span class="px-2 py-0.5 bg-slate-100 rounded text-[8px] font-bold text-slate-500">{{ $pig->healthReports->count() }} Records</span>
                    </div>
                    
                    <div class="space-y-3">
                        @foreach($pig->healthReports->take(5) as $report)
                        <div class="p-4 rounded-2xl border {{ $report->symptom === 'Healthy' ? 'border-green-100 bg-green-50/30' : 'border-red-100 bg-red-50/30' }}">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-black {{ $report->symptom === 'Healthy' ? 'text-green-600' : 'text-red-600' }} uppercase tracking-wider">
                                    {{ $report->symptom }}
                                </span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase">{{ $report->created_at->format('M d, H:i') }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4 text-[10px] mb-2">
                                <div>
                                    <span class="text-slate-400">Weight:</span> 
                                    <span class="font-black text-slate-700">{{ $report->weight ?? '—' }} kg</span>
                                </div>
                                <div>
                                    <span class="text-slate-400">BCS:</span> 
                                    <span class="font-black text-slate-700">{{ $report->body_condition_score ?? '—' }}/5</span>
                                </div>
                            </div>
                            @if($report->notes)
                            <p class="text-xs text-slate-600 leading-relaxed italic border-t border-black/5 pt-2 mt-2">
                                "{{ $report->notes }}"
                            </p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Quick Action Footer -->
                <div class="pt-6 border-t border-slate-50 grid grid-cols-2 gap-4">
                    <button onclick="managePig({{ json_encode($pig) }})" class="py-4 rounded-2xl bg-slate-900 text-white font-black text-[10px] uppercase tracking-widest hover:bg-slate-800 transition-all active:scale-95 shadow-xl shadow-slate-900/10">
                        Update Stats
                    </button>
                    <div class="grid grid-cols-3 gap-2">
                        <button onclick="logQuickAction('Care', 'Bathing', 'Bathed and cleaned.', {{ $pig->id }})" class="h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition-all">
                            <i class='bx bx-bath text-xl'></i>
                        </button>
                        <button onclick="logQuickAction('Care', 'Watering', 'Checked water supply.', {{ $pig->id }})" class="h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center hover:bg-sky-100 transition-all">
                            <i class='bx bx-droplet text-xl'></i>
                        </button>
                        <button onclick="logQuickAction('Care', 'Feeding', 'Individual feeding done.', {{ $pig->id }})" class="h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-100 transition-all">
                            <i class='bx bx-bowl-rice text-xl'></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer Meta -->
            <div class="px-10 py-5 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-[9px] font-black text-slate-300 uppercase tracking-widest">
                <span>Created: {{ \Carbon\Carbon::parse($pig->birth_date)->format('M d, Y') }}</span>
                <span>Worker: {{ auth()->user()->name }}</span>
            </div>
        </div>
    </div>
</div>

<script>
    function logQuickAction(type, action, details) {
        Swal.fire({
            title: `<div class="text-left font-black tracking-tight text-3xl">Log ${action}</div>`,
            text: `Log this care activity for #${{{ $pig->tag }}}?`,
            background: '#ffffff',
            showCancelButton: true,
            confirmButtonText: 'Log Activity',
            confirmButtonColor: '#0f172a',
            preConfirm: () => {
                return fetch('{{ route("worker.pigs.log-activity", $pig->id) }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: JSON.stringify({ type: type, action: action, details: details })
                })
                .then(response => {
                    if (!response.ok) return response.json().then(e => { throw new Error(e.message) });
                    return response.json();
                })
                .catch(error => Swal.showValidationMessage(`Sync Error: ${error}`));
            }
        }).then((result) => { if (result.isConfirmed) window.location.reload(); });
    }

    function openMedicalLogger() {
        Swal.fire({
            title: `<div class="text-left font-black tracking-tight text-3xl">Medical Entry</div>`,
            background: '#ffffff',
            html: `
                <div class="text-left py-4 space-y-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Event Nature</label>
                        <select id="mdl-action" class="w-full p-4 rounded-2xl bg-slate-50 border border-slate-100 font-bold text-slate-900">
                            <option value="Vaccination">Vaccination</option>
                            <option value="Medication">Medication</option>
                            <option value="Checkup">General Checkup</option>
                        </select>
                    </div>
                    <div>
                        <input id="mdl-details" type="text" class="w-full p-4 rounded-2xl bg-slate-50 border border-slate-100 font-bold text-slate-900" placeholder="e.g. Parvo Vaccine or Specific Meds">
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Record Event',
            confirmButtonColor: '#4f46e5',
            preConfirm: () => {
                const action = document.getElementById('mdl-action').value;
                const details = document.getElementById('mdl-details').value;
                return fetch('{{ route("worker.pigs.log-activity", $pig->id) }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: JSON.stringify({ type: 'Medical', action: action, details: details })
                })
                .then(response => {
                    if (!response.ok) return response.json().then(e => { throw new Error(e.message) });
                    return response.json();
                })
                .catch(error => Swal.showValidationMessage(`Sync Error: ${error}`));
            }
        }).then((result) => { if (result.isConfirmed) window.location.reload(); });
    }

    function managePig(pig) {
        Swal.fire({
            title: `<div class="text-left font-black tracking-tight text-3xl">Update Stats</div>`,
            background: '#ffffff',
            html: `
                <div class="text-left py-4 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                       <div>
                           <label class="block text-[10px] font-black uppercase text-slate-400 mb-1">Weight (KG)</label>
                           <input id="swal-weight" type="number" step="0.01" class="w-full p-4 rounded-2xl bg-slate-50 border border-slate-100 font-black text-slate-900" value="${pig.weight || 0}">
                       </div>
                       <div>
                           <label class="block text-[10px] font-black uppercase text-slate-400 mb-1">Condition</label>
                            <select id="swal-health" class="w-full p-4 rounded-2xl bg-slate-50 border border-slate-100 font-bold text-slate-900">
                                <option value="Healthy" ${pig.health_status === 'Healthy' ? 'selected' : ''}>Healthy</option>
                                <option value="Warning" ${pig.health_status === 'Warning' ? 'selected' : ''}>Warning</option>
                                <option value="Sick" ${pig.health_status === 'Sick' ? 'selected' : ''}>Sick</option>
                            </select>
                       </div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Update Record',
            confirmButtonColor: '#0f172a',
            preConfirm: () => {
                return fetch(`/worker/pigs/${pig.id}/update`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: JSON.stringify({
                        weight: document.getElementById('swal-weight').value,
                        health_status: document.getElementById('swal-health').value,
                        // Defaults for other fields
                        target_weight: pig.target_weight, breed: pig.breed, bcs_score: pig.bcs_score, feeding_status: pig.feeding_status, symptoms: pig.symptoms, remarks: pig.remarks
                    })
                })
                .then(response => {
                    if (!response.ok) return response.json().then(e => { throw new Error(e.message) });
                    return response.json();
                })
                .catch(error => Swal.showValidationMessage(`Sync Error: ${error}`));
            }
        }).then((result) => { if (result.isConfirmed) window.location.reload(); });
    }
</script>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #f1f5f9; border-radius: 10px; }
</style>
@endsection
