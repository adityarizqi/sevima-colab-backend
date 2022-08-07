<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(Request $request)
    {
        if (Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ])->fails()) {
            return ['status' => 'error', 'message' => 'Invalid Parameters'];
        }

        $user = $this->user->where('email', $request->email)->first();

        if (Hash::check($request->password, $user->password)) {
            $user->generateAndSaveApiAuthToken();
            return response()->json([
                'status' => 'success',
                'message' => 'Login Successful',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Email or Password is incorrect'
            ]);
        }
    }

    public function register(Request $request)
    {
        if ($this->user->where('email', $request->email)->first()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email already exists'
            ]);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        $user = $this->user->create($data);

        if ($user) {
            event(new Registered($user));
            return response()->json([
                'status' => 'success',
                'message' => 'Registration Successful, please check your email for verification',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Registration Failed, please try again',
            ]);
        }
    }

    public function logout(Request $request)
    {
        $user = User::where('api_token', str_replace('Bearer ','',$request->header('Authorization')))->first();
        return $user->update(['api_token' => null]) ? response()->json([
            'status' => 'success',
            'message' => 'Logout Successful'
        ]) : response()->json([
            'status' => 'error',
            'message' => 'Logout Failed'
        ]);
    }
}
