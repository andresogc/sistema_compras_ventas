<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use Illuminate\Support\Facades\Redirect;
use DB;

class ProveedorController extends Controller
{
    //

    public function index(Request $request)
    {
        //
       // $buscarTexto="";
        if ($request) {

            $sql=trim($request->get('buscarTexto'));
            $proveedores = DB::table('proveedores')->where('nombre','LIKE', '%'.$sql.'%' )
            ->orderBy('id','desc')
            ->paginate(3);
            return view('proveedor.index' , ["proveedores"=>$proveedores, "buscarTexto"=>$sql]);
           // return $proveedores;
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
        $proveedor = new Proveedor();
        $proveedor->nombre = $request->nombre;
        $proveedor->tipo_documento = $request->tipo_documento;
        $proveedor->num_documento = $request->num_documento;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;
        $proveedor->direccion = $request->direccion;
        $proveedor->save();

        return Redirect::to("proveedor");
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

        $proveedor = Proveedor::findOrFail($request->id_proveedor);
        $proveedor->nombre = $request->nombre;
        $proveedor->tipo_documento = $request->tipo_documento;
        $proveedor->num_documento = $request->num_documento;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;
        $proveedor->direccion = $request->direccion;
        $proveedor->save();

        return Redirect::to("proveedor");

    }


}
