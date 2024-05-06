<?php

namespace App\Http\Controllers\Deposito;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deposito\DepositoModel;
use App\Models\Nicho;

class DepositoController extends Controller
{


    // Mostrar todos los registros
    public function index()
    {
        $depositos = DepositoModel::all();
        return view('depositos.index', compact('depositos'));
    }

    // Mostrar el formulario para crear un nuevo registro
    public function create()
    {
        $nichos=Nicho::where('estado','ACTIVO')->select('id', 'codigo')->get();
        //dd($nichos);
        return view('depositos.create', compact('nichos'));
    }

    // Almacenar un nuevo registro
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id(); // Retrieve authenticated user's ID and assign it to user_id column

        DepositoModel::create($data);
        return redirect()->route('deposito');
    }

    // Mostrar un registro específico
    public function show($id)
    {
        $deposito = DepositoModel::findOrFail($id);
        return view('depositos.show', compact('deposito'));
    }

    // Mostrar el formulario para editar un registro
    public function edit($id)
    {
        $deposito = DepositoModel::findOrFail($id);
        return view('depositos.edit', compact('deposito'));
    }

    // Actualizar un registro específico
    public function update(Request $request, $id)
    {
        $deposito = DepositoModel::findOrFail($id);
        $deposito->update($request->all());
        return redirect()->route('depositos.index');
    }

    // Eliminar un registro específico
    public function destroy($id)
    {
        $deposito = DepositoModel::findOrFail($id);
        $deposito->delete();
        return redirect()->route('depositos.index');
    }

    public function formPago(Request $request)
    {
        //dd($request->deposito_id);
        $deposito = DepositoModel::findOrFail($request->deposito_id);
        //dd($deposito);
        return view('depositos.formpago', compact('deposito'));
    }
}
