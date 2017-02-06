<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenericSchedulerItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('generic_scheduler_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('scheduler_id')->unsigned();
			$table->integer('config_id')->unsigned();
			$table->timestamps();
			
			$table->foreign('scheduler_id')->references('id')->on('generic_schedulers')->onDelete('cascade');
			$table->foreign('config_id')->references('id')->on('generic_scheduler_configs')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('generic_scheduler_items');
	}

}
