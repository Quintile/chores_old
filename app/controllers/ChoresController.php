<?php

namespace Controllers;

class ChoreController extends \BaseController
{
	public function create()
	{
		return \View::make('chores.index');
	}

	public function store()
	{
		$chore = new \Chore();
		$chore->name = \Input::get('chore-name');
		$chore->description = \Input::get('chore-description');
		$chore->room_id = \Input::get('chore-room');
		$chore->frequency = \Input::get('chore-frequency');
		$chore->duration = \Input::get('chore-duration');
		$chore->user_id = \Auth::user()->id;
		$chore->save();

		//Handle importance
		$importance = new \Importance($chore, \Input::get('chore-importance'));
		$importance->save();

		return \Redirect::back()->with('flash_message', 'You have successfully created a chore');
	}
}