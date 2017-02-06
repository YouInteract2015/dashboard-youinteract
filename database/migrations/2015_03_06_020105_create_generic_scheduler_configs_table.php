<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenericSchedulerConfigsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('generic_scheduler_configs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('template_id')->unsigned();
			$table->string('title');
			$table->text('description');
			$table->boolean('status')->default( true );
			$table->timestamp('startat');
			$table->timestamp('endat');
			$table->boolean('monday')->default( true );
			$table->boolean('tuesday')->default( true );
			$table->boolean('wednesday')->default( true );
			$table->boolean('thursday')->default( true );
			$table->boolean('friday')->default( true );
			$table->boolean('saturday')->default( true );
			$table->boolean('sunday')->default( true );
			$table->integer('starthour');
			$table->integer('endhour');
			$table->integer('startminute');
			$table->integer('endminute');
			$table->integer('startsecond');
			$table->integer('endsecond');
			$table->timestamps();
			
			$table->foreign('template_id')->references('id')->on('generic_templates')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('generic_scheduler_configs');
	}

}
