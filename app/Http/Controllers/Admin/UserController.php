<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $data = [];

        $users = User::filter()->paginate(10);

        $data['users'] = $users;


        return view('admin.users.index', $data);
    }

    public function show($id)
    {
        $data = [];

        $user = User::find($id);
        $roles = Role::all();

        $data['user'] = $user;
        $data['roles'] = $roles;

        return view('admin.users.edit', $data);
    }

    public function assignRole(Request $request, User $user)
    {
        if ($user->hasRole($request->role)) {

            notify()->error('Thành viên đã có vai trò này', 'Lỗi');

            return back();
        }

        $user->assignRole($request->role);

        notify()->success('Thêm vai trò cho thành viên thành công', 'Thông báo');

        return back();
    }

    public function removeRole(User $user, Role $role)
    {
        if ($user->hasRole($role)) {

            $user->removeRole($role);

            notify()->success('Xoá vai trò khỏi thành viên thành công', 'Thông báo');

            return back();
        }

        notify()->error('Vai trò này không tồn tại', 'Lỗi');

        return back();
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {

            notify()->error('Thành viên này không thể xoá', 'Lỗi');

            return back();
        }

        $user->delete();

        notify()->success('Xoá thành viên thành công', 'Thông báo');

        return back();
    }
}
