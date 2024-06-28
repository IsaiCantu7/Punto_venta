<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Método para mostrar todos los clientes
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }
    // Método para mostrar el formulario de creación de cliente
    public function create()
    {
        return view('clientes.create');
    }
    // Método para guardar un nuevo cliente
    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required',
            'correo' => 'required|email',
            'telefono' => 'required',
            'Dirección' => 'required',
            'RFC' => 'required',
            'Razon_social' => 'required',
            'Codigo_postal' => 'required',
            'Regimen_fiscal' => 'required',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente.');
    }
    // Método para mostrar un cliente específico
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }
    // Método para mostrar el formulario de edición de cliente
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }
    // Método para actualizar un cliente
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'Nombre' => 'required',
            'correo' => 'required|email',
            'telefono' => 'required',
            'Dirección' => 'required',
            'RFC' => 'required',
            'Razon_social' => 'required',
            'Codigo_postal' => 'required',
            'Regimen_fiscal' => 'required',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }
    // Método para eliminar un cliente
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }
}
