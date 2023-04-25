<script type="text/javascript">

$(document).ready(function () {
    $('#id_txt_buscar').on('keyup', function() {   
        var vTableKardex = $('#tbl_kardex').DataTable();     
        vTableKardex.search(this.value).draw();
    });
    var table = $('#tbl_kardex').DataTable(
        {
        scrollY:        "900px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   {
            leftColumns: 1,
            rightColumns: 3
        },
        createdRow: function (row, data, index) {
            // Obtener la referencia a la tabla DataTable
            var table = $('#tbl_kardex').DataTable();

            // Obtener las últimas tres celdas de la fila actual
            var lastCells = $('td', row).slice(-3);

            // Agregar la clase CSS personalizada a esas celdas
            lastCells.addClass('bg-soft-success');

            // Obtener las cabeceras de las últimas tres celdas de la tabla
            var lastHeaders = $('th', table.table().header()).slice(-3);

            // Agregar la clase CSS personalizada a esas cabeceras
            lastHeaders.addClass('bg-soft-success');

            // Obtener la última cabecera de la tabla (corresponde a las tres ultimas columnas)
            var lastHeader = $('th:last-child', '#tbl_kardex');

            // Agregar la clase CSS personalizada a esa cabecera
            lastHeader.addClass('bg-soft-success');
        }
        
    });

    

    
    $("#tbl_kardex_length").hide();
    $("#tbl_kardex_filter").hide();
});
</script>