<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // List all books with pagination
    public function index()
    {
        return response()->json([
            'message' => 'Books retrieved successfully',
            'data' => Book::all(),
        ], 200);
    }

    // Create new book with validation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'author_id' => 'required|exists:authors,id',  // foreign key check
            'isbn' => 'required|string|unique:books,isbn',
            'published_year' => 'required|integer',
            'genre' => 'required|string',
            'summary' => 'required|string',
        ]);

        $book = Book::create($validated);

        return response()->json([
            'message' => 'Book created successfully',
            'data' => $book,
        ], 201);
    }

    // Show one book, route model binding auto-finds or 404s
    public function show($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json([
            'message' => 'Book found',
            'data' => $book->toArray(),
        ], 200);
    }


    // Update existing book with validation
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string',
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

    // Delete a book
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully',
        ]);
    }
}