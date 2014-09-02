<?php

namespace Controllers;

class RoomController extends \BaseController
{
	public function index()
	{
		return \View::make('rooms.index');
	}

	public function store()
	{
		$room = new \Room();
		$room->household_id = \Auth::user()->activeHousehold()->id;
		$room->creator_id = \Auth::user()->id;
		$room->name = \Input::get('room-name');
		$room->description = \Input::get('room-description');

		if(!$room->isValid())
			return \Redirect::back()->with('flash_message', 'There were errors creating your room.<br />'.$room->errors);

		$room->save();
		return \Redirect::back()->with('flash_message', 'Room created successfully');
	}

	public function delete($id)
	{
		$room = \Room::find($id);
		
		if(!\Auth::user()->belongsToHousehold($room->household_id))
			return \Redirect::back()->with('flash_message', 'You do not belong to that household');

		//Gotta do something with the chores that belong to this room

		//TODO

		$room->delete();
		return \Redirect::back()->with('flash_message', 'You have successfully deleted the room');
	}
}