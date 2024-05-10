<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AddUserRequest;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->simplePaginate(100);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddUserRequest $request)
    {
       $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $user->assignRole('member');
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
  
     
     public function update(Request $request, $id)
     {
         // Find the user by ID
         $user = User::findOrFail($id);
     
         // Validate the request
         $request->validate([
             'name' => ['sometimes', 'max:255', 'string'],
             'email' => ['sometimes', 'max:255', 'string', 'email', 'unique:users,email,' . $id],
             'password' => ['nullable', 'max:255', 'string', 'min:8'],
         ]);
     
         // Update the user's information only if new values are provided
        $user->name = $request->input('name', $user->name);
        $user->email = $request->input('email', $user->email);
    
        // Hash the password if provided
        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }
     
         // Save the changes
         $user->save();
     
         // Redirect back with a success message
         return redirect()->back()->with('success', 'User updated successfully.');
     }
     

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            // Redirect or return a response
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception, e.g., log the error, display an error message
            return back()->with('error', 'An error occurred while deleting the user.');
        }
    }
}
