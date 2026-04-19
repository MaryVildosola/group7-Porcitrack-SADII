<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pen Details: {{ $pen->penID ?? 'Pen ' . $pen->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold">Pen Occupancy</h3>
                        <p class="text-gray-600">Currently has {{ $pen->pigs->count() }} pigs</p>
                    </div>
                    <a href="{{ route('pens.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to Pens
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Individual Pig Records in this Pen</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 border-b text-left">Ear Tag ID</th>
                                    <th class="py-3 px-4 border-b text-left">Breed</th>
                                    <th class="py-3 px-4 border-b text-center">Status</th>
                                    <th class="py-3 px-4 border-b text-center">Sales & Disposal Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pen->pigs as $pig)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 border-b">{{ $pig->ear_tag_id ?? 'N/A' }}</td>
                                        <td class="py-3 px-4 border-b">{{ $pig->breed ?? 'N/A' }}</td>
                                        <td class="py-3 px-4 border-b text-center">
                                            <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full text-xs font-semibold">
                                                {{ $pig->status ?? 'Healthy' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 border-b text-center flex justify-center gap-2">
                                            
                                            <form action="{{ route('pigs.sellOrDispose', $pig->id) }}" method="POST" class="flex gap-2">
                                                @csrf
                                                <input type="hidden" name="type" value="Sold">
                                                <input type="number" name="amount" placeholder="Amount (₱)" class="border border-gray-300 rounded px-2 py-1 w-28 text-sm" required>
                                                <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" class="border border-gray-300 rounded px-2 py-1 text-sm" required>
                                                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white py-1 px-3 rounded text-sm transition">
                                                    Sell
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('pigs.sellOrDispose', $pig->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="type" value="Disposed">
                                                <input type="hidden" name="transaction_date" value="{{ date('Y-m-d') }}">
                                                <button type="submit" class="bg-red-600 hover:bg-red-800 text-white py-1 px-3 rounded text-sm transition" onclick="return confirm('Are you sure you want to dispose of this pig?')">
                                                    Dispose
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-gray-500 italic">No healthy/active pigs currently assigned to this pen.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>