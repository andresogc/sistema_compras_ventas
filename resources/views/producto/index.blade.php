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

               <h2>Listado de Productos</h2><br/>

                <button class="btn btn-primary btn-lg" type="button" data-toggle="modal" data-target="#abrirmodal">
                    <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar Producto
                </button>
                <a href="{{url('listarProductosPdf')}}">
                    <button class="btn btn-success btn-lg" type="button"target="_blank" >
                        <i class="fa fa-file fa-2x"></i>&nbsp;&nbsp;Reporte PDF
                    </button>
                </a>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        {!!Form::open(array('url'=>'producto','method'=>'GET','autocomplete' =>'off','role'=>'search')) !!}
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
                            <th>Categoría</th>
                            <th>Producto</th>
                            <th>Código</th>
                            <th>Precio de venta (USD$)</th>
                            <th>Stock</th>
                            <th>Imagen</th>
                            <th>Estado</th>
                            <th>Editar</th>
                            <th>Cambiar Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $prod)
                            <tr>
                                <td>{{$prod->categoria}}</td>
                                <td>{{$prod->nombre}}</td>
                                <td>{{$prod->codigo}}</td>
                                <td>{{$prod->precio_venta}}</td>
                                <td>{{$prod->stock}}</td>

                                <td>
                                <img src="{{asset('storage/img/producto/'.$prod->imagen)}}" id="imagen" alt="{{$prod->nombre}}" class="img-responsive" width="100px" height="100px">
                                </td>

                                <td>
                                    @if ($prod->condicion=="1")
                                        <button type="button" class="btn btn-success btn-md">
                                            <i class="fa fa-check fa-2x"></i> Activo
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-danger btn-md">
                                            <i class="fa fa-check fa-2x"></i> Desactivado
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-md" data-id_producto="{{$prod->id}}" data-id_categoria="{{$prod->idcategoria}}" data-codigo="{{$prod->codigo}}" data-stock="{{$prod->stock}}" data-nombre="{{$prod->nombre}}" data-precio_venta="{{$prod->precio_venta}}"data-toggle="modal" data-target="#abrirmodalEditar">
                                        <i class="fa fa-edit fa-2x"></i> Editar
                                    </button> &nbsp;
                                </td>
                                <td>
                                    @if (!$prod->condicion=="1")
                                        <button type="button" class="btn btn-success btn-md" data-id_producto="{{$prod->id}}" data-toggle="modal" data-target="#cambiarEstado">
                                            <i class="fa fa-lock fa-2x"></i>Activar
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-danger btn-md" data-id_producto="{{$prod->id}}" data-toggle="modal" data-target="#cambiarEstado">
                                            <i class="fa fa-times fa-2x"></i>Desactivar
                                        </button>

                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                    {{$productos->render()}}

            </div>
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar-->
    <div class="modal fade" id="abrirmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar producto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                <form action="{{route('producto.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">

                    @csrf
                    @include('producto.form')

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
                    <h4 class="modal-title">Actualizar producto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{route('producto.update','test')}}" method="post" class="form-horizontal" enctype="multipart/form-data">

                        {{method_field('patch')}}
                        @csrf
                        <input type="hidden" id="id_producto" name="id_producto" value="">

                        @include('producto.form')

                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->

     <!--Inicio del modal cambiar estado-->
     <div class="modal fade" id="cambiarEstado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cambiar estado de producto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{route('producto.destroy','test')}}" method="post" class="form-horizontal">

                        {{method_field('delete')}}
                        @csrf
                        <input type="hidden" id="id_producto" name="id_producto" value="">

                        <p>¿Estas seguro de cambiar el estado?</p>

                        <div>
                            <button type="button" class="btn btn_danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i>Cerrar</button>
                            <button type="submit" class="btn btn_success" ><i class="fa fa-lock fa-2x"></i>Aceptar</button>
                        </div>

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

