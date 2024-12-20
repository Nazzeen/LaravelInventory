<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $inventoryItems = InventoryItem::all();
        $admins = User::where('role', 'admin')->get();

        // Pass the data to the view
        return view('admin.dashboard', compact('admins', 'inventoryItems'));
    }

    // Show inventory item creation form
    public function createInventoryItemForm()
    {
        return view('admin.create_inventory_item');
    }

    // Store new inventory item
    public function storeInventoryItem(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Get the original filename and move the file to public/assets/images
            $fileName = $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('assets/images'), $fileName);
        } else {
            $fileName = null; // If no image is uploaded, set as null
        }

        // Create the new inventory item
        InventoryItem::create([
            'name' => $request->name,
            'section' => $request->section,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $fileName, // Save only the image filename in the database
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Item added successfully!');
    }

    // Show edit form for inventory item
    public function editInventoryItem($id)
    {
        $item = InventoryItem::findOrFail($id);
        return view('admin.edit_inventory_item', compact('item'));
    }

    // Update inventory item
    public function updateInventoryItem(Request $request, $id)
{
    // Validate the incoming request data

    $request->validate([
        'name' => 'required|string|max:255',
        'section' => 'required|string|max:255',
        'price' => 'required|numeric',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Find the item by ID
    $item = InventoryItem::findOrFail($id);

    // Handle image upload
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($item->image) {
            $oldImagePath = public_path('assets/images/' . $item->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Remove the old image file
            }
        }

        // Get the original filename and move the new file
        $fileName = $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('assets/images'), $fileName);
    } else {
        // Keep the old filename if no new image is uploaded
        $fileName = $item->image;
    }

    // Update the inventory item's data
    $item->update([
        'name' => $request->name,
        'section' => $request->section,
        'price' => $request->price,
        'description' => $request->description,
        'image' => $fileName, // Save the image filename (new or existing)
    ]);

    // Redirect back to the admin dashboard with a success message
    return redirect()->route('admin.dashboard')->with('success', 'Item updated successfully!');
}

    // Delete inventory item
    public function deleteInventoryItem($id)
    {
        $item = InventoryItem::findOrFail($id);

        // Delete the image from storage if it exists
        if ($item->image) {
            $imagePath = public_path('assets/images/' . $item->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $item->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Item deleted successfully!');
    }
}
