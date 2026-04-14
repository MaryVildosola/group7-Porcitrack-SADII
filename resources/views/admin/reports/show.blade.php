@extends('layouts.master')

@section('title', 'Report Details')

@section('contents')
<div class="p-6 md:p-8 max-w-4xl mx-auto">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Weekly Report Details</h1>
            <p class="text-gray-500 text-sm">Submitted for the week starting {{ \Carbon\Carbon::parse($report->week_start_date)->format('M d, Y') }}</p>
        </div>
        <a href="{{ route('admin.reports') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition text-sm font-bold">
            <i class='bx bx-arrow-back'></i> Back to List
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-gray-200 shadow-xl overflow-hidden">
        <!-- Worker Header -->
        <div class="p-8 border-b border-gray-100 bg-gray-50/50 flex items-center gap-6">
            <div class="w-20 h-20 rounded-2xl overflow-hidden border-2 border-white shadow-md">
                <img src="{{ $report->user->photo ? asset('storage/' . $report->user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($report->user->name) }}" class="w-full h-full object-cover">
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $report->user->name }}</h2>
                <p class="text-sm text-gray-400 font-medium">Farm Worker #{{ $report->user->id }}</p>
                <p class="text-xs text-blue-500 font-bold uppercase mt-1 tracking-widest">{{ $report->status }}</p>
            </div>
            <div class="ml-auto text-right">
                <p class="text-xs text-gray-400 uppercase font-bold tracking-tighter">Submitted On</p>
                <p class="text-lg font-bold text-gray-700">{{ $report->created_at->format('M d, Y') }}</p>
                <p class="text-xs text-gray-400">{{ $report->created_at->format('h:i A') }}</p>
            </div>
        </div>

        <!-- Report Content -->
        <div class="p-8">
            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Detailed Report Log</h3>
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 min-h-[300px] leading-relaxed text-gray-700 whitespace-pre-line text-lg italic">
                "{{ $report->details }}"
            </div>
        </div>
        
        <div class="p-8 bg-gray-50 border-t border-gray-100 flex justify-end">
             <button onclick="window.print()" class="px-6 py-2 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-lg flex items-center gap-2">
                <i class='bx bx-printer'></i> Print Report
             </button>
        </div>
    </div>
</div>
@endsection
