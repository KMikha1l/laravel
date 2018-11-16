@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card p-2">
            <h1>{{ $post->title }}</h1>
            {{ $post->content }}
        </div>
        <div class="card mt-4 p-2">
            <h3>Комментарии</h3>
            <div class="card p-4 mb-4">
            <form method="post" action="{{ route('comments.store') }}">
                @csrf
                <p class="card-text">
                    <textarea name="text" class="form-control" rows="3" placeholder="Input your comment" required>

                    </textarea>
                </p>
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <button type="submit" class="btn btn-outline-primary">Добавить комментарий</button>
            </form>
            </div>

            @forelse($comments as $comment)
                <div class="card p-1 mb-4">
                    @role(moder)
                        <form onsubmit="if(!confirm('Удалить комментарий?')){return false;}"
                        action="{{ route('comments.destroy', $comment->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-outline-primary" style="position: absolute; right: 0">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </form>
                    @endif
                    <h5 class="card-title">{{ $comment->owner->name }}</h5>
                    <p class="card-text">{{ $comment->text }}</p>
                    <p class="card-text">{{ $comment->created_at }}</p>
                </div>
            @empty
                Нет комментариев
            @endforelse
        </div>
    </div>
</div>
@endsection
