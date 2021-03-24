<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Channel;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Notifications\NewMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class MessageController extends Controller
{

   public function __construct()
   {
      $this->middleware('auth');
   }

   public function index($name)
   {
      $channel = Channel::where('name', $name)->with(['user','messages'])->first();

      if (!Gate::check('channel-member', $channel)) {
         return redirect()->route('home');
     }

     foreach (Auth::user()->unreadNotifications as $notification) {
      if ($notification->data['channel_id'] == $channel->id) {
         $notification->delete();
      }
      }

      return view('chat',[
         'channel' => json_encode($channel)
      ]);
   }

   public function messages(Request $request)
   {
      $channel = Channel::find($request->channel);

      if (!Gate::check('channel-member', $channel)) {
         return redirect()->route('home');
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
         return redirect()->route('home');
      }


      $this->validate($request, 
         ['message' => 'required|string|max:255'],
         [
            'message.max' => 'Le message est trop long, maximum 255 caractères',
            'message.required' => 'Le message est requis']
     );
      

      $message = new Message;
      $message->user_id = Auth::user()->id;
      $message->channel_id = $channel->id;
      $message->message = $request->message;
      $message->save();

      broadcast(new MessageSent($channel))->toOthers();

      $members = collect([]);
      foreach ($request->members as $value)
      {
          $members->push($value['id']);
      }

      $collection = collect([]);
      foreach ($channel->user as $value)
      {
          $collection->push($value->id);
      }

      $diff = $collection->diff($members);
      $users = User::find($diff->all());

      Notification::send($users, new NewMessage($channel));

      $data = Message::where('channel_id',$request->channel )
      ->orderBy('id', 'DESC')
      ->limit($request->count)
      ->get();
      
      return response()->json($data, 200);
   }
}
