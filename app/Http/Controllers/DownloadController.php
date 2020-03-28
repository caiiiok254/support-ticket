<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DownloadController extends Controller
{
    public function download($file_name) {
        $file_path = File::glob(public_path('uploads') . "\\" . "$file_name". ".*");
        return response()->file($file_path[0]);
    }
}
