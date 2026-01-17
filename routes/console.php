<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:wipe-data', function () {
    if (app()->environment('production')) {
        $this->error('This command cannot be run in production.');

        return 1;
    }

    if (! $this->confirm('This will truncate posts, tags and categories. Do you wish to continue?')) {
        $this->info('Operation cancelled.');

        return 0;
    }

    Schema::disableForeignKeyConstraints();

    $tables = ['post_tag', 'tags', 'posts', 'categories'];

    foreach ($tables as $table) {
        if (Schema::hasTable($table)) {
            DB::table($table)->truncate();
        }
    }

    Schema::enableForeignKeyConstraints();

    $this->info('Content tables truncated successfully. Users preserved.');
})->purpose('Truncate content tables for development and testing');
