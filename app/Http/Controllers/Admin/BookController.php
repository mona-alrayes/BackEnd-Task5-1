<?php
namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->simplePaginate(10);
        return view('books.show', compact('books'));
    }
    public function edit($id)
    {
      $book =Book::findorFail($id);
      $cat = $book->sub_category->sub_category_name;
    }
    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();

            // Redirect or return a response
            return redirect()->route('books.show')->with('success', 'Book deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception, e.g., log the error, display an error message
            return back()->with('error', 'An error occurred while deleting the Book.');
        }
    }
}
