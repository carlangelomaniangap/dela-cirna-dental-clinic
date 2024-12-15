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

        $stocks = AddStock::all();
        
        // Get Inventory items that are about to expire in 1 month or less
        $expiringItems = Inventory::where('expiration_date', '>=', now())
            ->where('expiration_date', '<=', now()->addMonth())
            ->get();

        // Get stocks for each Inventory item that are about to expire in 1 month or less
        foreach ($expiringItems as $item) {
            $item->stocks = $item->addStocks()->where('expiration_date', '>=', now())
                ->where('expiration_date', '<=', now()->addMonth())
                ->get();
        }

        return view('admin.inventory.inventory', compact('items', 'patients', 'stocks', 'expiringItems'));
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

        // Retrieve the inventory
        $inventory = Inventory::findOrFail($id);

        // Check if there are enough remaining stocks for issuance
        if ($inventory->remaining_stocks < $request->issuance) {
            return redirect()->back()->withErrors(['issuance' => 'Issuance exceeds the available stock!']);
        }

        // Update the remaining and issued stock in the inventory
        $inventory->remaining_stocks -= $request->issuance;
        $inventory->issuance += $request->issuance;
        $inventory->save();

        // Get the stocks sorted by created_at (oldest first)
        $stocks = AddStock::where('inventory_id', $inventory->id)
            ->orderBy('created_at', 'asc') // Ensure this is in ascending order by creation time
            ->get();

        // Track the remaining issuance to be processed
        $total_issuance = $request->issuance;

        // Process the stocks sequentially, starting with the first stock
        foreach ($stocks as $stock) {
            if ($total_issuance <= 0) {
                break; // Stop if all the issuance has been processed
            }

            if ($stock->quantity > 0) {
                // Determine how much we can issue from this stock
                $issuance_from_this_stock = min($stock->quantity, $total_issuance);
                $stock->quantity -= $issuance_from_this_stock; // Reduce the stock quantity
                $total_issuance -= $issuance_from_this_stock; // Decrease the remaining issuance

                // If stock quantity reaches zero, delete it
                if ($stock->quantity == 0) {
                    $stock->delete();
                } else {
                    $stock->save(); // Save the updated stock
                }
            }
        }

        // If there's still remaining issuance, it means there's not enough stock
        if ($total_issuance > 0) {
            return redirect()->back()->withErrors(['issuance' => 'Not enough stock available for issuance!']);
        }

        // Create an issuance record
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

    public function dispose(Request $request){
        
        $request->validate([
            'reason' => 'required|in:Expired,Damaged,Single-Use,Used',
            'disposequantity' => 'required|integer|min:1',
        ]);
    
        $inventory = Inventory::find($request->item_id);
        $stock = AddStock::find($request->stock_id);

        $disposequantity = $request->input('disposequantity');
        $reason = $request->input('reason');

        $remaining_stocks = $stock->quantity - $disposequantity;
        $stock->quantity = $remaining_stocks;
        if ($stock->quantity == 0) {
            $stock->delete();
        } else {
            $stock->save();
        }

        $inventory->remaining_stocks -= $disposequantity;
        $inventory->disposed += $disposequantity;
        $inventory->save();

        

        Dispose::create([
            'inventory_id' => $request->item_id,
            'addstock_id' => $request->stock_id,
            'reason' => $reason,
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