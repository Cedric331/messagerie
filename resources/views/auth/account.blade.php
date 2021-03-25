@extends('layouts.app')

@section('content')
<account :avatars="{{ $avatars }}" :user="{{ $user }}"></account>
@endsection
