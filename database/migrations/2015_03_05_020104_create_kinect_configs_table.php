<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKinectConfigsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kinect_configs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('template_id')->unsigned();
			$table->integer('scheduler_id')->unsigned();
			$table->string('title');
			$table->text('description');
			$table->boolean('default');
			$table->boolean('status')->default( true );
			$table->timestamps();
			
			$table->foreign('template_id')->references('id')->on('kinect_templates')->onDelete('cascade');
			$table->foreign('scheduler_id')->references('id')->on('kinect_schedulers');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('kinect_configs');
	}

}
