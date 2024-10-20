<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Registration;
use App\Models\VaccineCenter;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ScheduleVaccination extends Command
{
    // The name and signature of the console command.
    protected $signature = 'schedule:vaccination';

    // The console command description.
    protected $description = 'Assign users to vaccine centers and schedule vaccinations';

    // Execute the console command.
    public function handle()
    {
        $today = Carbon::today();
        $tomorrow = $today->addDay();
        $weekday = $tomorrow->isWeekday();

        // Get users who are registered but not scheduled yet
        $unscheduledUsers = Registration::whereNull('scheduled_date')->orderBy('created_at')->get();

        if ($unscheduledUsers->isEmpty()) {
            $this->info('No users to schedule.');
            return;
        }

        // Get available vaccine centers with their remaining capacity for the day
        $vaccineCenters = VaccineCenter::all();

        foreach ($unscheduledUsers as $user) {
            // Assign user to a vaccine center based on capacity and weekday
            foreach ($vaccineCenters as $center) {
                $centerCapacity = $center->daily_limit;
                $scheduledUsers = Registration::where('scheduled_date', $tomorrow)
                    ->where('vaccine_center_id', $center->id)
                    ->count();

                if ($scheduledUsers < $centerCapacity && $weekday) {
                    // Assign the user to this center and schedule them for the next available weekday
//                    $user->vaccine_center_id = $center->id;
                    $user->scheduled_date = $tomorrow;
                    $user->status = 'Scheduled';
                    $user->save();

                    // Send email notification for users scheduled for tomorrow
                    if ($user->scheduled_date == $tomorrow) {
                        Mail::to($user->email)->send(new \App\Mail\VaccineScheduleNotification($user));
                    }

                    $this->info('User ' . $user->nid . ' scheduled at center ' . $center->name . ' for ' . $user->scheduled_date->format('Y-m-d'));
                    break; // Move to the next user
                }
            }
        }
    }
}
