@extends('layouts.app')


@section('content')
  <form action="{{ route('users.store') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input maxlength="255" minlength="5" required="" name="name" type="text" class="form-control" id="exampleInputName" placeholder="Enter your name">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Email address</label>
      <input maxlength="255" name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Role</label>
      <select name="role_id" class="form-control">
        @foreach($roles as $role)
          <option value="{{ $role->id }}">{{ $role->title }}</option>
        @endforeach
      </select>
    </div>
    @role(admin)
      <div class="form-group">
        <label for="formInputUser">Status</label>
        <select id="formInputUser" name="status" class="form-control">
          <option value="{{ $statuses['deactivated'] }}" selected>
            Nonactivated
          </option>
          <option value="{{ $statuses['activated'] }}">
            Activated
          </option>
        </select>
      </div>
    @endrole
    <div class="form-group">
      <label for="exampleInputPassword1">Password</label>
      <input maxlength="255" minlength="5" name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection
