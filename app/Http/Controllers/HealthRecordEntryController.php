<?php

namespace App\Http\Controllers;

use App\Models\HealthRecord;
use App\Models\HealthRecordEntry;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use Session;

class HealthRecordEntryController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:therapist');
        $this->middleware('athlete.in.office');
    }

    public function create($athleteId)
    {
        return view('athletes.record.entries.create', compact('athleteId'));
    }

    public function store($athleteId, Request $request)
    {
        $this->validateRequest($request);

        $record = HealthRecord::whereAthleteId($athleteId)->firstOrFail();

        $entry = new HealthRecordEntry($request->input());
        $entry->healthRecord()->associate($record);
        $entry->user()->associate(Auth::user());
        $entry->save();

        return redirect()->action('App\Http\Controllers\HealthRecordEntryController@show', [ $athleteId, $entry->id ]);
    }

    public function show($athleteId, $entryId)
    {
        $entry = HealthRecordEntry::with('user')->findOrFail($entryId);
        $this->validateEntry($athleteId, $entry);

        return view('athletes.record.entries.show', compact('athleteId', 'entry'));
    }

    public function edit($athleteId, $entryId)
    {
        $entry = HealthRecordEntry::editable()->findOrFail($entryId);
        $this->validateEntry($athleteId, $entry);

        Session::flashInput([
            'title' => old('title', $entry->title),
            'content' => old('content', $entry->content)
        ]);

        return view('athletes.record.entries.edit', compact('athleteId', 'entry'));
    }

    public function update($athleteId, $entryId, Request $request)
    {
        $this->validateRequest($request);

        $entry = HealthRecordEntry::editable()->findOrFail($entryId);
        $this->validateEntry($athleteId, $entry);

        $entry->fill($request->input())->save();

        return redirect()->action('App\Http\Controllers\HealthRecordEntryController@show', [ $athleteId, $entry->id ]);
    }

    public function destroy($athleteId, $entryId)
    {
        HealthRecordEntry::editable()->findOrFail($entryId)->delete();

        return redirect()->action('App\Http\Controllers\HealthRecordController@show', [ $athleteId ]);
    }

    private function validateRequest(Request $request) {
        $this->validate($request, [
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

    }

    private function validateEntry($athleteId, $entry) {
        abort_if($entry->healthRecord->athlete->id != $athleteId, 404);
    }
}
