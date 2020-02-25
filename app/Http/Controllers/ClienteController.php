<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\Cliente;

class ClienteController extends Controller
{

    public function index(Request $request)
    {
        //
       // $buscarTexto="";
        if ($request) {

            $sql=trim($request->get('buscarTexto'));
            $clientes = DB::table('clientes')->where('nombre','LIKE', '%'.$sql.'%' )
            ->orderBy('id','desc')
            ->paginate(3);
            return view('cliente.index' , ["clientes"=>$clientes, "buscarTexto"=>$sql]);
           // return $clientes;
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $cliente = new Cliente();
        $cliente->nombre = $request->nombre;
        $cliente->tipo_documento = $request->tipo_documento;
        $cliente->num_documento = $request->num_documento;
        $cliente->telefono = $request->telefono;
        $cliente->email = $request->email;
        $cliente->direccion = $request->direccion;
        $cliente->save();

        return Redirect::to("cliente");
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

        $cliente = Cliente::findOrFail($request->id_cliente);
        $cliente->nombre = $request->nombre;
        $cliente->tipo_documento = $request->tipo_documento;
        $cliente->num_documento = $request->num_documento;
        $cliente->telefono = $request->telefono;
        $cliente->email = $request->email;
        $cliente->direccion = $request->direccion;
        $cliente->save();

        return Redirect::to("cliente");

    }


}
