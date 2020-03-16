@if ($errors->any())
    <div class="alert alert-danger">
        <li class="list-group">
            @foreach ($errors->all() as $error)
                <div class="text-danger">
                {{ $error }} 
                </div>
            @endforeach
        </li>
    </div>
@endif

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif