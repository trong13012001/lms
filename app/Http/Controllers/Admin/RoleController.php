<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::whereNotIn('name', ['admin'])->filter()->orderBy('id', 'DESC')->paginate(10);

        return view('admin.role.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => ['required', 'min:3','max:255']]);
        $isExistRole=Role::where('name',$request->name)->exists();
        if($isExistRole){
            notify()->error('Vai trò đã tồn tại, vui lòng thực hiện chỉnh sửa nếu muốn thay đổi thông tin vai trò', 'Lỗi');
            return back();
        }

        Role::create($validated);


        notify()->success('Thêm vai trò thành công', 'Thông báo');

        return to_route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.role.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate(['name' => ['required', 'min:3', 'max:255']]);

        if ($role->name !== $request->name) {
            $isExistRole = Role::where('name', $request->name)->exists();
            if ($isExistRole) {
                notify()->error('Vai trò đã tồn tại, vui lòng thực hiện chỉnh sửa nếu muốn thay đổi thông tin vai trò', 'Lỗi');
                return back();
            }
        }

        $role->update($validated);

        notify()->success('Sửa vai trò thành công', 'Thông báo');

        return to_route('admin.roles.index');
    }


    public function destroy(Role $role)
    {
        if ($role->users()->exists()) {
            notify()->error('Không thể xoá vai trò đang được sử dụng', 'Lỗi');
            return back();
        }

        try {
            $role->delete();
            notify()->success('Xoá vai trò thành công', 'Thông báo');
        } catch (\Exception $e) {
            notify()->error('Không thể xoá vai trò. Vui lòng thử lại sau', 'Lỗi');
        }

        return back();
    }

    public function givePermission(Request $request, Role $role)
    {
        if($role->hasPermissionTo($request->permission)){

            notify()->error('Vai trò đã có quyền này', 'Lỗi');

            return back();
        }
        $role->givePermissionTo($request->permission);

        notify()->success('Thêm quyền cho vai trò thành công', 'Thông báo');

        return back();
    }

    public function revokePermission(Role $role, Permission $permission)
    {
        if($role->hasPermissionTo($permission)){
            $role->revokePermissionTo($permission);

            notify()->success('Thu hồi quyền thành công', 'Thông báo');

            return back();
        }

        notify()->error('Quyền này không tồn tại', 'Lỗi');

        return back();
    }
}
