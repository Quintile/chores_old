<?php

namespace Controllers;

class PreferenceController extends \BaseController
{
	public function set($pref = null, $value = null)
	{
		if(is_null($pref) || is_null($value))
		{
			$pref = \Input::get('pref');
			$value = \Input::get('value');
		}

		\Preference::set($pref, $value);
	}

	public function index()
	{
		return \View::make('preferences.index');
	}
}