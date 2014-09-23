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

	public function generator()
	{
		return $this->hasOne('\Chores\Generator');
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

	public function chores()
	{
		return $this->hasManyThrough('\Chore', '\Room');
	}

	public function chorePool($ordering = 'DESC')
	{
		$chores = $this->chores;

		$choreArray = array();
	
		foreach($chores as $c)
		{
			
			if($c->priority() >= 1.0)
				$choreArray[] = $c;
		}
	
		$sorter = ($ordering == 'DESC') ? '\Chore::priorityCompareDesc' : '\Chore::priorityCompareDesc';

		usort($choreArray, $sorter);

		return $choreArray;
	}
}