@extends('layouts.app')
   
@section('content')
   <div class="container-fluid m-auto">
      <messagerie :channel="{{ $channel }}"></messagerie>
   </div>
   
@endsection
