<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'categories'])->get();
        return response()->json([
            'message' => 'Books retrieved successfully',
            'data' => $books,
        ], 200);
    }

    // Show one book with author and categories
    public function show($id)
    {
        $book = Book::with(['author', 'categories'])->find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json([
            'message' => 'Book found',
            'data' => $book,
        ], 200);
    }
    
    public function create(StoreBookRequest $request)
    {
        $validated = $request->validated();
        $book = Book::create($validated);

        return response()->json([
            'message' => 'Book created successfully',
            'data' => $book,
        ], 201);
    }


    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|min:2|max:255',
            'author_id' => 'sometimes|required|exists:authors,id',
            'isbn' => 'sometimes|required|string|unique:books,isbn,' . $book->id,
            'published_year' => 'sometimes|required|integer',
            'genre' => 'sometimes|required|string',
            'summary' => 'sometimes|required|string',
        ]);

        $book->update($validated);

        return response()->json([
            'message' => 'Book updated successfully',
            'data' => $book,
        ]);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully',
        ]);
    }
}