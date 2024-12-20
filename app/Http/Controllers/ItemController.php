<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item; // Import the Item model

class ItemController extends Controller
{
    public function mainIndexs(Request $request)
{

    $category = $request->get('section', 'dairy');


    $inventory_item = Item::where('section', $category)->get();


    return view('mainIndex', ['inventory_item' => $inventory_item, 'category' => $category]);
}

public function details($id)
{
    $item = Item::find($id);

     // This will show the item or null if not found

    if (!$item) {
        return redirect()->route('index')->with('error', 'Item not found.');
    }

    $category = $item->section;

    return view('detail', [
        'item' => $item,
        'category' => $category,
    ]);
}


public function show($id)
{
    $item = Item::find($id);

    if (!$item) {
        return response()->json(['error' => 'Item not found'], 404);
    }

    return response()->json($item);
}

public function searchItems(Request $request)
{
    $query = $request->get('query'); // Get the search query
    $items = Item::where('name', 'like', '%' . $query . '%')->get(); // Search items by name

    return response()->json($items); // Return results as JSON
}
}
