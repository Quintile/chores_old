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
		dd(\Input::all());
	}
}