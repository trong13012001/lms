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

        $request->validate([
            'name' => 'required|unique:books,name',
            'authors' => 'required|array',
            'authors.*' => 'exists:authors,id',
            'published_on' => 'required',
            'genres' =>'array',
            'genres.*' => 'exists:genres,id',
            'tags' =>'array',
            'tags.*' => 'exists:tags,id',
        ], [
            'name.required' => 'Sách không được bỏ trống',
            'name.unique' => 'Sách đã tồn tại',
            'authors.required' => 'Tác giả không được bỏ trống',
            'authors.*.exists' => 'Tác giả không tồn tại',
            'authors.array' => 'Tác giả không hợp lệ',
            'published_on.required' => 'Ngày phát hành không được bỏ trống',
            'genres.array' => 'Thể loại không hợp lệ',
            'genres.*.exists' => 'Thể loại không không tồn tại',
            'tags.array' => 'Thẻ không hợp lệ',
            'tags.*.exists' => 'Thẻ không không tồn tại',
        ]);
        $book = Book::create($request->all());
        $authors_id = $request->authors;
        $authors = Author::find($authors_id);
        $book->authors()->attach($authors);
        $genres_id = $request->genres;
        $genres = Genre::find($genres_id);
        $book->genres()->attach($genres);
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
                'name' => 'required|unique:books,name,'.$id,
                'published_on' =>'required',
                'authors' => 'required|array',
                'authors.*' => 'exists:authors,id',
                'genres' =>'array',
                'genres.*' => 'exists:genres,id',
                'tags' =>'array',
                'tags.*' => 'exists:tags,id',
            ],
            [
                'name.required'=>'Sách không được bỏ trống',
                'name.unique' => 'Sách đã tồn tại',
                'published_on.required' => 'Ngày phát hành không được bỏ trống',
                'authors.required' => 'Tác giả không được bỏ trống',
                'authors.array' => 'Tác giả không hợp lệ',
                'authors.*.exists' => 'Tác giả không không tồn tại',
                'genres.array' => 'Thể loại không hợp lệ',
                'genres.*.exists' => 'Thể loại không không tồn tại',
                'tags.array' => 'Thẻ không hợp lệ',
                'tags.*.exists' => 'Thẻ không không tồn tại',
            ]
            );
        $book=Book::find($id);
        $book->update([
           'name'=>$request->name,
           'description'=>$request->description,
           'image'=>$request->image
        ]);
        // Handle authors
        $authors_id = $request->authors;
        $authors = Author::find($authors_id);
        $book->authors()->sync($authors);
        // Handle genres
        $genres_id = $request->genres;
        $genres = Genre::find($genres_id);
        $book->genres()->sync($genres);
        // Handle tags
        $tags_id = $request->tags;
        $tags = Tag::find($tags_id);
        $book->tags()->sync($tags);
        notify()->success('Cập nhật sách thành công','Thông báo');
        return to_route('admin.book.index');
        }
        public function destroy($id)
        {
            if(Book::find($id)->items()->count()>0){
                // dd(Book::find($id)->items()->count()>0);
                notify()->error('Đầu sách đang có sách không thể xóa','Thông báo');
                return to_route('admin.book.index');

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
            return view('admin.book.show', compact('book', 'items','publishers','customers'));
        }



}
