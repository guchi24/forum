<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Channel;
use App\Discussion;
use App\Reply;
use App\Http\Requests\CreateChannelRequest;

class ChannelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('channels.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('channels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateChannelRequest $request)
    {
    
        Channel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        session()->flash('status', 'Channel added successfully.');

        return redirect(route('channels.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $channel = channel::findOrFail($id);

        return view('channels.create')->with( ['channel' => $channel] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateChannelRequest $request, $id)
    {

        $channel = Channel::findOrFail($id);

        $channel->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        session()->flash('status', 'Channel updated successfully.');

        return redirect(route('channels.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $channel = Channel::findOrFail($id);

        $discussion = Discussion::where('channel_id', $id);

        $discussion->delete();

        $channel->delete();

        session()->flash('status', 'Channel deleted successfully.');

        return redirect(route('channels.index'));
    }
}
