<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Index login controller
     *
     * When user success login will retrive callback as api_token
     */
    public function __construct()
    {
        //
    }

    public function login(Request $request)
    {
        $hasher = app()->make('hash');

        // $login = $request->validate([
        //     'email' => 'required|string',
        //     'password' => 'required|string',
        // ]);

        // if (!Auth::attempt($login)) {
        //     return response()->json([
        //         'status' => 'failed',
        //         'message' => 'Your email or password incorrect!'
        //     ]);
        // }

        // $api_token = Auth::user()->createToken

        $email = $request->input('email');
        $password = $request->input('password');

        $login = User::where('email', $email)->first();
        if (!$login) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Your email or password incorrect!'
            ]);
        } else {
            if ($hasher->check($password, $login->password)) {
                $api_token = sha1(time());
                $create_token = User::where('uuid', $login->uuid)->update(['api_token' => $api_token]);
                if ($create_token) {
                    return response()->json([
                        'status' => 'success',
                        'api_token' => $api_token,
                        'message' => $login
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Your email or password incorrect!'
                ]);
            }
        }
    }

    public function register(Request $request)
    {
        $hasher = app()->make('hash');

        $username = $request->input('username');
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $hasher->make($request->input('password'));

        $register = User::create([
            'username'=> $username,
            'name'=> $name,
            'email'=> $email,
            'password'=> $password,
        ]);

        if ($register) {
            return response()->json([
                'status' => 'success',
                'message' => 'Account created successfully'
            ]);
        }
        else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Account failed to created'
            ]);
        }
    }

    // public function get_nama(Request $request)
    // {
    //     return response()->json([
    //         'messages' => 'Your request has been successfully',
    //         'nama' => $request->nama
    //     ]);
    // }
}