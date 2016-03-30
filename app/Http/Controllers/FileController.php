<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    public function download($fileName)
    {
        $path = "/upload";
        return $path;
        //return response()->download($path, $fileName);
    }
}
