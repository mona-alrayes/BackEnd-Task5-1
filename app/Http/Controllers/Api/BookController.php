<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\category;
use App\Models\subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\FlareClient\Http\Response;
use Illuminate\Support\Facades\Validator;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();

        if (is_null($books->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No book found!',
            ], 404);
        }

        $response = [
            'status' => 'success',
            'message' => 'books are retrieved successfully.',
            'data' => $books,
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:250',
            'author' => 'required|string|max:250',
            'description' => 'required|string|max:250',
            'price' =>'required|numeric',
        ]);

        if($validate->fails()){  
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 422);    
        }

        $book = Book::create($request->all());

        $response = [
            'status' => 'success',
            'message' => 'book is added successfully.',
            'data' => $book,
        ];

        return response()->json($response, 200);
        
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id) 
    {
        $book = book::findorFail($id);
  
        if (is_null($book)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'book is not found!',
            ], 404);
        }

        $response = [
            'status' => 'success',
            'message' => 'Product is retrieved successfully.',
            'data' => $book,
        ];
        
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $validate = Validator::make($request->all(), [
        'title' => 'nullable',
        'author' => 'nullable',
        'description' => 'nullable',
        'price' => 'nullable',
    ]);

    if ($validate->fails()) {  
        return response()->json([
            'status' => 'failed',
            'message' => 'Validation Error!',
            'data' => $validate->errors(),
        ], 422);
    }

    $book = Book::find($id);

    if (is_null($book)) {
        return response()->json([
            'status' => 'failed',
            'message' => 'Book is not found!',
        ], 404);
    }

    $book->fill($request->all());
    $book->save();
    $response = [
        'status' => 'success',
        'message' => 'Product is updated successfully.',
        'data' => $book,
    ];

    return response()->json($response, 200);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);
  
        if (is_null($book)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'book is not found!',
            ], 404);
        }

        Book::destroy($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Book is deleted successfully.'
            ], 200);
        
    }
    public function searchByCategory(string $name)
    {
        $category = Category::where('category', $name)->first();
        $category_id = $category->id;

        if (is_null($category)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category not found!',
            ], 404);
        }
         $books = Book::where('category_id', $category_id)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Books of the category retrieved successfully.',
            'data' => $books->toArray(),
        ], 200);

    }
    public function searchBySubCategory(string $name)
    {

        $Subcategory = subcategory::where('subcategory', $name)->first();
        $category_id = $Subcategory->id;

        if (is_null($Subcategory)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'SubCategory not found!',
            ], 404);
        }
         $books = Book::where('category_id', $category_id)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Books of the category retrieved successfully.',
            'data' => $books->toArray(),
        ], 200);
    }
}
    