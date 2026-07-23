<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');
        
        // Search by name or email if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter by role if provided
        if ($request->has('role_id') && !empty($request->role_id)) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('roles.id', $request->role_id);
            });
        }
        
        $users = $query->orderBy('name')->paginate(15);
        $roles = Role::pluck('name', 'id')->toArray();
        
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('is_active', true)->pluck('name', 'id')->toArray();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,id'],
        ]);
        
        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);
        
        // Assign roles
        if (isset($validated['roles'])) {
            $user->roles()->sync($validated['roles']);
        }
        
        return redirect()->route('admin.users.index')
            ->with('success', __('User created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::where('is_active', true)->pluck('name', 'id')->toArray();
        
        // Check if trying to edit own account and redirect to profile instead
        if (Auth::id() == $user->id) {
            return redirect()->route('admin.profile.edit')
                ->with('info', __('Please use the profile page to edit your own account.'));
        }
        
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        // Prevent self-editing through this route
        if (Auth::id() == $user->id) {
            return redirect()->route('admin.profile.edit')
                ->with('info', __('Please use the profile page to edit your own account.'));
        }
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,id'],
        ]);
        
        // Update user data
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];
        
        // Only update password if provided
        if (!empty($validated['password'])) {
            $userData['password'] = $validated['password'];
        }
        
        $user->update($userData);
        
        // Update roles
        if (isset($validated['roles'])) {
            $user->roles()->sync($validated['roles']);
        } else {
            $user->roles()->detach();
        }
        
        return redirect()->route('admin.users.index')
            ->with('success', __('User updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        // Prevent self-deletion
        if (Auth::id() == $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', __('You cannot delete your own account.'));
        }
        
        // Delete user
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', __('User deleted successfully.'));
    }
}
