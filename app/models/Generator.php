<?php

namespace Chores;

class Generator extends \Eloquent
{
	protected $guarded = array();

	private $pool = array();

	private $rules = [
		'type' => 'required',
		'max' => 'required|numeric|min:1'
	];

	public function household()
	{
		return $this->belongsTo('Household');
	}

	public function users()
	{
		return $this->belongsToMany('User');
	}

	public function toggle()
	{
		if(!$this->isValid())
			return false;

		$this->active = !$this->active;
		$this->save();
		return true;
	}

	public function isValid()
	{
		$validation = \Validator::make($this->attributes, $this->rules);
		if($validation->passes())
			return true;

		$this->errors = $validation->messages();
		return false;
	}

	public function generate()
	{

		//Clear any assignments already generated today but not completed
		//they don't count as not completed because you are re-generating
		$this->clearAssignments();

		//Get a pool of chores ordered by priority
		$this->pool = $this->household->chorePool();

		foreach($this->pool as $chore)
			$this->assign($chore);
		
	}

	public function clearAssignments()
	{
		
		foreach($this->household->chorePool() as $c)
		{
			$results = \Assignment::where('chore_id', $c->id)->
						where('generated', true)->
						where('created_at', 'LIKE', with(new \DateTime())->format('Y-m-d').'%')->
						whereNull('completed_at')->get();

			foreach($results as $a)
			{
				$a->delete();
			}
		}
	}

	private function userPool()
	{
		$users = $this->household->users;
		$results = array();
		foreach($users as $u)
		{
			$results[] = $u;
		}
		return $results;
	}

	private function assign(\Chore $chore)
	{
		$users = $this->userPool();
		
		while(count($users))
		{
			$random = mt_rand(0, count($users)-1);
			$selected = $users[$random];

			//Check if the random user can take the chore
			if($this->type == "count")
			{
				if($selected->assignedTotal($this->type) + 1 > $this->max)
				{
					unset($users[$random]);
					$users = array_values($users);
					continue;
				}
				
			}
			else
			{
				$type = $this->type;
			
				if($selected->assignedTotal($this->type) + $chore->{$this->type} > $this->max)
				{
					unset($users[$random]);
					$users = array_values($users);
					continue;
				}
				
			}

			$chore->claim($selected->id, true);
			return $selected->id;
		}

		return false;
	}

	public function subscribes($userid = null)
	{
		if($userid == null && !\Auth::check())
			return null;

		if($userid == null)
			$userid = \Auth::user()->id;

		foreach($this->users as $u)
			if($u->id == $userid)
			{
				$active = \GeneratorUser::where('user_id', $u->id)->where('generator_id', $this->id)->first()->active;
				return $active;

			}
				
		return false;
	}
}