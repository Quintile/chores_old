<?php

class Invite extends \Eloquent
{
	use SoftDeletingTrait;

	protected $guarded = array();

	public function email()
	{

	}

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function origin()
	{
		return $this->belongsTo('User', 'origin_id');
	}

	public function household()
	{
		return $this->belongsTo('Household');
	}

	public function accept()
	{
		$householdUser = new \HouseholdUser();
		$householdUser->user_id = $this->user->id;
		$householdUser->household_id = $this->household->id;
		$householdUser->save();

		$this->delete();
	}
}