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

	public function daysString()
	{
		if(is_null($this->days()))
			return "Never";
		elseif($this->days() > 0)
			return $this->days()." Days";
		elseif($this->days() == '0')
			return "Today";
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

	public function frequencyString()
	{
		switch($this->frequency)
		{
			case 1:
				return "Daily";

			case 2:
				return "Every Other Day";

			case 4:
				return "Twice A Week";

			case 7:
				return "Weekly";

			case 14:
				return "Bi-Weekly";

			case 30:
				return "Monthly";

			default:
				return $this->frequency;
		}
	}
}