@extends('layouts.app')


@section('content')
  <div class="row">
    <div class="col-12">
      <h1>{{ $post->title }}</h1>
      <div>
        {{ $post->content }}
      </div>
    </div>
  </div>
@endsection
