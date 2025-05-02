<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publisher;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers=Publisher::filter()->paginate(10);
        return view('admin.publisher.index',compact('publishers'));
    }
    public function create()
    {
        return view('admin.publisher.create');
    }
    public function store(Request $request)
    {

            $validated = $request->validate(
                [
                    'name' => 'required|unique:publishers,name',
                ],
                [
                    'name.required' => 'Nhà xuất bản không được bỏ trống',
                    'name.unique' => 'Nhà xuất bản đã tồn tại'
                ]
            );

            Publisher::create([
                'name' => $validated['name'],
                'description' => $request->description,
                'image'=>$request->image
            ]);

            notify()->success('Thêm nhà xuất bản thành công', 'Thông báo');
            return to_route('admin.publisher.index');
    }
    public function edit($id)
    {
        $publisher=Publisher::find($id);
        return view('admin.publisher.edit',compact('publisher'));
    }
    public function update(Request $request,$id)
    {
        $request->validate(
            [
                'name' => 'required|unique:publishers,name',
            ],
            [
                'name.required' => 'Nhà xuất bản không được bỏ trống',
                'name.unique' => 'Nhà xuất bản đã tồn tại'            ]
            );
        $publisher=Publisher::find($id);
        $publisher->update([
           'name'=>$request->name,
           'description'=>$request->description,
           'image'=>$request->image
        ]);
        notify()->success('Cập nhật nhà xuất bản thành công','Thông báo');
        return to_route('admin.publisher.index');
        }
        public function destroy($id)
        {
            if(Publisher::find($id)->books()->count()>0){
                notify()->error('Nhà xuất bản đang có sách không thể xóa','Thông báo');
                return to_route('admin.publisher.index');
            }
            Publisher::find($id)->delete();
            notify()->success('Xóa nhà xuất bản thành công','Thông báo');
            return to_route('admin.publisher.index');
        }

}
