<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookItem;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Customer;

class BookItemController extends Controller
{
    public function index($id, Request $request)
    {
        $book = Book::findOrFail($id);
        $publishers = Publisher::all();
        $customers = Customer::all();
        $items = $book->items()->filter($request->all())->paginate(10);
        return view('admin.book_item.index',  compact('book', 'items','publishers','customers'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'publisher_id' =>'required',
            'book_code' => 'required|unique:book_items,book_code',
            'location' => 'required',
            'published_at' => 'required',
        ], [
            'publisher_id.required' => 'Nhà xuất bản không được bỏ trống',
            'book_code.required' => 'Mã sách không được bỏ trống',
            'book_code.unique' => 'Mã sách đã tồn tại',
            'location.required' => 'Vị trí không được bỏ trống',
            'published_at.required' => 'Ngày xuất bản không được bỏ trống',
        ])
        ;
        BookItem::create($request->all());
        notify()->success('Thêm sách thành công', 'Thông báo');
        return to_route('admin.book.item.index', $request->book_id);
    }
    public function create($id)
    {
        $book = Book::findOrFail($id);
        $publishers = Publisher::all();
        return view('admin.book_item.create', compact('book', 'publishers'));
    }
    public function edit($bookId, $itemId)
    {
        $bookItem = BookItem::where('book_id', $bookId)->findOrFail($itemId);
        // dd($bookItem);
        $publishers = Publisher::all();
        return view('admin.book_item.edit', compact('bookItem', 'publishers'));
    }
    public function update(Request $request, $bookId, $itemId)
    {
        $bookItem = BookItem::findOrFail($itemId);
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
        return to_route('admin.book.item.index', $bookId);
    }
    public function destroy($bookId, $itemId)
    {
        $bookItem = BookItem::findOrFail($itemId);
        $bookItem->delete();
        notify()->success('Xóa sách thành công', 'Thông báo');
        return redirect()->back();
    }

}
