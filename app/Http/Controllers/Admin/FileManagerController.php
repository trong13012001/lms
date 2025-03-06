<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use UniSharp\LaravelFilemanager\Controllers\LfmController;
use Illuminate\Support\Facades\Config;

class FileManagerController extends LfmController
{
    public function index()
    {
        $categories = Config::get('lfm.folder_categories');

        return view('admin.category-dash.file-manager.show', compact('categories'));
    }
}
