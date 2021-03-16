@extends('layouts.app')
   
@section('content')
   <post-message :messages="{{ $messages }}"></post-message>
@endsection

