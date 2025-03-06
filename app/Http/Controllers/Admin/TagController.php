<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags=Tag::filter()->paginate(10);
        return view('admin.tag.index',compact('tags'));
    }
    // public function create()
    // {
    //     return view('admin.tag.create');
    // }
    public function store(Request $request)
    {

            $validated = $request->validate(
                [
                    'name' => 'required|unique:tags,name',
                ],
                [
                    'name.required' => 'Nhãn không được bỏ trống',
                    'name.unique' => 'Nhãn đã tồn tại'
                ]
            );

            Tag::create([
                'name' => $validated['name'],
                'description' => $request->description,
                'image'=>$request->image
            ]);

            notify()->success('Thêm nhãn thành công', 'Thông báo');
            return to_route('admin.tag.index');

    }
    // public function edit($id)
    // {
    //     $tag=Tag::find($id);
    //     return view('admin.tag.edit',compact('tag'));
    // }
    public function update(Request $request,$id)
    {
        $request->validate(
            [
                'name' => 'required|unique:tags,name',
            ],
            [
                'name.required' => 'Nhãn không được bỏ trống',
                'name.unique' => 'Nhãn đã tồn tại'            ]
            );
        $tag=Tag::find($id);
        $tag->update([
           'name'=>$request->name,
           'description'=>$request->description,
           'image'=>$request->image
        ]);
        notify()->success('Cập nhật nhãn thành công','Thông báo');
        return to_route('admin.tag.index');
        }
        public function destroy($id)
        {
            if(Tag::find($id)->books()->count()>0){
                notify()->error('Tác giả đang có sách không thể xóa','Thông báo');
                return to_route('admin.tag.index');
            }
            Tag::find($id)->delete();
            notify()->success('Xóa nhãn thành công','Thông báo');
            return to_route('admin.tag.index');
        }

}
