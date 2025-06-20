<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'operator')->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'operator',
            'is_active' => true
        ]);

        return response()->json(['message' => 'Operator ditambahkan']);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        if ($user->role != 'operator') return abort(403, 'Hanya operator');
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->role != 'operator') return abort(403, 'Hanya operator');

        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username,'.$id,
        ]);

        $user->name = $request->name;
        $user->username = $request->username;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json(['message' => 'Operator diupdate']);
    }


    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        if ($user->role != 'operator') return abort(403, 'Hanya operator');
        $user->is_active = false;
        $user->save();
        return response()->json(['message' => 'User dinonaktifkan']);
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);
        if ($user->role != 'operator') return abort(403, 'Hanya operator');
        $user->is_active = true;
        $user->save();
        return response()->json(['message' => 'User diaktifkan']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->is_active) {
            return response()->json(['message' => 'User aktif tidak bisa dihapus'], 403);
        }
        $user->delete();
        return response()->json(['message' => 'User dihapus']);
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'role' => $user->role,
                'created_at' => $user->created_at,
            ]
        ]);
    }
}