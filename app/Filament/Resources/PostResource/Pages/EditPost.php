<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected array $tagsInput = [];

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->tagsInput = $data['tags_input'] ?? [];
        unset($data['tags_input']);

        return $data;
    }

    protected function afterSave(): void
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

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
