<?php

class Assignment extends \Eloquent
{
	protected $guarded = array();

	public function chore()
	{
		return $this->hasOne('\Chore');
	}
}