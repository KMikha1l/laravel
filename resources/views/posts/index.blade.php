@extends('layouts.app')


@section('content')
	<div class="container">

    <a href="{{ route('posts.create') }}">
      <button class="btn btn-primary mb-2">New post</button>
    </a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">id</th>
          <th scope="col">title</th>
          <th scope="col">actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($posts as $post)
          <tr>
            <th scope="row">{{ $post->id }}</th>
            <td>
              <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
            </td>
            <td>
              @role(moder)
                <a href="{{ route('posts.edit', $post) }}">
                  <button class="btn btn-outline-primary">Edit</button>
                </a>

                <form onsubmit="if(!confirm('Удалить пост?')){return false;}" class="d-inline" action="{{ route('posts.destroy', $post) }}" method="post">
                  @csrf
                  @method('delete')
                  <button class="btn btn-outline-primary" role="submit">Delete</button>
                </form>
              @endrole
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    {{ $posts->links() }}
  </div>
@endsection