<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-600 leading-tight">
                {{ __('Lawyer Master Dashboard') }}
            </h2>
            <a href="{{ route('admin.calendar') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-md text-sm font-bold shadow-lg hover:bg-indigo-500 transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                View Master Calendar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="bg-green-900 border border-green-500 text-green-200 px-4 py-3 rounded relative mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-900 border border-red-500 text-red-200 px-4 py-3 rounded relative mb-6 shadow-sm font-bold">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            <div class="mb-6 bg-slate-800 p-5 rounded-lg shadow-md border border-slate-700">
                <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end sm:items-center">
                    
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Search Cases</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search client name, category, or description..." class="block w-full pl-10 pr-3 py-2 bg-slate-700 border border-slate-600 text-slate-100 placeholder-slate-400 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm shadow-sm">
                        </div>
                    </div>

                    <div class="w-full sm:w-48">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Filter Status</label>
                        <select name="status" class="block w-full py-2 pl-3 pr-10 bg-slate-700 border border-slate-600 text-slate-100 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm shadow-sm" onchange="this.form.submit()">
                            <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Statuses</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending Review</option>
                            <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="flex space-x-2 w-full sm:w-auto mt-4 sm:mt-0">
                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center py-2 px-4 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            Search
                        </button>
                        
                        @if(request('search') || (request('status') && request('status') !== 'all'))
                            <a href="{{ route('admin.dashboard') }}" class="w-full sm:w-auto inline-flex justify-center items-center py-2 px-4 border border-slate-600 shadow-sm text-sm font-bold rounded-md text-slate-200 bg-slate-700 hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-slate-800 overflow-hidden shadow-lg sm:rounded-lg border-t-4 border-indigo-500">
                <div class="p-8 text-slate-100">
                    <h3 class="text-xl font-bold mb-6 text-white">All Client Requests</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse">
                            <thead>
                                <tr class="bg-slate-900">
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-slate-400">Client</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-slate-400">Details</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-slate-400">Document</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-slate-400">Meeting Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-slate-400">Manage Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700">
                                @forelse($allRequests as $case)
                                    <tr class="hover:bg-slate-700 transition duration-150">
                                        <td class="px-6 py-4 align-top">
                                            <div class="text-sm font-bold text-white">{{ $case->user->name }}</div>
                                            <div class="text-xs text-slate-400">{{ $case->user->email }}</div>
                                        </td>
                                        
                                        <td class="px-6 py-4 align-top">
                                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-indigo-900 text-indigo-200 mb-1 inline-block">
                                                {{ $case->legal_category }}
                                            </span>
                                            <div class="text-xs text-slate-300 mt-1">{{ Str::limit($case->description, 40) }}</div>
                                        </td>
                                        
                                        <td class="px-6 py-4 text-center align-top">
                                            @if($case->document_path)
                                                <a href="{{ asset('storage/' . $case->document_path) }}" target="_blank" class="inline-flex items-center text-indigo-400 hover:text-indigo-300 font-bold text-xs transition">
                                                    📄 View
                                                </a>
                                            @else
                                                <span class="text-slate-500 text-xs italic">None</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-sm align-top">
                                            @if($case->scheduled_at)
                                                <span class="font-bold text-green-400">
                                                    {{ $case->scheduled_at->format('M d, Y') }}
                                                </span><br>
                                                <span class="text-xs text-slate-400">
                                                    {{ $case->scheduled_at->format('g:i A') }}
                                                </span>
                                            @else
                                                <span class="text-slate-500 text-xs italic">Not scheduled</span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4 align-top w-64">
                                            <form action="{{ route('admin.consultation.update', $case->id) }}" method="POST" 
                                                  x-data="{ 
                                                      currentStatus: '{{ strtolower($case->status) }}',
                                                      selectedDate: '{{ $case->scheduled_at ? $case->scheduled_at->format('Y-m-d') : '' }}',
                                                      selectedTime: '{{ $case->scheduled_at ? $case->scheduled_at->format('H:i:s') : '' }}'
                                                  }">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <select name="status" x-model="currentStatus" class="w-full bg-slate-900 border-slate-600 text-slate-100 rounded-md shadow-sm text-sm focus:border-indigo-500 mb-2">
                                                    <option value="pending">Pending</option>
                                                    <option value="scheduled">Scheduled</option>
                                                    <option value="completed">Completed</option>
                                                </select>

                                                <div x-show="currentStatus === 'scheduled'" style="display: none;" class="mb-2 space-y-2">
                                                    <input type="hidden" name="scheduled_at" :value="selectedDate && selectedTime ? selectedDate + ' ' + selectedTime : ''">
                                                    
                                                    <input type="date" x-model="selectedDate" class="w-full bg-slate-900 border-slate-600 text-slate-100 rounded-md shadow-sm text-xs focus:border-indigo-500">
                                                    
                                                    <select x-model="selectedTime" class="w-full bg-slate-900 border-slate-600 text-slate-100 rounded-md shadow-sm text-xs focus:border-indigo-500">
                                                        <option value="">Select specific time...</option>
                                                        <option value="13:00:00">1:00 PM</option>
                                                        <option value="13:30:00">1:30 PM</option>
                                                        <option value="14:00:00">2:00 PM</option>
                                                        <option value="14:30:00">2:30 PM</option>
                                                        <option value="15:00:00">3:00 PM</option>
                                                        <option value="15:30:00">3:30 PM</option>
                                                    </select>
                                                </div>

                                                <textarea name="admin_notes" rows="2" placeholder="Add a note for the client..." class="w-full bg-slate-900 border-slate-600 text-slate-100 placeholder-slate-500 rounded-md shadow-sm text-xs focus:border-indigo-500 mb-2 resize-none">{{ $case->admin_notes }}</textarea>

                                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-3 rounded shadow-md text-xs transition-all mt-1">
                                                    Update Case
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                            <svg class="mx-auto h-12 w-12 text-slate-500 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                            </svg>
                                            <span class="italic font-medium">No cases match your search criteria.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                @if(method_exists($allRequests, 'links'))
                    {{ $allRequests->links() }}
                @endif
            </div>

        </div>
    </div>
</x-app-layout>