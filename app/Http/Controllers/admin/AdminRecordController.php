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
    
    public function showRecord(Request $request, $patientlistId){

        $patientlist = Patientlist::findOrFail($patientlistId);
        
        // Assuming records are associated with the patient list through a one-to-many relationship
        $records = Record::where('patientlist_id', $patientlistId)->get();

        $notes = Note::where('patientlist_id', $patientlistId)->get();

        $count = $records->count();

        $userId = $patientlist->users_id; 
        
        // Determine the appointment type filter
        $filter = $request->get('filter', 'upcoming'); // Default to 'upcoming'

        // Retrieve appointments based on the selected filter
        if ($filter == 'past') {
            // Get past appointments
            $calendars = Calendar::where('user_id', $userId)
                                 ->where('appointmentdate', '<', now()->toDateString())
                                 ->orderBy('appointmentdate', 'desc')
                                 ->get();
        } else {
            // Get upcoming appointments
            $calendars = Calendar::where('user_id', $userId)
                                 ->where('appointmentdate', '>=', now()->toDateString())
                                 ->orderBy('appointmentdate')
                                 ->get();
        }
        
        return view('admin.patientlist.showRecord', compact('patientlist', 'records', 'notes', 'count', 'calendars', 'filter'));
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
        if ($file) {
            // Get the original file name and extension
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
    
            // Create a unique file name
            $uniqueFileName = $originalFileName . '.' . $extension;
            $counter = 1;
    
            // Ensure the unique file name doesn't conflict
            while (Record::where('file', $uniqueFileName)->exists()) {
                $uniqueFileName = $originalFileName . "($counter)." . $extension;
                $counter++;
            }
    
            // Store the file with the unique file name
            $filePath = $file->storeAs('', $uniqueFileName); // Store in default disk
    
            // Save record with patientlist_id
            Record::create([
                'file' => $filePath,
                'patientlist_id' => $request->input('patientlist_id'),
            ]);
    
            return redirect()->route('admin.showRecord', ['patientlistId' => $request->input('patientlist_id')])
                             ->with('success', 'Record added successfully!');
        } else {
            return redirect()->back()->with('error', 'No file uploaded.');
        }
    }

    public function deleteRecord($patientlistId, $recordId){

        $record = Record::findOrFail($recordId);
        $record->delete();

        return redirect()->route('admin.showRecord', $patientlistId)->with('success', 'Record deleted successfully!');
    }


    public function updatedRecord(Request $request, $patientlistId, $recordId){

        $request->validate([
            'file' => 'required|string|max:255',
        ]);
    
        // Find the record
        $record = Record::findOrFail($recordId);
    
        // Extract the current file name and extension
        $currentFileName = $record->file;
        $currentBaseName = pathinfo($currentFileName, PATHINFO_FILENAME);
        $extension = pathinfo($currentFileName, PATHINFO_EXTENSION);
    
        // Create the new file name
        $newFileName = $request->file . '.' . $extension;
    
        // Check if the file name has changed
        if ($currentFileName !== $newFileName) {
            // Ensure the new file name is unique
            $baseName = pathinfo($newFileName, PATHINFO_FILENAME);
            $counter = 1;
    
            // Check if the file exists in the records
            while (Record::where('file', $newFileName)->exists()) {
                // Create a new file name with a counter
                $newFileName = $baseName . "($counter)." . $extension;
                $counter++;
            }
    
            // Update the file name
            $record->file = $newFileName;
            $record->save();
    
            return redirect()->route('admin.showRecord', $patientlistId)->with('success', 'File name updated successfully.');
        }
    
        // If no changes were made, redirect without success message
        return redirect()->route('admin.showRecord', $patientlistId);
    }

    public function downloadRecord($patientlistId, $recordId){

        PatientList::findOrFail($patientlistId);

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

    public function update(Request $request, $patientlistId, $noteId){
        // Validate the incoming request
        $request->validate([
            'note' => 'required|string|max:255', // Adjust the max length as needed
        ]);

        // Find the note by ID
        $note = Note::findOrFail($noteId);

        // Check if the note content has changed
        $newNoteContent = $request->input('note');
        if ($note->note !== $newNoteContent) {
            // Update the note content
            $note->note = $newNoteContent;
            $note->save();

            // Redirect back with a success message and compact patientlistId
            return redirect()->back()->with('success', 'Note updated successfully!')->with(compact('patientlistId'));
        }

        // If the note content is unchanged, redirect back without a message
        return redirect()->back();
    }
}
