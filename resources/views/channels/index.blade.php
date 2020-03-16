@extends('layouts.app')

@section('content')
<div class="container col-10 mt-3">
    @include('inc.messages')
    <div class="card card-header">
        <h3 style="margin-top: 4px">Channels</h3>
    </div>
    @if (count($channels) > 0)
        @foreach($channels as $channel)
            <div class="card card-body btn btn-white text-left">
                <a href="{{ route('channels.edit', $channel->id) }}" style="color: black; text-decoration: none">
                    <div class="d-flex justify-content-between">
                        <h5 style="margin-top: 10px">{{ $channel->name }}</h5>
                        <div class="col-2 text-center">
                            <strong>
                            {{ $channel->discussions->count() }} 
                            </strong>
                            <br>
                            Posts
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
                        <h3>No channels yet.</h3>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @auth
        <div class="text-center" style="margin: 50px">
            <a href="{{ route('channels.create') }}" style="width: 50%; font-size: 15px" class="btn btn-info my-3">
                Add Channel
            </a>
        </div>
    @endauth
</div>
@endsection
