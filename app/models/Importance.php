<?php

class Importance extends \Eloquent
{
	protected $guarded = array();

	public function __construct($chore = null, $importance = null)
	{
		if(is_object($chore) && get_class($chore) == 'Chore')
		{
			$this->chore_id = $chore->id;
			$this->user_id = $chore->user_id;
			$this->importance = $importance;
		}
	}
}