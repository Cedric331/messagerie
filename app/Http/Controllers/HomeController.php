<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      if (Auth::check()) {
         return view('welcome',[
            'channels' => Auth::user()->channel
         ]);
      }
      return view('welcome');
    }

    public function user()
    {
       if (Auth::check()) {
          return response()->json(Auth::user(), 200);
       } else {
         return response()->json(null, 200);
       }
    }
}
