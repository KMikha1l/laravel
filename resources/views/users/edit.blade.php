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
      <div class="form-group">
        <label for="exampleInputEmail1">Role</label>
        <select name="role_id" class="form-control">
          @foreach($roles as $role)
            <option value="{{ $role->id }}"
            @if($role->id == $user->role_id)
              selected
            @endif
            >{{ $role->title }}</option>
          @endforeach
        </select>
      </div>
      @role(admin)
      <div class="form-group">
        <label for="formInputUser">Status</label>
        <select id="formInputUser" name="status" class="form-control">
          <option value="{{ $statuses['deactivated'] }}" @if((int) $user->status === $statuses['deactivated']) selected @endif>
            Deactivated
          </option>
          <option value="{{ $statuses['activated'] }}" @if( (int) $user->status === $statuses['activated']) selected @endif>
            Activated
          </option>
        </select>
      </div>
      @endrole

<!--       <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div> -->

      <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
