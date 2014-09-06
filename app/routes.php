<?php

Route::get('login', array('as' => 'login', 'uses' => '\Controllers\UserController@login'));
Route::post('login', array('as' => 'login.post', 'uses' => '\Controllers\UserController@loginPost'));
Route::get('register', array('as' => 'register', 'uses' => '\Controllers\UserController@register'));
Route::Post('register', array('as' => 'register.post', 'uses' => '\Controllers\UserController@registerPost'));


Route::group(array('before' => 'auth'), function()
{
	//Home
	Route::get('/', array('as' => 'home', 'uses' => '\Controllers\HomeController@index'));
	Route::get('logout', array('as' => 'logout', 'uses' => '\Controllers\UserController@logout'));

	//Chores
	Route::get('chores/add', array('as' => 'chores.add', 'uses' => '\Controllers\ChoreController@create'));
	Route::post('chores/add', array('as' => 'chores.add.post', 'uses' => '\Controllers\ChoreController@store'));
	

	//Rooms
	Route::get('rooms', array('as' => 'rooms.index', 'uses' => '\Controllers\RoomController@index'));
	Route::post('rooms', array('as' => 'rooms.store', 'uses' => '\Controllers\RoomController@store'));
	Route::get('rooms/{id}/delete', array('as' => 'rooms.delete', 'uses' => '\Controllers\RoomController@delete'));

	//Households
	Route::get('households/create', array('as' => 'households.create', 'uses' => '\Controllers\HouseholdController@create'));
	Route::post('households/create', array('as' => 'households.create.post', 'uses' => '\Controllers\HouseholdController@createPost'));
	Route::get('households/manage', array('as' => 'households.manage', 'uses' => '\Controllers\HouseholdController@manage'));
	Route::get('households/{id}/leave', array('as' => 'households.leave', 'uses' => '\Controllers\HouseholdController@leave'));
	Route::get('households/{id}/active', array('as' => 'households.active', 'uses' => '\Controllers\HouseholdController@activate'));
	Route::get('households/{id}/delete', array('as' => 'households.delete', 'uses' => '\Controllers\HouseholdController@delete'));
	Route::get('households/{id}/admin/{user}', array('as' => 'households.admin', 'uses' => '\Controllers\HouseholdController@admin'));
	
	//Invites
	Route::post('households/invite', array('as' => 'households.invite', 'uses' => '\Controllers\InviteController@invite'));
	Route::post('households/invites/remind/{id}', array('as' => 'households.invites.remind', 'uses' => '\Controllers\InviteController@remind'));
	Route::post('households/invites/ignore/{id}', array('as' => 'households.invites.ignore', 'uses' => '\Controllers\InviteController@ignore'));
	Route::get('households/invites', array('as' => 'households.invites', 'uses' => '\Controllers\InviteController@index'));
	Route::get('households/invites/{id}/dismiss', array('as' => 'households.invites.dismiss', 'uses' => '\Controllers\InviteController@dismiss'));
	Route::get('households/invites/{id}/accept', array('as' => 'households.invites.accept', 'uses' => '\Controllers\InviteController@accept'));

	//Preferences
	Route::post('preferences', array('as' => 'preferences.ajax', 'uses' => '\Controllers\PreferenceController@set'));
	Route::get('preferences', array('as' => 'preferences', 'uses' => '\Controllers\PreferenceController@index'));
});