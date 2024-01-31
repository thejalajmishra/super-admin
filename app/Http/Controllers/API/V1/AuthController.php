<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Failed.',
                'data' => $validator->errors()
            ], 422);
        }

        $credentials = [
            'mobile' => $request->input('mobile'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $accessToken = $user->createToken('SuperAdmin')->accessToken;

            return response()->json([
                'success' => true,
                'message' => 'User Logged In Successfully.',
                'data' => $user,
                'access_token' => $accessToken,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User does not exist or wrong credentials.',
                'data' => null
            ], 401);
        }
    }

    /** 
     * register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Failed.',
                'data' => $validator->errors()
            ], 422);
        }

        $user = new User([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'password' => Hash::make($request->input('password')),
            'login_allowed' => 0
        ]);

        if ($user->save()) {
            $role = Role::find(3);
            $user->assignRole($role);
            return response()->json([
                'success' => true,
                'message' => 'User Registered Successfully.',
                'data' => $user
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Somthing wrong. User Not Registered.',
            'data' => null
        ], 404);
    }
}
