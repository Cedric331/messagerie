@extends('layouts.app')

@section('content')
<account :user="{{ $user }}"></account>
@endsection
