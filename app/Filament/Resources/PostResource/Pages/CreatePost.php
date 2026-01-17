<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected array $tagsInput = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->tagsInput = $data['tags_input'] ?? [];
        unset($data['tags_input']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $tags = collect($this->tagsInput)->map(function ($name) {
            $slug = \Illuminate\Support\Str::slug($name);
            return \App\Models\Tag::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            )->id;
        });

        $this->record->tags()->sync($tags);
    }
}
