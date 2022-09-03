<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
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
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60 // Expiration time
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    public function login(Request $request)
    {
        $validated = $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:6'
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
        $validated = $this->validate($request, [
            'username' => 'required|max:150',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        $register = User::create($validated);

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
}