<?php

namespace App\Http\Controllers;

use App\Motorista;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Exception;

class MotoristasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('motoristas.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|max:100',
            'cpf' => 'required|cpf|unique:motoristas,cpf',
            'email' => 'required|email',
            'situacao' => 'required|in:livre,em curso,retornando',
            'status' => 'required|in:ativo,inativo'
        ]);
        \App\Motorista::create($validatedData);
        return redirect('motoristas')->with('message', 'Motorista cadastrado com sucesso');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Motorista  $motorista
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Motorista $motorista)
    {
        $validatedData = $request->validate([
            'nome' => 'required|max:100',
            'cpf' => ['required','cpf', Rule::unique('motoristas', 'cpf')->ignore($motorista->id)],
            'email' => 'required|email',
            'situacao' => 'required|in:livre,em curso,retornando',
            'status' => 'required|in:ativo,inativo'
        ]);
        $motorista->update($validatedData);
        return redirect('motoristas')->with('message', 'Motorista atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Motorista  $motorista
     * @return \Illuminate\Http\Response
     */
    public function destroy(Motorista $motorista)
    {
        try{
            $motorista->delete();
            return redirect('motoristas')->with('message', 'Motorista deletado com sucesso');
        }catch(Exception $e){
            return redirect('motoristas')->with('message', 'Motorista não pode ser deletado');
        }
    }
}
