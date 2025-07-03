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
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->text('short_description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->dateTime('published_at')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('languages', function (Blueprint $table) {
            $table->string('locale')->primary();
            $table->string('name');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        Schema::create('post_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('post_id')->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->text('short_description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->unique(['post_id', 'locale']);
        });

        Schema::create('post_category', function (Blueprint $table) {
            $table->foreignUuid('post_id')->constrained('posts')->cascadeOnDelete();
            $table->foreignUuid('category_id')->constrained('categories')->cascadeOnDelete();

            $table->primary(['post_id', 'category_id']);
        });

        Schema::create('media', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('file_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->double('width')->nullable();
            $table->double('height')->nullable();
            $table->string('orientation')->nullable();
            $table->string('path')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->json('custom_properties')->nullable();

            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('body')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->dateTime('published_at')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('page_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type'); // e.g. 'text', 'image', 'video', 'cta'
            $table->integer('order')->default(0); // for sorting
            $table->json('settings')->nullable(); // custom config for the block
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_posts');
    }
};
