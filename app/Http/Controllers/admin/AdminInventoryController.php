<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;

class AdminInventoryController extends Controller
{
    public function index(){

        $userCount = User::whereIn('usertype', ['patient', 'dentistrystudent'])->count();
        $patientCount = User::where('usertype', 'patient')->count();
        $dentistrystudentCount = User::where('usertype', 'dentistrystudent')->count();

        $inventories = Inventory::all();
        
        return view('admin.dashboard', compact('userCount', 'patientCount', 'dentistrystudentCount', 'inventories'));
    }

    public function store(Request $request){

        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
        ]);

        Inventory::create($request->all());

        return redirect()->back()->with('success', 'Inventory created successfully.');
    }

    public function update(Request $request, Inventory $inventory){

        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
        ]);

        $inventory->update($request->all());

        return redirect()->back()->with('success', 'Inventory updated successfully.');
    }

    public function destroy(Inventory $inventory){
        
        $inventory->delete();
        return redirect()->back()->with('success', 'Inventory deleted successfully.');
    }

}