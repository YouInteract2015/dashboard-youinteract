<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenericConfigsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('generic_configs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('template_id')->unsigned();
			$table->integer('scheduler_id')->unsigned();
			$table->string('title');
			$table->text('description');
			$table->boolean('default');
			$table->boolean('status')->default( true );
			$table->timestamps();
			
			$table->foreign('template_id')->references('id')->on('generic_templates')->onDelete('cascade');
			$table->foreign('scheduler_id')->references('id')->on('generic_schedulers')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('generic_configs');
	}

}
