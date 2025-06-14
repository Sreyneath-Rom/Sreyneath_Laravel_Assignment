<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    public $authors = [
        [
            'id' => '1',
            'name' => 'J.R.R. Tolkien',
            'bio' => 'English writer, poet, and university professor, best known for The Lord of the Rings.',
            'nationality' => 'British',
        ],
        [
            'id' => '2',
            'name' => 'Jane Austen',
            'bio' => 'English novelist known for her realism and social commentary in works like Pride and Prejudice.',
            'nationality' => 'British',
        ],
    ];

    public function index()
    {
        return response()->json([
            'message' => 'Successful',
            'data' => $this->authors
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'bio' => 'required|string',
            'nationality' => 'required|string',
        ]);

        $newAuthor = array_merge($validated, ['id' => Str::uuid()->toString()]);
        $this->authors[] = $newAuthor;

        return response()->json([
            'message' => 'Author added (fake, no DB)',
            'data' => $newAuthor,
        ], 201);
    }

    public function show(string $id)
    {
        $author = collect($this->authors)->firstWhere('id', $id);

        if ($author) {
            return response()->json(['message' => 'Author found', 'data' => $author], 200);
        }

        return response()->json(['message' => 'Author not found'], 404);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'bio' => 'sometimes|required|string',
            'nationality' => 'sometimes|required|string',
        ]);

        foreach ($this->authors as &$author) {
            if ($author['id'] === $id) {
                $author = array_merge($author, $validated);
                return response()->json(['message' => 'Author updated', 'data' => $author], 200);
            }
        }

        return response()->json(['message' => 'Author not found'], 404);
    }

    public function destroy(string $id)
    {
        $initialCount = count($this->authors);
        $this->authors = array_filter($this->authors, fn($author) => $author['id'] !== $id);

        if (count($this->authors) < $initialCount) {
            return response()->json(['message' => 'Author deleted'], 200);
        }

        return response()->json(['message' => 'Author not found'], 404);
    }
}