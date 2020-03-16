@extends('layouts.app')

@section('content')
    <div class="container my-3">
        @include('inc.messages')
        <div class="card">
                <div class="card-header">
                    <div class="float-left mt-2" style="font-size: 16px">
                    {{ isset($discussion) ? 'Update Discussion' : 'Add Discussion' }}
                    </div>
                    <div class="float-right">
                        <a href="{{ URL::previous() }}" class="btn btn-secondary float-right">Back</a>
                        <!-- @isset($discussion) 
                            <button name="button" class="btn btn-danger float-right mr-2" onclick="handleDiscussionDelete({{ $discussion->id }})">Delete</button>
                        @endisset -->
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ isset($discussion) ? route('discussions.update', $discussion->id) : route('discussions.store') }}" method="post" id="discussion">
                        @csrf
                        @isset($discussion) 
                            @method('PUT')
                        @endisset
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input class="form-control" type="text" name="title" id="title" value="{{ !isset($discussion) ? old('title') : $discussion->title }}">
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <input id="content" type="hidden" name="content" value="{{ !isset($discussion) ? old('content') : $discussion->content }}">
                            <trix-editor input="content" style="min-height:200px"></trix-editor>
                        </div>
                        <div class="form-group">
                            <label for="channel">Channel</label>
                            <select class="form-control" name="channel" id="channel">
                                <option value="none" disabled>Select channel</option>
                                @foreach($channels as $channel)
                                    @isset($discussion) 
                                        <option value="{{ old('channel') ?? $channel->id }}" @if($discussion['channel_id'] === $channel['id']) {{ 'selected' }} @endif>{{ $channel->name }}</option>
                                    @else
                                        <option value="{{ old('channel') ?? $channel->id }}">{{ $channel->name }}</option>
                                    @endisset
                                @endforeach
                            </select>
                        </div>
                        @isset($discussion)
                            <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure to update this discussion?')">Update Discussion</button>
                        @else
                            <button type="submit" class="btn btn-success" onclick="return confirm('It will be shown in public. Are you sure to create this discussion?')">Add Discussion</button>
                        @endisset
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteDiscussionModal" tabindex="-1" role="dialog" aria-labelledby="deleteDiscussionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" id="deleteDiscussionForm" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="deleteDiscussionModalLabel">Delete Discussion</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>You can not recover it once you delete it. Are you sure to delete this discussion?</h5>
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

        function handleDiscussionDelete(id) {

            var form = document.getElementById('deleteDiscussionForm')

            form.action = '/discussions/' + id

            $('#deleteDiscussionModal').modal('show')
            
        }

    </script>

@endsection
    

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css">
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>
@endsection

