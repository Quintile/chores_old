<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('chores', function(Blueprint $table)
		{
			//$table->dropColumn('claim_id');
			//$table->dropColumn('score');
			//$table->dropColumn('completed_at');

		});

		Schema::table('assignments', function(Blueprint $table)
		{
			$table->dropColumn('completed');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('chores', function(Blueprint $table)
		{
			//$table->integer('claim_id');
			//$table->integer('score');
			//$table->timestamp('completed_at');
		});

		Schema::table('assignments', function(Blueprint $table)
		{
			$table->boolean('completed')->default(0);
		});
	}

}
