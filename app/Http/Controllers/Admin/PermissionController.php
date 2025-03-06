<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class PermissionController extends Controller
{
    public function index()
    {

        $permissions = Permission::filter()->paginate(10);


        $router = $this->getRoutesByGroup(['middleware' => 'permission']);

        $listRoute = [];

        foreach ($router as $item) {
            $action = $item->getAction();
            $listRoute[] = $action['as'];
        }

        return view('admin.permissions.index', compact('permissions', 'listRoute'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => '',
        ]);
        $isExistPermission = Permission::where('name', $request->name)->exists();

        if ($isExistPermission) {
            notify()->error('Phân quyền đã tồn tại, vui lòng thực hiện chỉnh sửa nếu muốn thay đổi thông tin phân quyền', 'Lỗi');

            return back();
        }
        Permission::create($validated);

        notify()->success('Thêm phân quyền thành công', 'Thông báo');

        return to_route('admin.permissions.index');
    }

    public function edit(Permission $permission)
    {
        $router = $this->getRoutesByGroup(['middleware' => 'permission']);

        $listRoute = [];

        foreach ($router as $item) {
            $action = $item->getAction();

            $listRoute[] = $action['as'];
        }

        $roles = Role::all();

        return view('admin.permissions.edit', compact('permission', 'roles', 'listRoute'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => '',
        ]);
        if($permission->name!=$request->name){
            $isExistPermission = Permission::where('name', $request->name)->exists();

            if ($isExistPermission) {
                notify()->error('Phân quyền đã tồn tại, vui lòng thực hiện chỉnh sửa nếu muốn thay đổi thông tin phân quyền', 'Lỗi');

                return back();
            }
        }
        $permission->update($validated);

        notify()->success('Sửa phân quyền thành công', 'Thông báo');

        return to_route('admin.permissions.index');
    }

    public function destroy(Permission $permission)
    {
        if ($permission->roles()->exists()) {

            notify()->error('Phân quyền đang được sử dụng. Vui lòng kiểm tra lại', 'Lỗi');

            return back();
        }
        $permission->delete();

        notify()->success('Xoá phân quyền thành công', 'Thông báo');

        return back();
    }

    public function assignRole(Request $request, Permission $permission)
    {
        if ($permission->hasRole($request->role)) {

            notify()->error('Quyền đã thuộc về vai trò này', 'Lỗi');

            return back();
        }

        $permission->assignRole($request->role);

        notify()->success('Thêm vai trò cho quyền thành công', 'Thông báo');

        return back();
    }

    public function removeRole(Permission $permission, Role $role)
    {
        if ($permission->hasRole($role)) {

            $permission->removeRole($role);

            notify()->success('Xoá vai trò khỏi quyền thành công', 'Thông báo');

            return back();
        }

        notify()->error('Vai trò này không tồn tại', 'Lỗi');

        return back();
    }

    function getRoutesByGroup(array $group = [])
    {
        $list = Route::getRoutes()->getRoutes();

        if (empty($group)) {
            return $list;
        }

        $routes = [];
        foreach ($list as $route) {
            $action = $route->getAction();
            foreach ($group as $key => $value) {
                if (empty($action[$key])) {
                    continue;
                }
                $actionValues = Arr::wrap($action[$key]);
                $values = Arr::wrap($value);
                foreach ($values as $single) {
                    foreach ($actionValues as $actionValue) {
                        if (Str::is($single, $actionValue)) {
                            $routes[] = $route;
                        } elseif($actionValue == $single) {
                            $routes[] = $route;
                        }
                    }
                }
            }
        }

        return $routes;
    }
}
