<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::paginate(10);
        return view('permissions.lists', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'guard_name' => 'required'
        ]);

        $role = Permission::create([
            'name' => $request->name, 
            'description'=> $request->description, 
            'guard_name' => $request->guard_name
        ]);

        return redirect('permissions/lists');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permissions = Permission::find($id);
        return view('permissions.edit', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'guard_name' => 'required'
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->name; 
        $permission->description = $request->description;
        $permission->guard_name = $request->guard_name;
        $permission->save();

        return redirect('permissions/lists');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
