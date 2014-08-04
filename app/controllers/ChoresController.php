<?php

namespace Controllers;

class ChoreController extends \BaseController
{
	public function index()
	{

		$chores = \Models\Chore::all();
		return \View::make('chores.index', compact('chores'));
	}
}