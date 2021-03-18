<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

   public function index($name)
   {
      $channel = Channel::where('name', $name)->first();

      return view('chat',[
         'channel' => json_encode($channel)
      ]);
   }

   public function messages(Request $request)
   {
      $data = Message::where('channel_id',$request->channel )
                     ->orderBy('id', 'DESC')
                     ->limit($request->count)
                     ->get();

      return response()->json($data, 200);
   }


   public function store(Request $request)
   {
      $user = Auth::user();

      $message = new Message;
      $message->user_id = $user->id;
      $message->channel_id = $request->channel;
      $message->message = $request->message;
      $message->save();

      broadcast(new MessageSent($user, $message))->toOthers();
      
      $data = Message::where('channel_id',$request->channel )
      ->orderBy('id', 'DESC')
      ->limit($request->count)
      ->get();
      
      return response()->json($data, 200);
   }
}
