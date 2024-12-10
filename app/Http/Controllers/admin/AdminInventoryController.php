<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\AddStock;
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
            'unit' => 'required|in:Each,Box,Pack,Roll,Vial,Tube,Bottle,Carton,Packet,Strip,Tray,Ampoule,Case,Set,Module',
            'stocks' => 'required|integer',
            'expiration_date' => 'date|nullable',
        ]);

        // Set remaining_stocks equal to stocks by default
        $remaining_stocks = $request->stocks;

        Inventory::create([
            'item_name' => $request->item_name,
            'type' => $request->type,
            'unit' => $request->unit,
            'stocks' => $request->stocks,
            'remaining_stocks' => $remaining_stocks,
            'expiration_date' => $request->expiration_date,
        ]);

        return redirect()->back()->with('success', 'Item added!');
    }

    public function update(Request $request, $id){
        
        $item = Inventory::findOrFail($id);

        $request->validate([
            'item_name' => 'required|string|max:255',
            'unit' => 'required|in:Each,Box,Pack,Roll,Vial,Tube,Bottle,Carton,Packet,Strip,Tray,Ampoule,Case,Set,Module',
        ]);

         // Update the item
        $item->update([
            'item_name' => $request->input('item_name'),
            'unit' => $request->input('unit'),
        ]);

        return redirect()->back()->with('success', 'Item updated successfully!');
    }

    public function AddStock(Request $request, $id){

        // Validate the request data
        $request->validate([
            'receiver_name' => 'required|string|max:255',
            'expiration_date' => 'nullable|date',
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the inventory
        $inventory = Inventory::findOrFail($id);

        // Create a new AddStock record
        $addStock = new AddStock([
            'inventory_id' => $inventory->id,  // Make sure this is correctly passed
            'receiver_name' => $request->receiver_name,
            'expiration_date' => $request->expiration_date,
            'quantity' => $request->quantity,
        ]);

        // Save the AddStock record
        $addStock->save();

        // Update the inventory's stocks and remaining_stocks
        $inventory->stocks += $request->quantity;  // Add to stocks
        $inventory->remaining_stocks += $request->quantity;  // Add to remaining stocks
        $inventory->save();  // Save the updated inventory

        return redirect()->back()->with('success', 'Stock added successfully!');
    }
    
    public function print(){
        // Get all inventory data or filter as needed
        $items = Inventory::all();

        // Return a view with the data
        return view('admin.inventory.inventory', compact('items'));
    }
}