@extends('layouts.app')
   
@section('content')
   <messagerie :messages="messages"></messagerie>
   <post-message v-on:messagesent="addMessage"></post-message>
@endsection

