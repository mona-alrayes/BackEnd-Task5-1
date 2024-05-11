<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\userRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        if (is_null($users->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No user found!',
            ], 404);
        }

        $response = [
            'status' => 'success',
            'message' => 'users are retrieved successfully.',
            'data' => $users,
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|max:250',
        ]);
    
        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 422);
        }
    
        try {
            $hashedPassword = Hash::make($request->input('password'));
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $hashedPassword,
            ]);        
    
            $user->assignRole('member');
            $token = $user->createToken('API Token')->plainTextToken;
            
            $response = [
                'status' => 'success',
                'message' => 'User is added successfully.',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ],
            ];
    
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create user.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findorFail($id);
  
        if (is_null($user)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'user is not found!',
            ], 404);
        }

        $response = [
            'status' => 'success',
            'message' => 'user is retrieved successfully.',
            'data' => $user,
        ];
        
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:250',
            'email' => 'sometimes|required|string|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|max:250',
        ]);
    
        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 422);
        }
    
        $user = User::find($id);
    
        if (is_null($user)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User is not found!',
            ], 404);
        }
        $user->name = $request->input('name', $user->name);
        $user->email = $request->input('email', $user->email);
    
        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }
    
        $user->save();
        $token = $user->createToken('API Token')->plainTextToken;
    
        $response = [
            'status' => 'success',
            'message' => 'User is updated successfully.',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ];
    
        return response()->json($response, 200);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
  
        if (is_null($user)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'user is not found!',
            ], 200);
        }

        User::destroy($id);
        return response()->json([
            'status' => 'success',
            'message' => 'user is deleted successfully.'
            ], 200);
    }
}
