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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('author_id');
            $table->string('isbn')->unique();
            $table->year('published_year');
            $table->string('genre');
            $table->text('summary');
            $table->timestamps();

            // Add foreign key constraint if you have authors table
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
        });
    }


        /**
         * Reverse the migrations.
         */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};