<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    // Mostrar todos los proveedores
    public function index(Request $request)
    {
        $term = $request->get('search');

        $proveedores = Proveedor::query()
            ->when($term, function ($query, $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('nombre', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%")
                        ->orWhere('telefono', 'like', "%{$term}%")
                        ->orWhere('direccion', 'like', "%{$term}%");
                });
            })
            ->latest() // Ordenar por los más recientes
            ->paginate(10); // Mostrar 10 por página

        return view('proveedores.index', compact('proveedores'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('proveedores.create');
    }

    // Guardar nuevo proveedor
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:proveedores,email',
            'telefono' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:255',
        ]);

        Proveedor::create($validated);

        return redirect()->route('proveedores.index')
            ->with('success', '¡Proveedor registrado con éxito en StockMaster!');
    }

    // Mostrar un proveedor específico
    public function show(Proveedor $proveedor)
    {
        return view('proveedores.show', compact('proveedor'));
    }

    // Formulario de edición
    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    // Actualizar proveedor
    public function update(Request $request, Proveedor $proveedor)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:proveedores,email,' . $proveedor->id,
            'telefono' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:255',
        ]);

        $proveedor->update($validated);

        return redirect()->route('proveedores.index')
            ->with('success', 'Datos de "' . $proveedor->nombre . '" actualizados correctamente.');
    }

    // Eliminar proveedor
    public function destroy(Proveedor $proveedor)
    {
        // Guardamos el nombre para el mensaje antes de borrarlo
        $nombre = $proveedor->nombre;

        $proveedor->delete();

        // Usamos 'error' para que tu componente de Alpine.js lo muestre en rojo
        return redirect()->route('proveedores.index')
            ->with('success', 'El proveedor "' . $nombre . '" ha sido eliminado del sistema.');
    }
}
