<?php

namespace App\Http\Controllers;

use App\Models\FormaDePago;
use Illuminate\Http\Request;

class FormaDePagoController extends Controller
{
    // Mostrar una lista de las formas de pago
    public function index()
    {
        $formasDePago = FormaDePago::all();
        return view('forma_pago.index', compact('formasDePago'));
    }
    // Mostrar el formulario para crear una nueva forma de pago
    public function create()
    {
        return view('forma_pago.create');
    }
    // Almacenar una nueva forma de pago en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
        ]);
        // Crear la forma de pago
        FormaDePago::create($request->all());

        return redirect()->route('forma_pago.index')->with('success', 'Forma de pago creada con éxito.');
    }
    // Mostrar una forma de pago específica
    public function show($id)
    {
        $formaDePago = FormaDePago::findOrFail($id);

        return view('forma_pago.show', compact('formaDePago'));
    }
    // Mostrar el formulario para editar una forma de pago
    public function edit($id)
    {
        // Buscar la forma de pago a editar
        $formaDePago = FormaDePago::findOrFail($id);
        
        // Pasar la forma de pago a la vista
        return view('forma_pago.edit', compact('formaDePago'));
    }
    
    // Actualizar una forma de pago en la base de datos
    public function update(Request $request, FormaDePago $formaDePago)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
        ]);

        $formaDePago->update($request->all());

        return redirect()->route('forma_pago.index')->with('success', 'Forma de pago actualizada con éxito.');
    }
    // Eliminar una forma de pago de la base de datos
    public function destroy($id)
    {
        // Buscar la forma de pago a eliminar
        $formaDePago = FormaDePago::findOrFail($id);
        // Eliminar la forma de pago
        $formaDePago->delete();
        // Redireccionar a la lista de formas de pago con un mensaje de éxito
        return redirect()->route('forma_pago.index')->with('success', 'Forma de pago eliminada con éxito.');
    }
}
