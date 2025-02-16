<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_id')->references('id')->on('curriculums')->onDelete('cascade');
            $table->string('title');
            $table->string('company');
            $table->string('location');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('experiences');
    }
};
