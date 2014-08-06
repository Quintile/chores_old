<?php

namespace Models;

class Log extends \Eloquent
{
	protected $guarded = array();

	public function __construct($chore_id = null, $user_id = null)
	{
		$this->chore_id = $chore_id;
		$this->user_id = $user_id;
	}

	public function chore()
	{
		return $this->belongsTo('Chore');
	}
}