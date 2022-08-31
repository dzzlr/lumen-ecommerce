<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Index login controller
     *
     * When user success login will retrive callback as api_token
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function jwt(User $user) 
    {
        $payload = [
            'iss' => "bearer", // Issuer of the token
            'sub' => $user->uuid, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60 // Expiration time
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    public function login(Request $request)
    {
        $validated = $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $validated['email'])->first();
        if (!Hash::check($validated['password'], $user->password)) {
            return abort(401, 'Your email or password incorrect!');
        }

        return response()->json([
            'status' => 'success',
            'message' => $user,
            'access_token' => $this->jwt($user),
        ]);
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
            ], 200);
        }
        else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Account failed to created'
            ], 400);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ], 200);
    }

    public function getUser(Request $request)
    {
        $token = $request->bearerToken();
        $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

        $user = User::where('uuid', $credentials->sub)->first();

        return response()->json([
            'messages' => 'Your request has been successfully',
            'data' => $user
        ]);
    }
}