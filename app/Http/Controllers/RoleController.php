<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function get_permissions(Request $request){
        $permissions =$this->user->getAuthUser($request)->getPermissions($request->key);
        return $permissions != null ? response()->json([
            'status' => 'success',
            'message' => 'Permissions',
            'data' => $permissions
        ], 200) : response()->json([
            'status' => 'error',
            'message' => 'Permissions not found'
        ], 400);
    }
}
