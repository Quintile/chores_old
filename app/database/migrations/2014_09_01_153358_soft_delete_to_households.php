<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SoftDeleteToHouseholds extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('households', function(Blueprint $table)
		{
			$table->softDeletes();
			$table->integer('admin_id')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('households', function(Blueprint $table)
		{
			$table->dropColumn('deleted_at');
			$table->dropColumn('admin_id');
		});
	}

}
