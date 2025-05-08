<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = [];

        $users = User::filter($request->all())->paginate(10)->withQueryString();

        $data['users'] = $users;


        return view('admin.users.index', $data);
    }

    public function create() {
        return view('admin.users.create');
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
        $request->validate([
            'role' => 'required|exists:roles,name',

        ],
        [
        'role.required' => 'Vai trò không được bỏ trống',
        'role.exists' => 'Vai trò không tồn tại',
        ]);
        if ($user->hasRole($request->role)) {

            notify()->error('tài khoản đã có vai trò này', 'Thông báo');

            return back();
        }

        $user->assignRole($request->role);

        notify()->success('Thêm vai trò cho tài khoản thành công', 'Thông báo');

        return back();
    }

    public function removeRole(User $user, Role $role)
    {
        if ($user->hasRole($role)) {

            $user->removeRole($role);

            notify()->success('Xoá vai trò khỏi tài khoản thành công', 'Thông báo');

            return back();
        }

        notify()->error('Vai trò này không tồn tại', 'Thông báo');

        return back();
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            notify()->error('tài khoản này không thể xoá', 'Thông báo');
            return back();
        }

        $currentPage = request()->get('page', 1);
        $perPage = 10;
        $searchParams = request()->only(['username']);

        $query = User::query();
        if (!empty($searchParams['username'])) {
            $query->where('username', 'like', '%' . $searchParams['username'] . '%');
        }

        $totalUsers = $query->count();
        $user->delete();

        $newTotalUsers = $totalUsers - 1;
        $maxPage = max(1, ceil($newTotalUsers / $perPage));

        notify()->success('Xóa tài khoản thành công', 'Thông báo');

        if ($currentPage > $maxPage) {
            return redirect()->route('admin.users.index', array_merge($searchParams, ['page' => $maxPage]));
        }

        return back();
    }
}
