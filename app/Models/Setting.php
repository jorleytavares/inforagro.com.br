<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // The primary key is a string 'option'
    protected $primaryKey = 'option';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'option',
        'payload',
    ];

    protected $casts = [
        'payload' => 'json',
    ];

    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::find($key);
        return $setting ? $setting->payload : $default;
    }

    /**
     * Set a setting value by key.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['option' => $key],
            ['payload' => $value]
        );
    }
}
