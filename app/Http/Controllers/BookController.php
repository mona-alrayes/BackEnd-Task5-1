<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\category;
use App\Models\subcategory;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::latest()->simplePaginate(100);
        return view('admin.books.index', compact('books'));
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
        $category=category::where('category', $request->category)->first();
        $category_id=$category->id;
        $subcategory=subcategory::where('subcategory', $request->subcategory)->first();
        $subcategory_id=$subcategory->id;

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $category_id,
            'subcategory_id' => $subcategory_id,
        ]);
        return redirect()->back()->with('success', 'Book added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book =Book::findorFail($book);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();

            // Redirect or return a response
            return redirect()->back()->with('success', 'Book deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while deleting the Book.');
        }
    }
}
