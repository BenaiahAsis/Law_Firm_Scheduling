<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-600 leading-tight">
            {{ __('Lawyer Administration Portal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-red-600">
                <div class="p-8 text-gray-900">
                    <h3 class="text-xl font-bold mb-6">Incoming Legal Requests (All Clients)</h3>

                    @if (session('success'))
                        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="min-w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase">Client Name</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase">Description</th>
                                
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase">Attached Document</th>
                                
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase">Update Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($allRequests as $request)
                            <tr>
                                <td class="px-6 py-4 font-bold">{{ $request->user->name }}</td>
                                <td class="px-6 py-4">{{ $request->legal_category }}</td>
                                <td class="px-6 py-4 text-sm">{{ $request->description }}</td>
                                
                                <td class="px-6 py-4">
                                    @if($request->document_path)
                                        <a href="{{ asset('storage/' . $request->document_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900 underline text-sm font-bold">
                                            View File
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm italic">No file</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.consultation.update', $request->id) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                                            <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="scheduled" {{ $request->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                            <option value="completed" {{ $request->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-700 shadow-sm">
                                            SAVE
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>