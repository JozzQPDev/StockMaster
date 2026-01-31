<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Http\Requests\UpdatesettingsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    /**
     * Muestra el formulario de configuración agrupado.
     */
    public function index()
    {
        // Traemos todos los ajustes y los agrupamos por la columna 'group'
        $settings = Setting::all()->groupBy('group');

        return view('settings.index', compact('settings'));
    }

    /**
     * Actualiza los ajustes de forma masiva y segura.
     */
    public function update(UpdatesettingsRequest $request)
    {
        // 1. Validar los datos mediante el FormRequest
        $data = $request->validated();

        foreach ($data as $key => $value) {
            $setting = Setting::where('key', $key)->first();

            // Solo actualizamos si el valor enviado es diferente al actual
            if ($setting && $setting->value != $value) {

                // 2. Auditoría: Registro en logs
                Log::info("Configuración cambiada por el usuario ID: " . Auth::id(), [
                    'clave'          => $key,
                    'valor_anterior' => $setting->value,
                    'nuevo_valor'    => $value
                ]);

                // 3. Persistencia
                $setting->update([
                    'value' => $value
                ]);

                // Nota: La caché se limpia mediante el evento 'booted' en el modelo Setting.
                // Si no lo tienes en el modelo, descomenta la siguiente línea:
                // Cache::forget("setting_{$key}");
            }
        }

        return redirect()
            ->route('settings.index')
            ->with('success', 'La configuración ha sido actualizada y protegida correctamente.');
    }

    /**
     * Restablece todos los ajustes a sus valores de fábrica (Dinámico).
     * Requiere columna 'default_value' en la tabla 'settings'.
     */
    public function reset()
    {
        // Obtenemos todos los registros
        $settings = Setting::all();

        if ($settings->isEmpty()) {
            return redirect()->back()->with('error', 'No hay ajustes para restablecer.');
        }

        $settings->each(function ($setting) {
            // Actualizamos el valor actual con el de fábrica guardado en la DB
            $setting->update([
                'value' => $setting->default_value
            ]);

            // Limpiamos la caché de cada llave
            Cache::forget("setting_{$setting->key}");
        });

        return redirect()->back()->with('success', 'Todos los ajustes han vuelto a los valores originales de fábrica.');
    }
}