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

               <h2>Listado de Compras</h2><br/>

                <a href="compra/create">
                    <button class="btn btn-primary btn-lg" type="button" data-toggle="modal" data-target="#abrirmodal">
                        <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar Compra
                    </button>
                </a>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        {!!Form::open(array('url'=>'compra','method'=>'GET','autocomplete' =>'off','role'=>'search')) !!}
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
                            <th>Ver detalle</th>
                            <th>Fecha Compra</th>
                            <th>Número compra</th>
                            <th>Proveedor</th>
                            <th>Tipo de identificación</th>
                            <th>Comprador</th>
                            <th>Total (USD$)</th>
                            <th>Impuesto</th>
                            <th>Estado</th>
                            <th>Cambiar estado</th>
                            <th>Descargar reporte</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($compras as $compra)
                            <tr>
                                <td>
                                    <a href="{{URL::action('CompraController@show',$compra->id)}}">
                                        <button type="button" class="btn btn-warning btn-md">
                                            <i class="fa fa-eye fa-2x">Ver detalle</i>
                                        </button>&nbsp;
                                    </a>
                                </td>
                                <td>{{$compra->fecha_compra}}</td>
                                <td>{{$compra->num_compra}}</td>
                                <td>{{$compra->proveedor}}</td>
                                <td>{{$compra->tipo_identificacion}}</td>
                                <td>{{$compra->nombre}}</td>
                                <td>${{number_format($compra->total,2)}}</td>
                                <td>{{$compra->impuesto}}</td>
                                <td>
                                    @if ($compra->estado == "Registrado")
                                        <button type="button" class="btn btn-success btn-md">
                                            <i class="fa fa-check fa-2x"></i>Registrado
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-danger btn-md">
                                            <i class="fa fa-check fa-2x"></i>Anulado
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    @if ($compra->estado == "Registrado")
                                    <button type="button" class="btn btn-danger btn-sm" data-id_compra = "{{$compra->id}}" data-toggle="modal" data-target="#cambiarEstadoCompra">
                                            <i class="fa fa-check fa-2x"></i>Anular compra
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-success btn-md">
                                            <i class="fa fa-lock fa-2x"></i>Anulado
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{url('pdfCompra', $compra->id)}}" target="_blank">
                                        <button type="button" class="btn btn-info btn-sm">
                                            <i class="fa fa-file fa-2x"></i>Descargar PDF
                                        </button>&nbsp;
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                    {{$compras->render()}}

            </div>
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>


     <!--Inicio del modal cambiar estado de compra -->
     <div class="modal fade" id="cambiarEstadoCompra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cambiar estado de compra</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{route('compra.destroy','test')}}" method="post" class="form-horizontal">

                        {{method_field('delete')}}
                        @csrf
                        <input type="hidden" id="id_compra" name="id_compra" value="">

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
