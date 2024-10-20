<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Mail\VaccineScheduleNotification;
use App\Models\Registration;
use App\Models\VaccineCenter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function create(){
        $vaccineCenters = VaccineCenter::all();
        return view('registration', compact('vaccineCenters'));
    }

    public function register(RegistrationRequest $request){

        Registration::create([
            'nid' => $request->nid,
            'name' => $request->name,
            'email' => $request->email,
            'vaccine_center_id' => $request->vaccine_center_id,
            'status' => 'Not scheduled',
        ]);
        return redirect()->route('registration_success');
    }


    // Show success page after registration
    public function registrationSuccess()
    {
        return view('registration_success');
    }

    // Search for user's vaccination status
    public function searchStatus(Request $request)
    {
        $request->validate(['nid' => 'required']);

        $registration = Registration::where('nid', $request->nid)->first();

        if (!$registration) {
            return view('status', ['status' => 'Not registered']);
        }

        $status = $registration->status;
        $scheduledDate = $registration->scheduled_date;

        // Check if the user is vaccinated
        if ($status === 'Scheduled' && $scheduledDate && Carbon::parse($scheduledDate)->isPast()) {
            $status = 'Vaccinated';
        }

        return redirect()->route('registration.success');
    }

    // Schedule users for vaccination
    public function scheduleVaccination()
    {
        $registrations = Registration::where('status', 'Not scheduled')->get();
        $today = Carbon::now();

        foreach ($registrations as $registration) {
            $center = VaccineCenter::find($registration->vaccine_center_id);

            if ($center) {
                // Get the next available date for the vaccine center (Monday to Thursday)
                $date = $this->getNextAvailableDate($center);

                if ($date) {
                    // Schedule the user
                    $registration->scheduled_date = $date;
                    $registration->status = 'Scheduled';
                    $registration->save();

                    // Send email notification
                    Mail::to($registration->user_email)->send(new VaccineScheduleNotification($registration));
                }
            }
        }
    }

    // Get the next available weekday (Sunday to Thursday)
    private function getNextAvailableDate($center)
    {
        $date = Carbon::now()->nextWeekday();
        $scheduledCount = Registration::where('vaccine_center_id', $center->id)
            ->where('scheduled_date', $date->toDateString())
            ->count();

        // Check if the center has capacity for the selected date
        while ($scheduledCount >= $center->max_capacity) {
            $date->addDay();
            $scheduledCount = Registration::where('vaccine_center_id', $center->id)
                ->where('scheduled_date', $date->toDateString())
                ->count();
        }

        return $date->toDateString();
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'nid' => 'required|string',
        ]);

        $registration = Registration::where('nid', $request->nid)->first();

        if (!$registration) {
            return back()->with('status', 'Not registered. <a href="' . route('register') . '">Click here to register</a>');
        }

        // Determine the current date
        $currentDate = Carbon::now()->format('Y-m-d');

        // Check vaccination status
        if ($registration->status === 'Vaccinated' && $registration->scheduled_date < $currentDate) {
            return back()->with('status', 'Vaccinated');
        } elseif ($registration->scheduled_date) {
            return back()->with('status', 'Scheduled on ' . $registration->scheduled_date);
        } else {
            return back()->with('status', 'Not scheduled');
        }
    }


}
