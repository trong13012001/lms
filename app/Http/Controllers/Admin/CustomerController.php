<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
class CustomerController extends Controller
{
    public function index()
    {
        $customers=Customer::filter()->paginate(10);
        return view('admin.customer.index',compact('customers'));
    }
    public function create()
    {
        return view('admin.customer.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' =>'required|unique:customers,customer_id',
            'name' =>'required',
            'email' =>'required|unique:customers,email',
            'phone' =>'required|unique:customers,phone',
            'address' =>'required',
        ],
        [
            'customer_id.required' => 'Mã khách hàng không được bỏ trống',
            'customer_id.unique' => 'Mã khách hàng đã tồn tại',
            'name.required' => 'Tên khách hàng không được bỏ trống',
            'email.required' => 'Email không được bỏ trống',
            'email.unique' => 'Email đã tồn tại',
            'phone.required' => 'Số điện thoại không được bỏ trống',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'address.required' => 'Địa chỉ không được bỏ trống',
        ])
        ;
        Customer::create($request->all());
        notify()->success('Thêm khách hàng thành công','Thông báo');
        return to_route('admin.customer.index');
    }
    public function edit($id)
    {
        $customer=Customer::findOrFail($id);
        return view('admin.customer.edit',compact('customer'));
    }
    public function update(Request $request,$id)
    {
        $request->validate([
            'customer_id' =>'required|unique:customers,customer_id,'.$id,
            'name' =>'required',
            'email' =>'required|unique:customers,email,'.$id,
            'phone' =>'required|unique:customers,phone,'.$id,
            'address' =>'required',
        ],
        [
            'customer_id.required' => 'Mã khách hàng không được bỏ trống',
            'customer_id.unique' => 'Mã khách hàng đã tồn tại',
            'name.required' => 'Tên khách hàng không được bỏ trống',
            'email.required' => 'Email không được bỏ trống',
            'email.unique' => 'Email đã tồn tại',
            'phone.required' => 'Số điện thoại không được bỏ trống',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'address.required' => 'Địa chỉ không được bỏ trống',
        ]);
        $customer=Customer::find($id);
        $customer->update($request->all());
        notify()->success('Cập nhật khách hàng thành công','Thông báo');
        return to_route('admin.customer.index');
    }
    public function destroy($id)
    {
        $customer = Customer::with('issuedBooks')->findOrFail($id);

        $allBooksStatusTwo = $customer->issuedBooks->every(function($book) {
            return $book->status == 0;
        });

        if ($allBooksStatusTwo) {
            $customer->issuedBooks()->where('status', 0)->delete();
        } else {
            notify()->error('Khách hàng có sách đang mượn, không thể xóa', 'Thông báo');
            return to_route('admin.customer.index');
        }

        $customer->delete();
        notify()->success('Xóa khách hàng thành công', 'Thông báo');
        return to_route('admin.customer.index');
    }
    public function show($id, Request $request)
    {
        $customer=Customer::with('issuedBooks')->findOrFail($id);
        $items = $customer->issuedBooks()->filter($request->all())->paginate(10);
        // dd($items);
        return view('admin.customer.show',compact('customer','items'));
    }

}
