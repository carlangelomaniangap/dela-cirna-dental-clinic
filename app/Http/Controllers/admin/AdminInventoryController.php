<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
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
            'type' => 'required|in:Equipment,Consumable',
            'stocks' => 'required|integer',
            'expiration_date' => $request->type == 'Consumable' ? 'required|date' : 'nullable',
        ]);

        // Set remaining_stocks equal to stocks by default
        $remaining_stocks = $request->stocks;

        Inventory::create([
            'item_name' => $request->item_name,
            'type' => $request->type,
            'stocks' => $request->stocks,
            'remaining_stocks' => $remaining_stocks,
            'expiration_date' => $request->type == 'Consumable' ? $request->expiration_date : null,
        ]);

        return redirect()->back()->with('success', 'Item added!');
    }

    public function update(Request $request, $id){

        $item = Inventory::findOrFail($id);

        // Check if the item is of type "equipment"
        if ($item->type == 'Equipment') {
            // If it's equipment, we directly add to both total and available quantities
            $item->stocks += $request->quantity;
            $item->remaining_stocks += $request->quantity;
        } 
        // If it's consumable, we handle it based on the action (add_stocks or dispose)
        elseif ($item->type == 'Consumable') {
            // Add to total and available quantities
            if ($request->action == 'add_stocks') {
                // Add quantity to available stock
                $item->stocks += $request->quantity;
                $item->remaining_stocks += $request->quantity;
            } elseif ($request->action == 'dispose') {
                if ($item->remaining_stocks >= $request->quantity) {
                    // Reduce available quantity and increase quantity used
                    $item->remaining_stocks -= $request->quantity;
                    $item->disposed += $request->quantity;
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