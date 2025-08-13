<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BoardingHouse;
use App\Models\category;
use App\Models\facility;
use App\Models\room;
use Illuminate\Support\Facades\Crypt;

class BoardingHouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boardingHouses = BoardingHouse::with('rooms', 'rooms.roomImage', 'rooms.facilities', 'categories')->get();
        $categories = category::all();
        $selectedCategory = null;
        return view('list-kost', compact('boardingHouses', 'categories', 'selectedCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $id = Crypt::decrypt($id);
        $boardingHouse = BoardingHouse::with(['rooms.facilities','rooms.roomImage', 'categories'])->findOrFail($id);
        // Ambil semua fasilitas dari semua room
        $facilities = collect();
        foreach ($boardingHouse->rooms as $room) {
            foreach ($room->facilities as $facility) {
                $facilities->push($facility);
            }
        }

        return view('detail', compact('boardingHouse', 'facilities'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function showCategories($id)
    {
        $id = Crypt::decrypt($id); 
        $categories = category::all();
        $boardingHouses = BoardingHouse::where('categories_id', $id)->with('rooms', 'rooms.roomImage', 'rooms.facilities')->get();
        $selectedCategory = $id; // Set the selected category to the current one
        return view('list-kost', compact('boardingHouses', 'categories', 'selectedCategory'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
