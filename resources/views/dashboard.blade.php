<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Law Firm Client Portal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-blue-600">
                <div class="p-8 text-gray-900">
                    <h3 class="text-2xl font-bold mb-2 text-blue-900">Request a Legal Consultation</h3>
                    <p class="text-gray-600 mb-6">Fill out the form below and our legal team will review your request.</p>

                    @if (session('status'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('consultation.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label class="block font-semibold text-sm text-gray-700 mb-1">Service Category</label>
                            <select name="legal_category" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="Notary">Notary Service</option>
                                <option value="Civil Case">Civil Case</option>
                                <option value="Family Law">Family Law</option>
                                <option value="Corporate">Corporate Law</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-sm text-gray-700 mb-1">Case Description</label>
                            <textarea name="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Briefly describe your situation..."></textarea>
                        </div>

                        <div>
                            <label class="block font-semibold text-sm text-gray-700 mb-1">Upload Supporting Document (Optional)</label>
                            <input type="file" name="document" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Accepted formats: PDF, JPG, PNG (Max 2MB)</p>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-700 text-white px-6 py-3 rounded-md font-bold uppercase text-xs shadow-md hover:bg-blue-800">
                                Submit Legal Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-gray-400">
                <div class="p-8 text-gray-900">
                    <h3 class="text-xl font-bold mb-6 text-gray-800">Your Legal Request History</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-600">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-600">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-600">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-600">Document</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-600">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-600">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($myConsultations as $case)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium">{{ $case->legal_category }}</td>
                                        
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600">{{ Str::limit($case->description, 30) }}</div>
                                            
                                            @if($case->admin_notes)
                                                <div class="mt-3 bg-blue-50 border-l-4 border-blue-500 p-3 rounded-r-md shadow-sm">
                                                    <p class="text-[10px] font-bold text-blue-800 uppercase tracking-wider mb-1">Message from Attorney:</p>
                                                    <p class="text-xs text-blue-900 italic">"{{ $case->admin_notes }}"</p>
                                                </div>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">
                                                {{ strtoupper($case->status) }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-4">
                                            @if($case->document_path)
                                                <a href="{{ asset('storage/' . $case->document_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900 underline text-sm font-bold">
                                                    View File
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-sm italic">None</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $case->created_at->format('M d, Y') }}</td>
                                        
                                        <td class="px-6 py-4">
                                            @if(strtolower($case->status) === 'pending')
                                                <form action="{{ route('consultation.destroy', $case->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel and delete this request?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 underline text-sm font-bold">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-sm italic">Locked</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">No legal requests found yet.</td>
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