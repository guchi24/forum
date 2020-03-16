@extends('layouts.app')

@section('content')
<div class="container my-3">
    <div class="card">
        <div class="card-header">
            Notifications
        </div>
        <div class="card-body">
            @if (count($notifications) > 0)
                @foreach( $notifications as $notification)
                    <ul class="list-group btn text-left my-2">
                        <a class="text-dark not-active text-left" href="{{ route('discussions.show', $notification->data['discussion']['slug']) }}">
                            <li class="list-group-item">
                                @if ( $notification->type === "App\Notifications\NewReplyAdded")
                                    <div>
                                    New reply was added by {{ $notification->data['discussion']['user_id'] }} to <strong>{{ $notification->data['discussion']['title'] }}</strong>
                                    <span style="margin-left: 30px; color: grey">{{ $notification->created_at }}</span></div>
                                @endif
                                @if ( $notification->type === "App\Notifications\ReplyMarkedAsBestReply")
                                    <div>Your reply got Best reply in  <strong>{{ $notification->data['discussion']['title'] }}</strong>
                                    <span style="margin: 30px; color: grey">{{ $notification->created_at }}</span></div>
                                @endif
                            </li>
                        </a>
                    </ul>
                @endforeach
            @else
                <div class="text-center" style="margin-top: 50px; margin-bottom: 50px"><h4>No nontifications.</h4></div>
            @endif
        </div>
    </div>
</div>
@endsection
