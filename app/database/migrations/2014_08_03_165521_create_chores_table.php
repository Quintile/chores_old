<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('room_id');
			$table->string("name");
			$table->text("description")->nullable();
			$table->integer("duration");
			$table->integer('frequency');
			$table->integer('importance');
			$table->integer('user_id')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('chores');
	}

}
