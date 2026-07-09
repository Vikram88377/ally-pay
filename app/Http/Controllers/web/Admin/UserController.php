<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\AssignRoleRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $roles = Role::where('guard_name', 'api')->get();

        return view('admin.users.show', compact('user', 'roles'));
    }

    public function assignRole(AssignRoleRequest $request, User $user)
    {
        $user->syncRoles([$request->role]);

        return back()->with('success', 'Role assigned successfully');
    }
}