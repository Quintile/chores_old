<?php

class Assignment extends \Eloquent
{
	protected $guarded = array();

	public function chore()
	{
		return $this->belongsTo('\Chore');
	}

	public function user()
	{
		return $this->belongsTo('\User');
	}
}