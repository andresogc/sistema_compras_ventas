@extends('principal')
@section('contenido')
<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/">BACKEND - SISTEMA DE COMPRAS - VENTAS</a></li>
            </ol>
            <div class="container-fluid">


                @foreach($totales as $total)

                <div class="row">

                            <div class="col-lg-6 col-xs-6">
                            <!-- small box -->
                            <div class="card text-white bg-success">
                                <div class="card-body pb-0">
                                    <button class="btn btn-transparent p-0 float-right" type="button">
                                    <i class="fa fa-shopping-cart fa-4x"></i>
                                    </button>
                                    <div class="text-value h2"><strong>USD {{$total->totalcompra}} (MES ACTUAL)</strong></div>
                                    <div class="h2">Compras</div>
                                </div>
                                <div class="chart-wrapper mt-3 mx-3" style="height:35px;">
                                    <a href="{{url('compra')}}" class="small-box-footer h4">Compras <i class="fa fa-arrow-circle-right"></i></a>
                                </div>

                            </div>
                            </div>

                            <div class="col-lg-6 col-xs-6">
                            <!-- small box -->
                            <div class="card text-white bg-warning">
                                <div class="card-body pb-0">
                                    <button class="btn btn-transparent p-0 float-right" type="button">
                                    <i class="fa fa-suitcase fa-4x"></i>
                                    </button>
                                    <div class="text-value h2"><strong>USD {{$total->totalventa}} (MES ACTUAL) </strong></div>
                                    <div class="h2">Ventas</div>
                                </div>
                                <div class="chart-wrapper mt-3 mx-3" style="height:35px;">
                                    <a href="{{url('venta')}}" class="small-box-footer h4">Ventas <i class="fa fa-arrow-circle-right"></i></a>
                                </div>

                            </div>


                            </div><!-- ./col -->

                        </div>

                @endforeach


                        <!-- Estadísticas gráficos -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- compras - meses -->

                                <div class="card card-chart">
                                    <div class="card-header">
                                        <h4 class="text-center">Compras - Meses</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="ct-chart">
                                            <canvas id="compras">
                                            </canvas>
                                        </div>
                                    </div>

                            </div>

                            </div><!--col-md-6-->

                            <div class="col-md-6">

                                <!-- ventas - meses -->

                                <div class="card card-chart">
                                    <div class="card-header">
                                        <h4 class="text-center">Ventas - Meses</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="ct-chart">
                                            <canvas id="ventas">
                                            </canvas>
                                        </div>
                                    </div>

                                </div>


                            </div><!-- col-md-6 -->

                        </div><!--row-->




                @push ('scripts')
                <script src="{{asset('js/Chart.min.js')}}"></script>

                    <script>
                    $(function () {
                        /* ChartJS
                        * -------
                        * Here we will create a few charts using ChartJS
                        */

                        //--------------
                        //- AREA CHART -
                        //--------------

                        /**inicio de compras mes */

                        var varCompra=document.getElementById('compras').getContext('2d');

                            var charCompra = new Chart(varCompra, {
                                type: 'line',
                                data: {
                                    labels: [<?php foreach ($comprasmes as $reg)
                                        {

                                    setlocale(LC_TIME, 'es_ES', 'Spanish_Spain', 'Spanish');
                                    $mes_traducido=strftime('%B',strtotime($reg->mes));

                                    echo '"'. $mes_traducido.'",';} ?>],
                                    datasets: [{
                                        label: 'Compras',
                                        data: [<?php foreach ($comprasmes as $reg)
                                            {echo ''. $reg->totalmes.',';} ?>],

                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        borderWidth:3
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero:true
                                            }
                                        }]
                                    }
                                }
                            });

                            /*fin compras mes* */


                        /**inicio de ventas mes */
                        var varVenta=document.getElementById('ventas').getContext('2d');

                            var charVenta = new Chart(varVenta, {
                                type: 'bar',
                                data: {
                                    labels: [<?php foreach ($ventasmes as $reg)
                                {
                                    setlocale(LC_TIME, 'es_ES', 'Spanish_Spain', 'Spanish');
                                    $mes_traducido=strftime('%B',strtotime($reg->mes));

                                    echo '"'. $mes_traducido.'",';} ?>],
                                    datasets: [{
                                        label: 'Ventas',
                                        data: [<?php foreach ($ventasmes as $reg)
                                        {echo ''. $reg->totalmes.',';} ?>],
                                        backgroundColor: 'rgba(20, 204, 20, 1)',
                                        borderColor: 'rgba(54, 162, 235, 0.2)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero:true
                                            }
                                        }]
                                    }
                                }
                            });

                    });

                    /*fin ventas mes* */



                    </script>
                @endpush

            </div>


        </main>

@endsection
