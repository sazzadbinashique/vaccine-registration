<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\Registration;
use App\Models\VaccineCenter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return redirect()->route('search')->with('success', 'Registration successful');
    }


    public function search()
    {
        return view('search'); // Create a view named search.blade.php
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
