<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponseTrait;
class UserController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $users = User::latest()->paginate(10);

                return $this->successResponse(
                    UserResource::collection($users),
                    'Users fetched successfully'
                );
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles([$request->role]);

        return response()->json([
            'success' => true,
            'message' => 'Role assigned successfully',
            'data' => new UserResource($user),
        ]);
    }
}