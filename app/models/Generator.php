<?php

class Generator extends \Eloquent
{
	protected $guarded = array();
	private $rules = [
		'type' => 'required',
		'max' => 'required|numeric|min:1'
	];

	public function household()
	{
		return $this->belongsTo('Household');
	}

	public function users()
	{
		return $this->belongsToMany('User');
	}

	public function toggle()
	{
		if(!$this->isValid())
			return false;

		$this->active = !$this->active;
		$this->save();
		return true;
	}

	public function isValid()
	{
		$validation = \Validator::make($this->attributes, $this->rules);
		if($validation->passes())
			return true;

		$this->errors = $validation->messages();
		return false;
	}

	public function generate()
	{
		
	}
}