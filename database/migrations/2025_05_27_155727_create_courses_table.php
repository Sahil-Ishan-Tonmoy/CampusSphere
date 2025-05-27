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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('course_name')->unique();
            $table->string('course_code')->unique();
            $table->string('department')->nullable();
            $table->text('description')->nullable();
            $table->integer('credit')->nullable();
            $table->bigInteger('co-ordinator_id')->unsigned()->nullable();
            $table->foreign('co-ordinator_id')
                  ->references('id')->on('faculties')
                  ->onDelete('set null'); // Assuming you have a faculties table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
