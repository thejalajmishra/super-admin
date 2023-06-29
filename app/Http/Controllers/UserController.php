<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Notifications\UserCreatedSuccessful;
use Illuminate\Support\Facades\Notification;
Use Alert;
use Mail;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['role:superadmin','permission:users lists|users create|users update|users delete']);
    }

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
                'link' => "/users/lists",
                'name' => "User List"
            ]
        ];
        $pageTitle = 'Users List';
        $users = User::with('roles');
        if(isset($request->s) && !empty($request->s)){
            $users = $users->where('first_name', $request->s);
            $users = $users->orWhere('last_name', $request->s);
            $users = $users->orWhere('email', $request->s);
            $users = $users->orWhere('mobile', $request->s);
        }
        if(isset($request->status) && $request->status != ''){
            if($request->status == '2'){
                $users = $users->where('deleted_at', '!=', NULL);
            } else {
                $users = $users->where('status', $request->status);
            }
        }

        $user = Auth::user();
        if($user->hasRole('superadmin')){
            $users = $users->withTrashed();
        }

        $users = $users->orderBy('id', 'desc')->paginate($per_page);
        $roles = Role::all();
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('users/lists', [
            'breadcrumbs' => $breadcrumbs,
            'pagetitle' => $pageTitle,
            'users' => $users,
            'roles' => $roles,
            'request' => $request
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
            'file' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $users = new User();
        $users->first_name = $request->first_name;
        $users->last_name = $request->last_name;
        $users->email = $request->email;
        $users->mobile = $request->mobile;
        $users->gender = $request->gender;
        $users->password = Hash::make($request->password);
        $users->status = $request->status;
        if($request->file('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time().'_'.$file->getClientOriginalName();
            $location = 'uploads/profile';
            $file->move($location, $filename);
            $users->profile_picture = $location.'/'.$filename;
        }
        $users->login_allowed = $request->login_allowed ?? 0;
        $users->save();

        if(isset($request->role)){
            $role = Role::find($request->role);
            $users->assignRole($role);
        }

        $superadminRole = Role::where('name', 'superadmin')->first();
        $users = User::role($superadminRole)->get();

        Notification::send($users, new UserCreatedSuccessful($request->email));

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
        $users = User::withTrashed()->find($id);
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
        // echo '<pre>';
        // print_r($request->file('profile_picture'));
        // exit;

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'status' => 'required',
            'role' => 'required',
        ]);

        $users = User::withTrashed()->find($id);
        $users->first_name = $request->first_name;
        $users->last_name = $request->last_name;
        $users->email = $request->email;
        $users->mobile = $request->mobile;
        $users->gender = $request->gender;
        if(isset($request->password) && !empty($request->password)){
            $users->password = Hash::make($request->password);
        }
        $users->status = $request->status;
        if($request->file('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time().'_'.$file->getClientOriginalName();
            $location = 'uploads/profile';
            $file->move($location, $filename);
            $users->profile_picture = $location.'/'.$filename;
        }
        $users->login_allowed = $request->login_allowed ?? 0;
        $users->deleted_at = NULL;
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
        $breadcrumbs  = [
            [
                'link' => "/dashboard",
                'name' => "Dashboard"
            ],
            [
                'link' => "/users/lists",
                'name' => "Users List"
            ],
            [
                'link' => "/users/".$id."/permissions",
                'name' => "Roles Permissions"
            ]
        ];
        $pageTitle = 'Users Permissions';

        $users = User::find($id);
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

        $user_permissions = $users->permissions->pluck('name')->toArray();

        return view('users.permissions', [
            'breadcrumbs' => $breadcrumbs,
            'pagetitle' => $pageTitle,
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
        $user = User::find($id);
        $user->syncPermissions($request->permissions);
        return redirect('users/lists');
    }

    public function search(Request $request) {
        $results = User::search('jalaj')->get();
        dd($results);
    }
}
