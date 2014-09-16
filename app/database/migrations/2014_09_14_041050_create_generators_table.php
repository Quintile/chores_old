<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneratorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('generators', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('household_id');
			$table->boolean('active')->default(0);
			$table->string('type')->default('duration');
			$table->integer('max')->default(0);
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
		Schema::drop('generators');
	}

}
