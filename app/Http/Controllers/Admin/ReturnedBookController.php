<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IssuedBook;
use App\Models\BookItem;
use App\Models\Customer;
class ReturnedBookController extends Controller
{
    public function index()
    {
        $issuedBooks=IssuedBook::with('bookItem','customer')->filter()->where('status',0)->paginate(10);
        $customers = Customer::all();
        return view('admin.returned_book.index',compact('issuedBooks','customers'));
    }
}
