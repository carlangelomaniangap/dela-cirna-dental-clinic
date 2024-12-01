<?php

namespace App\Http\Controllers\patient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patientlist;
use App\Models\Record;

class PatientRecordController extends Controller
{

    public function showRecord($patientlistId, $recordId){

        $patientlist = Patientlist::findOrFail($patientlistId);
        $records = $patientlist->records;
        $record = Record::findOrFail($recordId);
    
        return view('patient.patientlist.showRecord', compact('patientlist', 'records', 'record'));
    }
}
