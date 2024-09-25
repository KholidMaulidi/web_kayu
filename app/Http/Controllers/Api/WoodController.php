<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wood;
use App\JsonResponseTrait;

class WoodController extends Controller
{
    use JsonResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $wood = Wood::all();

            if($wood->isEmpty()) {
                return $this->successResponse([], 'Wood is empty', 200);
            }
            return $this->successResponse($wood, 'Wood retrieved successfully', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
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
        try {
            $validate = $request->validate([
                'wood_name' => 'required|string|max:255',
            ]);
            $wood = Wood::create($validate);

            return $this->successResponse($wood, 'Wood create succesfully', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(),500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $wood = Wood::find($id);
            if (!$wood) {
                return $this->errorResponse('Wood not found', 404);
            }

            return $this->successResponse($wood, 'Wood retrieved successfully', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
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
            $wood = Wood::find($id);
            if (!$wood) {
                return $this->errorResponse('Wood not found', 404);
            }

            $validate = $request->validate([
                'wood_name' =>'required|string|max:255',
            ]);

            $wood->update($validate);

            return $this->successResponse($wood, 'Wood updated successfully', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $wood = Wood::find($id);
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
