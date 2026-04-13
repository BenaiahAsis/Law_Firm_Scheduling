<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lawyer Master Calendar') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm font-bold shadow hover:bg-gray-700">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-50 overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-indigo-600">
                <div class="p-8 text-gray-900">
                    
                    <h3 class="text-xl font-bold mb-6 text-gray-800">Scheduled Consultations Overview</h3>
                    
                    <div id="calendar" class="min-h-[600px]"></div>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            
            // We pass the JSON data from our controller directly into JavaScript!
            var eventsData = @json($scheduledCases);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Starts in month view
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay' // Allows switching to week/day views
                },
                events: eventsData,
                eventClick: function(info) {
                    // Opens the link in the same tab (which searches for that user on the dashboard)
                    info.jsEvent.preventDefault(); 
                    if (info.event.url) {
                        window.location.href = info.event.url;
                    }
                }
            });
            
            calendar.render();
        });
    </script>
</x-app-layout>