<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;
use App\Models\Image;
use App\Models\Lister;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class AddHousesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * */
     
     public function store(Request $request)
{
    try {
        // Validate the request
        $validatedData = $request->validate([
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'availability' => 'required|string',
            'contact' => 'required|string',
            'rules_and_regulations' => 'nullable|string',
            'amenities' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'home_images.*' => 'image|mimes:jpeg,png,jpg,gif',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Get the authenticated user's ID
        $user_id = Auth::id();

        // Fetch the lister ID for the authenticated user
        $lister = Lister::where('user_id', $user_id)->first();

        if (!$lister) {
            return back()->withErrors(['error' => 'Failed to find lister information. Please try again later.']);
        }

        // Add lister_id to the validated data
        $validatedData['lister_id'] = $lister->id;

        // Handle the main image upload (Thumbnail)
        if ($request->hasFile('main_image')) {
            // Store the main image in the public/images/thumbnails directory
            $mainImagePath = $request->file('main_image')->store('images/thumbnails', 'public');
            $validatedData['main_image'] = $mainImagePath; // Add main image path to validated data
        } else {
            return back()->withErrors(['error' => 'Main image is required.']);
        }

        // Create the house entry with the main image path
        $house = House::create([
            'location' => $validatedData['location'],
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
            'availability' => $validatedData['availability'],
            'contact' => $validatedData['contact'],
            'rules_and_regulations' => $validatedData['rules_and_regulations'],
            'amenities' => $validatedData['amenities'],
            'category_id' => $validatedData['category_id'],
            'main_image' => $validatedData['main_image'], // Set the main image path
            'user_id' => $user_id,
            'lister_id' => $validatedData['lister_id']
        ]);

        // Initialize array to hold image data
        $images = [];

        // Handle multiple image uploads (Additional Images) if present
        // Handle the main image upload (Thumbnail)
if ($request->hasFile('main_image')) {
    // Store the main image in the public/images/thumbnails directory
    $mainImagePath = $request->file('main_image')->store('images/thumbnails', 'public');
    $validatedData['main_image'] = $mainImagePath; // Add main image path to validated data

    Log::info('Main image uploaded', ['main_image_path' => $mainImagePath]);
} else {
    return back()->withErrors(['error' => 'Main image is required.']);
}

// Handle multiple image uploads (Additional Images) if present
if ($request->hasFile('home_images')) {
    foreach ($request->file('home_images') as $image) {
        // Store each image in the public/images directory (for additional images)
        $filePath = $image->store('images', 'public');
        $images[] = [
            'house_id' => $house->id,
            'image_path' => $filePath,
            'is_main' => false, // Additional images are not main
        ];

        Log::info('Additional image uploaded', ['image_path' => $filePath]);
    }
} else {
    Log::warning('No additional images found in the request.');
}


        // Debugging: Log the images array before insertion
        Log::info('Images array before insert', ['images' => $images]);

        // Bulk insert all images into the database
        if (!empty($images)) {
            try {
                Image::insert($images); // Use insert instead of create for bulk insertion

                Log::info('Images inserted into the database', ['images' => $images]);
            } catch (\Exception $e) {
                Log::error('Error inserting images into the database: ' . $e->getMessage());
                return back()->withErrors(['error' => 'Failed to save images. Please try again later.']);
            }
        } else {
            Log::warning('No images to insert into the database.');
        }

        return redirect()->route('lister.listingForm')->with('success', 'Listing added successfully.');
    } catch (\Exception $e) {
        Log::error('Error creating house: ' . $e->getMessage());
        return view('components.add-house-confirmation');
    }
}



    public function destroy($id)
    {
        try {
            // Fetch the house
            $house = House::findOrFail($id);

            // Check if the authenticated user is the owner of the house
            if ($house->user_id !== Auth::id()) {
                return response()->json(['error' => 'Unauthorized access'], 403);
            }

            // Delete the house images
            $images = Image::where('house_id', $house->id)->get();
            foreach ($images as $image) {
                // Delete the image file from storage
                \Storage::disk('public')->delete($image->image_path);
                // Delete the image record from the database
                $image->delete();
            }

            // Delete the house
            $house->delete();

            // Log the deletion
            Log::info('House deleted successfully', ['house_id' => $house->id]);

            return view('lister.delete-house-confirmation');

        } catch (\Exception $e) {
            Log::error('Error deleting house: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete house. Please try again later.'], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            // Get the house to be updated
            $house = House::findOrFail($id);

            // Ensure the authenticated user is the lister of the house
            $user_id = Auth::id();
            $lister = Lister::where('user_id', $user_id)->first();

            if ($lister && $house->lister_id !== $lister->id) {
                return back()->withErrors(['error' => 'You do not have permission to update this house.']);
            }

            // Validate the request
            $validatedData = $request->validate([
                'location' => 'nullable|string|max:255',
                'price' => 'nullable|numeric',
                'description' => 'nullable|string',
                'availability' => 'nullable|string',
                'contact' => 'nullable|string',
                'rules_and_regulations' => 'nullable|string',
                'amenities' => 'nullable|string',
                'category_id' => 'nullable|exists:categories,id',
                'home_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            ]);

            // Initialize array to hold image data
            $images = [];

            // Handle the main image upload (Thumbnail) if present
            if ($request->hasFile('main_image')) {
                // Delete the old main image
                if ($house->main_image) {
                    Storage::disk('public')->delete($house->main_image);
                }

                // Store the new main image in the public/images/thumbnails directory
                $mainImagePath = $request->file('main_image')->store('images/thumbnails', 'public');

                // Update the house main image path
                $house->main_image = $mainImagePath;

                // Add main image data to the images array
                $images[] = [
                    'house_id' => $house->id,
                    'image_path' => $mainImagePath,
                    'is_main' => true, // Indicate this is the main image
                ];

                Log::info('Main image (thumbnail) updated', ['image_path' => $mainImagePath]);
            }

            // Handle multiple image uploads (Additional Images) if present
            if ($request->hasFile('home_images')) {
                // Delete old images if any new images are uploaded
                $existingImages = Image::where('house_id', $house->id)->where('is_main', false)->get();
                foreach ($existingImages as $existingImage) {
                    Storage::disk('public')->delete($existingImage->image_path);
                    $existingImage->delete();
                }

                foreach ($request->file('home_images') as $image) {
                    // Store each image in the public/images directory (for additional images)
                    $filePath = $image->store('images', 'public');

                    // Add additional image data to the images array
                    $images[] = [
                        'house_id' => $house->id,
                        'image_path' => $filePath,
                        'is_main' => false, // For additional images, is_main should be false
                    ];

                    Log::info('Additional image uploaded', ['image_path' => $filePath]);
                }
            }

            // Bulk insert all images into the database
            if (!empty($images)) {
                try {
                    Image::insert($images);
                    Log::info('Images inserted into the database', ['images' => $images]);
                } catch (\Exception $e) {
                    Log::error('Error inserting images into the database: ' . $e->getMessage());
                    return back()->withErrors(['error' => 'Failed to save images. Please try again later.']);
                }
            }

            // Update house details conditionally
            $houseData = [];
            if ($request->has('location')) {
                $houseData['location'] = $validatedData['location'];
            }
            if ($request->has('price')) {
                $houseData['price'] = $validatedData['price'];
            }
            if ($request->has('description')) {
                $houseData['description'] = $validatedData['description'];
            }
            if ($request->has('availability')) {
                $houseData['availability'] = $validatedData['availability'];
            }
            if ($request->has('contact')) {
                $houseData['contact'] = $validatedData['contact'];
            }
            if ($request->has('rules_and_regulations')) {
                $houseData['rules_and_regulations'] = $validatedData['rules_and_regulations'];
            }
            if ($request->has('amenities')) {
                $houseData['amenities'] = $validatedData['amenities'];
            }
            if ($request->has('category_id')) {
                $houseData['category_id'] = $validatedData['category_id'];
            }

            $house->update($houseData);

            return redirect()->route('dashboard')->with('success', 'Listing updated successfully.');

        } catch (\Exception $e) {
            Log::error('Error updating house: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update house. Please try again later.']);
        }
    }

    
    
    
     public function edit($id)
    {
        $categories=Category::all();
        $house = House::findOrFail($id);
        return view('lister.edit-house', compact('house', 'categories'));
    }
    public function show($id)
    {
        // Fetch the house with its associated images
        $house = House::with('images')->findOrFail($id);
    
        return view('lister.houses-info', compact('house'));
    }
    
    
    //to view all houses
    // public function show($id)
    //     {
    //         // Fetch the house with its associated images
    //         $house = House::findOrFail($id);
    //         $images = Image::where('house_id', $house->id)->get();
        
    //         return view('lister.lister-houses-info', compact('house', 'images'));
    //     }
    public function index($listerId = null)
    {
        if (!$listerId) {
            $listerId = Auth::id(); // Get the authenticated user's ID if $listerId is not provided
        }

        $houses = House::where('user_id', $listerId)->get();

        return view('lister.lister-houses-info', compact('houses'));
    }



    /**
     * Count the number of houses.
     *
     * @return \Illuminate\Http\Response
     */
    public function count()
    {
        $houses = House::all();
        $remainingUnits = count($houses);
        // Use $remainingUnits as needed
    }

    /**
     * Search for houses based on location and description.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $location = $request->input('location');
        $description = $request->input('description');

        $query = House::query();

        if ($location) {
            $query->where('location', $location);
        }
        if ($description) {
            $query->where('description', 'like', '%' . $description . '%');
        }

        $housesInformation = $query->get();

        return response()->json($housesInformation);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Get houses uploaded by the authenticated lister.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListerHouses()
    {
        $userId = Auth::user()->id;
        $houses = House::where('user_id', $userId)->with(['images' => function ($query) {
            $query->where('is_main', true);
        }])->get();
        
        return response()->json($houses);
    }

    public function homeImages()
    {
       // Fetch all houses with their main images
       $houses = House::with('mainImage')->get();

       // Pass the houses to the view
       return view('home', compact('houses'));
    }
    // // For home
    // public function homeImages()
    // {
    //     // Retrieve houses with their listers and main images
    //     $houses = House::with('lister')
    //         ->orderBy('created_at', 'desc')
    //         ->get();
    
    //     // Transform each house to include main image URL
    //     $houses->transform(function ($house) {
    //         // Assign main image URL to 'mainImage' attribute
    //         $house->mainImage = $house->main_image ? Storage::url($house->main_image) : null;
    
    //         return $house;
    //     });
    
    //     return view('home', compact('houses'));
    // }
    


    public function listingView() {
        $categories = Category::all();
        // dd($categories);
        return view('lister.listingForm', compact('categories'));  
    }

    /**
     * Display the hunter dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function hunter()
    {
        // Example: Fetching houses data
        $houses = House::all(); // Adjust this query according to your needs

        return view('hunter.dashboard', 
        [
            'houses' => $houses,
        ]);
    }

    // Other methods for handling specific actions like viewing notifications, communication, feedback, etc.
}