<?php

namespace App\Http\Controllers;

use App\Models\boardingHouse;
use Illuminate\Http\Request;

class BoardingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = boardingHouse::with('categories')->get();
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $boardingHouse = boardingHouse::with('categories')->findOrFail($id);
        if (!$boardingHouse) {
            return response()->json(['message' => 'Boarding house not found'], 404);
        }else{
            return response()->json($boardingHouse, 200);
        }
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
