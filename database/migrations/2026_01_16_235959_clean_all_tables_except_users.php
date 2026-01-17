<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // Tabelas Pivô
        DB::table('post_tag')->truncate();
        
        // Tabelas Principais
        DB::table('tags')->truncate();
        DB::table('posts')->truncate();
        DB::table('categories')->truncate();

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Irreversível (limpeza de dados)
    }
};
