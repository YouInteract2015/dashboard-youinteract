<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenericConfigItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('generic_config_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('config_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->boolean('status')->default( true );
			$table->integer('priority')->unsigned();
			$table->timestamps();
			
			$table->foreign('config_id')->references('id')->on('generic_configs')->onDelete('cascade');
			$table->foreign('item_id')->references('id')->on('generic_items')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('generic_config_items');
	}

}
