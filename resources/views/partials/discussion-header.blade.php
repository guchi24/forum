<div class="card-header">
    <div class="d-flex justify-content-between">  
        <div>
            <img width="30px" height="30px" style="border-radius: 50%; margin-right: 10px" src="{{ Gravatar::src($discussion->author->email) }}" alt="">
            <span style="font-weight: bold; font-size: 13px">{{ $discussion->author->name }}</span>
            @if($discussion->created_at < $discussion->updated_at)
                <span style="color: grey; margin-left: 20px; font-size: 10px"><strong>Updated at: </strong>{{ $discussion->updated_at }}</span>
            @else
                <span style="color: grey; margin-left: 20px; font-size: 10px">{{ $discussion->created_at }}</span>
            @endif
        </div>
        @auth
            @if(auth()->user()->id === $discussion->user_id)
                <a href="{{ route('discussions.edit', $discussion->id) }}" class="btn btn-secondary-original">Edit</a>
            @endif
        @endauth
    </div>
</div>

