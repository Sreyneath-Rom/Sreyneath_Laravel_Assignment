<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index()
    {
        $users = new User();

        return response()->json([
            'message' => 'Users retrieved successfully',
            'data' => $users::all(), // Retrieve all users
        ], 200);
    }

    //create new user with validation
    public function create(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }
    // Show one user

    public function show(string $id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json(['message' => 'User found', 'data' => $user], 200);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'sometimes|required|string|email|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:6',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        return response()->json(['message' => 'User updated', 'data' => $user], 200);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted'], 200);
    }
}