<?php

namespace Models;

class Chore extends \Eloquent
{
	protected $guarded = array();

	public function room()
	{
		return $this->belongsTo('\Models\Room');
	}

	public function days()
	{
		if(is_null($this->lastdone))
			return null;

		$now = new \DateTime();
		$diff = $now->diff(new \DateTime($this->lastdone))->format("%a");
		return $diff;
	}

	public function priority()
	{
		if(is_null($this->days()))
			$days = $this->frequency;
		else
			$days = $this->days();

		$priority = $days / $this->frequency;
		
		return number_format($priority, 2);
	}

	public function urgency()
	{
		$priority = $this->priority();
		if($priority >= 1 )
			return "danger";

		if($priority >= 0.8 && $priority < 1)
			return "warning";

		return null;
	}
}