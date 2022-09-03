<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $token = $request->bearerToken();
        $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

        $user = User::where('id', $credentials->sub)->first();

        if ($user) {
            return response()->json([
                'status' => 'success',
                'messages' => 'Successfully get retrieved user info data',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to get retrieve user info data'
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) //$id
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $token = $request->bearerToken();
        $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

        $validated = $this->validate($request, [
            'username' => 'sometimes|unique|max:100',
            'name' => 'sometimes|max:255'
        ]);
        
        $user = User::where('id', $credentials->sub)->update($validated);
        $user_data = User::where('id', $credentials->sub)->first();

        if ($user) {
            return response()->json([
                'status' => 'success',
                'messages' => 'Successfully updated user info data',
                'data' => $user_data
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to update user info data'
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $token = $request->bearerToken();
        $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

        $validated = $this->validate($request, [
            'password' => 'required|min:6',
            'new_password' => 'required|min:6',
            'new_confirm_password' => 'required|min:6',
        ]);

        $user = User::where('id', $credentials->sub)->first();

        $password_old = $request->password;
        if (Hash::check($password_old, $user->password)) {
            if ($validated["new_password"] == $validated["new_confirm_password"]) {
                $validated["new_password"] = Hash::make($validated["new_password"]);

                $user->fill(['password' => $validated["new_password"]])->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Successfully updated user password'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Your new confirm password doesn\'t match'
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Your old password doesn\'t match'
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
    }
}