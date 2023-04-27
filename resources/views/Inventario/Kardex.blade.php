@extends('layouts.lyt_kardex')
@section('metodosjs')
@include('jsViews.js_kardex')
@endsection
@section('content')

<!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <div class="container-fluid" data-layout="container">
        <div class="content">
          @include('layouts.nav')
          <div class="card" >
            <div class="card-header">
                <div class="row flex-between-center ">
                    <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Registro de Kardex del período {{$d1}} al {{$d2}}.</h5>
                    </div>
                    <div class="col-8 col-sm-auto text-end ps-2">
                        <div id="table-customers-replace-element">
                            <div class="input-group" >
                                <input class="form-control form-control-sm shadow-none search" type="search" placeholder="Buscar..." aria-label="search" id="id_txt_buscar" />
                                <div class="input-group-text bg-transparent">
                                    <span class="fa fa-search fs--1 text-600"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
              <div class="row flex-between-center mb-3">
              <table class="table nowrap table-bordered" id="tbl_kardex" style="width:100%">
                <thead class="bg-200 text-900">
                    <tr>
                        <th rowspan="2">ARTICULO</th>
                        @foreach ($Kardex['header_date'] as $k) 
                            <th colspan="3" style="text-align:center">{{date('d-M-y',strtotime($k))}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($Kardex['header_date'] as $k) 
                            <th>Ingreso</th>
                            <th>Egreso</th>
                            <th>Saldo</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Kardex['header_date_rows'] as $r)
                        <tr>
                            <td>                               
                                <div class="d-flex align-items-center position-relative">                              
                              <div class="flex-1">
                                <h6 class="mb-0 fw-semi-bold"> {{$r['DESCRIPCION']}}</h6>
                                <p class="text-500 fs--2 mb-0"> {{$r['ARTICULO']}} | {{$r['UND']}}</p>
                              </div>
                            </div>
                            </td>
                            @foreach ($Kardex['header_date'] as $k) 
                                <td> <p class="text-end">{{$r['IN01_'.date('Ymd',strtotime($k))]}}</p> </td>
                                <td> <p class="text-end">{{$r['OUT02_'.date('Ymd',strtotime($k))]}}</p></td>
                                <td> <p class="text-end">{{$r['STOCK03_'.date('Ymd',strtotime($k))]}}</p></td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
                </table>
              </div>
            </div>
            
          </div>
          @include('layouts.footer')
        </div>
        
      </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->


        

@endsection('content')