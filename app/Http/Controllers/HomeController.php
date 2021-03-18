<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Message;
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
}
