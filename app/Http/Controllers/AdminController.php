<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Needed to send emails
use App\Mail\CaseStatusUpdated; // The "Envelope" we just created

class AdminController extends Controller
{
    public function index(Request $request)
    
    {
        // 1. Start a base query (and load the user relationship so we know whose case it is)
        $query = Consultation::with('user')->latest();

        // 2. SEARCH LOGIC: Did she type something in the search bar?
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            
            $query->where(function ($q) use ($searchTerm) {
                // Search the case description or category
                $q->where('legal_category', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  // Search the client's actual name
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // 3. FILTER LOGIC: Did she select a specific status from a dropdown?
        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        // 4. Execute the query and paginate the results (10 per page)
        // CHANGED: Renamed variable to $allRequests to match your Blade view!
        $allRequests = $query->paginate(10)->withQueryString();

        return view('admin.dashboard', compact('allRequests'));
    }

    
      public function calendar()
    {
        // 1. Fetch only cases that have been officially scheduled
        $scheduledCases = Consultation::with('user')
            ->where('status', 'scheduled')
            ->whereNotNull('scheduled_at')
            ->get()
            ->map(function ($case) {
                // 2. Format the data exactly how FullCalendar.js expects it
                return [
                    'title' => $case->user->name . ' (' . $case->legal_category . ')',
                    'start' => $case->scheduled_at->format('Y-m-d\TH:i:s'),
                    'url'   => route('admin.dashboard', ['search' => $case->user->name]), // Clicking the calendar event searches for the user!
                    'color' => '#4f46e5' // Indigo color for the events
                ];
            });

        return view('admin.calendar', compact('scheduledCases'));
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