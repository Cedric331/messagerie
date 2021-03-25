<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

   public function __construct()
   {
      $this->middleware('auth');
   }

   public function index()
   {
      $files = Storage::files('/public/image/avatars');

      $array = collect([]);
      foreach ($files as $value) {
         $file = explode("public/image/avatars/", $value);
         $array->push($file[1]);
      }

      return view('auth.account',[
         'user' => Auth::user(),
         'avatars' => $array
      ]);
   }

   public function avatar(Request $request)
   {
      $request->validate([
         'avatar' => ['required'],
      ]);

      $user = User::findOrFail(Auth::user()->id);
      $user->avatar = $request->avatar;
      $user->save();

      return response()->json(null, 200);
   }

   public function update(Request $request)
   {
      if ($request->name != Auth::user()->name) {
         $request->validate([
            'name' => ['required', 'string', 'max:255', 'alpha_dash','unique:users'],
         ]);
      }
      if ($request->email != Auth::user()->email) {
         $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
         ]);
      }
      if ($request->email != Auth::user()->email || $request->name != Auth::user()->name) {
         $user = User::findOrFail(Auth::user()->id);
         $user->name = $request->name;
         $user->email = $request->email;
         $user->save();
         
      return response()->json(null ,200);
      } 
      else {
         return response()->json(null ,201);
      }
   }

   public function delete(Request $request)
   {
      $request->validate([
         'id' => ['required']
      ]);
      
      $user = User::find($request->id);
      $user->delete();
   }
}
