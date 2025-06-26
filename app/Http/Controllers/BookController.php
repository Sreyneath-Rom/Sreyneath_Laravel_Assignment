<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // List all books with pagination
    public function index()
    {
        $books = new Book();
        return response()->json([
            'message' => 'Books retrieved successfully',
            'data' => $books::all(), 
        ], 200);
    }

    // Create new book with validation
   
    public function create(StoreBookRequest $request)
    {
        $validated = $request->validated();
        $book = Book::create($validated);

        return response()->json([
            'message' => 'Book created successfully',
            'data' => $book,
        ], 201);
    }

    // Show one book
    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json([
            'message' => 'Book found',
            'data' => $book,
        ], 200);
    }

    // Update a book
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

    // Delete a book
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully',
        ]);
    }
}