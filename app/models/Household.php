<?php

class Household extends Eloquent
{
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
}