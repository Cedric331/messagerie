@extends('layouts.app')
   
@section('content')
   <div class="container-fluid m-auto">
      <messagerie :channel="{{ $channel }}" :user="{{ Auth::user() }}"></messagerie>
   </div>
   
@endsection
