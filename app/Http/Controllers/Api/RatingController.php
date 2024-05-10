<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\rating;
use App\Models\ratings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
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
        $ratings = ratings::where('user_id', $user->id)->with('book')->get();

        // Extract book titles from favorites
        $books = $ratings->pluck('book.title');

        // Check if favorites are empty
        if ($ratings->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No favorites added!',
            ], 404);
        }

        // Build response
        $response = [
            'status' => 'success',
            'message' => 'Ratings are retrieved successfully.',
            'books' => $books,
            'user_name' => $userName,
            'rating' => $ratings,
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $userId = Auth::id();

        // Validate the request data
        $validatedData = $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        // Check if the user has already rated the book
        $rating = ratings::where('user_id', $userId)->where('book_id', $id)->first();

        if (!$rating) {
            // If the user hasn't rated the book, create a new rating
            $rating = new ratings;
            $rating->user_id = $userId;
            $rating->book_id = $id;
        }

        // Update the rating value
        $rating->rating = $validatedData['rating'];
        $rating->save();

        return response()->json(['message' => 'Book rating has been added'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $rating = ratings::where('user_id', $user->id)->where('book_id', $id)->first();

        if (!$rating) {
            return response()->json(['message' => 'Rating not found Or book not Found'], 404);
        }

        $rating->delete();

        return response()->json(['message' => 'Rating deleted successfully'], 200);
    }
}
