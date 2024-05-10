<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\userRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AddUserRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::latest()->simplePaginate(10);

        return view('users.index', compact('users'));
    }

    public function destroy($id)
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

    public function view(){
        return view('users.create');
    }

    public function create(AddUserRequest $request){
        $request->validate();
        USER::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }
}
