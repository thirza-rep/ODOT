<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with(['roles', 'branch'])
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%"))
            ->latest()
            ->paginate(15);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $branches = Branch::active()->get();

        return view('users.create', compact('roles', 'branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'confirmed', Password::min(8)],
            'phone'     => ['nullable', 'string', 'max:20'],
            'role'      => ['required', 'exists:roles,name'],
            'branch_id' => ['nullable', 'exists:branches,id'],
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'phone'     => $validated['phone'] ?? null,
            'branch_id' => $validated['branch_id'] ?? null,
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('users.index')->with('success', "User {$user->name} berhasil dibuat.");
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $branches = Branch::active()->get();

        return view('users.edit', compact('user', 'roles', 'branches'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone'     => ['nullable', 'string', 'max:20'],
            'role'      => ['required', 'exists:roles,name'],
            'branch_id' => ['nullable', 'exists:branches,id'],
            'password'  => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $user->update([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'phone'     => $validated['phone'] ?? null,
            'branch_id' => $validated['branch_id'] ?? null,
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.index')->with('success', "User {$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
