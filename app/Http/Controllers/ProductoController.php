<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use DB;


class ProductoController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
       // $buscarTexto="";
        if ($request) {

            $sql=trim($request->get('buscarTexto'));
            $productos = DB::table('productos as p')
            ->join('categorias as c','p.idcategoria','c.id')
            ->select('p.id','p.idcategoria','p.nombre','p.precio_venta','p.codigo','p.stock','p.imagen','p.condicion','c.nombre as categoria')
            ->where('p.nombre','LIKE','%'.$sql.'%')
            ->orWhere('p.codigo','LIKE','%'.$sql.'%')
            ->orderBy('p.id','desc')
            ->paginate(3);

            /*listar las categorias en ventana modal*/
            $categorias = DB::table('categorias')
            ->select('id','nombre','descripcion')
            ->where('condicion','1')->get();

            return view('producto.index',["productos" =>$productos, "categorias"=>$categorias,"buscarTexto"=>$sql]);


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
        $producto = new Producto();
        $producto->idcategoria = $request->id;
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->stock = '0';
        $producto->condicion = '1';

        //Handle file upload
        if($request->hasFile('imagen')){

            //get filename with extension
            $filenamewithExt = $request -> file('imagen')->getClientOriginalName();

            //get just filename
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);

            //get just ext
            $extension = $request->file('imagen')->guessClientExtension();

            //fileName to store
            $fileNameToStore = time().'.'.$extension;


            //upload image
            $path = $request->file('imagen')->storeAs('public/img/producto', $fileNameToStore);

        }else{
            $fileNameToStore = "noimagen.jpg";
        }

        $producto->imagen=$fileNameToStore;


        $producto->save();

        return Redirect::to("producto");
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
        $producto = Producto::findOrFail($request->id_producto);
        $producto->idcategoria = $request->id;
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->stock = '0';
        $producto->condicion = '1';

        //Handle file upload
        if($request->hasFile('imagen')){


            /* Si la imagen que se sube es distinta a la que esta por defecto
            entonces eliminaria la imagen anterior, eso es para evitar acumular
            imagenes en el servidor*/

            if ($producto->imagen != 'noimagen.jpg') {
                Storage::delete('public/img/producto'.$producto->imagen);
            }

            //get filename with extension
            $filenamewithExt = $request -> file('imagen')->getClientOriginalName();

            //get just filename
            $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);

            //get just ext
            $extension = $request->file('imagen')->guessClientExtension();

            //fileName to store
            $fileNameToStore = time().'.'.$extension;


            //upload image
            $path = $request->file('imagen')->storeAs('public/img/producto', $fileNameToStore);

        }else{
            $fileNameToStore = $producto->imagen;
        }

            $producto->imagen=$fileNameToStore;

        $producto->save();

        return Redirect::to("producto");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $producto = Producto::findOrFail($request->id_producto);

        if ($producto->condicion=="1") {
            $producto->condicion ='0';
            $producto->save();
            return Redirect::to("producto");

        } else {
            $producto->condicion ='1';
            $producto->save();
            return Redirect::to("producto");
        }


    }

    public function listarPdf(){


        $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
        ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.stock','productos.condicion')
        ->orderBy('productos.nombre', 'desc')->get();


        $cont=Producto::count();

        $pdf= \PDF::loadView('pdf.productospdf',['productos'=>$productos,'cont'=>$cont]);
        return $pdf->download('productos.pdf');

}
}
