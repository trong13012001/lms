<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    public function index()
    {
        $genres=Genre::filter()->paginate(10);
        return view('admin.genre.index',compact('genres'));
    }
    public function create()
    {
        return view('admin.genre.create');
    }
    public function store(Request $request)
    {

            $validated = $request->validate(
                [
                    'name' => 'required|unique:genres,name',
                ],
                [
                    'name.required' => 'Thể loại không được bỏ trống',
                    'name.unique' => 'Thể loại đã tồn tại'
                ]
            );

            Genre::create([
                'name' => $validated['name'],
                'description' => $request->description,
                'image'=>$request->image
            ]);

            notify()->success('Thêm thể loại thành công', 'Thông báo');
            return to_route('admin.genre.index');
    }
    public function edit($id)
    {
        $genre=Genre::find($id);
        return view('admin.genre.edit',compact('genre'));
    }
    public function update(Request $request,$id)
    {
        $request->validate(
            [
                'name' => 'required|unique:genres,name',
            ],
            [
                'name.required' => 'Thể loại không được bỏ trống',
                'name.unique' => 'Thể loại đã tồn tại'

            ]
            );
        $genre=Genre::find($id);
        $genre->update([
           'name'=>$request->name,
           'description'=>$request->description,
           'image'=>$request->image
        ]);
        notify()->success('Cập nhật thể loại thành công','Thông báo');
        return to_route('admin.genre.index');
        }
        public function destroy($id)
        {
            if(Genre::find($id)->books()->count()>0){
                notify()->error('Tác giả đang có sách không thể xóa','Thông báo');
                return to_route('admin.genre.index');
            }
            Genre::find($id)->delete();
            notify()->success('Xóa thể loại thành công','Thông báo');
            return to_route('admin.genre.index');
        }

}
