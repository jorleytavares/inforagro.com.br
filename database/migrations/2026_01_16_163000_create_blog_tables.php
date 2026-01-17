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
        // 1. Categories Table (Must come first because posts reference it)
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('description')->nullable();
                $table->string('color')->nullable();
                $table->string('icon')->nullable();
                // Self-referencing FK needs to be careful, but since it references same table, it's fine if table is consistent
                $table->foreignId('parent_id')->nullable()->references('id')->on('categories')->onDelete('set null');
                $table->timestamps();
            });
        }

        // 2. Tags Table
        if (!Schema::hasTable('tags')) {
            Schema::create('tags', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }

        // 3. Posts Table
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
                // Now categories definitely exists
                $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
                $table->string('title');
                $table->string('slug')->unique();
                $table->string('subtitle')->nullable();
                $table->text('content');
                $table->string('featured_image')->nullable();
                $table->string('featured_image_caption')->nullable();
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

        // 4. Post Tags Pivot Table (Dependes on posts and tags)
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
