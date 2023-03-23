<script type="text/javascript">
    var Selectors = {
        TABLE_SETTING: '#modal_new_product',
        TABLE_UPLOARD: '#modal_upload'
    };

    dta_table_excel = [];
    var isError = false

    $(document).ready(function () {
       

       
        $('#id_txt_buscar').on('keyup', function() {   
            var vTableArticulos = $('#tbl_productos').DataTable();     
            vTableArticulos.search(this.value).draw();
        });

        $("#btn_upload").click(function(){

            

            var addMultiRow = document.querySelector(Selectors.TABLE_UPLOARD);
            var modal = new window.bootstrap.Modal(addMultiRow);
            modal.show();


        });

        $('#frm-upload').on("change", function(e){ 
            handleFileSelect(e)
        });

        initTable('#tbl_productos');
    });

  
    function OpenModal(Articulo){
        var HeaderArticulo = Articulo.DESCRIPCION + " : " + Articulo.UNIDAD_ALMACEN
        var FooterArticulo = Articulo.ARTICULO + " | " + Articulo.BODEGA +" - " + Articulo.NOMBRE


        $("#articulos_header").text(HeaderArticulo) 
        $("#articulos_footer").text(FooterArticulo) 

        var TABLE_SETTING = document.querySelector(Selectors.TABLE_SETTING);
        var modal = new window.bootstrap.Modal(TABLE_SETTING);
        modal.show();
    }

    function initTable(id){
        $(id).DataTable({
        "destroy": true,
        "info": false,
        "bPaginate": true,
        "order": [
            [0, "asc"]
        ],
        "lengthMenu": [
            [7, -1],
            [7, "Todo"]
        ],
        "language": {
            "zeroRecords": "NO HAY COINCIDENCIAS",
            "paginate": {
                "first": "Primera",
                "last": "Última ",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "lengthMenu": "MOSTRAR _MENU_",
            "emptyTable": "-",
            "search": "BUSCAR"
        },
        });

        $(id+"_length").hide();
        $(id+"_filter").hide();
    }
    function table_render(Table,datos,Header,Filter){

        $(Table).DataTable({
            "data": datos,
            "destroy": true,
            "info": false,
            "bPaginate": true,
            "order": [
                [0, "asc"]
            ],
            "lengthMenu": [
                [10, -1],
                [10, "Todo"]
            ],
            "language": {
                "zeroRecords": "NO HAY COINCIDENCIAS",
                "paginate": {
                    "first": "Primera",
                    "last": "Última ",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "lengthMenu": "MOSTRAR _MENU_",
                "emptyTable": "-",
                "search": "BUSCAR"
            },
            'columns': Header,
            "columnDefs": [
                {
                    "visible": false,
                    "searchable": false,
                    "targets": [0]
                },
            ],
            rowCallback: function( row, data, index ) {
                if ( data.Index == 'N/D' ) {
                    $(row).addClass('table-danger');
                } 
            }
        });
        if(!Filter){
            $(Table+"_length").hide();
            $(Table+"_filter").hide();
        }

    }
    var ExcelToJSON = function() {

        this.parseExcel = function(file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var data = e.target.result;
            var workbook = XLSX.read(data, {type: 'binary'});
           
            workbook.SheetNames.forEach(function(sheetName) {

               

                if(sheetName=='INV GRL'){
                    dta_table_excel = [];
                    isError=false;

                    var worksheet = workbook.Sheets[sheetName];
                    var range = XLSX.utils.decode_range('B4:E100');
                    var rows = XLSX.utils.sheet_to_json(worksheet, {range: range});
                    
                    

                    rows.forEach(function(row) {
                        var _Codigo   = isValue(row.Codigo,'N/D',true)
                        var index     = _Codigo;
                        var _Total    = numeral(isValue(row.Total,'0',true)).format('00.00')
                        var _Descr    = isValue(row["Descripcion de Producto"],'Columna <strong>"Descripcion de Producto"</strong> no Encontrada',true)

                        if(_Codigo == 'N/D'){
                            isError=true
                        }

                        if (/^[0-9N]/.test(_Codigo.charAt(0))){
                            dta_table_excel.push({ 
                                Index: _Codigo,
                                Articulo: _Codigo,
                                Descr: _Descr,
                                Total : _Total
                            })
                            
                        }
                    });

                    if(isError){
                        Swal.fire("Codigo de Articulo No encontrado", "Existen articulos sin Definicion de Codigo ", "error");
                    }

                    dta_table_header = [
                        {"title": "Index","data": "Index"}, 
                        {"title": "Articulo","data": "Articulo"},
                        {"title": "Descripcion","data": "Descr"},                                     
                        {"title": "Total","data": "Total"},
                    ]
                    table_render('#tbl_excel',dta_table_excel,dta_table_header,false)
                }
            })
        };

        reader.onerror = function(ex) {

        };

        reader.readAsBinaryString(file);

        };
    };

    $("#id_send_data_excel").click(function(){ 
     
        
        if(!isError){
        Swal.fire({
            title: '¿Estas Seguro de cargar  ?',
            text: "¡Se cargara la informacion previamente visualizada!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si!',
            target: document.getElementById('mdlMatPrima'),
            showLoaderOnConfirm: true,
            preConfirm: () => {
                $.ajax({
                    url: "GuardarInventario",
                    data: {
                        datos   : dta_table_excel,
                        _token  : "{{ csrf_token() }}" 
                    },
                    type: 'post',
                    async: true,
                    success: function(response) {
                        if(response){
                            Swal.fire({
                                title: 'Articulos Ingresados Correctamente ' ,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'OK'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                    }
                                })
                            }
                        },
                    error: function(response) {
                        //Swal.fire("Oops", "No se ha podido guardar!", "error");
                    }
                    }).done(function(data) {
                        //CargarDatos(nMes,annio);
                    });
                },
            allowOutsideClick: () => !Swal.isLoading()
        });

            
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Existen articulos sin Definicion de Codigo ",
                
            })
        }
    })
    function handleFileSelect(evt) {    
        var files = evt.target.files;
        var xl2json = new ExcelToJSON();
        xl2json.parseExcel(files[0]);
    }
    function isValue(value, def, is_return) {
        if ( $.type(value) == 'null'
            || $.type(value) == 'undefined'
            || $.trim(value) == '(en blanco)'
            || $.trim(value) == ''
            || ($.type(value) == 'number' && !$.isNumeric(value))
            || ($.type(value) == 'array' && value.length == 0)
            || ($.type(value) == 'object' && $.isEmptyObject(value)) ) {
            return ($.type(def) != 'undefined') ? def : false;
        } else {
            return ($.type(is_return) == 'boolean' && is_return === true ? value : true);
        }
    }
</script>