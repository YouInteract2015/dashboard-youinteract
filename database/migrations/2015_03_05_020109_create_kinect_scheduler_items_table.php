<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKinectSchedulerItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kinect_scheduler_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('config_id')->unsigned();
			$table->integer('scheduler_id')->unsigned();
			$table->boolean('status')->default( true );
			$table->integer('priority')->unsigned;
			$table->timestamps();
			
			$table->foreign('config_id')->references('id')->on('kinect_scheduler_configs')->onDelete('cascade');
			$table->foreign('scheduler_id')->references('id')->on('kinect_schedulers')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('kinect_scheduler_items');
	}

}
