<?php

class Chore extends Eloquent
{
	use SoftDeletingTrait;

	protected $guarded = array();

	private function getImportance()
	{
		return $this->hasMany('\Importance');
	}

	public function room()
	{
		return $this->belongsTo('\Room');
	}

	public function household()
	{
		return $this->room->household;
	}

	public function owner()
	{
		return $this->hasOne('\User');
	}

	private function lastDone()
	{
		$log = \ChoreLog::where('chore_id', $this->id)->
							orderBy('created_at', 'DESC')->
							first();
		return ($log) ? $log->created_at : null;
	}

	public function days()
	{
		if(is_null($this->lastDone()))
			return null;

		$now = new \DateTime();
		$diff = $now->diff(new \DateTime($this->lastDone()))->format("%a");
		return $diff;
	}

	public function daysString()
	{
		$days = $this->days();
		if(is_null($days))
			return "Never";
		if($days == 0)
			return "Today";
		if($days == 1)
			return $days." Day";
		if($days > 1)
			return $days." Days";
	}

	public function priority()
	{
		//Grab the days since its been last done
		$days = $this->days();

		if(is_null($days))
			$days = $this->frequency;

		//Base priority is the number of days since it was done
		//divided by the frequency it should be done.
		$priority = $days / $this->frequency;
		
		//The priority needs to be altered depending on it's importance
		$importance = $this->importance() / 2;
		$priority = $priority * ($importance / 10.0 + 1);

		return number_format($priority, 2);
	}

	public function score()
	{
		return round($this->priority() * 1050.50);
	}

	public function claim()
	{
		$this->claim_id = \Auth::user()->id;
		$this->save();
	}

	public function claimer()
	{
		$user = \User::find($this->claim_id);
		if($user)
			return $user->name;
		return null;
	}
/*
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
	*/

	public function personalImportance()
	{
		$import = \Importance::where('user_id', \Auth::user()->id)->where('chore_id', $this->id)->first();
		return ($import) ? $import->importance : null;
	}

	public function importance()
	{
		if(!$this->getImportance()->count())
			return null;

		if(\Preference::check('household-pref-importance') == 'average')
		{
			$sum = 0;
			foreach($this->getImportance()->get() as $i)
				$sum += $i->importance;
			
			return $sum / $this->getImportance()->count();
		}
		else
		{
			$import = $this->getImportance()->where('user_id', $this->user_id)->first();
			if($import)
				return $import->importance;
			else
				return null;
		}

		
	}
}