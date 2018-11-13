@extends('layouts.app')


@section('content')
	<div class="container">
    <a href="{{ route('users.create') }}">
      <button class="btn btn-primary mb-2">New user</button>
    </a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">id</th>
          <th scope="col">name</th>
          <th scope="col">email</th>
          <th scope="col">actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
            <tr>
              <th scope="row">{{ $user->id }}</th>
              <td>
                <a href="{{ route('users.show', $user) }}">{{ $user->name }}</a>
                @if($user->status === 'nonactivated')
                  deactivated
                @endif
              </td>
              <td>{{ $user->email }}</td>
              <td>
                @role(admin)
                  <a href="{{ route('users.edit', $user) }}">
                    <button class="btn btn-outline-primary">
                      <i class="fa fa-edit" aria-hidden="true"></i>
                    </button>
                  </a>
                @endrole
                <form onsubmit="if(!confirm('Удалить пользователя?')){return false;}" class="d-inline-block" action="{{ route('users.destroy', $user) }}" method="post">
                  @csrf
                  @method('delete')
                  <button class="btn btn-outline-primary">
                    <i class="fa fa-times" aria-hidden="true"></i>
                  </button>
                </form>
              </td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
