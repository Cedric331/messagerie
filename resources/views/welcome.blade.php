@extends('layouts.app')
   
@section('content')
   @auth
   <div class="container">
      <ul>
         @foreach ($channels as $channel)
         <li>
            <a href="{{ route('chat',['channel' => $channel->name]) }}">{{ $channel->name }}</a>
         </li>
         @endforeach
      </ul>
   </div>
   @endauth
@endsection

