<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Successful',
            'data' => Author::all(),
        ], 200);
    }

    // You can rename to 'create' if you're using custom routes
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'bio' => 'required|string',
            'nationality' => 'required|string',
        ]);

        $author = Author::create($validated);

        return response()->json([
            'message' => 'Author added successfully',
            'data' => $author,
        ], 201);
    }

    public function show(string $id)
    {
        $author = Author::find($id);

        if ($author) {
            return response()->json(['message' => 'Author found', 'data' => $author], 200);
        }

        return response()->json(['message' => 'Author not found'], 404);
    }

    public function update(Request $request, string $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'bio' => 'sometimes|required|string',
            'nationality' => 'sometimes|required|string',
        ]);

        $author->update($validated);

        return response()->json([
            'message' => 'Author updated successfully',
            'data' => $author,
        ]);
    }

    public function destroy(string $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        $author->delete();

        return response()->json([
            'message' => 'Author deleted successfully',
        ]);
    }
}