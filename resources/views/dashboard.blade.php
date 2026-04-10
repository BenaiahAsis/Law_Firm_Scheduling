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
                            <select name="legal_category" class="w-full rounded-md shadow-sm @error('legal_category') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-gray-300 focus:border-blue-500 focus:ring-blue-500 @enderror">
                                <option value="Notary" {{ old('legal_category') == 'Notary' ? 'selected' : '' }}>Notary Service</option>
                                <option value="Civil Case" {{ old('legal_category') == 'Civil Case' ? 'selected' : '' }}>Civil Case</option>
                                <option value="Family Law" {{ old('legal_category') == 'Family Law' ? 'selected' : '' }}>Family Law</option>
                                <option value="Corporate" {{ old('legal_category') == 'Corporate' ? 'selected' : '' }}>Corporate Law</option>
                            </select>
                            @error('legal_category')
                                <p class="text-red-500 text-xs font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-semibold text-sm text-gray-700 mb-1">Case Description</label>
                            <textarea name="description" rows="4" class="w-full rounded-md shadow-sm @error('description') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-gray-300 focus:border-blue-500 focus:ring-blue-500 @enderror" placeholder="Briefly describe your situation...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs font-medium mt-1 flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-semibold text-sm text-gray-700 mb-1">Upload Supporting Document (Optional)</label>
                            <input type="file" name="document" class="w-full rounded-md shadow-sm text-sm @error('document') border-red-500 focus:border-red-500 focus:ring-red-500 @else border-gray-300 focus:border-blue-500 focus:ring-blue-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500 font-medium">Accepted formats: PDF, JPG, PNG (Max 2MB)</p>
                            
                            <div class="mt-2 bg-slate-50 border border-slate-200 rounded-md p-3 flex items-start">
                                <svg class="w-4 h-4 text-slate-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                <p class="text-[11px] text-slate-600 leading-tight">
                                    <strong>Data Privacy Notice:</strong> All uploaded documents are securely stored and will only be accessed by Attorney Rosales and authorized legal staff for the sole purpose of evaluating your case.
                                </p>
                            </div>

                            @error('document')
                                <p class="text-red-500 text-xs font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-50 border border-gray-200 rounded-md p-4 mt-2">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" name="terms" type="checkbox" class="w-4 h-4 border-gray-300 rounded text-blue-600 focus:ring-blue-500 @error('terms') border-red-500 @enderror" {{ old('terms') ? 'checked' : '' }}>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-bold text-gray-900">I agree to the Legal Terms and Conditions</label>
                                    <p class="text-xs text-gray-500 mt-0.5">By checking this box, you acknowledge that submitting this request does not establish a formal attorney-client relationship until officially accepted by the firm.</p>
                                </div>
                            </div>
                            @error('terms')
                                <p class="text-red-500 text-xs font-bold mt-2 flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit" class="bg-blue-700 text-white px-6 py-3 rounded-md font-bold uppercase text-xs shadow-md hover:bg-blue-800 transition duration-150">
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