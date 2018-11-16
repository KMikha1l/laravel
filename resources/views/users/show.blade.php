@extends('layouts.app')


@section('content')
  <div class="row">
    <div class="col-12">
      <h1>User name: {{ $user->name }}</h1>
      <p>Email: {{ $user->email }}</p>
      <p>Role: {{ $user->role->title }}</p>
    </div>
  </div>
@endsection
