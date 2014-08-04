<?php

Route::get('chores', array('as' => 'chores.index', 'uses' => '\Controllers\ChoreController@index'));
