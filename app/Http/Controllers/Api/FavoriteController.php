<?php

namespace App\Http\Controllers\Api;
use App\Models\favorite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Get the authenticated user
    $user = Auth::user();
    
    // Get the user's name
    $userName = $user->name;
    
    // Get the user's favorites with book details (including titles) using eager loading
    $favorites = Favorite::where('user_id', $user->id)->with('book')->get();
    
    // Extract book titles from favorites
    $books = $favorites->pluck('book.title');

    // Check if favorites are empty
    if ($favorites->isEmpty()) {
        return response()->json([
            'status' => 'failed',
            'message' => 'No favorites added!',
        ], 404);
    }

    // Build response
    $response = [
        'status' => 'success',
        'message' => 'Favorites are retrieved successfully.',
        'books' => $books,
        'user_name' => $userName, 
        'favorites' => $favorites,
    ];

    return response()->json($response, 200);
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
    public function show(string $id)
    {
         
        $userId = Auth::id(); 
        $favorite = favorite::where('user_id', $userId)->where('book_id', $id)->first();

        if (!$favorite) {
            $favorite = new favorite;
            $favorite->user_id = $userId;
            $favorite->book_id = $id;
            $favorite->save();
        }

        return response()->json(['message' => 'Book added to favorites'], 200);
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

   