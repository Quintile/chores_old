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

	public function assignments()
	{
		return $this->hasMany('\Assignment');
	}

	private function lastDone()
	{
		$assignment = \Assignment::where('chore_id', $this->id)->whereNotNull('completed_at')->orderBy('completed_at', 'DESC')->first();
		return ($assignment) ? $assignment->completed_at : null;
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

	public function doneToday()
	{
		return ($this->days() === '0') ? true : false;
	}

	public function lastDoneBy()
	{
		$assignment = $this->assignments()->orderBy('completed_at', 'DESC')->first();
		if($assignment)
			return $assignment->user->name;
		return null;
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
		$days = (is_null($this->days())) ? $this->frequency : $this->days();
		$score = ($this->priority() * 100.0 + (round($this->duration / 10.0)) + $days * 20) /2;
		if($this->frequency == 1)
			return round($score / 2);
		else
			return round($score);
	}

	public function claim($user_id = null, $generated = false)
	{

		if(is_null($user_id))
			$user_id = \Auth::user()->id;

		//Check if the user has already claimed the chore
		$assignment = \Assignment::where('user_id', $user_id)
						->where('chore_id', $this->id)
						->where('created_at', 'LIKE', with(new DateTime())->format('Y-m-d').'%')
						->first();
		
		if($assignment)
			return false;

		$assignment = new \Assignment();
		$assignment->chore_id = $this->id;
		$assignment->user_id = $user_id;
		$assignment->generated = $generated;
		$assignment->save();

		return true;
		
	}

	public function claimer()
	{

		$assignment = \Assignment::where('chore_id', $this->id)->whereNull('completed_at')->where('created_at', 'LIKE', with(new \DateTime())->format('Y-m-d').'%')->first();
		if($assignment)
			return $assignment->user->name;
		
		return null;
	}

	public static function priorityCompare(\Chore $a, \Chore $b)
	{
		if($a->priority() == $b->priority())
			return 0;
		return ($a->priority() < $b->priority()) ? -1 : 1;
	}

	public static function priorityCompareDesc(\Chore $a, \Chore $b)
	{
		if($a->priority() == $b->priority())
			return 0;
		return ($b->priority() < $a->priority()) ? -1 : 1;
	}

	public function finish($user_id = null)
	{
		if(is_null($user_id))
			$user_id = \Auth::user()->id;

		//Check if the user has already claimed the chore
		$assignment = \Assignment::where('user_id', $user_id)
						->where('chore_id', $this->id)
						->where('created_at', 'LIKE', with(new DateTime())->format('Y-m-d').'%')
						->first();
		if(!$assignment)
			return false;

		$assignment->score = $this->score();
		$assignment->completed_at = with(new DateTime())->format('Y-m-d G:i:s');
		$assignment->save();

		return \Redirect::back()->with('success', 'Successfully finished a chore');
	}

	public function alertStatus()
	{
		$priority = $this->priority();
		if($priority >= 1)
			return 'danger';
		if($priority >= 0.8)
			return 'warning';
		if($priority < 0.8)
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