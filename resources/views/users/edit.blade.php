@extends('layouts.app')


@section('content')
	<h1>Editing user's data</h1>
    <form action="{{ route('users.update', $user->id) }}" method="post">
        @csrf
        @method('put')
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input maxlength="255" minlength="5" required="" name="name" type="text" class="form-control" id="exampleInputName" placeholder="Enter your name" value="{{ $user->name }}">
        </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input maxlength="255" required="" name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="{{ $user->email }}">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
<!--       <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div> -->

      <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection