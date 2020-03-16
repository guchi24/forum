@extends('layouts.app')

@section('content')
    <div class="container col-10 my-3">
        @include('inc.messages')
        <div class="card">
                <div class="card-header">
                    <div class="float-left mt-2" style="font-size: 16px">
                    {{ isset($channel) ? 'Update Channel' : 'Add Channel' }}
                    </div>
                    <div class="float-right">
                        <a href="{{ URL::previous() }}" class="btn btn-secondary float-right">Back</a>
                        <!-- @isset($channel) 
                            <button name="button" class="btn btn-danger float-right mr-2" onclick="handleChannelDelete({{ $channel->id }})">Delete</button>
                        @endisset -->
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ isset($channel) ? route('channels.update', $channel->id) : route('channels.store') }}" method="post" id="channel">
                        @csrf
                        @isset($channel) 
                            @method('PUT')
                        @endisset
                        <div class="form-group">
                            <label for="name">Channel name</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ !isset($channel) ? old('name') : $channel->name }}">
                        </div>
                        @isset($channel)
                            <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure to update this channel?')">Update Channel</button>
                        @else
                            <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure to create this channel?')">Add Channel</button>
                        @endisset
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteChannelModal" tabindex="-1" role="dialog" aria-labelledby="deleteChannelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" id="deleteChannelForm" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="deleteChannelModalLabel">Delete channel</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>You can not recover it once you delete it. Are you sure to delete this channel?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Yes, delete.</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, go back.</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
    
@section('scripts')

    <script>

        function handleChannelDelete(id) {

            var form = document.getElementById('deleteChannelForm')

            form.action = '/channels/' + id

            $('#deleteChannelModal').modal('show')
            
        }

    </script>

@endsection
