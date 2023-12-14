<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*Run the migrations.*/
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('date_birth')->required();
            $table->string('cpf', 14)->unique()->required();
            $table->unsignedBigInteger('plan_id')->required();
            $table->foreign('plan_id')->references('id')->on('plans');
        });
    }

    /* Reverse the migrations.*/
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('date_birth');
            $table->dropColumn('cpf');
            $table->dropForeign(['plan_id']);
            $table->dropColumn('plan_id');
        });
    }
};
