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
            $table->increments('id');
            $table->string('title')->unique();
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('publisher_id');
            $table->foreign('author_id')->references('id')->on('authors')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('publisher_id')->references('id')->on('publishers')->cascadeOnDelete();
            $table->string('ISBN')->nullable();
            $table->string('book_description')->nullable()->default('');
            $table->date('publication_date');
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('visits_time')->default(0);
            $table->integer('downloads_time')->default(0);
            $table->integer('comments_time')->default(0);
            $table->string('pages_number');
            $table->string('chapters_number');
            $table->string('download_size');
            $table->decimal('rating')->default(0.0);
            $table->integer('rater_number')->default(0);
            $table->string('book_image')->nullable();
            $table->string('book_file');
            $table->timestamps();
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
