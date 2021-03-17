@extends('layouts.app')
   
@section('content')
   <messagerie :channel="{{ $channel }}" :messages="messages"></messagerie>
   <post-message v-on:messagesent="addMessage" :channel="{{ $channel }}"></post-message>
@endsection