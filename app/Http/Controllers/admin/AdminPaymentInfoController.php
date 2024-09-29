<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPaymentInfoController extends Controller
{
    public function index(){   

        $paymentinfo = PaymentInfo::all();
        $paymentinfo = PaymentInfo::paginate(10);
        $users = User::all();

        return view('admin.paymentinfo.paymentinfo', compact('paymentinfo', 'users'));
    }

    public function createPayment(){

        $users = User::all();

        return view('admin.paymentinfo.create', compact('users'));
    }

    public function storePayment(Request $request){

        $request->validate([ 
            'users_id' => 'required|exists:users,id',
            'patientname' => 'required|string',
            'description' => 'required|string',
            'amount' => 'required|integer',
            'balance' => 'required|integer',
            'date' => 'required|date',
        ]);

        $payment = PaymentInfo::create([
            'users_id' => $request->input('users_id'),
            'patientname' => $request->input('patientname'),
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
            'balance' => $request->input('balance'),
            'date' => $request->input('date'),
        ]);

        return redirect()->route('admin.paymentinfo')->with('success', 'Payment added successfully!');
    }

    public function deletePayment($id){

        $payment = PaymentInfo::findOrFail($id);
        $payment->delete();

        return back()->with('success', 'Payment deleted successfully!');
    }

   
    public function updatePayment($id){

        $payment = PaymentInfo::findOrFail($id);
        $users = User::all();

        return view('admin.paymentinfo.updatePayment', compact('payment', 'users'));
    }

    public function updatedPayment(Request $request, $id){

        $patient = PaymentInfo::findOrFail($id);
        
        $request->validate([
            'users_id' => 'required|exists:users,id',
            'patientname' => 'required|string',
            'description' => 'required|string',
            'amount' => 'required|integer',
            'balance' => 'required|integer',
            'date' => 'required|date',
        ]);

        $patient->update([
            'users_id' => $request->input('users_id'),
            'patientname' => $request->input('patientname'),
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
            'balance' => $request->input('balance'),
            'date' => $request->input('date'),
        ]);

        return redirect()->route('admin.paymentinfo')->with('success', 'Payment updated successfully!');
    }

    public function search(Request $request){
        
        $query = $request->input('query');
        $paymentinfo = PaymentInfo::Where('patientname', 'like', "%$query%")
                                  ->orWhere('description', 'like', "%$query%")
                                  ->orWhere('amount', 'like', "%$query%")
                                  ->orWhere('balance', 'like', "%$query%")
                                  ->orWhere('date', 'like', "%$query%")
                                  ->paginate(10);

        return view('admin.paymentinfo.paymentinfo', compact('paymentinfo'));
    }
}
