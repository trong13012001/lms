<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

Route::get('cdn/{path}', [ImageController::class, 'show'])->where('path', '.*');

require __DIR__ . '/admin.php';
