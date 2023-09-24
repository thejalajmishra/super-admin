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
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 5;
        $breadcrumbs  = [
            [
                'link' => "/dashboard",
                'name' => "Dashboard"
            ],
            [
                'link' => "/permissions/lists",
                'name' => "Permissions List"
            ]
        ];
        $pageTitle = 'Permissions List';
        $permissions = Permission::select('*');
        if(isset($request->s) && !empty($request->s)){
            $permissions = $permissions->where('name', $request->s);
            $permissions = $permissions->orWhere('description', $request->s);
        }
        $permissions = $permissions->orderBy('id', 'DESC');
        $permissions = $permissions->paginate($per_page);
        return view('permissions.lists', [
            'breadcrumbs' => $breadcrumbs,
            'pagetitle' => $pageTitle,
            'request' => $request,
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs  = [
            [
                'link' => "/dashboard",
                'name' => "Dashboard"
            ],
            [
                'link' => "/permissions/lists",
                'name' => "Permissions List"
            ],
            [
                'link' => "/permissions/create",
                'name' => "Permissions Create"
            ]
        ];
        $pageTitle = 'Permissions Create';
        return view('permissions.create', [
            'breadcrumbs' => $breadcrumbs,
            'pagetitle' => $pageTitle,
        ]);
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
            'guard_name' => $request->guard_name,
            'status' => $request->status
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
        $permission->status = $request->status;
        $permission->save();

        return redirect('permissions/lists');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::find($id);

        if ($permission != null) {
            $permission->delete($id);
            return redirect()->back()->with('message', "Permission deleted successfully.");
        }
        return redirect()->route('dashboard')->with(['message'=> 'Wrong ID!!']);  
    }
}
