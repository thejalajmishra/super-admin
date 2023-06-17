<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Mail;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['role:superadmin','permission:users lists|users create|users update|users delete']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs  = [
            [
                'link' => "/dashboard",
                'name' => "Dashboard"
            ],
            [
                'link' => "/users/lists",
                'name' => "User List"
            ]
        ];
        $pageTitle = 'Users List';
        $users = User::with('roles')->get();
        return view('users/lists', [
            'breadcrumbs' => $breadcrumbs,
            'pagetitle' => $pageTitle,
            'users' => $users
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
                'link' => "/users/lists",
                'name' => "User List"
            ],
            [
                'link' => "/users/create",
                'name' => "User Create"
            ]
        ];
        $pageTitle = 'Users Create';
        $roles = Role::all();
        return view('users/create', [
            'breadcrumbs' => $breadcrumbs,
            'pagetitle' => $pageTitle,
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'password' => 'required',
            'status' => 'required',
            'role' => 'required',
        ]);

        $users = new User();
        $users->first_name = $request->first_name;
        $users->last_name = $request->last_name;
        $users->email = $request->email;
        $users->mobile = $request->mobile;
        $users->password = Hash::make($request->password);
        $users->status = $request->status;
        $users->save();

        if(isset($request->role)){
            $role = Role::find($request->role);
            $users->assignRole($role);
        }

        return redirect('users/lists')->with('message', "User created successfully.");
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
        $breadcrumbs  = [
            [
                'link' => "/dashboard",
                'name' => "Dashboard"
            ],
            [
                'link' => "/users/lists",
                'name' => "User List"
            ],
            [
                'link' => "/users/".$id."/edit",
                'name' => "User Edit"
            ]
        ];
        $pageTitle = 'Users Edit';
        $roles = Role::all();
        $users = User::find($id);
        return view('users/edit', [
            'breadcrumbs' => $breadcrumbs,
            'pagetitle' => $pageTitle,
            'users' => $users,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'status' => 'required',
            'role' => 'required',
        ]);

        $users = User::find($id);
        $users->first_name = $request->first_name;
        $users->last_name = $request->last_name;
        $users->email = $request->email;
        $users->mobile = $request->mobile;
        if(isset($request->password) && !empty($request->password)){
            $users->password = Hash::make($request->password);
        }
        $users->status = $request->status;
        $users->save();

        $users->roles()->detach();
        if(isset($request->role)){
            $role = Role::find($request->role);
            $users->assignRole($role);
        }

        return redirect('users/lists')->with('message', "User updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = User::find($id);
        $users->delete($id);

        return redirect()->back()->with('message', "User deleted successfully.");
    }

    /**
     * Show the form for editing the role resource.
     */
    public function roles_edit(string $id)
    {
        $roles = Role::find($id);
        return view('users.roles-permissions', [
            'roles' => $roles
        ]);
    }

    public function send_email()
    {
        Mail::send('email', [
            'name' => 'Jalaj Kumar',
            'email' => 'jalaj.kumar@jaypeebrothers.com',
            'comment' => 'This is for testing purpose only' ],
            function ($message) {
                    $message->from('diginerve@email.diginerve.com');
                    $message->to('jalaj.kumar@jaypeebrothers.com', 'Jalaj Kumar');
                    // $message->to('akhil.ramachandran@jaypeebrothers.com', 'Akhil Ramchandran');
                    $message->subject('This is for testing purpose only');
        });
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function permissions(string $id)
    {
        $users = User::find($id);
        $permissions = Permission::all();
        $result = array();

        foreach ($permissions as $key => $permission) {
            $parts = explode(' ', $permission->name);
            $category = $parts[0] ?? '';
            $action = $parts[1] ?? '';
        
            if (!isset($result[$category])) {
                $result[$category] = array();
            }
        
            $result[$category][] = $action;
        }

        $user_permissions = $users->permissions->pluck('name')->toArray();

        return view('users.permissions', [
            'users' => $users,
            'permissions' => $result,
            'user_permissions' => $user_permissions
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

        $user = User::find($id);
        $user->syncPermissions($request->permissions);

        return redirect('users/lists');
    }
}
