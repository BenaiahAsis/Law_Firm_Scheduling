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
        // 1. Validate the incoming request, specifically looking for the new date
        $request->validate([
            'status' => 'required|string',
            'scheduled_at' => 'nullable|date|after_or_equal:today', 
        ]);

        // 2. Find the case
        $consultation = Consultation::findOrFail($id);

        // 3. THE ALGORITHM: Prevent Double Booking
        if ($request->status === 'scheduled' && $request->scheduled_at) {
            // Check if ANY other case is already scheduled for this exact time
            $conflict = Consultation::where('scheduled_at', $request->scheduled_at)
                                    ->where('id', '!=', $id) // Ignore the current case
                                    ->exists();

            if ($conflict) {
                return back()->with('error', 'Double Booking Alert! Another client is already scheduled for this exact time.');
            }
        }
        
        // 4. Update the database
        $consultation->update([
            'status' => $request->status,
            'scheduled_at' => $request->status === 'scheduled' ? $request->scheduled_at : null,
        ]);

        // 5. Send the automated email
        Mail::to($consultation->user->email)->send(new CaseStatusUpdated($consultation));

        return back()->with('success', 'Case status updated successfully!');
    }
}