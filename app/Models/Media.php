<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_path',
        'mime_type',
        'size',
        'disk',
        'alt_text',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Media $media): void {
            $disk = $media->disk ?: config('filesystems.default');

            if ($media->file_path && Storage::disk($disk)->exists($media->file_path)) {
                Storage::disk($disk)->delete($media->file_path);
            }
        });
    }

    public function getUrlAttribute(): ?string
    {
        $disk = $this->disk ?: config('filesystems.default');

        return $this->file_path
            ? Storage::disk($disk)->url($this->file_path)
            : null;
    }
}

