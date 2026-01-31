<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * Obtiene un ajuste de la base de datos de forma global.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        return Setting::get($key, $default);
    }
}