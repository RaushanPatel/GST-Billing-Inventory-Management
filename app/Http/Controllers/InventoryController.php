<?php
namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
/**
* Display a listing of the inventory.
*
* @return \Illuminate\View\View
*/
    public function index()
    {
        // Retrieve the inventory items for the logged-in user, with pagination of 15 items per page
        $inventory = auth()->user()->inventory()->paginate(15);

        return view('inventory.index', compact('inventory'));
    }


/**
* Show the form for creating a new inventory item.
*
* @return \Illuminate\View\View
*/
public function create()
{
return view('inventory.create');
}

/**
* Store a newly created inventory item in storage.
*
* @param \Illuminate\Http\Request $request
* @return \Illuminate\Http\RedirectResponse
*/
public function store(Request $request)
{
$request->validate([
'product_name' => 'required|string|max:255',
'product_quantity' => 'required|integer',
'product_price' => 'required|numeric|min:0',
]);

// Add the authenticated user's ID to the request
$request->merge(['user_id' => auth()->user()->id]);

// Create the new inventory item
Inventory::create($request->all());

return redirect()->route('inventory.index')->with('success', 'Product added successfully.');
}

/**
* Display the specified inventory item.
*
* @param int $id
* @return \Illuminate\View\View
*/
public function show($id)
{
$product = auth()->user()->inventory()->findOrFail($id); // Ensure the product belongs to the authenticated user
return view('inventory.show', compact('product'));
}

/**
* Show the form for editing the specified inventory item.
*
* @param int $id
* @return \Illuminate\View\View
*/
public function edit($id)
{
$product = auth()->user()->inventory()->findOrFail($id); // Ensure the product belongs to the authenticated user
return view('inventory.edit', compact('product'));
}

/**
* Update the specified inventory item in storage.
*
* @param \Illuminate\Http\Request $request
* @param int $id
* @return \Illuminate\Http\RedirectResponse
*/
public function update(Request $request, $id)
{
$request->validate([
'product_name' => 'required|string|max:255',
'product_quantity' => 'required|integer',
'product_price' => 'required|numeric|min:0',
]);

$product = auth()->user()->inventory()->findOrFail($id); // Ensure the product belongs to the authenticated user
$product->update($request->all());

return redirect()->route('inventory.index')->with('success', 'Product updated successfully.');
}

/**
* Remove the specified inventory item from storage.
*
* @param int $id
* @return \Illuminate\Http\RedirectResponse
*/
public function destroy($id)
{
$product = auth()->user()->inventory()->findOrFail($id); // Ensure the product belongs to the authenticated user
$product->delete();

return redirect()->route('inventory.index')->with('success', 'Product deleted successfully.');
}
}