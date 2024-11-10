<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Treatment;
use Illuminate\Http\Request;

class AdminTreatmentController extends Controller
{
    // Show the form for creating a new treatment
    public function create()
    {
        return view('admin.dashboard');
    }

    // Store a new treatment in the database
    public function store(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'treatment' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        // Handle the image upload
        $image = $request->file('image');
        $imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();

        // Set the initial file name
        $newImageName = $imageName . '.' . $extension;
        $filePath = public_path('treatments/' . $newImageName);

        // Check if file exists and append a number to make the filename unique
        $counter = 1;
        while (file_exists($filePath)) {
            $newImageName = $imageName . '(' . $counter . ').' . $extension;
            $filePath = public_path('treatments/' . $newImageName);
            $counter++;
        }

        // Move the uploaded image to the treatments folder
        $image->move(public_path('treatments'), $newImageName);

        // Create a new treatment record in the database
        Treatment::create([
            'image' => 'treatments/' . $newImageName, // Store the image path
            'treatment' => $request->treatment,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Treatment added successfully!');
    }

    // Show the form to edit the treatment
    public function edit(Treatment $treatment)
    {
        return view('admin.dashboard', compact('treatment'));
    }

    // Update the treatment in the database
    public function update(Request $request, Treatment $treatment)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'treatment' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        // Update image if provided
        if ($request->hasFile('image')) {
            // Handle the image upload
            $image = $request->file('image');
            $imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();

            // Set the initial file name
            $newImageName = $imageName . '.' . $extension;
            $filePath = public_path('treatments/' . $newImageName);

            // Check if file exists and append a number to make the filename unique
            $counter = 1;
            while (file_exists($filePath)) {
                $newImageName = $imageName . '(' . $counter . ').' . $extension;
                $filePath = public_path('treatments/' . $newImageName);
                $counter++;
            }

            // Move the uploaded image to the treatments folder
            $image->move(public_path('treatments'), $newImageName);

            // Delete the old image
            if (file_exists(public_path($treatment->image))) {
                unlink(public_path($treatment->image));
            }

            // Update the treatment's image path
            $treatment->image = 'treatments/' . $newImageName;
        }

        // Update other fields
        $treatment->treatment = $request->treatment;
        $treatment->description = $request->description;

        $treatment->save();

        return redirect()->route('admin.dashboard')->with('success', 'Treatment updated successfully!');
    }

    // Delete a treatment from the database
    public function destroy(Treatment $treatment)
    {
        // Delete the image file
        if (file_exists(public_path($treatment->image))) {
            unlink(public_path($treatment->image));
        }

        // Delete the treatment record
        $treatment->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Treatment deleted successfully!');
    }
}