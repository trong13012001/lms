<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Trang chủ
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Trang chủ', route('dashboard'));
});
//Tác giả
Breadcrumbs::for('admin.author.index', function (BreadcrumbTrail $trail) {
    $trail->push('Danh sách tác giả',route('admin.author.index'));
});
//Thêm tác giả
Breadcrumbs::for('admin.author.create',function (BreadcrumbTrail $trail) {
    $trail->parent('admin.author.index');
    $trail->push('Thêm tác giả',route('admin.author.create'));
});
//Chỉnh sửa tác giả
Breadcrumbs::for('admin.author.edit',function (BreadcrumbTrail $trail,$author) {
    $trail->parent('admin.author.index');
    $trail->push($author->name,route('admin.author.edit',$author));
});
//Nhà xuất bản
Breadcrumbs::for('admin.publisher.index', function (BreadcrumbTrail $trail) {
    $trail->push('Danh sách nhà xuất bản',route('admin.publisher.index'));
});
//Thêm nhà xuất bản
Breadcrumbs::for('admin.publisher.create',function (BreadcrumbTrail $trail) {
    $trail->parent('admin.publisher.index');
    $trail->push('Thêm nhà xuất bản',route('admin.publisher.create'));
});
//Chỉnh sửa nhà xuất bản
Breadcrumbs::for('admin.publisher.edit',function (BreadcrumbTrail $trail,$publisher) {
    $trail->parent('admin.publisher.index');
    $trail->push($publisher->name,route('admin.publisher.edit',$publisher));
});
//Thể loại
Breadcrumbs::for('admin.genre.index', function (BreadcrumbTrail $trail) {
    $trail->push('Danh sách thể loại',route('admin.genre.index'));
});
//Thêm thể loại
Breadcrumbs::for('admin.genre.create',function (BreadcrumbTrail $trail) {
    $trail->parent('admin.genre.index');
    $trail->push('Thêm thể loại',route('admin.genre.create'));
});
//Chỉnh sửa thể loại
Breadcrumbs::for('admin.genre.edit',function (BreadcrumbTrail $trail,$genre) {
    $trail->parent('admin.genre.index');
    $trail->push($genre->name,route('admin.genre.edit',$genre));
});
//Nhãn
Breadcrumbs::for('admin.tag.index', function (BreadcrumbTrail $trail) {
    $trail->push('Danh sách nhãn',route('admin.tag.index'));
});
//Danh sách sách
Breadcrumbs::for('admin.book.index', function (BreadcrumbTrail $trail) {
    $trail->push('Danh sách đầu sách',route('admin.book.index'));
});
//Thêm đầu sách
Breadcrumbs::for('admin.book.create',function (BreadcrumbTrail $trail) {
    $trail->parent('admin.book.index');
    $trail->push('Thêm đầu sách',route('admin.book.create'));
});
//Chỉnh sửa đầu sách
Breadcrumbs::for('admin.book.edit',function (BreadcrumbTrail $trail,$book) {
    $trail->parent('admin.book.index');
    $trail->push($book->name,route('admin.book.edit',$book));
});
//Danh sách sách
Breadcrumbs::for('admin.book.item.index',function (BreadcrumbTrail $trail,$book) {
    $trail->parent('admin.book.index');
    $trail->push('Danh sách sách',route('admin.book.item.index',$book));

});
//Danh sách sách -> Thêm sách
Breadcrumbs::for('admin.book.item.create',function (BreadcrumbTrail $trail,$book) {
    $trail->parent('admin.book.item.index',$book);
    $trail->push('Thêm sách',route('admin.book.item.create',$book));

});
//Danh sách sách -> Chỉnh sửa sách
Breadcrumbs::for('admin.book.item.edit', function (BreadcrumbTrail $trail, $book, $bookItem) {
    $trail->parent('admin.book.item.index', $book);
    $trail->push('Chỉnh sửa sách', route('admin.book.item.edit', ['book' => $book, 'item' => $bookItem]));
});
//Danh sách khách hàng
Breadcrumbs::for('admin.customer.index', function (BreadcrumbTrail $trail) {
    $trail->push('Danh sách khách hàng',route('admin.customer.index'));
});
//Thêm khách hàng
Breadcrumbs::for('admin.customer.create',function (BreadcrumbTrail $trail) {
    $trail->parent('admin.customer.index');
    $trail->push('Thêm khách hàng',route('admin.customer.create'));
});
//Chỉnh sửa khách hàng
Breadcrumbs::for('admin.customer.edit',function (BreadcrumbTrail $trail,$customer) {
    $trail->parent('admin.customer.index');
    $trail->push($customer->name,route('admin.customer.edit',$customer));
});
//Xem khách hàng
Breadcrumbs::for('admin.customer.show',function (BreadcrumbTrail $trail,$customer) {
    $trail->parent('admin.customer.index');
    $trail->push($customer->name,route('admin.customer.show',$customer));
});
//Danh sách mượn sách
Breadcrumbs::for('admin.issued_book.index', function (BreadcrumbTrail $trail) {
    $trail->push('Danh sách mượn sách',route('admin.issued_book.index'));
});
//Thêm mượn sách
Breadcrumbs::for('admin.issued_book-book.create',function (BreadcrumbTrail $trail) {
    $trail->parent('admin.issued_book.index');
    $trail->push('Thêm mượn sách',route('admin.issued_book.create'));
});
//Chỉnh sửa mượn sách
Breadcrumbs::for('admin.issued_book.edit',function (BreadcrumbTrail $trail,$issuedBook) {
    $trail->parent('admin.issued_book.index');
    $trail->push($issuedBook->book->name,route('admin.issued_book.edit',$issuedBook));
});

// Quản lý vai trò
Breadcrumbs::for('admin.roles.index', function (BreadcrumbTrail $trail) {
    $trail->push('Danh sách vai trò', route('admin.roles.index'));
});

// Quản lý vai trò > Thông tin vai trò
Breadcrumbs::for('admin.roles.show', function (BreadcrumbTrail $trail, $roles) {
    $trail->parent('admin.roles.index');
    $trail->push($roles->name, route('admin.roles.show', $roles));
});

// Quản lý phân quyền
Breadcrumbs::for('admin.permissions.index', function (BreadcrumbTrail $trail) {
    $trail->push('Danh sách phân quyền', route('admin.permissions.index'));
});

// Quản lý phân quyền > Thông tin phân quyền
Breadcrumbs::for('admin.permissions.show', function (BreadcrumbTrail $trail, $permissions) {
    $trail->parent('admin.permissions.index');
    $trail->push($permissions->name, route('admin.permissions.show', $permissions));
});

// Quản lý thành viên
Breadcrumbs::for('admin.users.index', function (BreadcrumbTrail $trail) {
    $trail->push('Danh sách thành viên', route('admin.users.index'));
});
// Quản lý thành viên > Thêm thành viên
Breadcrumbs::for('admin.users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.users.index');
    $trail->push('Thêm thành viên', route('admin.users.create'));
});

// Quản lý thành viên > Thông tin thành viên
Breadcrumbs::for('admin.users.show', function (BreadcrumbTrail $trail, $users) {
    $trail->parent('admin.users.index');
    $trail->push($users->name, route('admin.users.show', $users));
});

//Thông tin tài khoản
Breadcrumbs::for('edit-profile', function (BreadcrumbTrail $trail) {
    $trail->push('Thông tin tài khoản', route('edit-profile'));
});

////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
