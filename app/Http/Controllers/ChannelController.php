<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Channel;
use App\Models\ChannelUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChannelController extends Controller
{
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
      
      if($channel->user->contains($request->user)){
         return response()->json('utilisateur déjà présent', 401);
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
}
