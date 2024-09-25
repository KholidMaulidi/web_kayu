<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BondedWood;
use App\Http\Requests\BondedWoodStoreRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BondedWoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bondedWoods = BondedWood::all();
        return response()->json($bondedWoods, 200);
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
            'quantity' => 'required|string|max:255',
        ]);

        Storage::disk('public')->put($imageName, file_get_contents($request->image));


        $bondedWood = BondedWood::create([
            'id_type' => $validated['id_type'],
            'id_wood' => $validated['id_wood'],
            'image' => $imageName,
            'size' => $validated['size'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
        ]);

        $bondedWood->load('woodType');
        $bondedWood->load('wood');


        return response()->json([
            'message' => 'BondedWood successfully created.',
            'data' => [
                'id' => $bondedWood->id,
                'id_type' => $bondedWood->woodType->type_name,
                'id_wood' => $bondedWood->wood->wood_name,
                'image' => $bondedWood->image,
                'size' => $bondedWood->size,
                'price' => $bondedWood->price,
                'quantity' => $bondedWood->quantity,
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bondedWood = BondedWood::find($id);

        if (!$bondedWood) {
            return response()->json(['message' => 'BondedWood not found'], 404);
        }

        return response()->json($bondedWood, 200);
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
            $bondedWood = BondedWood::find($id);
        
            if (!$bondedWood) {
                return response()->json(['message' => 'BondedWood not found'], 404);
            }
        
            // Validasi data
            $validated = $request->validate([
                'id_type' => 'required|exists:type_wood,id',
                'id_wood' => 'required|exists:wood,id',
                'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                'size' => 'required|string|max:255',
                'price' => 'required|integer',
                'quantity' => 'required|string|max:255',
            ]);
    
        
            if ($request->hasFile('image')) {
                if (Storage::disk('public')->exists($bondedWood->image)) {
                    Storage::disk('public')->delete($bondedWood->image);
                }
        
                $imageName = Str::random(32) . "." . $request->image->getClientOriginalExtension();
                Storage::disk('public')->put($imageName, file_get_contents($request->image));
        
                $bondedWood->image = $imageName;
            }
            
            $bondedWood->id_type = $validated['id_type'];
            $bondedWood->id_wood = $validated['id_wood'];
            $bondedWood->image = $imageName;
            $bondedWood->size = $validated['size'];
            $bondedWood->price = $validated['price'];
            $bondedWood->quantity = $validated['quantity'];
            $bondedWood->save();

            $bondedWood->load('woodType');
            $bondedWood->load('wood');
        
            return response()->json([
                'message' => 'BondedWood successfully created.',
                'data' => [
                    'id' => $bondedWood->id,
                    'id_type' => $bondedWood->woodType->type_name,
                    'id_wood' => $bondedWood->wood->wood_name,
                    'image' => $bondedWood->image,
                    'size' => $bondedWood->size,
                    'price' => $bondedWood->price,
                    'quantity' => $bondedWood->quantity,
                ]
            ], 201);
        
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'BondedWood not found'], 404);
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
        $bondedWood = BondedWood::find($id);

        if (!$bondedWood) {
            return response()->json(['message' => 'BondedWood not found'], 404);
        }

        $bondedWood->delete();

        return response()->json(['message' => 'BondedWood deleted successfully'], 200);
    }
}
