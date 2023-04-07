<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->string('id', 8)->unique();
            $table->primary('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->integer('age')->unsigned();
            $table->string('department');
            $table->string('position');
            $table->timestamps();
        });

        DB::unprepared(file_get_contents('app/employee_init.sql'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
