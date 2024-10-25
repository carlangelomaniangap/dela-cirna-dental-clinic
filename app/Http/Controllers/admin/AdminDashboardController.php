<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\User;
use App\Models\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(Request $request){

        $dentalclinicId = Auth::user()->dentalclinic_id;
    
        $clinicUsers = User::where('dentalclinic_id', $dentalclinicId)->whereIn('usertype', ['patient', 'dentistrystudent'])->get();
        
        $userCount = $clinicUsers->count();

        $patientCount = $clinicUsers->where('usertype', 'patient')->count();

        $dentistrystudentCount = $clinicUsers->where('usertype', 'dentistrystudent')->count();

        $approvedAppointments = Calendar::where('dentalclinic_id', $dentalclinicId)->where('approved', 'Approved')->whereDate('appointmentdate', Carbon::today())->count();
        
        $pendingAppointments = Calendar::where('dentalclinic_id', $dentalclinicId)->where('approved', 'Pending')->whereDate('appointmentdate', Carbon::today())->count();
        
        $todayAppointments = Calendar::where('dentalclinic_id', $dentalclinicId)->whereDate('appointmentdate', Carbon::today())->orderBy('appointmenttime')->get();
        
        $inventories = Inventory::where('dentalclinic_id', $dentalclinicId)->get();
    
        $showUserWelcome = $request->session()->get('showUserWelcome', false);
    
        if ($showUserWelcome) {
            $request->session()->forget('showUserWelcome');
        }
    
        return view('admin.dashboard', compact(
            'clinicUsers', 
            'userCount', 
            'patientCount', 
            'dentistrystudentCount', 
            'inventories', 
            'showUserWelcome', 
            'pendingAppointments', 
            'approvedAppointments',
            'todayAppointments'
        ));
    }
    
    public function store(Request $request){

        $request->validate([
            'dentalclinic_id' => 'required', 'exists:dentalclinics,id',
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
        ]);

        // Create the inventory item with the dentalclinic_id
        Inventory::create([
            'dentalclinic_id' => $request->dentalclinic_id, // Ensure this is included
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
        ]);

        return redirect()->back()->with('success', 'Inventory created successfully.');
    }

    public function update(Request $request, Inventory $inventory){

        $request->validate([
            'item_name' => 'required|string|max:255',
        ]);

        // Update the item name
        $inventory->item_name = $request->input('item_name');

        // Check if quantity and action are provided
        if ($request->filled('quantity') && $request->filled('action')) {
            // Determine the new quantity based on the action
            if ($request->action === 'add') {
                $inventory->quantity += $request->quantity;
            } else if ($request->action === 'subtract') {
                if ($inventory->quantity < $request->quantity) {
                    return redirect()->back()->withErrors(['quantity' => 'Not enough quantity to subtract.']);
                }
                $inventory->quantity -= $request->quantity;
            }

            // Log the action in history
            $inventory->histories()->create([
                'inventory_id' => $inventory->id, // Store the inventory ID
                'quantity' => $request->quantity,
                'action' => $request->action,
            ]);
        }

        // Save the inventory changes
        $inventory->save();

        return redirect()->back()->with('success', 'Inventory updated successfully.');
    }

    public function destroy($inventoryId){

        $inventory = Inventory::findOrFail($inventoryId);
        $inventory->delete();
        return redirect()->back()->with('success', 'Inventory deleted successfully.');
    }

    public function show(Inventory $inventory){

        $histories = $inventory->histories()->get();
        
        return view('admin.inventory.history', compact('inventory', 'histories'));
    }

}