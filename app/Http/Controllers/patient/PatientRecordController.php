<?php

namespace App\Http\Controllers\patient;
use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Note;
use Illuminate\Http\Request;
use App\Models\Patientlist;
use App\Models\Record;

class PatientRecordController extends Controller
{
    
    public function showRecord(Request $request){

        $patientlist = Patientlist::where('users_id', auth()->id())->first();

        $records = Record::where('patientlist_id', $patientlist->id)->get();
        $notes = Note::where('patientlist_id', $patientlist->id)->get();

        $count = $records->count();

        $filter = $request->get('filter', 'upcoming');

        if ($filter == 'past') {
            $calendars = Calendar::where('user_id', auth()->id()) // Use the logged-in user's ID
                                ->where('appointmentdate', '<', now()->toDateString())
                                ->orderBy('appointmentdate', 'desc')
                                ->get();
        } else {
            $calendars = Calendar::where('user_id', auth()->id()) // Use the logged-in user's ID
                                ->where('appointmentdate', '>=', now()->toDateString())
                                ->orderBy('appointmentdate')
                                ->get();
        }

        return view('patient.record.showRecord', compact('patientlist', 'records', 'notes', 'count', 'calendars', 'filter'));
    }

    public function downloadRecord(){
        
        $patientlist = PatientList::where('users_id', auth()->id())->first();

        $record = Record::where('patientlist_id', $patientlist->id)->firstOrFail();

        $filePath = storage_path('app/' . $record->file);

        return response()->download($filePath);
    }
}
