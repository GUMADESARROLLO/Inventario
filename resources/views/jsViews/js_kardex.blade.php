<script type="text/javascript">

$(document).ready(function () {
    $('#id_txt_buscar').on('keyup', function() {   
        var vTableKardex = $('#tbl_kardex').DataTable();     
        vTableKardex.search(this.value).draw();
    });
    var table = $('#tbl_kardex').DataTable(
        {
        scrollY:        "500px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   {
            leftColumns: 1,
        },
        createdRow: function (row, data, index) {
            
        }
        
    });

    

    
    $("#tbl_kardex_length").hide();
    $("#tbl_kardex_filter").hide();
});
</script>