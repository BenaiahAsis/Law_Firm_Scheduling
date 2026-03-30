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
        // 1. Validate the incoming request, now including admin_notes
        $request->validate([
            'status' => 'required|string',
            'scheduled_at' => 'nullable|date|after_or_equal:today', 
            'admin_notes' => 'nullable|string|max:1000', // Allow up to 1000 characters of notes
        ]);

        // 2. Find the case
        $consultation = Consultation::findOrFail($id);

        // 3. THE ALGORITHM: Prevent Double Booking
        if ($request->status === 'scheduled' && $request->scheduled_at) {
            $conflict = Consultation::where('scheduled_at', $request->scheduled_at)
                                    ->where('id', '!=', $id) // Ignore the current case
                                    ->exists();

            if ($conflict) {
                return back()->with('error', 'Double Booking Alert! Another client is already scheduled for this exact time.');
            }
        }
        
        // 4. Update the database (Now saving the notes too!)
        $consultation->update([
            'status' => $request->status,
            'scheduled_at' => $request->status === 'scheduled' ? $request->scheduled_at : null,
            'admin_notes' => $request->admin_notes, // Catches the text from the form
        ]);

            // 5. Send the automated email (assuming Mail facade and CaseStatusUpdated are imported)
            // Mail::to($consultation->user->email)->send(new CaseStatusUpdated($consultation));
    
            return back()->with('success', 'Case updated successfully!');
        }
    }