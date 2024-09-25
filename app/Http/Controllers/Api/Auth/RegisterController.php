<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\JsonResponseTrait;

class RegisterController extends Controller
{
    
    use JsonResponseTrait;
    public function register(Request $request)
    {


        try {
            // Validasi input dengan ID numerik untuk role
            $validateUser = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            if ($validateUser->fails()) {
                return $this->errorResponse('Validation Error', $validateUser->errors(), 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return $this->successResponse([
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 'User successfully registered', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), [], 500);
        }
    }
}
