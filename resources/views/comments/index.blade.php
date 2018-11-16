@extends('layouts.app')


@section('content')
    @forelse($comments as $comment)
        <div class="card">

            <div class="card-header">
                @role(moder)
                    <form class="d-inline" onsubmit="if(!confirm('Удалить комментарий?')){return false;}" action="{{ route('comments.destroy', $comment->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-link">
                            Delete this comment
                        </button>
                    </form>
                @endif
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    Post name:
                    <a href="{{ route('posts.show', $comment->post_id) }}">{{ $comment->post->title}}</a>
                </h5>
                <p>Comment: {{ $comment->text}}</p>
                <hr>
                <p class="card-text">
                    Author: {{ $comment->owner->name}} <br>
                    Created: {{ $comment->created_at}}
                </p>
            </div>
        </div>
    @empty
        <p>Комментариев к постам нет</p>
    @endforelse
    {{ $comments->links() }}
@endsection