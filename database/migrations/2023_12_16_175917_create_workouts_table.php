<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* Run the migrations. */
    public function up(): void
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('exercise_id');
            $table->integer('repetitions');
            $table->decimal('weight', 5, 2); // No máx 5 digitos, 2 casas decimais
            $table->integer('break_time');
            $table->enum('day', ['SEGUNDA', 'TERÇA', 'QUARTA', 'QUINTA', 'SEXTA', 'SÁBADO', 'DOMINGO']);
            $table->text('observations')->nullable();
            $table->integer('time');
            $table->timestamps();
        });
    }

    /* Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('workouts');
    }
};
