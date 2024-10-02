<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request){

        $userCount = User::whereIn('usertype', ['patient', 'dentistrystudent'])->count();
        $patientCount = User::where('usertype', 'patient')->count();
        $dentistrystudentCount = User::where('usertype', 'dentistrystudent')->count();

        $inventories = Inventory::all();

        $showUserWelcome = $request->session()->get('showUserWelcome', false);
    
        // Clear the session variable if it exists
        if ($showUserWelcome) {
            $request->session()->forget('showUserWelcome');
        }

        return view('admin.dashboard', compact('userCount', 'patientCount', 'dentistrystudentCount', 'inventories', 'showUserWelcome'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
        ]);

        Inventory::create($request->all());

        return redirect()->back()->with('success', 'Inventory created successfully.');
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
        ]);

        $inventory->update($request->all());

        return redirect()->back()->with('success', 'Inventory updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->back()->with('success', 'Inventory deleted successfully.');
    }

}