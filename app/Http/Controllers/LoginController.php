<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(Request $request)
    {
        if(Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ])->fails()){
            return ['status' => 'error', 'message' => 'Invalid Parameters'];
        }

        $user = $this->user->where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login Successful',
                    'data' => $user
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid Password'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Email'
            ]);
        }
    }

    public function register(Request $request)
    {
        $user = $this->user->where('email', $request->email)->first();

        if ($user) {
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

        return $this->user->create($data) ? response()->json([
            'status' => 'success',
            'message' => 'Registration Successful',
            'data' => $this->user
        ]) : response()->json([
            'status' => 'error',
            'message' => 'Registration Failed'
        ]);
    }
}
