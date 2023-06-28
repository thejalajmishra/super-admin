<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Notifications\RoleCreatedSuccessful;
use Illuminate\Support\Facades\Notification;
use Mail;

class RoleController extends Controller
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
                'link' => "/roles/lists",
                'name' => "Roles List"
            ]
        ];
        $pageTitle = 'Roles List';
        $roles = Role::select('*');
        if(isset($request->s) && !empty($request->s)){
            $roles = $roles->where('name', $request->s);
            $roles = $roles->orWhere('description', $request->s);
        }
        $roles = $roles->paginate($per_page);
        return view('roles.lists', [
            'breadcrumbs' => $breadcrumbs,
            'pagetitle' => $pageTitle,
            'request' => $request,
            'roles' => $roles
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
                'link' => "/roles/lists",
                'name' => "Roles List"
            ],
            [
                'link' => "/roles/create",
                'name' => "Roles Create"
            ]
        ];
        $pageTitle = 'Roles Create';
        return view('roles.create', [
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

        $role = Role::create([
            'name' => $request->name, 
            'description'=> $request->description, 
            'guard_name' => $request->guard_name,
            'status' => $request->status
        ]);

        $superadminRole = Role::where('name', 'superadmin')->first();
        $users = User::role($superadminRole)->get();

        Notification::send($users, new RoleCreatedSuccessful($request->name));

        return redirect('roles/lists')->with('message', "Role created successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $breadcrumbs  = [
            [
                'link' => "/dashboard",
                'name' => "Dashboard"
            ],
            [
                'link' => "/roles/lists",
                'name' => "Roles List"
            ],
            [
                'link' => "/roles/create",
                'name' => "Roles Edit"
            ]
        ];
        $pageTitle = 'Roles Edit';
        $roles = Role::find($id);
        return view('roles.edit', [
            'breadcrumbs' => $breadcrumbs,
            'pagetitle' => $pageTitle,
            'roles' => $roles
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

        $role = Role::find($id);
        $role->name = $request->name; 
        $role->description = $request->description;
        $role->guard_name = $request->guard_name;
        $role->status = $request->status;
        $role->save();

        return redirect('roles/lists')->with('message', "Role updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roles = Role::find($id);

        if ($roles != null) {
            $roles->delete($id);
            return redirect()->back()->with('message', "Role deleted successfully.");
        }
        return redirect()->route('dashboard')->with(['message'=> 'Wrong ID!!']);   
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function permissions(string $id)
    {
        $breadcrumbs  = [
            [
                'link' => "/dashboard",
                'name' => "Dashboard"
            ],
            [
                'link' => "/roles/lists",
                'name' => "Roles List"
            ],
            [
                'link' => "/roles/".$id."/permissions",
                'name' => "Roles Permissions"
            ]
        ];
        $pageTitle = 'Roles Permissions';

        $roles = Role::find($id);
        $permissions = Permission::all();
        $result = array();

        foreach ($permissions as $key => $permission) {
            $parts = explode('.', $permission->name);
            $category = $parts[0] ?? '';
            $action = $parts[1] ?? '';
            if (!isset($result[$category])) {
                $result[$category] = array();
            }
            $result[$category][] = $action;
        }

        $role_permissions = $roles->permissions->pluck('name')->toArray();

        return view('roles.permissions', [
            'breadcrumbs' => $breadcrumbs,
            'pagetitle' => $pageTitle,
            'roles' => $roles,
            'permissions' => $result,
            'role_permissions' => $role_permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_permissions(Request $request, string $id)
    {
        $request->validate([
            'permissions' => 'required'
        ]);

        $role = Role::find($id);
        $role->syncPermissions($request->permissions);

        return redirect('roles/lists');
    }
}
