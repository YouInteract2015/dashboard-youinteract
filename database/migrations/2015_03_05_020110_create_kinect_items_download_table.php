<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKinectItemsDownloadTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kinect_items_download', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('device_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->string('version');
			$table->timestamps();
			
			$table->foreign('device_id')->references('id')->on('kinect_devices')->onDelete('cascade');
			$table->foreign('item_id')->references('id')->on('kinect_items')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('kinect_items_download');
	}

}
