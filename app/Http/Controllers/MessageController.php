<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

   public function index()
   {
      $data = Message::orderBy('id', 'DESC')->limit(5)->get();

      return response()->json($data, 200);
   }


   public function store(Request $request)
   {
      $user = Auth::user();

      $message = new Message;
      $message->user_id = $user->id;
      $message->message = $request->message;
      $message->save();

      broadcast(new MessageSent($user, $message))->toOthers();
   }
}
