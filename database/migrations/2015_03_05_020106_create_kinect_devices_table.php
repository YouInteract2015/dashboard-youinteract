<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKinectDevicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kinect_devices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('config_id')->unsigned();
			$table->string('title');
			$table->text('description');
			$table->string('location');
			$table->string('ip'); // Need to check if it is ipv4 or ipv6, no need to make both
			$table->boolean('status');
			$table->timestamps();
			
			$table->foreign('config_id')->references('id')->on('kinect_configs')->onDelete('cascade'); // cascade will delete dependencies, need to rethink this... Maybe in the controller instead of here.
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('kinect_devices');
	}

}
