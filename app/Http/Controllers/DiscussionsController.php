<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\CreateDiscussionRequest;
use App\Discussion;
use App\Reply;
use App\Channel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class DiscussionsController extends Controller
{

    public function __construct()

    {

        $this->middleware(['auth', 'verified'])->only(['create', 'store']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('discussions.index', [
            'discussions' => Discussion::filterByChannels()->orderBy('created_at', 'desc')->paginate(10),
        ]);

    }

    // public function myDiscussions()
    // {
    //     $user = Auth::user();

    //     return view('discussions.index', [
    //         'discussions' => Discussion::filterByLoginAuthor()->orderBy('created_at', 'desc')->paginate(10),
    //         'user' => $user->id
    //     ]);

    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('discussions.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDiscussionRequest $request)
    {

        auth()->user()->discussions()->create([
            'title' => $request->title,
            'slug' => Str::slug($request->title).'-'.date('created_at'),
            'content' => $request->content,
            'channel_id' => $request->channel
        ]);

        session()->flash('status', 'Discussion posted successfully.');
        
        return redirect()->route('discussions.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Discussion $discussion)
    {

        return view('discussions.show', [
            'discussion' => $discussion,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id, Channel $channel)
    {

        $discussion = Discussion::findOrFail($id);

        return view('discussions.create')->with( ['discussion' => $discussion] );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateDiscussionRequest $request, $id)
    {
        $discusssion = Discussion::findOrFail($id);
        
        $discusssion->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title).'-'.date('created_at'),
            'content' => $request->content,
            'channel_id' => $request->channel
        ]);

        $message = 'Discussion updated successfully.';

        session()->flash('status', 'Discussion updated successfully.');
        
        return redirect()->route('discussions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)

    {
        
        $discussion = Discussion::findOrFail($id);

        $discussion->delete();

        $reply = Reply::where('discussion_id', $id);

        $reply->delete();

        session()->flash('status', 'Discussion deleted successfully.');

        return redirect()->route('discussions.index');

    }

    public function reply(Discussion $discussion, Reply $reply)
    
    {

        $discussion->markAsBestReply($reply);

        session()->flash('status', 'Reply marked as best reply.');

        return redirect()->back();

    }

    public function unsetBestReply(Discussion $discussion, Reply $reply){
        

        $discussion->removeBestReply($reply);

        session()->flash('status', 'Best reply was unset.');

        return redirect()->back();

    }
}
