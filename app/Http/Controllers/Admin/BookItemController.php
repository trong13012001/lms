<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookItem;
use App\Models\Book;
use App\Models\Publisher;
class BookItemController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'book_code' => 'required|unique:book_items,book_code',
            'location' => 'required',
            'published_at' => 'required',
        ], [
            'book_code.required' => 'Mã sách không được bỏ trống',
            'book_code.unique' => 'Mã sách đã tồn tại',
            'location.required' => 'Vị trí không được bỏ trống',
            'published_at.required' => 'Ngày xuất bản không được bỏ trống',
        ])
        ;
        // dd($request->all());
        $bookItem = BookItem::create($request->all());
        notify()->success('Thêm sách thành công', 'Thông báo');
        return redirect("/book/{$request->book_id}");
    }
    public function update(Request $request, $id)
    {
        $bookItem = BookItem::findOrFail($id);
        $request->validate([
            'book_code' => 'required|unique:book_items,book_code,' . $bookItem->id,
            'location' => 'required',
            'published_at' => 'required',
        ], [
            'book_code.required' => 'Mã sách không được bỏ trống',
            'book_code.unique' => 'Mã sách đã tồn tại',

            'location.required' => 'Vị trí không được bỏ trống',
            'published_at.required' => 'Ngày xuất bản không được bỏ trống',
        ]);
        $bookItem->update($request->all());
        notify()->success('Cập nhật sách thành công', 'Thông báo');
        return redirect("/book/{$request->book_id}");
    }
    public function destroy($id)
    {
        $bookItem = BookItem::findOrFail($id);
        $bookItem->delete();
        notify()->success('Xóa sách thành công', 'Thông báo');
        return redirect()->back();
    }

}
