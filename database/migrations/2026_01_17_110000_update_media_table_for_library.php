<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('media')) {
            return;
        }

        Schema::table('media', function (Blueprint $table) {
            if (! Schema::hasColumn('media', 'title')) {
                $table->string('title')->nullable()->after('id');
            }

            if (! Schema::hasColumn('media', 'file_path')) {
                $table->string('file_path')->after('title');
            }

            if (! Schema::hasColumn('media', 'disk')) {
                $table->string('disk')->default('public')->after('size');
            }

            if (! Schema::hasColumn('media', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('media')) {
            return;
        }

        Schema::table('media', function (Blueprint $table) {
            if (Schema::hasColumn('media', 'file_path')) {
                $table->dropColumn('file_path');
            }

            if (Schema::hasColumn('media', 'title')) {
                $table->dropColumn('title');
            }

            if (Schema::hasColumn('media', 'disk')) {
                $table->dropColumn('disk');
            }

            if (Schema::hasColumn('media', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
        });
    }
};

