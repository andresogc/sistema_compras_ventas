@extends('principal')

@section('contenido')
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="/">BACKEND - SISTEMA DE COMPRAS - VENTAS</a></li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">

               <h2>Listado de Proveedores</h2><br/>

                <button class="btn btn-primary btn-lg" type="button" data-toggle="modal" data-target="#abrirmodal">
                    <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar Proveedor
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        {!!Form::open(array('url'=>'proveedor','method'=>'GET','autocomplete' =>'off','role'=>'search')) !!}
                            <div class="input-group">
                                <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" value="{{$buscarTexto}}">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>Buscar</button>
                            </div>
                        {!!Form::close() !!}
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr class="bg-primary">
                            <th>Proveedor</th>
                            <th>Tipo de documento</th>
                            <th>Número de documento</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Dirección</th>
                            <th>Editar</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proveedores as $prov)
                            <tr>
                                <td>{{$prov->nombre}}</td>
                                <td>{{$prov->tipo_documento}}</td>
                                <td>{{$prov->num_documento}}</td>
                                <td>{{$prov->telefono}}</td>
                                <td>{{$prov->email}}</td>
                                <td>{{$prov->direccion}}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-md" data-id_proveedor="{{$prov->id}}" data-nombre="{{$prov->nombre}}" data-tipo_documento="{{$prov->tipo_documento}}" data-num_documento="{{$prov->num_documento}}" data-telefono="{{$prov->telefono}}" data-email="{{$prov->email}}" data-direccion="{{$prov->direccion}}" data-toggle="modal" data-target="#abrirmodalEditar">
                                        <i class="fa fa-edit fa-2x"></i> Editar
                                    </button> &nbsp;
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                    {{$proveedores->render()}}

            </div>
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar-->
    <div class="modal fade" id="abrirmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Proveedor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                <form action="{{route('proveedor.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">

                    @csrf
                    @include('proveedor.form')

                </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->

     <!--Inicio del modal editar-->
     <div class="modal fade" id="abrirmodalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Actualizar Proveedor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{route('proveedor.update','test')}}" method="post" class="form-horizontal" enctype="multipart/form-data">

                        {{method_field('patch')}}
                        @csrf
                        <input type="hidden" id="id_proveedor" name="id_proveedor" value="">

                        @include('proveedor.form')

                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->


</main>
@endsection

