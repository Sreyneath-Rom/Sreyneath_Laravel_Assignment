<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public $users = [
        [
            'id' => '1',
            'name' => 'Alice Johnson',
            'email' => 'alice@example.com',
            'membershipDate' => '2023-05-10',
        ],
        [
            'id' => '2',
            'name' => 'Bob Smith',
            'email' => 'bob@example.com',
            'membershipDate' => '2022-11-25',
        ],
    ];

    public function index()
    {
        return response()->json([
            'message' => 'Users retrieved successfully',
            'data' => $this->users
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'membershipDate' => 'required|date',
        ]);

        $newUser = array_merge($validated, ['id' => Str::uuid()->toString()]);
        $this->users[] = $newUser;

        return response()->json([
            'message' => 'User added (fake, no DB)',
            'data' => $newUser,
        ], 201);
    }

    public function show(string $id)
    {
        $user = collect($this->users)->firstWhere('id', $id);

        if ($user) {
            return response()->json(['message' => 'User found', 'data' => $user], 200);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|string|email',
            'membershipDate' => 'sometimes|required|date',
        ]);

        foreach ($this->users as &$user) {
            if ($user['id'] === $id) {
                $user = array_merge($user, $validated);
                return response()->json(['message' => 'User updated', 'data' => $user], 200);
            }
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    public function destroy(string $id)
    {
        $initialCount = count($this->users);
        $this->users = array_filter($this->users, fn($user) => $user['id'] !== $id);

        if (count($this->users) < $initialCount) {
            return response()->json(['message' => 'User deleted'], 200);
        }

        return response()->json(['message' => 'User not found'], 404);
    }
}