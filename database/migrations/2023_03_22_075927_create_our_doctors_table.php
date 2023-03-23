<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
			Schema::create('our_doctors', function (Blueprint $table) {
				$table->id();
				$table->string('title');
				$table->string ('name');
				$table->string('email');
				$table->string('specialist');
				$table->text('description');
				$table->text('work_experience');
				$table->timestamps();
			});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
			Schema::dropIfExists ('our_doctors');
    }
};
