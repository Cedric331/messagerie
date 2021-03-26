<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Channel;
use App\Models\ChannelUser;
use Illuminate\Http\Request;
use App\Events\RemoveUserChat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

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

   public function searchChannel(Request $request)
   {
      $request->validate([
         'search' => ['required', 'string', 'min:1', 'max:30'],
      ]);

      $channels = Channel::where([
         ['name', 'like', $request->search.'%'],
         ['private', false]
      ])->get();

      $array = collect([]);
      foreach ($channels as $channel) {
         if(!$channel->user->contains(Auth::user())){
            $array->push($channel);
         };
      }

      $array = $array->take(5);

      return response()->json($array, 200);
   }

   public function joinChannel(Request $request)
   {
      $channel = Channel::findOrFail($request->id);

      if($channel->user->contains(Auth::user())){
         return response()->json('utilisateur déjà présent', 403);
      };

      ChannelUser::create([
         'user_id' => Auth::user()->id,
         'channel_id' => $channel->id,
     ]);

     return response()->json($channel->name, 200);
   }

   public function searchMember(Request $request)
   {
      $request->validate([
         'search' => ['required', 'string', 'min:1', 'max:15'],
         'channel' => ['required'],
      ]);

      $channel = Channel::findOrFail($request->channel);

      if (!Gate::check('admin-channel', $channel)) {
         return response()->json('Action non autorisée', 401);
      }

      $users = User::where('name', 'like', $request->search.'%')->get();

      $members = collect([]);
      foreach ($users as $user)
      {
          $members->push($user->id);
      }

      $collection = collect([]);
      foreach ($channel->user as $user)
      {
          $collection->push($user->id);
      }

      $diff = $members->diff($collection);
      $users = User::find($diff->all());
      $users = $users->take(5);

      return response()->json($users, 200);
   }

   public function addMember(Request $request)
   {
      $request->validate([
         'channel' => ['required'],
         'user' => ['required']
      ]);
      $channel = Channel::find($request->channel);
      
      if (!Gate::check('admin-channel', $channel)) {
         return response()->json('Action non autorisée', 401);
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
      $this->validate($request, 
      ['name' => 'required|string|max:30|unique:channels'],
      [
         'name.unique' => 'Le nom du groupe existe déjà',
         'name.required' => 'Le nom est requis',
         'name.string' => 'Le nom est incorrect'],
      );

      $this->validate($request, 
         ['checked' => 'required']
      );

      if ($request->channel != true && $request->channel != false ) {
         $request->channel = false;
      }

      $channel = new Channel;
      $channel->name = $request->name;
      $channel->private = $request->checked;
      $channel->user_id = Auth::user()->id;
      $channel->save();

      ChannelUser::create([
         'user_id' => Auth::user()->id,
         'channel_id' => $channel->id,
     ]);

      return response()->json($channel->name, 200);
   }

   public function removeMember(Request $request)
   {
      $request->validate([
         'channel' => ['required'],
         'user' => ['required']
      ]);

      $channel = Channel::findOrFail($request->channel);

      $user = User::findOrFail($request->user['id']);

      if (Auth::user()->id != $user->id) {
         if (!Gate::check('admin-channel', $channel)) {
            return response()->json('Action non autorisée', 401);
         }
      }

     $channel_user = ChannelUser::where([
        ['user_id', $user->id], 
        ['channel_id', $channel->id]
        ]);

        if ($channel_user != null) {
            $channel_user->delete();
        }

      $channel->refresh();
         
     return response()->json($channel->user, 200);
   }

   public function delete(Request $request)
   {
      $channel = Channel::findOrFail($request->channel);

      if (!Gate::check('admin-channel', $channel)) {
         return response()->json('Action non autorisée', 401);
      }

      broadcast(new RemoveUserChat($channel));

      Storage::disk('public')->deleteDirectory('image/images/'.$channel->id);

      $channel->delete();

      return response()->json(null, 200);
   }
}
