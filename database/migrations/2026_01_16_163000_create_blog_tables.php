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
        // Posts Table
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
                $table->string('title');
                $table->string('slug')->unique();
                $table->string('subtitle')->nullable(); // Adicionado aqui
                $table->text('content');
                $table->string('featured_image')->nullable();
                $table->string('featured_image_caption')->nullable(); // Adicionado aqui
                $table->string('status')->default('draft');
                $table->timestamp('published_at')->nullable();
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->string('focus_keyword')->nullable();
                $table->integer('read_time')->nullable();
                $table->integer('word_count')->nullable();
                $table->integer('views')->default(0);
                $table->timestamps();
            });
        } else {
             Schema::table('posts', function (Blueprint $table) {
                if (!Schema::hasColumn('posts', 'subtitle')) {
                    $table->string('subtitle')->nullable();
                }
                if (!Schema::hasColumn('posts', 'featured_image_caption')) {
                    $table->string('featured_image_caption')->nullable();
                }
            });
        }

        // Categories Table (if not exists)
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('description')->nullable();
                $table->string('color')->nullable();
                $table->string('icon')->nullable();
                $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('set null');
                $table->timestamps();
            });
        }

        // Tags Table
        if (!Schema::hasTable('tags')) {
            Schema::create('tags', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }

        // Post Tags Pivot Table
        if (!Schema::hasTable('post_tags')) {
            Schema::create('post_tags', function (Blueprint $table) {
                $table->id();
                $table->foreignId('post_id')->constrained()->onDelete('cascade');
                $table->foreignId('tag_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_tags');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('categories');
    }
};
