<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authors=Author::filter()->paginate(10);
        return view('admin.author.index',compact('authors'));
    }
    public function create()
    {
        return view('admin.author.create');
    }
    public function store(Request $request)
    {
            $validated = $request->validate(
                [
                    'name' => 'required|unique:authors,name',
                ],
                [
                    'name.required' => 'Tác giả không được bỏ trống',
                    'name.unique' => 'Tác giả đã tồn tại'
                ]
            );

            Author::create([
                'name' => $validated['name'],
                'description' => $request->description,
                'image'=>$request->image
            ]);

            notify()->success('Thêm tác giả thành công', 'Thông báo');
            return to_route('admin.author.index');

    }
    public function edit($id)
    {
        $author=Author::find($id);
        return view('admin.author.edit',compact('author'));
    }
    public function update(Request $request,$id)
    {
        $request->validate(
            [
                'name'=>'required',
            ],
            [
                'name.required'=>'Tác giả không được bỏ trống'
            ]
            );
        $author=Author::find($id);
        $author->update([
           'name'=>$request->name,
           'description'=>$request->description,
           'image'=>$request->image
        ]);
        notify()->success('Cập nhật tác giả thành công','Thông báo');
        return to_route('admin.author.index');
        }
        public function destroy($id)
        {
            if(Author::find($id)->books()->count()>0){
                notify()->error('Tác giả đang có sách không thể xóa','Thông báo');
                return to_route('admin.author.index');
            }
            Author::find($id)->delete();
            notify()->success('Xóa tác giả thành công','Thông báo');
            return to_route('admin.author.index');
        }

}
