<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Patientlist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPatientListController extends Controller
{
    public function index(){

        $patientlist = Patientlist::paginate(10);
        
        $user = Auth::user();

        // Retrieve only the patients for the specific dental clinic
        $patientlist = Patientlist::where('id', $user->id)->paginate(10);
        $users = User::where('id', $user->id)->get();

        return view('admin.patientlist.patientlist', compact('patientlist', 'users'));
    }

    public function createPatient(){

        $user = Auth::user();

        // Retrieve only users (patients) associated with the specific dental clinic
        $users = User::where('id', $user->id)->whereIn('usertype', ['patient'])->get();

        return view('admin.patientlist.create', compact('users'));
    }

    public function storePatient(Request $request){

        $request->validate([
            'dentalclinic_id' => 'required', 'exists:dentalclinics,id',
            'users_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'gender' => 'required|string',
            'birthday' => 'required|date',
            'age' => 'required|integer',
            'address' => 'required|string',
            'phone' => 'required|string|regex:/^0[0-9]{10}$/',
            'email' => 'required|string|lowercase|email|max:255',
        ]);

        Patientlist::create([
            'dentalclinic_id' => $request->dentalclinic_id,
            'users_id' => $request->input('users_id'),
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),
            'birthday' => $request->input('birthday'),
            'age' => $request->input('age'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
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
            'gender' => 'required|string',
            'birthday' => 'required|date',
            'age' => 'required|integer',
            'address' => 'required|string',
            'phone' => 'required|string|regex:/^0[0-9]{10}$/',
            'email' => 'required|string|lowercase|email|max:255',
        ]);

        $patient->update([
            'users_id' => $request->input('users_id'),
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),
            'birthday' => $request->input('birthday'),
            'age' => $request->input('age'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
        ]);

        return redirect()->route('admin.patientlist')->with('success', 'Patient updated successfully!');
    }

    public function search(Request $request){
        
        $query = $request->input('query');

        $patientlist = Patientlist::where('name', 'like', "%$query%")
                                ->orWhere('gender', 'like', "%$query%")
                                ->orWhere('birthday', 'like', "%$query%")
                                ->orWhere('age', 'like', "%$query%")
                                ->orWhere('address', 'like', "%$query%")
                                ->orWhere('phone', 'like', "%$query%")
                                ->orWhere('email', 'like', "%$query%")
                                ->paginate(10);

        return view('admin.patientlist.patientlist', compact('patientlist'));
    }
}
