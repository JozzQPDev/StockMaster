<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    // Mostrar lista de productos con búsqueda y paginación
    public function index(Request $request)
    {
        // Iniciamos la consulta
        $query = Producto::with(['categoria', 'proveedor']);

        // Si el usuario hizo clic en el botón de la alerta del Dashboard
        if ($request->get('filtro') === 'critico') {
            $query->whereColumn('stock_actual', '<=', 'stock_minimo');
        }

        // Puedes añadir también la lógica de búsqueda que tienes en el header
        if ($request->has('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%')
                ->orWhere('codigo', 'like', '%' . $request->search . '%');
        }

        $productos = $query->latest()->paginate(10);

        return view('productos.index', compact('productos'));
    }

    // Mostrar formulario para crear producto
    public function create()
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();

        return view('productos.create', compact('categorias', 'proveedores'));
    }

    // Validar si el SKU ya existe vía AJAX
    public function validarSku(Request $request)
    {
        $exists = Producto::where('codigo', $request->codigo)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    // Guardar nuevo producto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|unique:productos,codigo|max:50',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Guardar imagen si existe
        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');

            // Limpiar nombre original y evitar caracteres raros
            $nombreOriginal = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $archivo->getClientOriginalExtension();
            $nombreSeguro = Str::slug($nombreOriginal) . '.' . $extension;

            // Guardar en storage/public/productos
            $validated['imagen'] = $archivo->storeAs('productos', $nombreSeguro, 'public');
        }

        Producto::create($validated);

        return redirect()->route('productos.index')
            ->with('success', '¡Producto "' . $request->nombre . '" registrado con éxito!');
    }

    // Mostrar formulario de edición
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();

        return view('productos.edit', compact('producto', 'categorias', 'proveedores'));
    }

    // Actualizar producto existente
    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:50|unique:productos,codigo,' . $producto->id,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            // Borrar la imagen anterior si existe
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $archivo = $request->file('imagen');

            $nombreOriginal = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $archivo->getClientOriginalExtension();
            $nombreSeguro = Str::slug($nombreOriginal) . '.' . $extension;

            $validated['imagen'] = $archivo->storeAs('productos', $nombreSeguro, 'public');
        }

        $producto->update($validated);

        return redirect()->route('productos.index')
            ->with('success', 'El producto "' . $producto->nombre . '" fue actualizado correctamente.');
    }

    // Eliminar producto
    public function destroy(Producto $producto)
    {
        $nombreProducto = $producto->nombre;

        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'El producto "' . $nombreProducto . '" ha sido eliminado permanentemente.');
    }

    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }


    public function ajustar(Request $request, Producto $producto)
    {
        $request->validate([
            'cantidad' => 'required|numeric|min:0.01|max:' . $producto->stock_actual,
            'motivo'   => 'required|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request, $producto) {
                // Actualización directa para blindar contra campos fantasmas
                DB::table('productos')
                    ->where('id', $producto->id)
                    ->decrement('stock_actual', $request->cantidad, ['updated_at' => now()]);

                // ... dentro del DB::transaction ...

                \App\Models\Movimiento::create([
                    'user_id'         => Auth::id(),
                    'producto_id'     => $producto->id,
                    'producto_nombre' => $producto->nombre,
                    'cantidad'        => -abs($request->cantidad), // <--- Forzamos que sea negativo para el historial
                    'accion'          => 'SALIDA MANUAL',
                    'detalle'         => $request->motivo,
                    'color_badge'     => 'rose', // El color rose/rojo indicará que es resta
                ]);
            });

            return back()->with('success', '¡Inventario actualizado correctamente!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error crítico: ' . $e->getMessage());
        }
    }
}
