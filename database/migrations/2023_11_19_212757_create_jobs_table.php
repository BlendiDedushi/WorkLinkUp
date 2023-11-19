<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('schedule_id');
            $table->string('title');
            $table->text('description');
            $table->integer('positions');
            $table->float('salary');
            $table->boolean('remote')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('schedule_id')->references('id')->on('schedules');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
