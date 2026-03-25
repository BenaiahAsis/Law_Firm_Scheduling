<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ConsultationController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate the input (Now checking for a file up to 2MB)
        $request->validate([
            'legal_category' => 'required|string',
            'description' => 'required|string|max:1000',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', 
        ]);

        // 2. Handle the File Upload
        $path = null;
        if ($request->hasFile('document')) {
            // Saves to storage/app/public/documents
            $path = $request->file('document')->store('documents', 'public'); 
        }

        // 3. Save to the database
        Consultation::create([
            'user_id' => Auth::id(),
            'legal_category' => $request->legal_category,
            'description' => $request->description,
            'status' => 'pending',
            'document_path' => $path, // Save the file location!

        ]);

        

        return back()->with('status', 'Consultation request and files sent successfully!');
    }

    public function destroy($id)
    {
        // 1. Find the case, but ONLY if it belongs to the logged-in user
        $consultation = Consultation::where('user_id', Auth::id())->findOrFail($id);

        // 2. Security Check: Prevent deletion if the lawyer is already processing it
        if (strtolower($consultation->status) !== 'pending') {
            return back()->with('error', 'You cannot cancel a request that is already scheduled or completed.');
        }

        // 3. Pro Feature: Delete the attached file from the server to save space
        if ($consultation->document_path) {
            Storage::disk('public')->delete($consultation->document_path);
        }

        // 4. Delete the database record
        $consultation->delete();

        return back()->with('status', 'Your legal request has been successfully cancelled.');
    }
}