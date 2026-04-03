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
    // 1. STRICT DATA VALIDATION (Targeting your exact HTML names)
    $validated = $request->validate([
        'legal_category' => 'required|string',
        'description'    => 'required|string|min:20|max:2000',
        
        // This validates the file! Must be pdf/jpg/png and under 2MB (2048 KB)
        'document'       => 'nullable|file|mimes:pdf,jpg,png|max:2048', 
    ], [
        // Custom, Professional Error Messages
        'description.min' => 'Please provide a bit more detail (at least 20 characters) so our legal team can properly prepare.',
        'document.mimes'  => 'Please upload only PDF, JPG, or PNG files.',
        'document.max'    => 'The document must not be larger than 2MB.',
    ]);

    // 2. SECURE FILE UPLOAD HANDLING
    $documentPath = null;
    // If the client uploaded a file, save it securely to the 'public/documents' folder
    if ($request->hasFile('document')) {
        $documentPath = $request->file('document')->store('client_documents', 'public');
    }

    // 3. SAVE THE DATA
    Consultation::create([
        'user_id'        => Auth::id(),
        'legal_category' => $validated['legal_category'],
        'description'    => $validated['description'],
        'document_path'  => $documentPath, // Saves the file path to the database
        'status'         => 'pending',     // Default status
    ]);

    // 4. REDIRECT WITH SUCCESS MESSAGE
    // Note: I changed 'success' to 'status' because your frontend uses session('status')!
    return redirect()->route('dashboard')->with('status', 'Your legal request has been securely submitted.');
}


    public function destroy($id)
{
    // 1. Find the requested case
    $consultation = Consultation::findOrFail($id);

    // 2. SECURITY AUDIT CHECK: Does this case actually belong to the logged-in user?
    if ($consultation->user_id !== Auth::id()) {
        // If they try to delete someone else's case, immediately block them with a 403 Forbidden error.
        abort(403, 'Unauthorized action. You do not have permission to modify this record.');
    }

    // 3. BUSINESS LOGIC CHECK: Are they allowed to cancel it right now?
    // We only want them to cancel if the status is still "pending". 
    if (strtolower($consultation->status) !== 'pending') {
        return back()->with('error', 'You cannot cancel a case that has already been scheduled or completed.');
    }

    // 4. If they pass both security checks, safely delete it
    $consultation->delete();

    // 5. Redirect back with a success message
    return back()->with('status', 'Your legal request has been successfully cancelled.');
}
}