<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        # By default we are using here auth:api middleware
        $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {


        $validate = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if ($validate->fails()) {
            return $this->errorResponse('Validation Error!',
                $validate->errors(),403);
          
        }

        $user = User::where('email', $request->email)->first();
        if ($user != null) {
            if (!Hash::check($request->password, $user->password)) {
                return $this->errorResponse('Password does not matched', '', 400);
            }

            $token = $user->createToken($request->device_name)->plainTextToken;
            return $this->respondWithToken($token);

        } else {
            return $this->errorResponse('Email does not exist', '', 400);
        }
        // if (Auth::guard('web')->attempt($credentials)) {
        //     $user = Auth::user();
        //     $token = $user->createToken('auth_token')->plainTextToken;
        //     return $this->respondWithToken($token);
        // } else {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }
    }

    public function register(Request $request)
    {

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            // Assuming you have other fields like 'email_verified_at', 'remember_token', etc.
        ];

        $validator = Validator::make($data, [
            // No specific validation for fake names
            'name' => 'required|string|min:5',
            'email' => [


                'required',
                'email',
                Rule::unique('users', 'email'), // Assuming you're updating a user and need to ignore the user's current email
            ],
            'password' => 'required|string|min:8', // You might want to enforce a minimum length for passwords
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }
        $user = User::create($request->all());
        return response()->json([
            'message' => 'User register successfully',
            'data' => $user
        ], 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        # Here we just get information about current user
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();

        return $this->successResponse('Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->respondWithToken($token);
      }

    public function index()
    {
        return $this->successResponse('User Fetch Successfully', User::all());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        # This function is used to make JSON response with new
        # access token of current user
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }
}