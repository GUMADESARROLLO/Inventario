@extends('layouts.plantilla')
@section('metodosjs')
@include('jsViews.js_articulos')
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
                                <div class="input-group-text bg-transparent" id="btn_upload">
                                    <span class="fas fa-upload fs--1 text-success" ></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
              <div class="row flex-between-center mb-3">
              <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden" id="tbl_productos">
                    <thead class="bg-200 text-900">
                        <tr>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">ARTICULO</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">EXISITENCIA ACTUAL</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">EXISTENCIA EN SISTEMA</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" >Ultima Modificacion</th>
                        
                        
                        </tr>
                    </thead>
                    <tbody class="list" id="table-customers-body">
                        @foreach ($Productos as $producto)  
                        
                        <td class="align-middle">
                        <div class="address d-flex align-items-center position-relative"><img class="rounded-1 border border-200" src="{{ asset('images/item.png') }}"alt="" width="60">
                            <div class="flex-1 ms-3">
                            <h6 class="mb-1 fw-semi-bold text-nowrap">{{ strtoupper($producto->DESCRIPCION) }} : {{ strtoupper($producto->UNIDAD_ALMACEN) }}</h6>
                            <p class="fw-semi-bold mb-0 text-500">{{ strtoupper($producto->ARTICULO) }} | {{ strtoupper($producto->BODEGA) }} - {{ strtoupper($producto->NOMBRE) }} </p>                            
                            <div class="row g-0 fw-semi-bold text-center py-2 fs--1">
                                <div class="col-auto">
                                    <a class="rounded-2 d-flex align-items-center me-3 text-700" href="#!" onclick="OpenModal({{ strtoupper($producto) }})"> 
                                    <span class="ms-1 fas fa-edit text-primary " data-fa-transform="shrink-2" ></span> 
                                    <span class="ms-1">Actualizar</span></a>
                                </div>
                                <div class="col-auto d-flex align-items-center invisible">
                                    <a class="rounded-2 text-700 d-flex align-items-center" href="#!" onclick="" >
                                    <span class="ms-1 fas fa-trash-alt text-danger" data-fa-transform="shrink-2" ></span><span class="ms-1">Descargar</span>
                                    </a>
                                </div>
                            </div> 
                            </div>
                        </div>
                        </td>
                        <td class="address align-middle white-space-nowrap ps-5 py-2">{{ number_format($producto->EXISTENCIA_ACTUAL,2) }} {{ strtoupper($producto->UNIDAD_ALMACEN) }}</td>
                        <td class="address align-middle white-space-nowrap ps-5 py-2">{{ number_format($producto->EXISTENCIA_SISTEMA,2) }} {{ strtoupper($producto->UNIDAD_ALMACEN) }}</td>
                        <td class="address align-middle white-space-nowrap ps-5 py-2">{{ $producto->created_at }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
              </div>
            </div>
            <div class="card-footer">
              
            </div>
          </div>
          @include('layouts.footer')
        </div>
        <div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="authentication-modal-label" aria-hidden="true">
          <div class="modal-dialog modal-xl mt-6" role="document">
            <div class="modal-content border-0">
              <div class="modal-header px-5 position-relative modal-shape-header bg-shape-inn">
                <div class="position-relative z-index-1 light">
                  <h4 class="mb-0 text-white" id="id_titulo_modal"> Carga via excel.</h4>
                </div>
                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body py-4 px-5 ">
                <div class="row">
                  <div class="col-md-12">
                    <input class="form-control" id="frm-upload" type=file  name="files[]"/>
                  </div>
                </div>
                  
                  

                  <div class="mb-3 mt-3">
                    

                      <div class="border-table" >                        
                      <table class="table table-hover table-striped overflow-hidden" id="tbl_excel" >

                      </table>  
                      </div>


                    
                  </div>
                              
                  <div class="mb-3">
                    <button class="btn btn-bg-inn btn-primary d-block w-100 mt-3" id="id_send_data_excel" type="submit" name="submit">Cargar</button>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->


    <!--OPEN MODALS -->
    <div class="modal fade" id="modal_new_product" tabindex="-1">
        <div class="modal-dialog modal-xl">
        <div class="modal-content border-0">
        <div class="modal-header px-5 position-relative modal-shape-header bg-shape-inn">
            <div class="position-relative z-index-1 light">
                <h4 class="mb-0 text-white" id="authentication-modal-label">Ingreso</h4>
            </div>
            <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-card">
                <div class="row">
                    <div class="row flex-between-center">
                        <div class="col-auto">
                            <div class="d-flex align-items-center position-relative mt-0">
                                <div class="avatar avatar-xl ">
                                    <img class="rounded-circle" src="{{ asset('images/item.png') }}"   />
                                </div>
                                <div class="flex-1 ms-3">
                                    <h6 class="mb-0 fw-semi-bold">
                                        <a class="stretched-link text-900 fw-semi-bold" href="#!" >
                                            <div class="stretched-link text-900" id='articulos_header'>Cargando ...</div>
                                        </a>
                                    </h6>
                                    <p class="text-500 fs--2 mb-0"id='articulos_footer'>Cargando ... </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="row g-sm-4">
                                <div class="col-12 col-sm-auto">
                                    <div class="mb-3 pe-4 border-sm-end border-200">
                                        <h6 class="fs--2 text-600 mb-1">Existencia Actual</h6>
                                        <div class="d-flex align-items-center">
                                            <h5 class="fs-0 text-900 mb-0 me-2" id=""> 0.00</h5>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-12 col-sm-auto">
                                <div class="mb-3 pe-4 border-sm-end border-200">
                                    <h6 class="fs--2 text-600 mb-1">Existencia Sistema</h6>
                                <div class="d-flex align-items-center">
                                    <h5 class="fs-0 text-900 mb-0 me-2" id="">0.00</h5>
                                </div>
                            </div>
                        </div>
                            
                        <div class="col-12 col-sm-auto">
                            <div class="mb-3 pe-0">
                                <h6 class="fs--2 text-600 mb-1">Ultima Modificacion</h6>
                                <div class="d-flex align-items-center">
                                    <h5 class="fs-0 text-900 mb-0 me-2" id=""> {{ date('F d, Y, h:m A', strtotime(date('y-m-d')))  }} </h5>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <form class="row g-2 needs-validation" novalidate="">
                <div class="col-md-12">
                    <label class="form-label" for="art_cant_ingreso">Cantidad:</label>
                    <input class="form-control" id="art_cant_ingreso" type="text" required="" />
                    <div class="invalid-feedback">Ingrese una Cantidad.</div>
                </div>
                <div class="col-12">
                    <button class="btn btn-bg-inn btn-primary" type="submit">Guardar</button>
                </div>
            </form>

                
            </div>
        </div>
        </div>
    </div>
        <!--CLOSE MODALS -->

        

@endsection('content')