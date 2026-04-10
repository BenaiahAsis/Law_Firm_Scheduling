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
        $validated = $request->validate([
            'legal_category' => 'required|string',
            'description'    => 'required|string|min:20|max:2000',
            'document'       => 'nullable|file|mimes:pdf,jpg,png|max:2048', 
            'terms'          => 'accepted', 
            // Notice: requested_date and requested_time are GONE
        ], [
            'description.min' => 'Please provide a bit more detail...',
            'document.mimes'  => 'Please upload only PDF, JPG, or PNG files.',
            'document.max'    => 'The document must not be larger than 2MB.',
            'terms.accepted'  => 'You must acknowledge the legal terms.',
        ]);

        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('client_documents', 'public');
        }

        Consultation::create([
            'user_id'        => Auth::id(),
            'legal_category' => $validated['legal_category'],
            'description'    => $validated['description'],
            'document_path'  => $documentPath,
            'scheduled_at'   => null, // Stays null until the Admin sets it!
            'status'         => 'pending',     
        ]);

        return redirect()->route('dashboard')->with('status', 'Your legal request has been securely submitted and is pending review.');
    }

    public function destroy($id)
    {
        // 1. Find the requested case
        $consultation = Consultation::findOrFail($id);

        // 2. SECURITY AUDIT CHECK: Does this case actually belong to the logged-in user?
        if ($consultation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You do not have permission to modify this record.');
        }

        // 3. BUSINESS LOGIC CHECK: Are they allowed to cancel it right now?
        if (strtolower($consultation->status) !== 'pending') {
            return back()->with('error', 'You cannot cancel a case that has already been scheduled or completed.');
        }

        // 4. If they pass both security checks, safely delete it
        $consultation->delete();

        // 5. Redirect back with a success message
        return back()->with('status', 'Your legal request has been successfully cancelled.');
    }
}