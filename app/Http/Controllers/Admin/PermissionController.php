<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Permission::query();
        
        // Filter by module if provided
        if ($request->has('module') && !empty($request->module)) {
            $query->where('module', $request->module);
        }
        
        // Search by name or description if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        
        $permissions = $query->orderBy('module')->orderBy('name')->paginate(20);
        $modules = Permission::distinct()->pluck('module')->filter()->toArray();
        
        return view('admin.permissions.index', compact('permissions', 'modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = Permission::distinct()->pluck('module')->filter()->toArray();
        return view('admin.permissions.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:permissions,slug',
            'description' => 'nullable|string',
            'module' => 'nullable|string|max:100',
        ]);
        
        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Create the permission
        $permission = Permission::create($validated);
        
        return redirect()->route('admin.permissions.index')
            ->with('success', __('Permission created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permission = Permission::with('roles.users')->findOrFail($id);
        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::findOrFail($id);
        $modules = Permission::distinct()->pluck('module')->filter()->toArray();
        
        return view('admin.permissions.edit', compact('permission', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission = Permission::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:permissions,slug,' . $id,
            'description' => 'nullable|string',
            'module' => 'nullable|string|max:100',
        ]);
        
        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Update the permission
        $permission->update($validated);
        
        return redirect()->route('admin.permissions.index')
            ->with('success', __('Permission updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::withCount('roles')->findOrFail($id);
        
        // Check if permission is assigned to any roles
        if ($permission->roles_count > 0) {
            return back()->with('error', __('Cannot delete permission assigned to roles. Remove from roles first.'));
        }
        
        // Delete permission
        $permission->delete();
        
        return redirect()->route('admin.permissions.index')
            ->with('success', __('Permission deleted successfully.'));
    }
    
    /**
     * Generate default permissions for the system.
     */
    public function generateDefaults()
    {
        // Define modules and their permissions
        $modulePermissions = [
            'Dashboard' => ['view'],
            'Pages' => ['view', 'create', 'edit', 'delete'],
            'Contents' => ['view', 'create', 'edit', 'delete'],
            'News' => ['view', 'create', 'edit', 'delete', 'publish'],
            'Categories' => ['view', 'create', 'edit', 'delete'],
            'WasteLocations' => ['view', 'create', 'edit', 'delete'],
            'Users' => ['view', 'create', 'edit', 'delete'],
            'Roles' => ['view', 'create', 'edit', 'delete'],
            'Permissions' => ['view', 'create', 'edit', 'delete'],
            'Settings' => ['view', 'edit'],
        ];
        
        $count = 0;
        
        foreach ($modulePermissions as $module => $actions) {
            foreach ($actions as $action) {
                $name = ucfirst($action) . ' ' . $module;
                $slug = Str::slug($action . '-' . $module);
                
                $permission = Permission::firstOrNew(['slug' => $slug]);
                
                if (!$permission->exists) {
                    $permission->name = $name;
                    $permission->module = $module;
                    $permission->description = 'Ability to ' . strtolower($action) . ' ' . strtolower($module);
                    $permission->save();
                    $count++;
                }
            }
        }
        
        return redirect()->route('admin.permissions.index')
            ->with('success', __(':count default permissions generated.', ['count' => $count]));
    }
}
