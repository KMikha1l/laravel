@extends('layouts.app')


@section('content')
    <form class="col-6" action="{{ route('posts.update', $post) }}" method="post">
      @csrf
      @method('put')
      <div class="form-group">
        <label for="formInputTitle">Title</label>
        <input maxlength="255" minlength="5" required="" name="title" type="text" class="form-control" id="formInputTitle" placeholder="post title" value="{{ $post->title }}">
      </div>
      <div class="form-group">
        <label for="formInputUser">Creator</label>
        <select id="formInputUser" name="user_id" class="form-control">
          @foreach($users as $user)
            <option value="{{ $user->id }}"
            @if($user->id == $post->user_id)
              selected
            @endif
            >{{ $user->email }}</option>
          @endforeach
        </select>
      </div>
     <div class="form-group">
        <label for="formInputContent">Content</label>
        <textarea required="" name="content" class="form-control" rows="5" id="formInputContent">
          {{ $post->content }}
        </textarea>
      </div>

      <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection