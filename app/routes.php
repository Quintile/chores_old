<?php

Route::get('chores', array('as' => 'chores.index', 'uses' => '\Controllers\ChoreController@index'));
Route::get('chore/{id}/take', array('as' => 'chores.take', 'uses' => '\Controllers\ChoreController@take'));