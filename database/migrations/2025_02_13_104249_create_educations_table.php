<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Casts\Attribute;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_id')->references('id')->on('curriculums')->onDelete('cascade');
            $table->string('level');
            $table->string('type');
            $table->string('status')->default('completed');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('school');
            $table->string('diploma')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educations');
    }

    protected function startDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? $value->format('Y-m-d') : null,
        );
    }

    protected function endDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? $value->format('Y-m-d') : null,
        );
    }
};
