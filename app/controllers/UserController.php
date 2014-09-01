<?php

namespace Controllers;

class UserController extends \BaseController
{
	public function login()
	{
		return \View::make('home.login');
	}

	public function loginPost()
	{
		$attempt = \Auth::attempt([
			'email' => \Input::get('login-email'),
			'password' => \Input::get('login-password')
		]);

		if($attempt)
			return \Redirect::intended('/');

		return \Redirect::back()->with('flash_message', 'Invalid credentials')->withInput();
	}

	public function logout()
	{
		\Auth::logout();
		return \Redirect::route('login');
	}

	public function register()
	{
		return \View::make('home.register');
	}

	public function registerPost()
	{
		if(\Input::get('register-password') !== \Input::get('register-password2'))
			return \Redirect::back()->with('flash_message', 'Passwords did not match up')->withInput();

		$user = new \User();
		$user->name = \Input::get('register-name');
		$user->email = \Input::get('register-email');
		$user->password = \Hash::make(\Input::get('register-password'));

		if(!$user->isValid())
			return \Redirect::back()->with('flash_message', 'A required field was missing')->withInput();

		$user->save();
		return \Redirect::route('login')->with('user', $user->email);
	}
}