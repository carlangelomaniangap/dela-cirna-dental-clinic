<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminInventoryController extends Controller
{
    public function index(Request $request){
        
        $items = Inventory::all();

        return view('admin.inventory.inventory', compact('items'));
    }
    
    public function store(Request $request){

        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_type' => 'required|in:Equipment,Consumable',
            'total_quantity' => 'required|integer',
            'expiration_date' => $request->item_type == 'Consumable' ? 'required|date' : 'nullable',
        ]);

        // Set available_quantity equal to total_quantity by default
        $available_quantity = $request->total_quantity;

        Inventory::create([
            'item_name' => $request->item_name,
            'item_type' => $request->item_type,
            'total_quantity' => $request->total_quantity,
            'available_quantity' => $available_quantity,
            'expiration_date' => $request->item_type == 'Consumable' ? $request->expiration_date : null,
            'last_updated' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Item added!');
    }

    public function update(Request $request, $id){

        $item = Inventory::findOrFail($id);

        // Check if the item is of type "equipment"
        if ($item->item_type == 'Equipment') {
            // If it's equipment, we directly add to both total and available quantities
            $item->total_quantity += $request->quantity;
            $item->available_quantity += $request->quantity;
        } 
        // If it's consumable, we handle it based on the action (add or used)
        elseif ($item->item_type == 'Consumable') {
            // Add to total and available quantities
            if ($request->action == 'add') {
                // Add quantity to available stock
                $item->total_quantity += $request->quantity;
                $item->available_quantity += $request->quantity;
            } elseif ($request->action == 'used') {
                if ($item->available_quantity >= $request->quantity) {
                    // Reduce available quantity and increase quantity used
                    $item->available_quantity -= $request->quantity;
                    $item->quantity_used += $request->quantity;
                } else {
                    // If available quantity is less than the quantity to be used, prevent the update
                    return redirect()->back()->with('error', 'Insufficient available quantity to use.');
                }
            }
        }

        $item->save();

        return redirect()->back()->with('success', 'Item quantity updated!');
    }

    public function print()
    {
        // Get all inventory data or filter as needed
        $items = Inventory::all();

        // Return a view with the data
        return view('admin.inventory.inventory', compact('items'));
    }
}