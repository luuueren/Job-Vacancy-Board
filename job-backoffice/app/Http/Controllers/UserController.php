<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->boolean('archived')) {
            $query->onlyTrashed();
        } else {
            $query->latest();
        }

        $users = $query
            ->paginate(10)
            ->onEachSide(1);

        return view('user.index', compact('users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return view('user.show', compact('user'));
    }

   /**
 * Show the form for editing the specified resource.
 */
public function edit(string $id)
{
    $user = User::findOrFail($id);

    return view('user.edit', compact('user'));
}

/**
 * Update the specified resource in storage.
 */
public function update(UserUpdateRequest $request, string $id)
{
    $user = User::findOrFail($id);

    $user->update([
        'password' => Hash::make($request->password),
    ]);

    return redirect()
        ->route('user.index')
        ->with('success', 'User password updated successfully.');
}
    /**
     * Archive the specified resource.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()
            ->back()
            ->with('success', 'User archived successfully.');
    }

    /**
     * Restore the specified resource.
     */
    public function restore(string $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->restore();

        return redirect()
            ->route('user.index', ['archived' => true])
            ->with('success', 'User restored successfully.');
    }
}
