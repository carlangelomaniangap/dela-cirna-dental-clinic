<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Patientlist;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPatientListController extends Controller
{
    public function index(){

        $patientlist = Patientlist::all();
        $patientlist = Patientlist::paginate(10);
        $users = User::all();

        return view('admin.patientlist.patientlist', compact('patientlist', 'users'));
    }

    public function createPatient(){

        $users = User::all();

        return view('admin.patientlist.create', compact('users'));
    }

    public function storePatient(Request $request){

        $request->validate([
            'users_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'birthday' => 'required|date',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'phone' => 'required|string|regex:/^0[0-9]{10}$/',
            'address' => 'required|string',
            'email' => 'required|string|lowercase|email|max:255',
        ]);

        Patientlist::create([
            'users_id' => $request->input('users_id'),
            'name' => $request->input('name'),
            'birthday' => $request->input('birthday'),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
        ]);

        return redirect()->route('admin.patientlist')->with('success', 'Patient added successfully!');
    }

    public function deletePatient($id){

        $patient = Patientlist::findOrFail($id);
        $patient->delete();

        return back()->with('success', 'Patient deleted successfully!');
    }

    public function updatePatient($id){

        $patient = Patientlist::findOrFail($id);
        $users = User::all();

        return view('admin.patientlist.updatePatient', compact('patient', 'users'));
    }

    public function updatedPatient(Request $request, $id){

        $patient = Patientlist::findOrFail($id);
        
        $request->validate([
            'users_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'birthday' => 'required|date',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'phone' => 'required|string|regex:/^0[0-9]{10}$/',
            'address' => 'required|string',
            'email' => 'required|string|lowercase|email|max:255',
        ]);

        $patient->update([
            'users_id' => $request->input('users_id'),
            'name' => $request->input('name'),
            'birthday' => $request->input('birthday'),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
        ]);

        return redirect()->route('admin.patientlist')->with('success', 'Patient updated successfully!');
    }

    public function search(Request $request){
        
        $query = $request->input('query');

        $patientlist = Patientlist::where('name', 'like', "%$query%")
                                ->orWhere('birthday', 'like', "%$query%")
                                ->orWhere('age', 'like', "%$query%")
                                ->orWhere('gender', 'like', "%$query%")
                                ->orWhere('phone', 'like', "%$query%")
                                ->orWhere('address', 'like', "%$query%")
                                ->orWhere('email', 'like', "%$query%")
                                ->paginate(10);

        return view('admin.patientlist.patientlist', compact('patientlist'));
    }
}
