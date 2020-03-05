@extends('principal')
@section('contenido')
 

<main class="main">

 <div class="card-body">

 <h2>Agregar Venta</h2>

 <span><strong>(*) Campo obligatorio</strong></span><br/>

 <h3 class="text-center">LLenar el formulario</h3>

    <form action="{{route('venta.store')}}" method="POST">
    {{csrf_field()}}

            <div class="form-group row">

            <div class="col-md-8">

                <label class="form-control-label" for="nombre">Nombre del Cliente</label>

                    <select class="form-control selectpicker" name="id_cliente" id="id_cliente" data-live-search="true" required>

                    <option value="0" disabled>Seleccione</option>

                    @foreach($clientes as $client)

                    <option value="{{$client->id}}">{{$client->nombre}}</option>

                    @endforeach

                    </select>

                </div>
            </div>

            <div class="form-group row">

                <div class="col-md-8">

                        <label class="form-control-label" for="documento">Documento</label>

                        <select class="form-control" name="tipo_identificacion" id="tipo_identificacion" required>

                            <option value="0" disabled>Seleccione</option>
                            <option value="FACTURA">Factura</option>
                            <option value="TICKET">Ticket</option>


                        </select>
                </div>
            </div>


            <div class="form-group row">

                <div class="col-md-8">
                        <label class="form-control-label" for="num_venta">Número Venta</label>

                        <input type="text" id="num_venta" name="num_venta" class="form-control" placeholder="Ingrese el número venta" pattern="[0-9]{0,15}">
                </div>
            </div>

            <br/><br/>

            <div class="form-group row border">

                 <div class="col-md-8">

                        <label class="form-control-label" for="nombre">Producto</label>

                            <select class="form-control selectpicker" name="id_producto" id="id_producto" data-live-search="true" required>

                            <option value="0" selected>Seleccione</option>

                            @foreach($productos as $prod)

                            <option value="{{$prod->id}}_{{$prod->stock}}_{{$prod->precio_venta}}">{{$prod->producto}}</option>

                            @endforeach

                            </select>

                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-2">
                        <label class="form-control-label" for="cantidad">Cantidad</label>

                        <input type="number" id="cantidad" name="cantidad" class="form-control" placeholder="Ingrese cantidad" pattern="[0-9]{0,15}">
                </div>

                <div class="col-md-2">
                        <label class="form-control-label" for="stock">Stock</label>

                        <input type="number" disabled id="stock" name="stock" class="form-control" placeholder="Ingrese el stock" pattern="[0-9]{0,15}">
                </div>

                <div class="col-md-2">
                        <label class="form-control-label" for="precio_venta">Precio Venta</label>

                        <input type="number" disabled id="precio_venta" name="precio_venta" class="form-control" placeholder="Ingrese precio de venta" >
                </div>

                <div class="col-md-2">
                        <label class="form-control-label" for="impuesto">Descuento</label>

                        <input type="number" id="descuento" name="descuento" class="form-control" placeholder="Ingrese el descuento">
                </div>

                <div class="col-md-4">

                    <button type="button" id="agregar" class="btn btn-primary"><i class="fa fa-plus fa-2x"></i> Agregar detalle</button>
                </div>


            </div>

            <br/><br/>

           <div class="form-group row border">

              <h3>Lista de Ventas a Clientes</h3>

              <div class="table-responsive col-md-12">
                <table id="detalles" class="table table-bordered table-striped table-sm">
                <thead>
                    <tr class="bg-success">
                        <th>Eliminar</th>
                        <th>Producto</th>
                        <th>Precio Venta (USD$)</th>
                        <th>Descuento</th>
                        <th>Cantidad</th>
                        <th>SubTotal (USD$)</th>
                    </tr>
                </thead>

                <tfoot>
                   <!--<th>Total</th>
                   <th></th>
                   <th></th>
                   <th></th>
                   <th></th>
                   <th><h4 id="total">USD$ 0.00</h4><input type="hidden" name="total_venta" id="total_venta">  </th>-->

                    <tr>
                        <th  colspan="5"><p align="right">TOTAL:</p></th>
                        <th><p align="right"><span id="total">USD$ 0.00</span> </p></th>
                    </tr>

                    <tr>
                        <th colspan="5"><p align="right">TOTAL IMPUESTO (20%):</p></th>
                        <th><p align="right"><span id="total_impuesto">USD$ 0.00</span></p></th>
                    </tr>

                    <tr>
                        <th  colspan="5"><p align="right">TOTAL PAGAR:</p></th>
                        <th><p align="right"><span align="right" id="total_pagar_html">USD$ 0.00</span> <input type="hidden" name="total_pagar" id="total_pagar"></p></th>
                    </tr>

                </tfoot>

                <tbody>
                </tbody>


                </table>
              </div>

            </div>

            <div class="modal-footer form-group row" id="guardar">

            <div class="col-md">
               <input type="hidden" name="_token" value="{{csrf_token()}}">

                <button type="submit" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Registrar</button>

            </div>

            </div>

         </form>

    </div><!--fin del div card body-->
  </main>

@push('scripts')
 <script>

  $(document).ready(function(){

     $("#agregar").click(function(){

         agregar();
     });

  });

   var cont=0;
   total=0;
   subtotal=[];
   $("#guardar").hide();
   $("#id_producto").change(mostrarValores);

     function mostrarValores(){

         datosProducto = document.getElementById('id_producto').value.split('_');
         $("#precio_venta").val(datosProducto[2]);
         $("#stock").val(datosProducto[1]);

     }

     function agregar(){

         datosProducto = document.getElementById('id_producto').value.split('_');

         id_producto= datosProducto[0];
         producto= $("#id_producto option:selected").text();
         cantidad= $("#cantidad").val();
         descuento= $("#descuento").val();
         precio_venta= $("#precio_venta").val();
         stock= $("#stock").val();
         impuesto=20;

          if(id_producto !="" && cantidad!="" && cantidad>0  && descuento!="" && precio_venta!=""){

                if(parseInt(stock)>=parseInt(cantidad)){

                    /*subtotal[cont]=(cantidad*precio_venta)-descuento;
                    total= total+subtotal[cont];*/

                    subtotal[cont]=(cantidad*precio_venta)-(cantidad*precio_venta*descuento/100);
                    total= total+subtotal[cont];

                    var fila= '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger btn-sm" onclick="eliminar('+cont+');"><i class="fa fa-times fa-2x"></i></button></td> <td><input type="hidden" name="id_producto[]" value="'+id_producto+'">'+producto+'</td> <td><input type="number" name="precio_venta[]" value="'+parseFloat(precio_venta).toFixed(2)+'"> </td> <td><input type="number" name="descuento[]" value="'+parseFloat(descuento).toFixed(2)+'"> </td> <td><input type="number" name="cantidad[]" value="'+cantidad+'"> </td> <td>$'+parseFloat(subtotal[cont]).toFixed(2)+'</td></tr>';
                    cont++;
                    limpiar();
                    totales();
                    /*$("#total").html("USD$ " + total.toFixed(2));
                    $("#total_venta").val(total.toFixed(2));*/
                    evaluar();
                    $('#detalles').append(fila);

                } else{

                    //alert("La cantidad a vender supera el stock");

                    Swal.fire({
                    type: 'error',
                    //title: 'Oops...',
                    text: 'La cantidad a vender supera el stock',

                    })
                }

            }else{

                //alert("Rellene todos los campos del detalle de la venta");

                Swal.fire({
                type: 'error',
                //title: 'Oops...',
                text: 'Rellene todos los campos del detalle de la venta',

                })

            }

     }


     function limpiar(){

        $("#cantidad").val("");
        $("#descuento").val("0");
        $("#precio_venta").val("");

     }

     function totales(){

        $("#total").html("USD$ " + total.toFixed(2));
        //$("#total_venta").val(total.toFixed(2));

        total_impuesto=total*impuesto/100;
        total_pagar=total+total_impuesto;
        $("#total_impuesto").html("USD$ " + total_impuesto.toFixed(2));
        $("#total_pagar_html").html("USD$ " + total_pagar.toFixed(2));
        $("#total_pagar").val(total_pagar.toFixed(2));
      }


     function evaluar(){

         if(total>0){

           $("#guardar").show();

         } else{

           $("#guardar").hide();
         }
     }

     function eliminar(index){

        total=total-subtotal[index];
        total_impuesto= total*20/100;
        total_pagar_html = total + total_impuesto;

        $("#total").html("USD$" + total);
        $("#total_impuesto").html("USD$" + total_impuesto);
        $("#total_pagar_html").html("USD$" + total_pagar_html);
        $("#total_pagar").val(total_pagar_html.toFixed(2));

        $("#fila" + index).remove();
        evaluar();
     }

 </script>
@endpush

@endsection
