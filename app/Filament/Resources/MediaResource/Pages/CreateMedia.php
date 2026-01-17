<?php

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Resources\MediaResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateMedia extends CreateRecord
{
    protected static string $resource = MediaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $disk = config('filament.default_filesystem_disk') ?? config('filesystems.default');
        $path = $data['file_path'] ?? null;

        if ($path) {
            $data['disk'] = $disk;
            $data['mime_type'] = Storage::disk($disk)->mimeType($path) ?: null;
            $data['size'] = Storage::disk($disk)->size($path) ?: null;

            if (empty($data['title'])) {
                $basename = pathinfo($path, PATHINFO_FILENAME);
                $data['title'] = str($basename)->headline();
            }
        }

        return $data;
    }
}

