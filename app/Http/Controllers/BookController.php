<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public $books = [
        [
            'id' => '1',
            'title' => 'The Hobbit',
            'author' => 'J.R.R. Tolkien',
            'published_year' => '1937',
            'genre' => 'Fantasy',
            'summary' => 'A hobbit embarks on a journey to win a share of a treasure guarded by a dragon.',
        ],
        [
            'id' => '2',
            'title' => 'Pride and Prejudice',
            'author' => 'Jane Austen',
            'published_year' => '1813',
            'genre' => 'Romance',
            'summary' => 'A story about manners, upbringing, morality, and marriage in 19th century England.',
        ],

    ];

    public function index()
    {
        return response()->json([
            'message' => 'successful',
            'Data' => $this->books

        ], 200);
    }

 

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'authorId' => 'required|string',
            'isbn' => 'required|string',
            'published_year' => 'required|integer',
            'genre' => 'required|string',
            'summary' => 'required|string',
        ]);

        $newBook = array_merge($validated, ['id' => Str::uuid()->toString()]);
        $this->books[] = $newBook; 

        return response()->json([
            'message' => 'Book added (fake, no DB)',
            'data' => $newBook,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = collect($this->books)->firstWhere('id', $id);

        if ($book) {
            return response()->json(['message' => 'Book found', 'data' => $book], 200);
        }

        return response()->json(['message' => 'Book not found'], 404);
    }

 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = collect($this->books)->firstWhere('id', $id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $updatedBook = array_merge($book, $request->only([
            'title',
            'authorId',
            'isbn',
            'published_year',
            'genre',
            'summary'
        ]));

        return response()->json([
            'message' => 'Book updated (simulated)',
            'data' => $updatedBook,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = collect($this->books)->firstWhere('id', $id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json([
            'message' => 'Book deleted (simulated)',
            'data' => $book,
        ]);
    }
}