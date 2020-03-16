@extends('layouts.app')

@section('content')
<div class="container">
    @if (count($discussions->appends(['channel' => request()->query('channel')])) > 0)
        @include('inc.messages')
        @foreach($discussions as $discussion)
            <div class="card my-3">
                @include('partials.discussion-header')
                <a href="{{ route('discussions.show', $discussion->slug) }}" class="btn text-left" style="color: black; text-decoration:none">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex col-8">
                                <div class="badge badge-light mb-0 py-2 px-2">
                                    {{ $discussion->channel->name }}
                                </div>
                                <h5 class="mb-0 ml-4">{{ $discussion->title }}</h5>
                            </div>
                            @if($discussion->bestReply)
                                <h4 class="mb-0"><span class="badge badge-success mb-0 py-2 px-2">Got best reply</span></h4>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    @else
        <div class="card my-3">
            <div class="card-body width:100%">
                <div class="text-center width:100%" style="margin: 50px">
                    <div>
                        <h3>No discussions in this channel yet.</h3>
                    </div>
                </div>
                @auth
                    <div class="text-center" style="margin: 50px">
                        <a href="{{ route('discussions.create') }}" style="width: 50%; font-size: 15px" class="btn btn-info my-3">
                            Add Discussion
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    @endif
    {{ $discussions->appends(['channel' => request()->query('channel')])->links() }}
</div>
@endsection
