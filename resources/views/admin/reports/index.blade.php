@extends('layouts.master')

@section('title', 'Weekly Worker Reports')

@section('contents')
<div class="p-6 md:p-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Weekly Progress Tracking</h1>
        <p class="text-gray-500 text-sm">Monitor mandatory worker submissions for the week of {{ \Carbon\Carbon::parse($thisWeek)->format('M d, Y') }}</p>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Workers</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ $workers->count() }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm border-l-4 border-l-green-500">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Submissions</p>
            <h3 class="text-3xl font-bold text-green-600">{{ $reports->count() }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm border-l-4 border-l-red-500">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Pending</p>
            <h3 class="text-3xl font-bold text-red-500">{{ $workers->count() - $reports->count() }}</h3>
        </div>
    </div>

    <!-- Workers Table -->
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-bottom border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Worker Name</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Submission Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Population</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($workers as $worker)
                    @php $report = $reports->get($worker->id); @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 border border-gray-200">
                                    <img src="{{ $worker->photo ? asset('storage/' . $worker->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($worker->name) }}" alt="" class="w-full h-full object-cover">
                                </div>
                                <span class="font-semibold text-gray-700">{{ $worker->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($report)
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold border border-green-200">SUBMITTED</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold border border-red-200">PENDING</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $report ? $report->created_at->format('M d, Y h:i A') : '---' }}
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-700">
                            {{ $report ? $report->total_pigs : '---' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($report)
                                <a href="{{ route('admin.reports.show', $report->id) }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-bold text-sm transition">
                                    <i class='bx bx-show'></i> View Details
                                </a>
                            @else
                                <span class="text-gray-300 pointer-events-none text-sm italic">Waiting for data</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
