<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IssuedBook;
use App\Models\BookItem;
use App\Models\Customer;
class IssuedBookController extends Controller
{
    public function index()
    {
        $issuedBooks=IssuedBook::with('bookItem','customer')->filter()->where('status',1)->paginate(10);
        $customers = Customer::all();
        return view('admin.issued_book.index',compact('issuedBooks','customers'));
    }
    public function create()
    {
        return view('admin.issued_book.create');
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'return_date' => 'required|date|after:today',
            ], [
                'return_date.required' => 'Ngày trả không được bỏ trống',
                'return_date.after' => 'Ngày trả phải sau ngày hiện tại',
            ]);

            $bookItem = BookItem::findOrFail($request->book_item_id);

            if ($bookItem->status != 1) {
                throw new \Exception('Sách này không có sẵn để mượn.');
            }

            $issuedBook = IssuedBook::create([
                'user_id' => auth()->user()->id,
                'issued_date' => now(),
                'return_date' => $request->return_date,
                'customer_id' => $request->customer_id,
                'book_item_id' => $request->book_item_id,
            ]);

            // Update book item status to 0 (issued)
            $bookItem->update(['status' => 0]);

            $customer = $issuedBook->customer;
            $book = $issuedBook->bookItem->book;

            notify()->success("Khách hàng ".$customer->name . ' mượn sách ' . $book->name . ' thành công', 'Thông báo');
            return redirect()->back();
        } catch (\Exception $e) {
            notify()->error($e->getMessage(), 'Thông báo');
            return redirect()->back()->withInput();
        }
    }


    public function edit($id)
    {
        $issuedBook=IssuedBook::findOrFail($id);
        return view('admin.issued_book.edit',compact('issuedBook'));
    }
    public function update(Request $request, $id)
    {
        try{
                    $request->validate([
            'issued_date' =>'required',
            'return_date' => 'required|date|after:today',
        ],
        [
            'issued_date.required' => 'Ngày mượn không được bỏ trống',
            'return_date.required' => 'Ngày phải trả không được bỏ trống',
            'return_date.after' => 'Ngày trả phải sau ngày hiện tại',

        ]);
        $issuedBook=IssuedBook::find($id);
        // dd($issuedBook);
        $issuedBook->update($request->all());
        notify()->success('Cập nhật dữ liệu mượn sách thành công','Thông báo');
        return to_route('admin.issued_book.index');
        }
        catch(\Exception $e){
            notify()->error($e->getMessage(), 'Thông báo');
            return redirect()->back()->withInput();
        }
    }
    public function destroy($id)
    {
        $issuedBook = IssuedBook::findOrFail($id);
        $bookItem = $issuedBook->bookItem;

        $issuedBook->delete();

        // Update book item status to 1 (available)
        $bookItem->update(['status' => 1]);

        notify()->success('Xóa dữ liệu mượn sách thành công', 'Thông báo');
        return to_route('admin.issued_book.index');
    }
    public function returned_book($id)
    {
        $issuedBook=IssuedBook::find($id);
        $bookItem = $issuedBook->bookItem;

        $bookItem->update([
           'status'=>1,
        ]);
        $issuedBook->update([
            'returned_date'=>now(),
           'status'=>0,
        ]);
        notify()->success('Trả sách thành công','Thông báo');
        return back();
    }
}
