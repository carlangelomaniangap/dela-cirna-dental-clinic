<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\AddStock;
use App\Models\Dispose;
use App\Models\Issuance;
use App\Models\User;
use Illuminate\Http\Request;

class AdminInventoryController extends Controller
{
    public function index(Request $request){
        
        $items = Inventory::all();

        $patients  = User::where('usertype', 'patient')->get();

        $addstocks = AddStock::orderBy('expiration_date', 'asc')->get();

        return view('admin.inventory.inventory', compact('items', 'patients', 'addstocks'));
    }
    
    public function store(Request $request){

        $request->validate([
            'item_name' => 'required|string|max:255',
            'type' => 'required|in:Equipment,Consumable',
            'unit' => 'required|in:Each,Box,Pack,Tube,Bottle,Bag,Kit,Set',
            'stocks' => 'required|integer',
            'expiration_date' => 'date|nullable',
        ]);

        // Set remaining_stocks equal to stocks by default
        $remaining_stocks = $request->stocks;

        $inventory = Inventory::create([
            'item_name' => $request->item_name,
            'type' => $request->type,
            'unit' => $request->unit,
            'stocks' => $request->stocks,
            'remaining_stocks' => $remaining_stocks,
            'expiration_date' => $request->expiration_date,
        ]);

        AddStock::create([
            'inventory_id' => $inventory->id,
            'receiver_name' => $request->receiver_name ?? 'N/A',
            'expiration_date' => $request->expiration_date,
            'quantity' => $request->stocks,
        ]);

        return redirect()->back()->with('success', 'Item added!');
    }

    public function update(Request $request, $id){
        
        $item = Inventory::findOrFail($id);

        $request->validate([
            'item_name' => 'required|string|max:255',
            'unit' => 'required|in:Each,Box,Pack,Tube,Bottle,Bag,Kit,Set',
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

    public function addstock_history($id){

        $item = Inventory::findOrFail($id);
        
        $addstocks = AddStock::where('inventory_id', $id)->get();

        return view('admin.inventory.addstock_history', compact('addstocks', 'item'));
    }

    public function issuance(Request $request, $id){

        $request->validate([
            'issuance' => 'required|integer|min:1',
            'users_id' => 'required|exists:users,id',
        ]);

        $inventory = Inventory::findOrFail($id);

        if ($inventory->remaining_stocks < $request->issuance) {
            return redirect()->back()->withErrors(['issuance' => 'Issuance exceeds the available stock!']);
        }
        
        $inventory->remaining_stocks -= $request->issuance;
        $inventory->issuance += $request->issuance;
        $inventory->save();

        $stock = AddStock::where('inventory_id', $inventory->id)->orderBy('expiration_date', 'asc')->first(); 
        $stock->quantity -= $request->issuance;
        $stock->save();

        $user = User::where('id', $request->users_id)->where('usertype', 'patient')->first();

        Issuance::create([
            'inventory_id' => $inventory->id,
            'users_id' => $request->users_id,
            'distribute_to' => $user->name,
            'issuance' => $request->issuance,
        ]);

        return redirect()->back()->with('success', 'Issuance successfully!');
    }

    public function issuance_history($id){

        $item = Inventory::findOrFail($id);
        
        $issuances = Issuance::where('inventory_id', $id)->get();

        return view('admin.inventory.issuance_history', compact('issuances', 'item'));
    }

    public function dispose(Request $request, $id){
        
        $request->validate([
            'reason' => 'required|in:Expired,Damaged,Single-Use,Used',
            'disposequantity' => 'required|integer|min:1',
        ]);
    
        $inventory = Inventory::findOrFail($id);

        $inventory->remaining_stocks -= $request->disposequantity;
        $inventory->disposed += $request->disposequantity;
        $inventory->save();

        $stock = AddStock::findOrFail($request->input('stocks'));
        
        $stock->quantity -= $request->disposequantity;

        if ($stock->quantity == 0) {
            $stock->delete();
        }

        $stock->save();
    
        Dispose::create([
            'inventory_id' => $inventory->id,
            'addstock_id' => $stock->id,
            'reason' => $request->input('reason'),
            'expiration_date' => $stock->expiration_date,
            'disposequantity' => $request->input('disposequantity'),
        ]);
        
        return redirect()->back()->with('success', 'Dispose successfully!');
    }

    public function dispose_history($id){

        $item = Inventory::findOrFail($id);
        
        $disposes = Dispose::where('inventory_id', $id)->get();

        return view('admin.inventory.dispose_history', compact('disposes', 'item'));
    }

    public function print(){
        // Get all inventory data or filter as needed
        $items = Inventory::all();

        // Return a view with the data
        return view('admin.inventory.inventory', compact('items'));
    }
}