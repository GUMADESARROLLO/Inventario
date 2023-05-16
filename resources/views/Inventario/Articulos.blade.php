@extends('layouts.plantilla')
@section('metodosjs')
@include('jsViews.js_items');
@endsection
@section('content')

<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">
    <div class="container-fluid" data-layout="container">
        <div class="content">
            @include('layouts.nav')
            <div class="card mb-3" id="customersTable">
                <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Master de Articulos</h5>
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
                <div class="table-responsive">
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden" id="tbl_productos">
                    <thead class="bg-200 text-900">
                        <tr>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">ARTICULO</th>
                        <th class="sort pe-1 align-middle white-space-nowrap ps-5" data-sort="address" style="min-width: 200px;">CREADO</th>
                        
                        
                        </tr>
                    </thead>
                    <tbody class="list" id="table-customers-body">
                        @foreach ($Articulos as $producto)  
                        
                        <td class="align-middle">
                        <div class="address d-flex align-items-center position-relative"><img class="rounded-1 border border-200" src="{{ asset('images/item.png') }}"alt="" width="60">
                            <div class="flex-1 ms-3">
                            <h6 class="mb-1 fw-semi-bold text-nowrap"><strong>#{{ strtoupper($producto->ID) }} </strong> : {{ strtoupper($producto->DESCRIPCION) }} : {{ strtoupper($producto->ARTICULO) }}</h6>
                            <p class="fw-semi-bold mb-0 text-500">{{ strtoupper($producto->DESCRIPCION) }}</p>                            
                            <div class="row g-0 fw-semi-bold text-center py-2 fs--1">
                                <div class="col-auto">
                                    <a class="rounded-2 d-flex align-items-center me-3 text-700" href="#!" onclick="OpenModal({{$producto}})"> <span class="ms-1 fas fa-pencil-alt text-primary " data-fa-transform="shrink-2" ></span> 
                                    <span class="ms-1">Editar</span></a>
                                </div>
                                <div class="col-auto d-flex align-items-center"> 
                                    @if (Auth::user()->id_rol == 4 || Auth::user()->id_rol == 1)
                                        <span class="ms-3 badge rounded-pill bg-info"> {{ $producto->user->rol->descripcion }}</span> 
                                    @endif   
                                    @if(!empty($producto->Clasificacion_1))
                                        <span class="ms-3 badge rounded-pill bg-info"> {{ strtoupper($producto->Clasificacion1->DESCRIPCION) }}</span>
                                    @endif 
                                    @if(!empty($producto->Clasificacion_2))
                                        <span class="ms-3 badge rounded-pill bg-info"> {{ strtoupper($producto->Clasificacion2->DESCRIPCION) }}</span>
                                    @endif                                 
                                </div>
                            </div> 
                            </div>
                        </div>
                        </td>
                        <td class="address align-middle white-space-nowrap ps-5 py-2">{{ date('F d, Y, h:m A', strtotime($producto['created_at']))  }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                </div>


        </div>

        <!--OPEN MODALS -->
        <div class="modal fade" id="modal_new_product" tabindex="-1">
          <div class="modal-dialog modal-xl">
            <div class="modal-content border-0">
            <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                <div class="position-relative z-index-1 light">
                    <h4 class="mb-0 text-white" id="authentication-modal-label">Producto</h4>
                    <p class="fs--1 mb-0 text-white invisible"> --- </p>
                    <p class="fs--1 mb-0 text-white invisible" id="id_modal_state"> - </p>
                </div>
                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
                <div class="modal-body p-card">
                   
                 

                  <div class="row g-2">
                    
                    <div class="col-md-6 col-sm-12 col-xxl-6">
                        <div class="mb-3">
                            <label class="fs-0" for="id_tipo">CLASIFICACION 1</label>
                            <select class="form-select" id="id_clasificacion_1" name="label" required="required">
                                @foreach ($Clasifica as $cl)
                                <option value="{{$cl->ID}}"> {{strtoupper($cl->DESCRIPCION)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xxl-6">
                        <div class="mb-3">
                            <label class="fs-0" for="id_tipo">CLASIFICACION 2</label>
                            <select class="form-select" id="id_clasificacion_2" name="label" required="required">
                                @foreach ($Clasifica as $cl)
                                <option value="{{$cl->ID}}"> {{strtoupper($cl->DESCRIPCION)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                  </div>

                  
                </div>
                <div class="card-footer d-flex justify-content-end align-items-center bg-light">
                  <button class="btn btn-primary px-4" id="id_send_frm_produc" type="submit">Guardar</button>
                </div>
            </div>
          </div>
        </div>
        <!--CLOSE MODALS -->
    </div>
</main>
@endsection('content')