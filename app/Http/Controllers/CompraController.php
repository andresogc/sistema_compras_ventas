<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Compra;
use App\DetalleCompra;
use Illuminate\Support\Facades\Redirect;




class CompraController extends Controller
{
    //
    public function index(Request $request){
        $sql = trim($request->get('buscarTexto'));
        $compras = Compra::join('proveedores','compras.idproveedor','proveedores.id')
        ->join('users','compras.idusuario','users.id')
        ->join('detalle_compras','compras.id','detalle_compras.idcompra')
        ->select('compras.id','compras.tipo_identificacion','compras.num_compra',
        'compras.fecha_compra','compras.impuesto','compras.estado','compras.total',
        'proveedores.nombre as proveedor','users.nombre')
        ->where('compras.num_compra','LIKE','%'.$sql.'%')
        ->orderBy('compras.id','desc')
        ->groupBy('compras.id','compras.tipo_identificacion','compras.num_compra',
        'compras.fecha_compra','compras.impuesto', 'compras.estado','compras.total'
        ,'proveedores.nombre','users.nombre')
        ->paginate(8);

        return view('compra.index', ["compras"=>$compras,"buscarTexto"=>$sql]);

        //return $compras;
    }

    public function create(){
        //listar los proveedores en ventana modal
        $proveedores = DB::table('proveedores')->get();

        //listar los productos en ventana modal
        $productos = DB::table('productos as prod')
        ->select(DB::raw('CONCAT(prod.codigo," ",prod.nombre) AS producto'), 'prod.id')
        ->where('prod.condicion','1')->get();


        return view('compra.create',["proveedores"=>$proveedores, "productos"=>$productos]);
    }

    public function store(Request $request){

        try {
            DB::beginTransaction();

            $mytime = Carbon::now('America/Bogota');

            $compra = new Compra();
            $compra->idproveedor = $request->id_proveedor;
            $compra->idusuario = \Auth::user()->id;
            $compra->tipo_identificacion = $request->tipo_identificacion;
            $compra->num_compra = $request->num_compra;
            $compra->fecha_compra = $mytime->toDateString();
            $compra->impuesto = '0.20';
            $compra->total = $request->total_pagar;
            $compra->estado = 'Registrado';
            $compra->save();

            $id_producto = $request->id_producto;
            $cantidad = $request->cantidad;
            $precio = $request->precio_compra;

            //recorro todos los elementos
            $cont = 0;

            while($cont < count($id_producto)){
                $detalle = new DetalleCompra();
                //Enviamos valores a las propiedades del objeto detalle
                //al idcompra del objeto detalle le envio el id del objeto compra, que es el objeto que se ingreso en la tabla compras de la db
                $detalle->idcompra = $compra->id;
                $detalle->idproducto = $id_producto[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio = $precio[$cont];
                $detalle->save();
                $cont = $cont+1;
            }


            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
        }

        return Redirect::to('compra');


    }


    public function show($id){

        //mostrar compra
        $compra = Compra::join('proveedores','compras.idproveedor','proveedores.id')
        ->join('detalle_compras','compras.id','detalle_compras.idcompra')
        ->select('compras.id','compras.tipo_identificacion','compras.num_compra',
        'compras.fecha_compra','compras.impuesto','compras.estado',
         DB::raw('sum(detalle_compras.cantidad * precio) as total'),'proveedores.nombre')
        ->where('compras.id',$id)
        ->orderBy('compras.id','desc')
        ->groupBy('compras.id','compras.tipo_identificacion','compras.num_compra',
        'compras.fecha_compra','compras.impuesto','compras.estado','proveedores.nombre')
        ->first();

        //mostrar detalles
        $detalles = DetalleCompra::join('productos','detalle_compras.idproducto','productos.id')
        ->select('detalle_compras.cantidad', 'detalle_compras.precio', 'productos.nombre AS producto')
        ->where('detalle_compras.idcompra',$id)
        ->orderBy('detalle_compras.id','desc')
        ->get();
       
        return view('compra.show',['compra'=>$compra,'detalles'=>$detalles]);


    }



    public function destroy(Request $request){

        $compra = Compra::findOrFail($request->id_compra);
        $compra->estado = 'Anulado';
        $compra->save();

        return Redirect::to('compra');
    }


    public function PDF(Request $request,$id){

        $compra = Compra::join('proveedores','compras.idproveedor','proveedores.id')
        ->join('users','compras.idusuario','users.id')
        ->join('detalle_compras','compras.id','detalle_compras.idcompra')
        ->select('compras.id','compras.tipo_identificacion','compras.num_compra',
        'compras.created_at','compras.impuesto',DB::raw('SUM(detalle_compras.cantidad*precio) AS total'),
        'compras.estado', 'proveedores.nombre', 'proveedores.tipo_documento', 'proveedores.num_documento',
        'proveedores.email','proveedores.direccion','proveedores.telefono', 'users.usuario')
        ->where('compras.id',$id)
        ->orderBy('compras.id','desc')
        ->groupBy('compras.id','compras.tipo_identificacion','compras.num_compra',
        'compras.created_at','compras.impuesto','compras.estado', 'proveedores.nombre', 'proveedores.tipo_documento', 'proveedores.num_documento',
        'proveedores.email','proveedores.direccion','proveedores.telefono', 'users.usuario')
        ->take(1)->get();

        $detalles = DetalleCompra::join('productos','detalle_compras.idproducto','productos.id')
        ->select('detalle_compras.cantidad', 'detalle_compras.precio')
        ->where('detalle_compras.idcompra',$id)
        ->orderBy('detalle_compras.id','desc')
        ->get();

        $numcompra = Compra::select('num_compra')->where('id',$id)->get();

        $pdf = \PDF::loadView('pdf.compra',['compra'=>$compra ,'detalles'=>$detalles]);

        return $pdf->download('compra-'.$numcompra[0]->num_compra.'.pdf');

    }


}
