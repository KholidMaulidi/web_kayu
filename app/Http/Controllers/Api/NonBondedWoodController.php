<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NonBondedWood;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NonBondedWoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nonBondedWoods = NonBondedWood::all();
        return response()->json($nonBondedWoods, 200);
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
        $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();

        $validated = $request->validate([
            'id_type' => 'required|exists:type_wood,id',
            'id_wood' => 'required|exists:wood,id',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'size' => 'required|string|max:255',
            'price' => 'required|integer',
        ]);


        Storage::disk('public')->put($imageName, file_get_contents($request->image));

        $nonBondedWood = NonBondedWood::create([
            'id_type' => $validated['id_type'],
            'id_wood' => $validated['id_wood'],
            'image' => $imageName,
            'size' => $validated['size'],
            'price' => $validated['price'],
        ]);

        $nonBondedWood->load('woodType');
        $nonBondedWood->load('wood');

        return response()->json([
            'message' => 'BondedWood successfully created.',
            'data' => [
                'id' => $nonBondedWood->id,
                'id_type' => $nonBondedWood->woodType->type_name,
                'id_wood' => $nonBondedWood->wood->wood_name,
                'image' => $nonBondedWood->image,
                'size' => $nonBondedWood->size,
                'price' => $nonBondedWood->price,
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $nonBondedWood = NonBondedWood::find($id);

        if (!$nonBondedWood) {
            return response()->json(['message' => 'NonBondedWood not found'], 404);
        }

        return response()->json($nonBondedWood, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $nonBondedWood = NonBondedWood::find($id);
        
            if (!$nonBondedWood) {
                return response()->json(['message' => 'nonBondedWood not found'], 404);
            }
        
            // Validasi data
            $validated = $request->validate([
                'id_type' => 'required|exists:type_wood,id',
                'id_wood' => 'required|exists:wood,id',
                'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                'size' => 'required|string|max:255',
                'price' => 'required|integer',
            ]);
    
        
            if ($request->hasFile('image')) {
                if (Storage::disk('public')->exists($nonBondedWood->image)) {
                    Storage::disk('public')->delete($nonBondedWood->image);
                }
        
                $imageName = Str::random(32) . "." . $request->image->getClientOriginalExtension();
                Storage::disk('public')->put($imageName, file_get_contents($request->image));
        
                $nonBondedWood->image = $imageName;
            }
            
            $nonBondedWood->id_type = $validated['id_type'];
            $nonBondedWood->id_wood = $validated['id_wood'];
            $nonBondedWood->image = $imageName;
            $nonBondedWood->size = $validated['size'];
            $nonBondedWood->price = $validated['price'];
            $nonBondedWood->save();

            $nonBondedWood->load('woodType');
            $nonBondedWood->load('wood');
        
            return response()->json([
                'message' => 'BondedWood successfully created.',
                'data' => [
                    'id' => $nonBondedWood->id,
                    'id_type' => $nonBondedWood->woodType->type_name,
                    'id_wood' => $nonBondedWood->wood->wood_name,
                    'image' => $nonBondedWood->image,
                    'size' => $nonBondedWood->size,
                    'price' => $nonBondedWood->price,
                ]
            ], 201);
        
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'nonBondedWood not found'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $nonBondedWood = NonBondedWood::find($id);

        if (!$nonBondedWood) {
            return response()->json(['message' => 'NonBondedWood not found'], 404);
        }

        $nonBondedWood->delete();

        return response()->json(['message' => 'NonBondedWood deleted successfully'], 200);
    }
}
