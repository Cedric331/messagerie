<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

   public function index($name)
   {
      $channel = Channel::where('name', $name)->with(['user','messages'])->first();

      if (!Gate::check('channel-member', $channel)) {
         abort(403);
     }

      return view('chat',[
         'channel' => json_encode($channel)
      ]);
   }

   public function messages(Request $request)
   {
      $channel = Channel::find($request->channel);

      if (!Gate::check('channel-member', $channel)) {
         abort(403);
     }
     
      $data = Message::where('channel_id',$request->channel )
                     ->orderBy('id', 'DESC')
                     ->limit($request->count)
                     ->get();

      return response()->json($data, 200);
   }


   public function store(Request $request)
   {
      $channel = Channel::find($request->channel);

      if (!Gate::check('channel-member', $channel)) {
         abort(403);
     }

      $message = new Message;
      $message->user_id = Auth::user()->id;
      $message->channel_id = $channel->id;
      $message->message = $request->message;
      $message->save();

      broadcast(new MessageSent(Auth::user(), $message))->toOthers();
      
      $data = Message::where('channel_id',$request->channel )
      ->orderBy('id', 'DESC')
      ->limit($request->count)
      ->get();
      
      return response()->json($data, 200);
   }
}
