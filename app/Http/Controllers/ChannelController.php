<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Channel;
use App\Models\ChannelUser;
use Illuminate\Http\Request;
use App\Events\RemoveUserChat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ChannelController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth');
   }

   public function create()
   {
      return view('create-chat');
   }

   public function member(Request $request)
   {
      $members = User::where('name', 'like', $request->search.'%')
      ->limit(5)
      ->get();

      return response()->json($members, 200);
   }

   public function addMember(Request $request)
   {
      $channel = Channel::find($request->channel);
      
      if (!Gate::check('admin-channel', $channel)) {
         return response()->json('Action non autorisé', 401);
      }

      if($channel->user->contains($request->user)){
         return response()->json('utilisateur déjà présent', 403);
      };

      ChannelUser::create([
         'user_id' => $request->user,
         'channel_id' => $request->channel,
     ]);

     $channel->refresh();
         
     return response()->json($channel->user, 200);
   }

   public function store(Request $request)
   {
      $channel = new Channel;
      $channel->name = $request->name;
      $channel->private = $request->checked;
      $channel->user_id = Auth::user()->id;
      $channel->save();

      ChannelUser::create([
         'user_id' => Auth::user()->id,
         'channel_id' => $channel->id,
     ]);

      return response()->json(null, 200);
   }

   public function removeMember(Request $request)
   {
      $channel = Channel::find($request->channel);

      if (Auth::user()->id != $request->user['id']) {
         if (!Gate::check('admin-channel', $channel)) {
            return response()->json('Action non autorisée', 401);
         }
      }

     $channel_user = ChannelUser::where([
        ['user_id', $request->user['id']], 
        ['channel_id', $channel->id]
        ]);

      $channel_user->delete();

      $channel->refresh();
         
     return response()->json($channel->user, 200);
   }

   public function delete(Request $request)
   {
      $channel = Channel::find($request->channel);

      if (!Gate::check('admin-channel', $channel)) {
         return response()->json('Action non autorisée', 401);
      }

      broadcast(new RemoveUserChat($channel));

      $channel->delete();

      return response()->json(null, 200);
   }
}
