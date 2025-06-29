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
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('designation');
            $table->string('department');
            $table->string('faculty_id')->unique();
            $table->string('email')->unique();
            $table->string('initial')->unique();
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->string('profile_picture')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};
