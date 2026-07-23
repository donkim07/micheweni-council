<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::withCount(['users', 'permissions'])
            ->orderBy('name')
            ->paginate(15);
            
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = $this->getGroupedPermissions();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:roles,slug',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
        
        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Set default values for checkboxes if not present
        $validated['is_active'] = $request->has('is_active');
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Create the role
            $role = Role::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'is_active' => $validated['is_active'],
            ]);
            
            // Attach permissions
            if (isset($validated['permissions'])) {
                $role->permissions()->sync($validated['permissions']);
            }
            
            DB::commit();
            
            return redirect()->route('admin.roles.index')
                ->with('success', __('Role created successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', __('Error creating role: ') . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::with(['permissions', 'users'])->findOrFail($id);
        $permissions = $this->getGroupedPermissions();
        
        return view('admin.roles.show', compact('role', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = $this->getGroupedPermissions();
        
        // Convert permissions to array of IDs for easier handling in form
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:roles,slug,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
        
        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Set default values for checkboxes if not present
        $validated['is_active'] = $request->has('is_active');
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Update the role
            $role->update([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'is_active' => $validated['is_active'],
            ]);
            
            // Update permissions
            if (isset($validated['permissions'])) {
                $role->permissions()->sync($validated['permissions']);
            } else {
                $role->permissions()->detach();
            }
            
            DB::commit();
            
            return redirect()->route('admin.roles.index')
                ->with('success', __('Role updated successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', __('Error updating role: ') . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::withCount('users')->findOrFail($id);
        
        // Check if role has users
        if ($role->users_count > 0) {
            return back()->with('error', __('Cannot delete role with assigned users. Remove users from role first.'));
        }
        
        // Delete role
        $role->delete();
        
        return redirect()->route('admin.roles.index')
            ->with('success', __('Role deleted successfully.'));
    }
    
    /**
     * Get permissions grouped by module.
     */
    private function getGroupedPermissions()
    {
        $permissions = Permission::all();
        $grouped = [];
        
        foreach ($permissions as $permission) {
            $module = $permission->module ?? 'General';
            if (!isset($grouped[$module])) {
                $grouped[$module] = [];
            }
            $grouped[$module][] = $permission;
        }
        
        // Sort groups alphabetically
        ksort($grouped);
        
        return $grouped;
    }
}
