<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $table = 'users';

	protected $hidden = array('password', 'remember_token');

	public static $rules = [
		'email' => 'required|email|unique:users,email',
		'password' => 'required',
		'name' => 'required'
	];

	public $errors;

	public function isValid()
	{
		$validation = \Validator::make($this->attributes, self::$rules);

		if($validation->passes())
			return true;
		$this->errors = $validation->messages();
		return false;
	}

	public function generators()
	{
		return $this->belongsToMany('\Chores\Generator');
	}

	public function households()
	{
		return $this->belongsToMany('Household');
	}

	public function assignments()
	{
		return $this->hasMany('\Assignment');
	}

	public function invites()
	{
		return $this->hasMany('Invite');
	}

	public function sentInvites()
	{
		return $this->hasMany('Invite', 'origin_id');
	}

	public function hasUnreadInvites()
	{
		$invites = $this->invites()->where('read', false)->where('remind', '<=', with(new DateTime())->format('Y-m-d H:i:s'))->count();
		if(!$invites)
			return $this->invites()->where('read', false)->whereNull('remind')->count();
	}

	public function unreadInvites()
	{
		return $this->invites()->where('read', false)->get();
	}

	public function markInvitesRead()
	{
		foreach($this->invites as $i)
		{
			$i->read = true;
			$i->save();
		}
	}

	public function assigned($generatorOnly = false)
	{
		$household_id = $this->activeHousehold()->id;

		$results = \Assignment::whereNull('completed_at')->where('user_id', $this->id)->where('created_at', 'LIKE', with(new \DateTime())->format('Y-m-d').'%');
		if($generatorOnly)
			$results = $results->where('generated', true);

		$results = $results->get();
		return $results;		
		$specific = array();

		return $specific;
	}

	public function assignedTotal($property)
	{
		if($property == "count")
			return count($this->assigned(true));

		$total = 0;
		foreach($this->assigned(true) as $assignment)
		{
			$total += $assignment->chore->$property;
		}

		return $total;
	}


	public function activeHousehold()
	{
		return \Household::where('id', $this->household_id)->first();
	}

	public function hasActiveHousehold()
	{
		$house = $this->activeHousehold();
		return ($house) ? true : false;
	}

	public function belongsToHousehold($house_id)
	{
		$result = $this->households()->where('household_id', $house_id)->first();
		if($result)
			return true;
		else
			return false;
	}

	public function score()
	{
		$score = 0;
		$assignments = $this->assignments()->whereNotNull('completed_at')->where('created_at', '>', with(new \DateTime('Last Saturday'))->format('Y-m-d'))->where('created_at', '<=', with(new \DateTime('This Saturday'))->format('Y-m-d'))->get();
		foreach($assignments as $ass)
			$score += $ass->score;
	
		return $score;
	}

	public function scoreAllTime()
	{
		$score = 0;
		$assignments = $this->assignments()->whereNotNull('completed_at')->get();
		foreach($assignments as $ass)
			$score += $ass->score;
		return $score;
	}

	public function rank()
	{
		$ranks = $this->activeHousehold()->ranks();
		
		foreach($ranks as $index => $r)
		{
			if($r->id == $this->id)
				return $index + 1;
		}

		return null;
	}

	public static function scoreCompare($a, $b)
	{
		if($a->score() == $b->score())
			return 0;
		return ($a->score() > $b->score()) ? -1 : 1;
	}

}
