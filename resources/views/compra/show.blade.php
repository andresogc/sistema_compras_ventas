@extends('principal')

@section('contenido')
<main class="main">
  <div class="card-body">
    <h2>Detalle de compra</h2><br><br><br>

        <div class="form-group row">
            <div class="col-md-4">
                <label class="form-control-label" for="nombre">Proveedor</label>
                <p>{{$compra->nombre}}</p>
            </div>
            <div class="col-md-4">
                <label class="form-control-label" for="documento">Documento</label>
                <p>{{$compra->tipo_identificacion}}</p>
            </div>
            <div class="col-md-4">
                <label class="form-control-label" for="num_compra">Número de compra</label>
                <p>{{$compra->num_compra}}</p>
            </div>
        </div>

        <div class="form-group row border">
            <h3>Detalle de compras</h3>
            <div class="table-responsive col-md-12">
                <table id="detalles" class="table table-bordered table-striped">
                    <thead>
                        <tr class="bg-success">
                            <th>Producto</th>
                            <th>Precio (USD$)</th>
                            <th>Cantidad</th>
                            <th>SubTotal (USD$)</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="3"><p align="right">TOTAL:</p></th>
                            <th><p align="right">${{number_format($compra->total,2)}}</p></th>
                        </tr>
                        <tr>
                            <th colspan="3"><p align="right">TOTAL IMPUESTO (20%):</p></th>
                            <th><p align="right">${{number_format($compra->total*20/100,2)}}</p></th>
                        </tr>
                        <tr>
                            <th colspan="3"><p align="right">TOTAL PAGAR:</p></th>
                            <th><p align="right">${{number_format($compra->total+($compra->total*20/100),2)}}</p></th>
                        </tr>
                    </tfoot>

                    <tbody>
                        @foreach ($detalles as $detalle)
                            <tr>
                                <td>{{$detalle->producto}}</td>
                                <td>{{$detalle->precio}}</td>
                                <td>{{$detalle->cantidad}}</td>
                                <td>{{number_format($detalle->cantidad*$detalle->precio,2)}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>

@endsection

