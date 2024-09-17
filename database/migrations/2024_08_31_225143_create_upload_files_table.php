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
        Schema::create('upload_files', function (Blueprint $table) {
            $table->id();
            $table->string('userid');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('gender');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->date('dob')->nullable();
            $table->string('jobTitle')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload_files');
    }
};
