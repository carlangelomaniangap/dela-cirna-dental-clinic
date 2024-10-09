<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use App\Models\PaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPaymentInfoController extends Controller
{
    public function index(){   
        
        // Get the dentalclinic_id from the authenticated user
        $dentalclinicId = Auth::user()->dentalclinic_id;

        // Retrieve payment information related to the specific dental clinic
        $paymentinfo = PaymentInfo::where('dentalclinic_id', $dentalclinicId)->paginate(10);

        // Retrieve users associated with the dental clinic (if needed)
        $users = User::where('dentalclinic_id', $dentalclinicId)->get();

        return view('admin.paymentinfo.paymentinfo', compact('paymentinfo', 'users'));
    }

    public function createPayment(){

        // Get the dentalclinic_id from the authenticated user's session or user info
        $dentalclinicId = Auth::user()->dentalclinic_id;

        // Retrieve only users (patients) associated with the specific dental clinic
        $users = User::where('dentalclinic_id', $dentalclinicId)->whereIn('usertype', ['patient'])->get();

        return view('admin.paymentinfo.create', compact('users'));
    }

    public function storePayment(Request $request){

        $request->validate([ 
            'dentalclinic_id' => 'required', 'exists:dentalclinics,id',
            'users_id' => 'required|exists:users,id',
            'patientname' => 'required|string',
            'description' => 'required|string',
            'amount' => 'required|integer',
            'balance' => 'required|integer',
            'date' => 'required|date',
        ]);

        PaymentInfo::create([
            'dentalclinic_id' => $request->dentalclinic_id,
            'users_id' => $request->input('users_id'),
            'patientname' => $request->input('patientname'),
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
            'balance' => $request->input('balance'),
            'date' => $request->input('date'),
        ]);

        return redirect()->route('admin.paymentinfo')->with('success', 'Payment added successfully!');
    }

    public function deletePayment($paymentId){

        $payment = PaymentInfo::findOrFail($paymentId);
        $payment->delete();

        return back()->with('success', 'Payment deleted successfully!');
    }

   
    public function updatePayment($paymentId){

        $payment = PaymentInfo::findOrFail($paymentId);
        $users = User::all();

        return view('admin.paymentinfo.updatePayment', compact('payment', 'users'));
    }

    public function updatedPayment(Request $request, $paymentId){

        $patient = PaymentInfo::findOrFail($paymentId);
        
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
    
    public function addPayment(Request $request, $paymentId){
        
        $request->validate([
            'payment' => 'required|integer', // Validate the payment amount
        ]);

        // Find the payment record by ID
        $payment = PaymentInfo::findOrFail($paymentId);
        
        // Get the current balance from the payment record
        $currentBalance = $payment->balance;

        // Check if the payment amount exceeds the current balance
        if ($request->input('payment') > $currentBalance) {
            return back()->withErrors(['payment' => 'Payment amount exceeds current balance.']);
        }

        // Calculate the new balance
        $newBalance = $currentBalance - $request->input('payment');

        // Update the payment record
        $payment->update([
            'balance' => $newBalance, // Store the new balance
        ]);

        // Create a payment history record
        Payment::create([
            'payment_id' => $payment->id,
            'payment' => $request->input('payment'),
        ]);

        // Redirect with a success message
        return redirect()->route('admin.paymentinfo')->with('success', 'Payment added successfully! New balance: ' . $newBalance);
    }

    public function paymentHistory($paymentId){
        
        $paymentInfo = PaymentInfo::with('payments')->findOrFail($paymentId);
        $paymenthistories = $paymentInfo->payments;

        return view('admin.paymentinfo.paymenthistories', compact('paymenthistories', 'paymentInfo'));
    }

}
