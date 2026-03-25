<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Needed to send emails
use App\Mail\CaseStatusUpdated; // The "Envelope" we just created

class AdminController extends Controller
{
    public function index()
    {
        // The Lawyer sees EVERYONE'S requests
        $allRequests = Consultation::with('user')->latest()->get();
        
        return view('admin.dashboard', compact('allRequests'));
    }

    public function updateStatus(Request $request, $id)
    {
        // 1. Find the specific legal case by its ID
        $consultation = Consultation::findOrFail($id);
        
        // 2. Update the status
        $consultation->update([
            'status' => $request->status
        ]);

        // 3. SEND THE AUTOMATED EMAIL!
        Mail::to($consultation->user->email)->send(new CaseStatusUpdated($consultation));

        // 4. Send the lawyer back with a success message
        return back()->with('success', 'Case status updated and email sent to client!');
    }
}