<?php

namespace Controllers;

class HomeController extends \BaseController {

	
	public function index()
	{
		return \View::make('home.index');
	}

}
