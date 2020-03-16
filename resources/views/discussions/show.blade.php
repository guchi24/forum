@extends('layouts.app')

@section('content')
<div class="container">
    @include('inc.messages')
    <div class="container d-flex justify-content-end">
        <a href="{{ route('discussions.index') }}" class="btn btn-secondary float-right">Back</a>
    </div>
    <div class="card my-3 border-secondary">
        @include('partials.discussion-header')
        <div class="card-body">
            <h4>{{ $discussion->title }}</h4>
            <hr>
            {!! $discussion->content !!}

            @if($discussion->bestReply)
                <div class="card-body bg-warning my-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">  
                            <div>
                                <img width="20px" height="20px" style="border-radius: 50%; margin-right: 10px" src="{{ Gravatar::src($discussion->bestReply->owner->email) }}" alt="">
                                <span class="font-weight-bold">{{ $discussion->bestReply->owner->name }}</span>
                            </div>
                            @auth
                                @if(auth()->user()->id === $discussion->user_id)
                                    <div class="d-flex justify-content-end">
                                        <div class="badge badge-success" style="margin-top: 3px">
                                            <div>
                                                <form action="{{ route('discussions.best-reply-unset', [ 'discussion' => $discussion->slug, 'reply' => $reply->id ?? '' ]) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-light float-right ml-2">Remove</button>
                                                </form>
                                            </div>
                                            <div style="margin-left: 2px; margin-top: 6px; align: left ; width: 120px; font-size:10px">
                                                Best Reply
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="badge badge-success p-2">Best Reply</div>
                                @endif
                            @endauth
                        </div>
                    </div>
                    <div class="card-body">
                        {!! $discussion->bestReply->content !!}
                    </div>
                </div>
            @endif
            
        </div>
    </div>

    @foreach ($discussion->replies()->orderBy('created_at', 'desc')->paginate(10) as $reply)
        <div class="card my-5 mx-4">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between">  
                    <div>
                        <img width="20px" height="20px" style="border-radius: 50%; margin-right: 10px" src="{{ Gravatar::src($reply->owner->email) }}" alt="">
                        <span class="font-weight-bold">{{ $reply->owner->name }}</span>
                        <span style="color: grey; margin-left: 20px; font-size: 10px">{{ $reply->created_at }}</span>
                    </div>

                    <div class="col-3">
                        @auth
                            @if(auth()->user()->id === $discussion->user_id)
                                <form action="{{ route('discussions.best-reply', [ 'discussion' => $discussion->slug, 'reply' => $reply->id ]) }}" method="post">
                                    @csrf
                                    @if($reply->id === $discussion->reply_id)
                                        <div class="btn-sm btn-warning float-right">Best reply</div>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-light float-right">Best reply</button>
                                    @endif
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
            <div class="card-body">
                {!! $reply->content !!}
            </div>
        </div>
    @endforeach
    <br>
    {{ $discussion->replies()->paginate(10)->links() }}

    <div class="card my-5">
        <div class="card-header">
            Add Reply
        </div>
        <div class="card-body">
            @auth
                <form action="{{ route('replies.store', $discussion->slug) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="content" id="content">
                        <trix-editor input="content" style="min-height:200px"></trix-editor>
                    </div>
                    <button class="btn my-2 btn-success">Add reply</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-info">Sign in to reply</a>
            @endauth
        </div>
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css">
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>
@endsection
