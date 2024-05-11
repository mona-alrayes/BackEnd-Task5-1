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
        $user = Auth::user();
        $userName = $user->name;
        $ratings = ratings::where('user_id', $user->id)->with('book')->get();
        $books = $ratings->pluck('book.title');
        if ($ratings->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No favorites added!',
            ], 404);
        }
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
        $validatedData = $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
        ]);
        $rating = ratings::where('user_id', $userId)->where('book_id', $id)->first();

        if (!$rating) {
            $rating = new ratings;
            $rating->user_id = $userId;
            $rating->book_id = $id;
        }
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
