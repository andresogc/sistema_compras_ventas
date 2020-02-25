<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use DB;


class UserController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        if ($request) {

            $sql=trim($request->get('buscarTexto'));
            $usuarios = DB::table('users')
            ->join('roles','users.idrol','roles.id')
            ->select('users.id',
                    'users.nombre',
                    'users.tipo_documento',
                    'users.num_documento',
                    'users.direccion',
                    'users.telefono',
                    'users.email',
                    'users.usuario',
                    'users.password',
                    'users.condicion',
                    'users.idrol',
                    'users.imagen',
                    'roles.nombre as rol' )
            ->where('users.nombre','LIKE', '%'.$sql.'%' )
            ->orWhere('users.num_documento','LIKE', '%'.$sql.'%' )
            ->orderBy('users.id','desc')
            ->paginate(3);


            //Listar los roles en ventana modal

            $roles = DB::table('roles')
            ->select('id','nombre','descripcion')
            ->where('condicion','1')
            ->get();

           return view('user.index' , ["usuarios"=>$usuarios,"roles"=>$roles, "buscarTexto"=>$sql]);
          // return $usuarios;
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
        $user = new User();
        $user->nombre = $request->nombre;
        $user->tipo_documento = $request->tipo_documento;
        $user->num_documento = $request->num_documento;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->direccion = $request->direccion;
        $user->usuario = $request->usuario;
        $user->password = bcrypt($request->password);
        $user->condicion = '1';
        $user->idrol = $request->id_rol;

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
            $path = $request->file('imagen')->storeAs('public/img/usuario', $fileNameToStore);

        }else{
            $fileNameToStore = "noimagen.jpg";
        }

        $user->imagen=$fileNameToStore;



        $user->save();

        return Redirect::to("user");
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
        $user = User::findOrFail($request->id_usuario);
        $user->nombre = $request->nombre;
        $user->tipo_documento = $request->tipo_documento;
        $user->num_documento = $request->num_documento;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->direccion = $request->direccion;
        $user->usuario = $request->usuario;
        $user->password = bcrypt($request->password);
        $user->condicion = '1';
        $user->idrol = $request->id_rol;

         //Handle file upload
         if($request->hasFile('imagen')){


            /* Si la imagen que se sube es distinta a la que esta por defecto
            entonces eliminaria la imagen anterior, eso es para evitar acumular
            imagenes en el servidor*/

            if ($user->imagen != 'noimagen.jpg') {
                Storage::delete('public/img/usuario/'.$user->imagen);
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
            $path = $request->file('imagen')->storeAs('public/img/usuario', $fileNameToStore);

        }else{
            $fileNameToStore = $user->imagen;
        }

            $user->imagen=$fileNameToStore;

        $user->save();

        return Redirect::to("user");

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
        

        $user = User::findOrFail($request->id_usuario);

        if ($user->condicion=="1") {
            $user->condicion ='0';
            $user->save();
            return Redirect::to("user");

        } else {
            $user->condicion ='1';
            $user->save();
            return Redirect::to("user");
        }


    }

}
