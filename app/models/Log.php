<?php

class ChoreLog extends \Eloquent
{
	protected $table = 'logs';
	protected $guarded = array();

	public function __construct($chore_id = null, $user_id = null)
	{
		$this->chore_id = $chore_id;
		$this->user_id = $user_id;
	}

	public function chore()
	{
		return $this->belongsTo('\Chore');
	}
}