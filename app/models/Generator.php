<?php

namespace Chores;

class Generator extends \Eloquent
{
	protected $guarded = array();
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
		foreach($this->household->users as $u)
		{
			
		}
	}

	public function subscribes($userid = null)
	{
		if($userid == null)
			$userid = \Auth::user()->id;

		foreach($this->users as $u)
			if($u->id == $userid)
				$active = \GeneratorUser::where('user_id', $u->id)->where('generator_id', $this->id)->first()->active;
				return $active;
		return false;
	}
}