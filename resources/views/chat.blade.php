@extends('layouts.app')
   
@section('content')
@auth
   <div class="container-fluid m-auto">
      <messagerie :channel="{{ $channel }}" :user="{{ Auth::user() }}"></messagerie>
   </div>
@endauth
@endsection
