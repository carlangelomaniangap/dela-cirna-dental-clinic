<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Note;
use Illuminate\Http\Request;
use App\Models\Patientlist;
use App\Models\Record;

class AdminRecordController extends Controller
{
    
    public function showRecord($patientlistId){

        $patientlist = Patientlist::findOrFail($patientlistId);
        
        // Assuming records are associated with the patient list through a one-to-many relationship
        $records = Record::where('patientlist_id', $patientlistId)->get();

        $notes = Note::where('patientlist_id', $patientlistId)->get();

        $count = $records->count();

        $userId = $patientlist->users_id; 
        
        $calendars = Calendar::where('user_id', $userId)
                            ->where('appointmentdate', '>=', now()->toDateString())
                            ->orderBy('appointmentdate')
                            ->get();
        
        return view('admin.patientlist.showRecord', compact('patientlist', 'records', 'notes', 'count', 'calendars'));
    }

    public function createRecord($patientlistId){

        // Find the patient list by ID
        $patientlist = Patientlist::findOrFail($patientlistId);
    
        // Pass the patient list to the view
        return view('admin.patientlist.showRecord', compact('patientlist'));
    }
    
    public function storeRecord(Request $request){

        $request->validate([
            'file' => 'required|file',
            'patientlist_id' => 'required|exists:patientlists,id'
        ]);

        $file = $request->file('file');
        if($file){
            // Get the original file name
            $originalFileName = $file->getClientOriginalName();
            
            // Generate a unique file name to avoid conflicts
            // $uniqueFileName = time() . '_' . $originalFileName;
            $uniqueFileName = $originalFileName;
            
            // Store the file with the unique file name
            $filePath = $file->storeAs($uniqueFileName);
        
            // Save record with patientlist_id
            Record::create([
                'file' => $filePath,
                'patientlist_id' => $request->input('patientlist_id'),
            ]);

            return redirect()->route('admin.showRecord', ['patientlistId' => $request->input('patientlist_id')])
                            ->with('success', 'Record added successfully!');
        }else{
            return redirect()->back()->with('error', 'No file uploaded.');
        }
    }

    public function deleteRecord($patientlistId, $recordId){

        $record = Record::findOrFail($recordId);
        $record->delete();

        return redirect()->route('admin.showRecord', $patientlistId)->with('success', 'Record deleted successfully!');
    }

    public function updateRecord($patientlistId, $recordId){

        $patientlist = Patientlist::findOrFail($patientlistId);
        $record = Record::findOrFail($recordId);

        return view('admin.record.update', compact('patientlist', 'record'));
    }


    public function updatedRecord(Request $request, $patientlistId, $recordId){

        $request->validate([
            'file' => 'nullable|file',
            'patientlist_id' => 'required|exists:patientlists,id'
        ]);

        $record = Record::findOrFail($recordId);

        if($request->hasFile('file')){
            
            $file = $request->file('file');

            // Get the original file name
            $originalFileName = $file->getClientOriginalName();

            // Generate a unique file name to avoid conflicts
            $uniqueFileName = time() . '_' . $originalFileName;

            // Store the file with the unique file name
            $filePath = $file->storeAs($uniqueFileName);

            // Update the file path in the record
            $record->file = $filePath;
        }

        // Update other fields
        $record->patientlist_id = $patientlistId;
        $record->save();

        return redirect()->route('admin.showRecord', $patientlistId)->with('success', 'Record updated successfully!');
    }

    public function downloadRecord($recordId){

        $record = Record::findOrFail($recordId);

        return response()->download(storage_path('app/' . $record->file));
    }

    public function countRecords(){

        $count = Record::count();

        return view('admin.patientlist.showRecord', ['count' => $count]);
    }


    public function createNote($patientlistId){

        $patientlist = Patientlist::findOrFail($patientlistId);

        return view('admin.patientlist.showRecord', compact('patientlist'));
    }

    public function storeNote(Request $request){

        $request->validate([
            'note' => 'required|string|max:255',
            'patientlist_id' => 'required|exists:patientlists,id'
        ]);

        Note::create([
            'note' => $request->input('note'),
            'patientlist_id' => $request->input('patientlist_id'),
        ]);

        return redirect()->route('admin.showRecord', ['patientlistId' => $request->input('patientlist_id')])
            ->with('success', 'Note added successfully!');
    }
}
