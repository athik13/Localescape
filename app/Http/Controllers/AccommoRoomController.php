<?php

namespace App\Http\Controllers;

use App\accommo_room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AccommoRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $rooms = \App\accommo_room::where('accommo_id', $id)->get();
        return view('extranet.accommodations.rooms.all', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('extranet.accommodations.rooms.add', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $rooms = \App\accommo_room::create(Input::except('_token'));
        $url = 'extranet/accommodations/rooms/' . $id ; 
        return redirect($url)->with('alert-success', 'Successfully added new room');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\accommo_room  $accommo_room
     * @return \Illuminate\Http\Response
     */
    public function show(accommo_room $accommo_room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\accommo_room  $accommo_room
     * @return \Illuminate\Http\Response
     */
    public function edit(accommo_room $accommo_room)
    {
        return view('extranet.accommodations.rooms.edit', compact('accommo_room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\accommo_room  $accommo_room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, accommo_room $accommo_room)
    {
        $accommo_room->room_type = $request->room_type;
        $accommo_room->description = $request->description;
        $accommo_room->no_adult = $request->no_adult;
        $accommo_room->price_adult = $request->price_adult;
        $accommo_room->no_children = $request->no_children;
        $accommo_room->price_child = $request->price_child;
        $accommo_room->save();

        $url = 'extranet/accommodations/rooms/' . $request->accommo_id ; 
        return redirect($url)->with('alert-success', 'Successfully edited room');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\accommo_room  $accommo_room
     * @return \Illuminate\Http\Response
     */
    public function destroy(accommo_room $accommo_room)
    {
        $accommo_room->delete();
        return redirect()->back()->with('alert-success', 'Successfully deleted the room');
    }
}