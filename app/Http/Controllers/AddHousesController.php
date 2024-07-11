<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;
use App\Models\Image;
use App\Models\Lister;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class AddHousesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
                'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
    
            // Get the authenticated user's ID
            $user_id = Auth::id();
            
            // Fetch the lister ID for the authenticated user
            $lister = Lister::where('user_id', $user_id)->first();
            
            if ($lister) {
                $validatedData['lister_id'] = $lister->id;
            } else {
                // Log::error('Lister not found for user ID: ' . auth()->id());
                return back()->withErrors(['error' => 'Failed to find lister information. Please try again later.']);
            }
            
            // Create the house entry
            $house = House::create([
                'location' => $validatedData['location'],
                'price' => $validatedData['price'],
                'description' => $validatedData['description'],
                'availability' => $validatedData['availability'],
                'phone_number' => $validatedData['phone_number'],
                'rules_and_regulations' => $validatedData['rules_and_regulations'],
                'amenities' => $validatedData['amenities'],
                'category_id' => $validatedData['category_id'],
                'main_image' => $validatedData['main_image']
            ]);
            // Log::info('House created successfully', ['house_id' => $house->id]);
    
            // Initialize array to hold image data
            $images = [];
    
            // Handle the main image upload (Thumbnail) if present
            if ($request->hasFile('main_image')) {
                // Store the main image in the public/images/thumbnails directory
                $mainImagePath = $request->file('main_image')->store('images/thumbnails', 'public');
    
                // Add main image data to the images array
                $images[] = [
                    'house_id' => $house->id,
                    'image_path' => $mainImagePath,
                    'is_main' => $mainImagePath, // Store the path as string for thumbnail
                ];
    
                Log::info('Main image (thumbnail) uploaded', ['image_path' => $mainImagePath]);
            }
    
            // Handle multiple image uploads (Additional Images) if present
            if ($request->hasFile('home_images')) {
                foreach ($request->file('home_images') as $image) {
                    // Store each image in the public/images directory (for additional images)
                    $filePath = $image->store('images', 'public');
    
                    // Add additional image data to the images array
                    $images[] = [
                        'house_id' => $house->id,
                        'image_path' => $filePath,
                        'is_main' => null, // For additional images, is_main should be null
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
                    Image::insert($images);
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
            // return back()->withErrors(['error' => 'Failed to add house. Please try again later.' $e->getMessage()]);
            return $e->getMessage();
        }
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
    public function show($id)
    {
        $house = House::with('images')->findOrFail($id);
        return view('house.show', compact('house'));
    }

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

    public function edit(House $house)
    {
        return view('lister.listingForm', compact('house'));
    }
    

    public function update(Request $request, House $house)
    {
        // Validate input if necessary
        $validatedData = $request->validate([
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'availability' => 'required|string',
            'contact' => 'required|string',
            'rules_and_regulations' => 'nullable|string',
            'amenities' => 'required|string',
            'home_images.*' => 'image|mimes:jpeg,png,jpg,gif', // Validate each image
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update the house with validated data
        $house->update($validatedData);

        // Redirect back to the dashboard with a success message
        return redirect()->route('lister.dashboard')->with('success', 'House information updated successfully.');
    }

    

    //for home
    public function homeImages()
    {
        // Retrieve houses with their listers and main images
        $houses = House::with(['lister', 'images' => function($query) {
            $query->where('is_main', true);
        }])
        ->orderBy('created_at', 'desc')
        ->get();
    
        // Add a mainImage attribute to each house
        $houses->each(function($house) {
            $house->mainImage = $house->images->first();
        });
    
        return view('home', compact('houses'));
    }

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
