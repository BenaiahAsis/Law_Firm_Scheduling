<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Consultation;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Generate 50 realistic fake clients
        for ($i = 0; $i < 50; $i++) {
            
            // 1. Create a fake user
            $user = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'), 
                // Note: Assuming your default users are clients. If you have a specific role column, add it here!
            ]);

            // 2. Determine a random status for their case
            $status = fake()->randomElement(['pending', 'scheduled', 'completed']);
            
            $scheduledAt = null;
            $adminNotes = null;

            // 3. If it's scheduled or completed, generate a realistic time slot!
            if ($status !== 'pending') {
                // Pick a random day in the next 30 days
                $daysToAdd = fake()->numberBetween(1, 30);
                
                // Pick a random hour between 1 PM (13) and 3 PM (15)
                $hour = fake()->numberBetween(13, 15); 
                
                // Snap to either the top or bottom of the hour
                $minute = fake()->randomElement(['00', '30']); 
                
                $scheduledAt = Carbon::today()->addDays($daysToAdd)->format("Y-m-d {$hour}:{$minute}:00");
                $adminNotes = 'Reviewed by Admin. Case file is prepared and ready for the consultation.';
            }

            // 4. Create the consultation case
            Consultation::create([
                'user_id' => $user->id,
                'legal_category' => fake()->randomElement(['Notary', 'Civil Case', 'Family Law', 'Corporate']),
                'description' => fake()->realTextBetween(60, 250), // Generates realistic paragraphs
                'status' => $status,
                'scheduled_at' => $scheduledAt,
                'admin_notes' => $adminNotes,
            ]);
        }
    }
}