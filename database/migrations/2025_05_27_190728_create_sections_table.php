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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('section_number');
            $table->json('day')->nullable(); 
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable(); 
            $table->string('room')->nullable(); 

            // Foreign key: course_code (string, assuming course_code is a string in courses table)
            $table->string('course_code');
            $table->foreign('course_code')
                ->references('course_code')->on('courses')
                ->onDelete('cascade');

            // Foreign key: faculty_id (nullable unsignedBigInteger, assuming id is primary in faculties)
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->foreign('faculty_id')
                ->references('id')->on('faculties')
                ->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
