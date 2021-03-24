<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   public function index()
   {
      return view('auth.account',[
         'user' => Auth::user()
      ]);
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
      } else{
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
