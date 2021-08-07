<?php

namespace App\Http\Controllers;

use App\Models\HealthRecord;
use Illuminate\Http\Request;

use App\Http\Requests;

class HealthRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:therapist');
        $this->middleware('athlete.in.office');
    }

    public function show($athleteId)
    {
        $healthRecord = HealthRecord::whereAthleteId($athleteId)
            ->withEntries()
            ->firstOrFail();

        return view('athletes.record.show', compact('athleteId', 'healthRecord'));
    }

}
