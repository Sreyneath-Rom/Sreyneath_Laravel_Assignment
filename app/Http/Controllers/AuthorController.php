<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\StoreAuthorRequest;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = new Author();
        return response()->json([
            'message' => 'Authors retrieved successfully',
            'data' => $authors::all(),
        ], 200);
    }

    //create author with validation
    public function create(StoreAuthorRequest $request)
    {
        $validated = $request->validated();

        $author = Author::create($validated);

        return response()->json([
            'message' => 'Author created successfully',
            'data' => $author,
        ], 201);
    }
    // Show one author
    public function show($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'message' => 'Author not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Author found',
            'data' => $author,
        ], 200);
    }
    // Show author with books
    public function showWithBooks($id)
    {
        $author = Author::with('books')->find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        return response()->json([
            'message' => 'Author and books retrieved successfully',
            'data' => $author,
        ], 200);
    }



    // Update an author
    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'bio' => 'sometimes|required|string',
            'nationality' => 'sometimes|required|string',
        ]);

        $author = Author::update($validated);
        return response()->json([
            'message' => 'Author updated successfully',
            'data' => $author,
        ], 200);

     
    }





    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json([
            'message' => 'Author deleted successfully',
        ]);
    }
}