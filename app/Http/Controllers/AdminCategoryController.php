<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = subcategory::latest()->simplePaginate(100);
        return view('admin.books.category', compact('categories'));
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
        $validator = Validator::make($request->all(), [
            'category' => 'required|string',
            'subcategory' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = Category::firstOrCreate(['category' => $request->category]);
        $subcategory = new Subcategory();
        $subcategory->category_id = $category->id;
        $subcategory->subcategory = $request->subcategory;
        $subcategory->save();

        return redirect()->back()->with('success', 'Book added successfully.');
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
        //
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
        try {
            $subcategory = subcategory::findOrFail($id);
            $subcategory->delete();
            return redirect()->back()->with('success', 'record deleted successfully.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while deleting the Book.');
        }
    }

}
