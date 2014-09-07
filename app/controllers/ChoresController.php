<?php

namespace Controllers;

class ChoreController extends \BaseController
{
	public function create($id = null)
	{
		if(is_null($id))
			return \View::make('chores.index');
		else
		{
			$chore = \Chore::find($id);
			return \View::make('chores.index', compact('chore'));
		}
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

		//Store the last used room in the preferences
		\Preference::set('create-chore-lastroom', $chore->room_id);

		return \Redirect::back()->with('flash_message', 'You have successfully created a chore');
	}

	public function delete($id)
	{
		$chore = \Chore::find($id);
		if($chore->user_id == \Auth::user()->id)
		{
			$chore->delete();
			return \Redirect::back()->with('flash_message', 'Chore successfully deleted');
		}

		if($chore->room->household()->isAdmin(\Auth::user()->id))
		{
			$chore->delete();
			return \Redirect::back()->with('flash_message', 'Chore successfully deleted');
		}

		return \Redirect::back()->with('flash_message', 'You do not have permission to do that');
	}

	public function edit($id)
	{
		$chore = \Chore::find($id);
		$chore->name = \Input::get('chore-name');
		$chore->description = \Input::get('chore-description');
		$chore->room_id = \Input::get('chore-room');
		$chore->frequency = \Input::get('chore-frequency');
		$chore->duration = \Input::get('chore-duration');
		$chore->save();

		//Handle importance
		if(\Input::get('chore-importance') == '')
			return \Redirect::back()->with('flash_message', 'Chore successfully edited');

		$importance = \Importance::where('chore_id', $chore->id)->where('user_id', \Auth::user()->id)->first();
	
		if($importance)
			$importance->importance = \Input::get('chore-importance');
		else
			$importance = new \Importance($chore, \Input::get('chore-importance'));
		
		$importance->save();

		return \Redirect::back()->with('flash_message', 'Chore successfully edited');
	}
}