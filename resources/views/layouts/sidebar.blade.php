@auth
    <div class="d-flex justify-content-end px-5">
        <a href="{{ route('discussions.create') }}" style="width: 100%" class="btn btn-info my-3">
            Add Discussion
        </a>
    </div>
@else
    <div class="d-flex justify-content-end px-5">
        <a href="{{ route('login') }}" style="width: 100%" class="btn btn-info my-3">
            Sign in to discussion
        </a>
    </div>
@endauth
<div class="card my-3">
    <div class="card-header">
        Channels
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <a style="color: black" href="{{ route('discussions.index') }}">
                <li class="list-group-item" style="border: none">
                    <strong>All channels</strong>
                </li>
            </a>
            <div class="float-right">
                @auth
                    <a class="btn btn-light" id="addChannel" href="{{ route('channels.index') }}">Manage channels</a>
                @endauth
            </div>
        </div>
        <!-- <a style="color: black; width: 100%" href="">
            <li class="list-group-item" style="border: none">
                <strong>My channels</strong>
            </li>
        </a>-->
        <br>
        @foreach($channels as $channel)
            <a style="color: black; width: 100%" href="{{ route('discussions.index') }}?channel={{ $channel->slug }}">
                <li class="list-group-item" style="border: none">
                    {{ $channel->name }}
                    <div class="badge badge-warning ml-3 py-1 px-2">
                    {{ $channel->discussions->count() }}
                    </div>
                </li>
            </a>
        @endforeach
        <br>
    </div>
</div>