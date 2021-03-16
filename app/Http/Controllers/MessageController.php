<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request){

       $message = new Message;
       $message->name = $request->name;
       $message->message = $request->message;
       $message->save();

       $data = Message::all();

       return response()->json($data, 200);
    }
}
