<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TypeWood;
use App\JsonResponseTrait;

class TypeWoodController extends Controller
{
    use JsonResponseTrait;
    public function index(){
        try {
            $typeWoods = TypeWood::all();

            if ($typeWoods->isEmpty()) {
                return $this->successResponse([], 'Type of Wood is empty', 200);
            }
            return $this->successResponse($typeWoods, 'Type od Wood fetched successfully', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

    public function store(Request $request){
        try {
            $validatedData = $request->validate([
                'type_name' =>'required|string|max:255',
            ]);

            $typeWood = TypeWood::create($validatedData);
            return $this->successResponse($typeWood, 'Type of Wood created successfully', 201);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

    public function show($id){
        try {
            $typeWood = TypeWood::find($id);

            if (!$typeWood) {
                return $this->errorResponse('Type of Wood not found', 404);
            }
            return $this->successResponse($typeWood, 'Type of Wood fetched successfully', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

    public function update(Request $request, $id){
        try {
            $typeWood = TypeWood::find($id);

            if (!$typeWood) {
                return $this->errorResponse('Type of Wood not found', 404);
            }

            $validatedData = $request->validate([
                'type_name' =>'required|string|max:255',
            ]);

            $typeWood->update($validatedData);
            return $this->successResponse($typeWood, 'Type of Wood updated successfully', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

    public function delete($id){
        try {
            $wood = TypeWood::find($id);
            if (!$wood) {
                return $this->errorResponse('Wood not found', 404);
            }

            $wood->delete();

            return $this->successResponse([], 'Wood deleted successfully', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }
}
