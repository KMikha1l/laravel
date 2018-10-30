@extends('layouts.app')


@section('content')
    <form class="col-6" action="{{ route('posts.store') }}" method="post">
      @csrf
      <div class="form-group">
          <label for="formInputTitle">Title</label>
          <input name="title" type="text" class="form-control" id="formInputTitle" placeholder="Enter your name">
      </div>

      <div class="form-group">
        <label for="formInputContent">Owner</label>
        <select name="user_id" class="form-control">
          @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="formInputContent">Content</label>
        <textarea name="content" class="form-control" rows="5" id="formInputContent"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection