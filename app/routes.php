<?php

Route::get('login', array('as' => 'login', 'uses' => '\Controllers\UserController@login'));
Route::post('login', array('as' => 'login.post', 'uses' => '\Controllers\UserController@loginPost'));
Route::get('register', array('as' => 'register', 'uses' => '\Controllers\UserController@register'));
Route::Post('register', array('as' => 'register.post', 'uses' => '\Controllers\UserController@registerPost'));


Route::group(array('before' => 'auth'), function()
{
	Route::get('/', array('as' => 'home', 'uses' => '\Controllers\HomeController@index'));
	Route::get('logout', array('as' => 'logout', 'uses' => '\Controllers\UserController@logout'));

	//Households
	Route::get('households/create', array('as' => 'households.create', 'uses' => '\Controllers\HouseholdController@create'));
	Route::post('households/create', array('as' => 'households.create.post', 'uses' => '\Controllers\HouseholdController@createPost'));
	Route::get('households/manage', array('as' => 'households.manage', 'uses' => '\Controllers\HouseholdController@manage'));
	Route::post('households/invite', array('as' => 'households.invite', 'uses' => '\Controllers\HouseholdController@invite'));
	Route::get('households/{id}/leave', array('as' => 'households.leave', 'uses' => '\Controllers\HouseholdController@leave'));

	//Invites
	Route::post('households/invites/remind/{id}', array('as' => 'households.invites.remind', 'uses' => '\Controllers\InviteController@remind'));
	Route::post('households/invites/ignore/{id}', array('as' => 'households.invites.ignore', 'uses' => '\Controllers\InviteController@ignore'));
	Route::get('households/invites', array('as' => 'households.invites', 'uses' => '\Controllers\InviteController@index'));
	Route::get('households/invites/{id}/dismiss', array('as' => 'households.invites.dismiss', 'uses' => '\Controllers\InviteController@dismiss'));
	Route::get('households/invites/{id}/accept', array('as' => 'households.invites.accept', 'uses' => '\Controllers\InviteController@accept'));
});