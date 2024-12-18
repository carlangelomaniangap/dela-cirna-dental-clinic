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
        
        // $items = Inventory::all();
        $items = Inventory::orderBy('id', 'desc')->get();

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

        $remaining_stocks = $request->stocks;

        // Step 1: Search for an existing inventory item with the same item_name, type, and unit
        $existingInventory = Inventory::where('item_name', $request->item_name)
            ->where('type', $request->type)
            ->where('unit', $request->unit)
            ->first();

        // Step 2: If an existing item is found
        if ($existingInventory) {
            // Sum the stocks and remaining stocks
            $existingInventory->stocks += $request->stocks;
            $existingInventory->remaining_stocks += $request->stocks;

            // Save the updated inventory record
            $existingInventory->save();

            // Create a new AddStock entry for the existing item
            AddStock::create([
                'inventory_id' => $existingInventory->id,
                'receiver_name' => $request->receiver_name ?? 'N/A',
                'expiration_date' => $request->expiration_date, // Store the expiration date in AddStock
                'quantity' => $request->stocks,
            ]);

            return redirect()->back()->with('success', 'Stocks updated and added to history!');
        } else {
            // Step 3: If no matching inventory item is found, create a new item
            $inventory = Inventory::create([
                'item_name' => $request->item_name,
                'type' => $request->type,
                'unit' => $request->unit,
                'stocks' => $request->stocks,
                'remaining_stocks' => $remaining_stocks,
                'expiration_date' => $request->expiration_date,
            ]);

            // Create a new AddStock record for the newly created inventory item
            AddStock::create([
                'inventory_id' => $inventory->id,
                'receiver_name' => $request->receiver_name ?? 'N/A',
                'expiration_date' => $request->expiration_date,
                'quantity' => $request->stocks,
            ]);

            return redirect()->back()->with('success', 'New item added and stock history created!');
        }
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

        // Check if the receiver name is 'N/A' or not
        if ($request->receiver_name === 'N/A') {
            // If the receiver name is 'N/A', just add the stock normally
            $existingStock = AddStock::where('inventory_id', $inventory->id)
                ->where('receiver_name', 'N/A')
                ->where('expiration_date', $request->expiration_date)
                ->first();

            if ($existingStock) {
                // Sum the quantities if the same expiration date and 'N/A' receiver name exists
                $existingStock->quantity += $request->quantity;
                $existingStock->save();
            } else {
                // If no 'N/A' exists for this expiration date, create a new stock entry
                $addStock = new AddStock([
                    'inventory_id' => $inventory->id,
                    'receiver_name' => 'N/A', // Keep receiver_name as 'N/A' for now
                    'expiration_date' => $request->expiration_date,
                    'quantity' => $request->quantity,
                ]);
                $addStock->save();
            }
        } else {
            // If receiver_name is not 'N/A', we check if there's an existing stock with 'N/A'
            $existingStock = AddStock::where('inventory_id', $inventory->id)
                ->where('receiver_name', 'N/A')
                ->where('expiration_date', $request->expiration_date)
                ->first();

            if ($existingStock) {
                // If an 'N/A' stock exists for the same expiration date, replace 'N/A' with the actual receiver name
                $existingStock->receiver_name = $request->receiver_name;
                $existingStock->quantity += $request->quantity; // Sum the quantities
                $existingStock->save();
            } else {
                // If no matching stock exists, create a new stock entry
                $addStock = new AddStock([
                    'inventory_id' => $inventory->id,
                    'receiver_name' => $request->receiver_name,
                    'expiration_date' => $request->expiration_date,
                    'quantity' => $request->quantity,
                ]);
                $addStock->save();
            }
        }

        // $addStock = new AddStock([
        //     'inventory_id' => $inventory->id,
        //     'receiver_name' => $request->receiver_name,
        //     'expiration_date' => $request->expiration_date,
        //     'quantity' => $request->quantity,
        // ]);

        // $addStock->save();

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
            ->orderBy('expiration_date', 'asc')
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
            'expiration_date' => $stock->expiration_date,
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
}