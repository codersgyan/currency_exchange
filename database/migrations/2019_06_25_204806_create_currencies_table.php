<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('currencies', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('currency_id');
			$table->string('currency_code');
			$table->string('currency_name');
			$table->unsignedInteger('nominal');
			$table->decimal('value', 8, 4);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('currencies');
	}
}
