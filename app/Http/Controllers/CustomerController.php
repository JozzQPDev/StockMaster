<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('document_number', 'LIKE', '%' . $request->search . '%');
            });
        }

        $customers = $query->orderBy('points', 'desc')->paginate(10);
        return view('customers.index', compact('customers'));
    }

    /**
     * MUESTRA EL FORMULARIO DE CREACIÓN
     */
    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'document_type' => 'required|string|max:10',
            'document_number' => 'required|string|max:20|unique:customers,document_number',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'level' => 'required|in:REGULAR,VIP', // Agregado para tu diseño
        ]);

        $customer = Customer::create($validated);

        if ($request->ajax()) {
            return response()->json($customer);
        }

        return redirect()->route('customers.index')->with('success', 'Cliente registrado.');
    }

    /**
     * Registro rápido de cliente desde el POS (AJAX)
     */
    public function storeRapido(Request $request)
    {
        try {
            // 1. Validar los datos
            $request->validate([
                'name' => 'required|string|max:255',
                'document_number' => 'required|string|unique:customers,document_number',
            ]);

            // 2. Lógica para determinar si es DNI o RUC
            $doc = $request->document_number;
            $tipoDoc = strlen($doc) == 11 ? 'RUC' : (strlen($doc) == 8 ? 'DNI' : 'OTRO');

            // 3. Crear el cliente
            $cliente = \App\Models\Customer::create([
                'name'            => mb_strtoupper($request->name),
                'document_number' => $doc,
                'document_type'   => $tipoDoc,
                'phone'           => $request->phone,
                'points'          => 0,
                'total_spent'     => 0,
            ]);

            // 4. Retornar el cliente creado para que el JS lo use
            return response()->json($cliente);
        } catch (\Exception $e) {
            // Si hay error (ej: documento duplicado), enviamos el mensaje
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * MUESTRA EL DETALLE DEL CLIENTE
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * MUESTRA EL FORMULARIO DE EDICIÓN
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'document_number' => 'required|string|max:20|unique:customers,document_number,' . $customer->id,
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'level' => 'required|in:REGULAR,VIP', // Agregado para tu diseño
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Customer $customer)
    {
        // Si tienes la relación ventas en el modelo Customer
        if (method_exists($customer, 'ventas') && $customer->ventas()->count() > 0) {
            return back()->with('error', 'No se puede eliminar un cliente con historial de compras.');
        }

        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Cliente eliminado del sistema.');
    }

    public function buscar(Request $request)
    {
        $term = $request->q;
        if (!$term) {
            return response()->json([]);
        }

        $clientes = Customer::where('name', 'LIKE', "%$term%")
            ->orWhere('document_number', 'LIKE', "%$term%")
            ->orderByRaw("CASE WHEN document_number = ? THEN 1 ELSE 2 END", [$term])
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json($clientes);
    }

    public function adjustPoints(Request $request, Customer $customer)
    {
        $request->validate([
            'amount' => 'required|integer',
            'reason' => 'required|string|max:255'
        ]);

        $customer->increment('points', $request->amount);
        return back()->with('success', "Se han ajustado los puntos de {$customer->name}");
    }
}
