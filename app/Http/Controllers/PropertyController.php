<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;

class PropertyController extends Controller
{
    // Function to display houses in Nairobi
    public function showNairobi()
    {
        $houses = House::where('location', 'Nairobi')->get();
        return view('property.locations.Nairobi', compact('houses'));
    }

    // Function to display houses in Nakuru
    public function showNakuru()
    {
        $houses = House::where('location', 'Nakuru')->get();
        return view('property.locations.Nakuru', compact('houses'));
    }

    // Function to display houses in Mombasa
    public function showMombasa()
    {
        $houses = House::where('location', 'Mombasa')->get();
        return view('property.locations.Mombasa', compact('houses'));
    }

    // Function to display houses in Kirinyaga
    public function showKirinyaga()
    {
        $houses = House::where('location', 'Kirinyaga')->get();
        return view('property.locations.Kirinyaga', compact('houses'));
    }

    // Function to display houses in Eldoret
    public function showEldoret()
    {
        $houses = House::where('location', 'Eldoret')->get();
        return view('property.locations.Eldoret', compact('houses'));
    }

    // Function to display houses in Embu
    public function showEmbu()
    {
        $houses = House::where('location', 'Embu')->get();
        return view('property.locations.Embu', compact('houses'));
    }

    // Function to display apartments
    public function showApartments()
    {
        $houses = House::where('category', 'Apartment')->get();
        return view('property.category.apartments', compact('houses'));
    }

    // Function to display houses with own compound
    public function showOwnCompound()
    {
        $houses = House::where('category', 'Own Compound')->get();
        return view('property.category.own-compound', compact('houses'));
    }

    // Function to display houses in gated communities
    public function showGatedCommunity()
    {
        $houses = House::where('category', 'Gated Community Spaces')->get();
        return view('property.category.gated-community', compact('houses'));
    }

    // Function to display townhouses
    public function showTownhouses()
    {
        $houses = House::where('category', 'Townhouses')->get();
        return view('property.category.town-houses', compact('houses'));
    }

    // Function to display commercial properties
    public function showCommercialProperties()
    {
        $houses = House::where('category', 'Commercial Properties')->get();
        return view('property.category.commercial-properties', compact('houses'));
    }

    // Function to display short-term rentals
    public function showShortTermRentals()
    {
        $houses = House::where('category', 'Short-Term Rentals')->get();
        return view('property.category.short-term-rentals', compact('houses'));
    }

    // Function to display luxury villas
    public function showLuxuryVillas()
    {
        $houses = House::where('category', 'Luxury Villas')->get();
        return view('property.category.luxury-villas', compact('houses'));
    }

    // Function to display property management services
    public function showPropertyManagementServices()
    {
        $houses = House::where('category', 'Property Management Services')->get();
        return view('property.category.property-management-services', compact('houses'));
    }
    public function search(Request $request)
    {
        $query = House::query();

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }
        if ($request->has('min_amount')) {
            $query->where('price', '>=', $request->min_amount);
        }
        if ($request->has('max_amount')) {
            $query->where('price', '<=', $request->max_amount);
        }

        $houses = $query->get();

        return view('property.search.search-results', compact('houses'));
    }

    public function category($category)
    {
        $houses = House::where('category', $category)->get();
        return view('property.category', compact('houses'))->with('category', $category);
    }
}
