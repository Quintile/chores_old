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

	public function households()
	{
		return $this->belongsToMany('Household');
	}

	public function invites()
	{
		return $this->hasMany('Invite');
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

	public function activeHousehold()
	{
		return \Household::where('id', $this->household_id)->first();
	}

	public function hasActiveHousehold()
	{
		$house = $this->activeHousehold();
		return ($house) ? true : false;
	}
}
