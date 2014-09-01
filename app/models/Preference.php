<?php

class Preference extends \Eloquent
{
	protected $table = 'prefs';
	protected $guarded = array();

	public function __construct($pref = null, $value = null, $user_id = null)
	{
		$this->pref = $pref;
		$this->value = $value;
		if(is_null($user_id))
			$user_id = \Auth::user()->id;

		$this->user_id = $user_id;
	}

	public static function check($pref, $user_id = null)
	{
		if(is_null($user_id))
			$user_id = \Auth::user()->id;

		$pref = Preference::where('pref', $pref)->where('user_id', $user_id)->first();
		if(!$pref)
			return null;
		else
			return $pref->value;
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
}