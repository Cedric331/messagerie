<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function upload(Request $request)
    {
      $path = 'storage/image/images/'.$request->channel.'/'.$request->image;
     return response()->download($path);
   }
}
