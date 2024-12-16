<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\AddStock;
use App\Models\Calendar;
use App\Models\Dispose;
use App\Models\Inventory;
use App\Models\Issuance;
use App\Models\Patientlist;
use Illuminate\Http\Request;

class AdminReportsController extends Controller
{
    public function index(){

        return view('admin.reports.reports');
    }

    
    public function print(){
        
        $items = Inventory::all();

        $addstocks = AddStock::all();
        
        $issuances = Issuance::all();

        $disposes = Dispose::all();

        $patientlist = Patientlist::all();

        $calendars = Calendar::all();

        return view('admin.reports.reports', compact('items', 'addstocks', 'issuances', 'disposes', 'patientlist', 'calendars'));
    }
}