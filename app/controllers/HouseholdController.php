<?php

namespace Controllers;

class HouseholdController extends \BaseController
{
	public function create()
	{
		return \View::make('households.create');
	}

	public function createPost()
	{
		$household = new \Household();
		$household->name = \Input::get('household-name');
		$household->user_id = \Auth::user()->id;

		if(!$household->isValid())
			return \Redirect::back()->with('flash_message', 'Household name must be unique. That household name already exists.');

		$household->save();

		$userHousehold = new \HouseholdUser();
		$userHousehold->user_id = \Auth::user()->id;
		$userHousehold->household_id = $household->id;
		$userHousehold->save();

		if(is_null(\Auth::user()->household_id))
		{
			$user = \Auth::user();
			$user->household_id = $household->id;
			$user->save();
		}

		return \Redirect::route('households.manage');
	}

	public function manage()
	{
		return \View::make('households.manage');
	}

	public function invite()
	{
		$user = \User::where('email', \Input::get('household-add-email'))->first();
		if(!$user)
			return \Redirect::back()->with('flash_message', 'That email was not found to belong to a user.');

		$invite = new \Invite();
		$invite->origin_id = \Auth::user()->id;
		$invite->household_id = \Input::get('household-id');
		$invite->user_id = $user->id;

		$invite->save();

		$invite->email();

		return \Redirect::back()->with('flash_message', 'User has been invited and membership is pending');

	}

	public function leave($id)
	{
		$householdUser = \HouseholdUser::where('user_id', \Auth::user()->id)->where('household_id', $id)->first();
		$householdUser->delete();
		return \Redirect::back()->with('flash_message', 'You have successfully left the household');
	}
}