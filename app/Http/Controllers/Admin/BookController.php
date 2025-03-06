<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Tag;
use App\Models\Publisher;
use App\Models\Customer;

class BookController extends Controller
{
    public function index()
    {
        $books=Book::filter()->paginate(10);
        return view('admin.book.index',compact('books'));
    }
    public function create()
    {
        $authors=Author::all();
        $genres=Genre::all();
        $tags=Tag::all();
        return view('admin.book.create',compact('authors','genres','tags'));
    }
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required|unique:books,name',
            'isbn' => 'required|unique:books,isbn',
            'published_on' => 'required',

        ], [
            'name.required' => 'Sách không được bỏ trống',
            'name.unique' => 'Sách đã tồn tại',
            'isbn.required' => 'ISBN không được bỏ trống',
            'isbn.unique' => 'ISBN đã tồn tại',
            'published_on.required' => 'Ngày phát hành không được bỏ trống',
        ]);
        $book = Book::create($request->all());

        // Handle authors
        $authors_id = $request->authors;
        $authors = Author::find($authors_id);
        $book->authors()->attach($authors);

        // Handle genres
        $genres_id = $request->genres;
        $genres = Genre::find($genres_id);
        $book->genres()->attach($genres);

        // Handle tags
        $tags_id = $request->tags;
        $tags = Tag::find($tags_id);
        $book->tags()->attach($tags);

        notify()->success('Thêm sách thành công', 'Thông báo');
        return to_route('admin.book.index');
    }

    public function edit($id)
    {
        $book = Book::with(['authors', 'tags', 'genres'])->findOrFail($id);

        $authors = Author::all();
        $tags = Tag::all();
        $genres = Genre::all();

        return view('admin.book.edit', compact('book', 'authors', 'tags', 'genres'));
    }

    public function update(Request $request,$id)
    {
        $request->validate(
            [
                'name' => 'required|unique:books,name',
            ],
            [
                'name.required'=>'Sách không được bỏ trống',
                'name.unique' => 'Sách đã tồn tại'

            ]
            );
        $book=Book::find($id);
        $book->update([
           'name'=>$request->name,
           'description'=>$request->description,
           'image'=>$request->image
        ]);
        notify()->success('Cập nhật sách thành công','Thông báo');
        return to_route('admin.book.index');
        }
        public function destroy($id)
        {
            if(Book::find($id)->books()->count()>0){
                notify()->error('Tác giả đang có sách không thể xóa','Thông báo');
            }
            Book::find($id)->delete();

            notify()->success('Xóa sách thành công','Thông báo');
            return to_route('admin.book.index');
        }
        public function show($id, Request $request)
        {
            $book = Book::findOrFail($id);
            $publishers = Publisher::all();
            $customers = Customer::all();
            $items = $book->items()->filter($request->all())->paginate(10);
            // dd($customers);
            // dd($items);
            return view('admin.book.show', compact('book', 'items','publishers','customers'));
        }



}
