<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, $default = null)
    {
        if (! self::tableExists()) {
            return $default;
        }

        $setting = static::where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, $value): void
    {
        if (! self::tableExists()) {
            return;
        }

        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    private static function tableExists(): bool
    {
        if (! app()->bound('db')) {
            return false;
        }

        try {
            return Schema::hasTable('settings');
        } catch (\Exception $e) {
            return false;
        }
    }
}
