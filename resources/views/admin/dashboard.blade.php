<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lawyer Master Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 shadow-sm font-bold">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-indigo-600">
                <div class="p-8 text-gray-900">
                    <h3 class="text-xl font-bold mb-6 text-gray-800">All Client Requests</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-600">Client</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-600">Details</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-600">Document</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-600">Meeting Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-600">Manage Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($allRequests as $case)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $case->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $case->user->email }}</div>
                                        </td>
                                        
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800 mb-1 inline-block">
                                                {{ $case->legal_category }}
                                            </span>
                                            <div class="text-xs text-gray-600 mt-1">{{ Str::limit($case->description, 40) }}</div>
                                        </td>
                                        
                                        <td class="px-6 py-4 text-center">
                                            @if($case->document_path)
                                                <a href="{{ asset('storage/' . $case->document_path) }}" target="_blank" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-bold text-xs">
                                                    📄 View
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-xs italic">None</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-sm">
                                            @if($case->scheduled_at)
                                                <span class="font-bold text-green-700">
                                                    {{ $case->scheduled_at->format('M d, Y') }}
                                                </span><br>
                                                <span class="text-xs text-gray-500">
                                                    {{ $case->scheduled_at->format('g:i A') }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs italic">Not scheduled</span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4 align-top">
                                            <form action="{{ route('admin.consultation.update', $case->id) }}" method="POST" x-data="{ currentStatus: '{{ strtolower($case->status) }}' }">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <select name="status" x-model="currentStatus" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-indigo-500 mb-2">
                                                    <option value="pending">Pending</option>
                                                    <option value="scheduled">Scheduled</option>
                                                    <option value="completed">Completed</option>
                                                </select>

                                                <div x-show="currentStatus === 'scheduled'" style="display: none;" class="mb-2">
                                                    <input type="datetime-local" name="scheduled_at" 
                                                           value="{{ $case->scheduled_at ? $case->scheduled_at->format('Y-m-d\TH:i') : '' }}" 
                                                           class="w-full border-gray-300 rounded-md shadow-sm text-xs focus:border-indigo-500">
                                                </div>

                                                <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-3 rounded shadow-md text-xs transition-all mt-1">
    Update Case
</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">No incoming requests to manage.</td>
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