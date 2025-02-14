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
            $table->foreignId('curriculum_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->date('startDate');
            $table->date('endDate');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('experiences');
    }
};
