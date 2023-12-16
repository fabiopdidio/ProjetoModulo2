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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->required();
            $table->string('email', 255)->unique()->required();
            $table->date('date_birth')->required();
            $table->string('cpf', 14)->unique()->required();
            $table->string('contact', 20)->required();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('city', 50)->required();
            $table->string('neighborhood', 50)->required();
            $table->string('number', 30)->required();
            $table->string('street', 30)->required();
            $table->string('state', 2)->required();
            $table->string('cep', 20)->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
