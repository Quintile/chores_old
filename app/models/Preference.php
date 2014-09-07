<?php

class Preference extends \Eloquent
{
	protected $table = 'prefs';
	protected $guarded = array();

	public function __construct($pref = null, $value = null, $user_id = null, $household_id = null)
	{
		$this->pref = $pref;
		$this->value = $value;
		if(is_null($user_id) && is_null($household_id))
			$user_id = \Auth::user()->id;
		else
			$this->household_id = $household_id;

		$this->user_id = $user_id;
	}

	public static function check($pref, $user_id = null, $household_id = null)
	{
		if(is_null($user_id))
			$user_id = \Auth::user()->id;
		
		if(is_null($household_id))
			$household_id = \Auth::user()->activeHousehold()->id;

		$result = Preference::where('pref', $pref)->where('user_id', $user_id)->first();

		if(!$result)
			$result = Preference::where('pref', $pref)->where('household_id', $household_id)->first();

		if(!$result)
			return null;
		else
			return $result->value;
	}

	public static function set($pref, $value, $user_id = null)
	{
		if(is_null($user_id))
			$user_id = \Auth::user()->id;

		$preference = Preference::where('pref', $pref)->where('user_id', $user_id)->first();
		if($preference)
			$preference->value = $value;
		else
			$preference = new Preference($pref, $value, $user_id);

		$preference->save();
	}

	public static function setHouse($pref, $value, $household_id = null)
	{
		if(is_null($household_id))
			$household_id = \Auth::user()->activeHousehold()->id;
		$preference = Preference::where('pref', $pref)->where('household_id', $household_id)->first();
		if($preference)
			$preference->value = $value;
		else
			$preference = new Preference($pref, $value, null, $household_id);
		$preference->save();
	}
}