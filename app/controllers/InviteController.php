<?php

namespace Controllers;

class InviteController extends \BaseController
{
	public function remind($id)
	{
		$invite = \Invite::find($id);
		if(is_null(\Input::get('time')))
			$invite->remind = with(new \DateTime())->add(new \DateInterval('P1D'))->format('Y-m-d H:i:s');
		else
			$invite->remind = with(new \DateTime())->add(new \DateInterval('P0DT0H'.\Input::get('time').'M0S'));

		$invite->save();
	}

	public function ignore($id)
	{
		$invite = \Invite::find($id);
		$invite->read = true;
		$invite->save();
	}

	public function index()
	{
		$invites = \Invite::where('user_id', \Auth::user()->id)->get();
		return \View::make('households.invites', compact('invites'));
	}

	public function dismiss($id)
	{
		$invite = \Invite::find($id);

		if(\Auth::user()->id !== $invite->user->id && \Auth::user()->id !== $invite->origin->id)
			return \Redirect::route('households.invites')->with('flash_message', 'You do not have permission to do that');
		$invite->delete();

		return \Redirect::route('households.invites')->with('flash_message', 'You have successfully dismissed the invite');
	}

	public function accept($id)
	{
		$invite = \Invite::find($id);

		if(\Auth::user()->id !== $invite->user->id && \Auth::user()->id !== $invite->origin->id)
			return \Redirect::route('households.invites')->with('flash_message', 'You do not have permission to do that');

		$invite->accept();

		return \Redirect::route('households.invites')->with('flash_message', 'You are now a member of the '.$invite->household->name.' Household!');
	}
}