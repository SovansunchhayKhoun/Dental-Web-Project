<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Schema;
	use mysql_xdevapi\ColumnResult;
	
	return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
						$table->string('firstName');
						$table->string ('lastName');
						$table->string('fullName');
						$table->string('phoneNum');
						$table->string('email');
						$table->date ('birthday') -> nullable ();
						$table->date('appointmentDate') -> nullable ();
						$table->text('message')->nullable ();
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
        Schema::dropIfExists('appointments');
    }
};