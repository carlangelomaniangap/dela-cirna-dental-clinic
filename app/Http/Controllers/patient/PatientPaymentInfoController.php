<?php

namespace App\Http\Controllers\patient;
use App\Http\Controllers\Controller;
use App\Models\PaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientPaymentInfoController extends Controller
{
    public function index(){

        $paymentinfo = PaymentInfo::where('users_id', Auth::id())->paginate(10);
        
        return view('patient.paymentinfo.paymentinfo', compact('paymentinfo'));
    }

    public function search(Request $request){

        $query = $request->input('query');
        $paymentinfo = PaymentInfo::where('users_id', Auth::id())
            ->where(function($q) use ($query) {
                $q->where('description', 'like', "%$query%")
                  ->orWhere('amount', 'like', "%$query%")
                  ->orWhere('balance', 'like', "%$query%")
                  ->orWhere('date', 'like', "%$query%");
            })->paginate(10);

        return view('patient.paymentinfo.paymentinfo', compact('paymentinfo'));
    }

    public function paymentHistory($paymentId){
        
        $paymentInfo = PaymentInfo::with('payments')->findOrFail($paymentId);
        $paymenthistories = $paymentInfo->payments;

        return view('patient.paymentinfo.paymenthistories', compact('paymenthistories', 'paymentInfo'));
    }
}
