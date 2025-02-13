<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date_of_birth')->nullable();
            $table->string('nationality')->nullable();
            $table->string('civility')->nullable();
            $table->string('study_level')->nullable();
            $table->string('phone')->nullable();
            $table->string('email');
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->text('resume')->nullable();
            $table->json('experience')->nullable();
            $table->json('education')->nullable();
            $table->json('languages')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('curriculums');
    }
};
