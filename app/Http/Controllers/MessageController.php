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

      $request->validate([
         'message' => 'required_without:file|max:255',
         'file' => 'required_without:message|mimes:jpg,jpeg,png,pdf|max:2048'
      ]);

      $file_name = time().$request->file->getClientOriginalName();
     $request->file('file')->storeAs(
      '/image/images/'.$channel->id, $file_name,'public'
      );
     
      $message = new Message;
      $message->user_id = Auth::user()->id;
      $message->image = $file_name;
      $message->channel_id = $channel->id;
      $message->message = $request->message;
      $message->save();

      broadcast(new MessageSent($channel))->toOthers();

      $data = Message::where('channel_id',$request->channel )
      ->orderBy('id', 'DESC')
      ->limit($request->count)
      ->get();
      
      return response()->json($data, 200);
   }

   public function notification(Request $request)
   {
      $channel = Channel::find($request->channel);

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

      return response()->json(null, 200);
   }
}
