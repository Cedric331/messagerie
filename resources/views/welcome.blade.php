@extends('layouts.app')
   
@section('content')
   <messagerie :messages="{{ $messages }}"></messagerie>
@endsection

