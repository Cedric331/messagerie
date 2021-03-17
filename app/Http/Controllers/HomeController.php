<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $messages = Message::orderBy('id', 'DESC')->limit(5)->get();

        return view('welcome',[
           'messages' => json_encode($messages)
        ]);
    }
}
