<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AdminScheduleController extends Controller
{
    public function store(Request $request){
        
        // Validate the input data
        $validated = $request->validate([
            'dentalclinic_id' => 'required', 'exists:dentalclinics,id',
            'startweek' => 'required|string',
            'endweek' => 'required|string',
            'startmorningtime' => 'required',
            'endmorningtime' => 'required',
            'startafternoontime' => 'required',
            'endafternoontime' => 'required',
            'closedday' => 'required|string',
        ]);

        // Create a new schedule
        Schedule::create($validated);

        // Redirect with a success message
        return redirect()->route('admin.dashboard')->with('success', 'Opening hours created successfully.');
    }

    // Update an existing schedule
    public function update(Request $request, $scheduleId){

        // Validate the input data
        $validated = $request->validate([
            'startweek' => 'required|string',
            'endweek' => 'required|string',
            'startmorningtime' => 'required',
            'endmorningtime' => 'required',
            'startafternoontime' => 'required',
            'endafternoontime' => 'required',
            'closedday' => 'required|string',
        ]);

        // Find the schedule by ID and update it
        $schedule = Schedule::findOrFail($scheduleId);
        $schedule->update($validated);

        // Redirect with a success message
        return redirect()->route('admin.dashboard')->with('success', 'Opening hours updated successfully.');
    }

    public function destroy($scheduleId){

        $schedule = Schedule::findOrFail($scheduleId);
        $schedule->delete();
        return redirect()->back()->with('success', 'Schedule deleted successfully.');
    }
}