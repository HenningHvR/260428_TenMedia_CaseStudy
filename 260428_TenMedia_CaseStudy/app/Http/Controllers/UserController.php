<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    // Zeigt eine Liste aller User an.
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        $users = User::orderBy('name')->get();

        return view('users.index', compact('users'));
    }

    // Zeigt einen einzelnen User an.
    public function show(User $user): View
    {
        $this->authorize('view', $user);

        return view('users.show', compact('user'));
    }

    // Zeigt das Formular zum Bearbeiten eines Users an.
    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    // Aktualisiert die Rolle eines Users.
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $validatedUserData = $request->validated();

        $user->update($validatedUserData);

        return redirect()
            ->route('users.index')
            ->with('success', 'User-Rolle wurde erfolgreich aktualisiert.');
    }
}
