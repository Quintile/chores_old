<?php

namespace Controllers;

class ChoreController extends \BaseController
{
	public function index()
	{
		$chores = \Models\Chore::all();
		return \View::make('chores.index', compact('chores'));
	}

	public function take($id)
	{
		$chore = \Models\Chore::find($id);
		$chore->lastdone = new \DateTime();
		$chore->save();

		return \Redirect::back();
	}
}