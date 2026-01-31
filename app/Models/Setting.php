<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'default_value', 'group', 'type', 'description'];

    protected static function booted()
    {
        // Al actualizar O eliminar, limpiamos la caché
        $clearCache = function ($setting) {
            Cache::forget("setting_{$setting->key}");
            // También limpiamos la caché del grupo por si acaso
            Cache::forget("settings_group_{$setting->group}");
        };

        static::updated($clearCache);
        static::deleted($clearCache);
    }

    /**
     * Obtiene un ajuste por su llave con caché.
     */
    public static function get($key, $default = null)
    {
        // Usamos remember para no tocar la DB cada vez
        $setting = Cache::remember("setting_{$key}", 86400, function () use ($key) {
            return self::where('key', $key)->first();
        });

        if (!$setting) return $default;

        return self::castValue($setting->value, $setting->type);
    }

    /**
     * Método interno para manejar el tipado
     */
    private static function castValue($value, $type)
    {
        return match ($type) {
            'number'  => (float) $value,
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'json'    => json_decode($value, true),
            default   => $value,
        };
    }
}