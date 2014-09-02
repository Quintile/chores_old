<?php

class Household extends Eloquent
{
	use SoftDeletingTrait;

	protected $guarded = array();

	private $rules = [
		'name' => 'required|unique:households,name',
	];

	public $errors;

	public function isValid()
	{
		$validation = \Validator::make($this->attributes, $this->rules);
		if($validation->passes())
			return true;
		$this->errors = $validation->messages();
		return false;
	}

	public function users()
	{
		return $this->belongsToMany('User');
	}

	public function invites()
	{
		return $this->hasMany('Invite');
	}

	public function rooms()
	{
		return $this->hasMany('Room');
	}

	public function isActiveHousehold()
	{
		return ($this->id === \Auth::user()->household_id);
	}

	public function isAdmin($id)
	{
		return ($this->admin_id === $id);
	}

	public function hasNoRooms()
	{
		return ($this->rooms()->count()) ? false : true;
	}
}