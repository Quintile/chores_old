<?php

class Room extends \Eloquent
{
	protected $guarded = array();

	public function chores()
	{
		return $this->hasMany('\Chore');
	}
	public function isValid()
	{
		$validation = \Validator::make($this->attributes,array('name' => "required|unique:rooms,name,NULL,id,household_id,".$this->household_id));
		if($validation->passes())
			return true;
		$this->errors = $validation->messages();
		return false;
	}
}