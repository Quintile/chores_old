<?php

namespace Controllers;

class ChoreController extends \BaseController
{
	public function index()
	{
		$chores = \Models\Chore::orderBy('room_id')->orderBy('name')->get();
		return \View::make('chores.index', compact('chores'));
	}

	public function take($id)
	{
		$today = new \DateTime();
		$today = $today->format('Y-m-d');

		$exists = \Models\Log::where('chore_id', $id)->
								where('created_at', 'LIKE', $today.'%')->
								first();
		if($exists)
		{
			$exists->delete();
		}
		else
		{
			$log = new \Models\Log($id, 1);
			$log->save();
		}
		
		return \Redirect::back();
	}
}