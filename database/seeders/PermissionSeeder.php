<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['admin.author.index','Danh sách tác giả'],
            ['admin.author.create','Biểu mẫu thêm tác giả'],
            ['admin.author.store','Thêm tác giả'],
            ['admin.author.edit','Sửa tác giả'],
            ['admin.author.update','Cập nhật tác giả'],
            ['admin.author.destroy','Xóa tác giả'],
            ['admin.book.index','Danh sách đầu sách'],
            ['admin.book.create','Biểu mẫu thêm đầu sách'],
            ['admin.book.store','Thêm đầu sách'],
            ['admin.book.edit','Sửa đầu sách'],
            ['admin.book.update','Cập nhật đầu sách'],
            ['admin.book.destroy','Xóa đầu sách'],
            ['admin.book.item.index','Danh sách sách'],
            ['admin.book.item.create','Biểu mẫu thêm sách'],
            ['admin.book.item.store','Thêm sách'],
            ['admin.book.item.edit','Sửa sách'],
            ['admin.book.item.update','Cập nhật sách'],
            ['admin.book.item.destroy','Xóa sách'],
            ['admin.customer.index','Danh sách khách hàng'],
            ['admin.customer.create','Biểu mẫu thêm khách hàng'],
            ['admin.customer.store','Thêm khách hàng'],
            ['admin.customer.edit','Sửa khách hàng'],
            ['admin.customer.update','Cập nhật khách hàng'],
            ['admin.customer.destroy','Xóa khách hàng'],
            ['admin.genre.index','Danh sách thể loại'],
            ['admin.genre.create','Biểu mẫu thêm thể loại'],
            ['admin.genre.store','Thêm thể loại'],
            ['admin.genre.edit','Sửa thể loại'],
            ['admin.genre.update','Cập nhật thể loại'],
            ['admin.genre.destroy','Xóa thể loại'],
            ['admin.issued_book.index','Danh sách sách'],
            ['admin.issued_book.create','Biểu mẫu thêm sách'],
            ['admin.issued_book.store','Thêm sách'],
            ['admin.issued_book.edit','Sửa sách'],
            ['admin.issued_book.update','Cập nhật sách'],
            ['admin.issued_book.destroy','Xóa sách'],
            ['admin.publisher.index','Danh sách nhà xuất bản'],
            ['admin.publisher.create','Biểu mẫu thêm nhà xuất bản'],
            ['admin.publisher.store','Thêm nhà xuất bản'],
            ['admin.publisher.edit','Sửa nhà xuất bản'],
            ['admin.publisher.update','Cập nhật nhà xuất bản'],
            ['admin.publisher.destroy','Xóa nhà xuất bản'],
            ['admin.tag.index','Danh sách tag'],
            ['admin.tag.create','Biểu mẫu thêm tag'],
            ['admin.tag.store','Thêm tag'],
            ['admin.tag.edit','Sửa tag'],
            ['admin.tag.update','Cập nhật tag'],
            ['admin.tag.destroy','Xóa tag'],
            ['admin.user.index','Danh sách người dùng'],
            ['admin.user.create','Biểu mẫu thêm người dùng'],
            ['admin.user.store','Thêm người dùng'],
            ['admin.user.edit','Sửa người dùng'],
            ['admin.user.update','Cập nhật người dùng'],
            ['admin.user.destroy','Xóa người dùng'],
        ];
        foreach($permissions as $permission){
            Permission::create([
                'name'=>$permission[0],
                'description'=>$permission[1],
            ]);
        }

    }
}
