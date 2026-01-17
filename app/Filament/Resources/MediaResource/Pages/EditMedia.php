<?php

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Resources\MediaResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditMedia extends EditRecord
{
    protected static string $resource = MediaResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $disk = $this->record->disk ?: (config('filament.default_filesystem_disk') ?? config('filesystems.default'));
        $path = $data['file_path'] ?? null;

        if ($path) {
            $data['disk'] = $disk;
            $data['mime_type'] = Storage::disk($disk)->mimeType($path) ?: null;
            $data['size'] = Storage::disk($disk)->size($path) ?: null;
        }

        return $data;
    }
}

