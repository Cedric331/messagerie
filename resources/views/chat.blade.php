@extends('layouts.app')
   
@section('content')
   <div class="container m-auto chat">
      <messagerie :channel="{{ $channel }}"></messagerie>
   </div>
   
@endsection
