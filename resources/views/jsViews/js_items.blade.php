<script type="text/javascript">
    var Selectors = {
        TABLE_SETTING: '#modal_new_product',
        LIST_PRODUCT : '#eventLabel'
    };

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
   

    

    var SELECT_ITEM_PRODUCT = document.querySelector(Selectors.LIST_PRODUCT);
    if(SELECT_ITEM_PRODUCT) {
        const choices = new Choices(SELECT_ITEM_PRODUCT); 
    }
    var vTableArticulos= $('#tbl_productos').DataTable({
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
    });
    
    $("#tbl_productos_length").hide();
    $("#tbl_productos_filter").hide();
    $('#id_txt_buscar').on('keyup', function() {        
        vTableArticulos.search(this.value).draw();
    });

    $("#id_send_frm_produc").click(function(){

        var id_clasificacion_1     = $("#id_clasificacion_1 option:selected").val();  
        var id_clasificacion_2      = $("#id_clasificacion_2 option:selected").val();  
        var ID_iTEM     = $("#id_modal_state").text();  

        id_clasificacion_1   = isValue(id_clasificacion_1,'N/D',true)
        id_clasificacion_2   = isValue(id_clasificacion_2,'N/D',true)

        if(id_clasificacion_1 === 'N/D' || id_clasificacion_2 ==='N/D'){
            Swal.fire("Oops", "Datos no Completos", "error");
        }else{

            $.ajax({
                url: "UpdateArticulo",
                type: 'post',
                data: {
                    ID_iTEM     : ID_iTEM,
                    id_clasificacion_1   : id_clasificacion_1,
                    id_clasificacion_2   : id_clasificacion_2,
                    _token  : "{{ csrf_token() }}" 
                },
                async: true,
                success: function(response) {
                    if(response.original){
                        Swal.fire({
                        title: 'Correcto',
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
                    Swal.fire("Oops", "No se ha podido guardar!", "error");
                }
            }).done(function(data) {
                //location.reload();
            });

        }

    });
    function OpenModal(Producto){ 

        console.log(Producto.Clasificacion_1)

        var TABLE_SETTING = document.querySelector(Selectors.TABLE_SETTING);
        var modal = new window.bootstrap.Modal(TABLE_SETTING);
        modal.show();

        $("#id_modal_state").text(Producto.ID);  
        $("#id_clasificacion_1").val(Producto.Clasificacion_1).change();
        $("#id_clasificacion_2").val(Producto.Clasificacion_2).change();

    }


</script>
