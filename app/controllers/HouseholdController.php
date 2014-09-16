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
		$household->admin_id = \Auth::user()->id;

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

		$generator = new \Generator();
		$generator->household_id = $household->id;
		$generator->save();


		return \Redirect::route('households.manage');
	}

	public function manage()
	{
		if(!\Auth::user()->households()->count())
			return \Redirect::route('home');

		return \View::make('households.manage');
	}

	

	public function leave($id)
	{
		$householdUser = \HouseholdUser::where('user_id', \Auth::user()->id)->where('household_id', $id)->first();
		$householdUser->delete();

		$household = \Household::find($id);

		//Delete any invites sent from this user, to this house
		$invites = \Invite::where('origin_id', \Auth::user()->id)->where('household_id', $id)->get();
		foreach($invites as $i)
			$i->delete();

		//If the user is the admin, pass on admin status to next person
		if($household->isAdmin(\Auth::user()->id))
		{
			$newAdmin = \HouseholdUser::where('household_id', $id)->orderBy('created_at')->first();
			if($newAdmin)
			{
				$household->admin_id = $newAdmin->user_id;
				$household->save();
			}
			else
			{
				//If the user is the only member, delete the household
				$this->delete($household->id);
			}
		}

		//If this was the user's active household, remove that status
		if(\Auth::user()->activeHousehold()->id === $id)
		{
			$user = \Auth::user();
			$user->household_id = null;
			$user->save();
		}

		return \Redirect::back()->with('flash_message', 'You have successfully left the household');
	}

	public function activate($id)
	{
		$user = \Auth::user();
		$user->household_id = $id;
		$user->save();

		return \Redirect::back()->with('flash_message', 'You have changed your active household');
	}

	public function delete($id)
	{
		$household = \Household::find($id);
		if(!$household->isAdmin(\Auth::user()->id))
			return \Redirect::back()->with('flash_message', 'You do not have permission to do that');

		//Delete all membership
		$members = \HouseholdUser::where('household_id', $household->id)->get();
		foreach($members as $m)
			$m->delete();

		//Delete all invites
		$invites = \Invite::where('household_id', $household->id)->get();
		foreach($invites as $i)
			$i->delete();

		//Users
		$users = \User::where('household_id', $household->id)->get();
		foreach($users as $u)
		{
			$u->household_id = null;
			$u->save();
		}

		//Generators
		$generators = \Generators::where('household_id', $household->id)->get();
		foreach($generators as $g)
		{
			$g->delete();
		}

		$household->delete();

		return \Redirect::back()->with('flash_message', 'Household permanently deleted');
	}

	public function admin($id, $user_id)
	{
		$user = \User::find($user_id);
		if(!$user->belongsToHousehold($id))
			return \Redirect::back()->with('error', 'That user does not belong to that household');
		$household = \Household::find($id);
		$household->admin_id = $user_id;
		$household->save();
		return \Redirect::back()->with('success', 'Admin has moved to '.$user->name);
	}

	public function generator($id)
	{
		$household = \Household::find($id);
		if(!$household->isAdmin(\Auth::user()->id))
			return \Redirect::to(\URL::previous()."#gen-".$id)->with('error', 'You do not have permission to do that');
		$toggle = $household->generator->toggle();

		if($toggle)
			return \Redirect::to(\URL::previous()."#gen-".$id)->with('success', 'Generator has been toggled successfully');
		else
			return \Redirect::to(\URL::previous()."#gen-".$id)->with('error', 'Unable to toggle generator. Save valid settings before toggling');

	}

	public function genSettings($id)
	{
		$household = \Household::find($id);
		if(!$household->isAdmin(\Auth::user()->id))
			return \Redirect::to(\URL::previous()."#gen-".$id)->with('error', 'You do not have permission to do that');

		$household->generator->type = \Input::get('generator-type');
		$household->generator->max = \Input::get('generator-max');
		if(!$household->generator->isValid())
			return \Redirect::to(\URL::previous()."#gen-".$id)->with('error', 'Invalid values supplied for generator settings');

		$household->generator->save();
		return \Redirect::to(\URL::previous()."#gen-".$id)->with('success', 'Successfully updated generator settings');
	}
}