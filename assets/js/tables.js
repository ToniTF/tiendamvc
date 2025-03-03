$(document).ready(function() {
    $('#orders_table').DataTable({
        language: {
            "sProcessing":   "Procesando...",
            "sLengthMenu":   "Mostrar _MENU_ órdenes",
            "sZeroRecords":  "No se encontraron órdenes",
            "sEmptyTable":   "Ninguna orden disponible",
            "sInfo":         "Mostrando órdenes del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty":    "Mostrando órdenes del 0 al 0 de un total de 0",
            "sInfoFiltered": "(filtrado de un total de _MAX_ órdenes)",
            "sInfoPostFix":  "",
            "sSearch":       "Buscar:",
            "sUrl":          "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de forma ascendente",
                "sSortDescending": ": Activar para ordenar la columna de forma descendente"
            }
        },
        // Otras opciones de configuración que utilices
        columnDefs: [
            {
                targets: [0],
                orderData: [0, 1]
            },
            {
                targets: [1, 2, 4],
                searchable: true
            },
            {
                targets: [0, 3, 5],
                searchable: false
            }
        ]
    });
});
$(document).ready(function() {
    $('#products_table').DataTable({
        language: {
            "sProcessing":   "Procesando...",
            "sLengthMenu":   "Mostrar _MENU_ productos",
            "sZeroRecords":  "No se encontraron productos",
            "sEmptyTable":   "Ningún producto disponible",
            "sInfo":         "Mostrando productos del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty":    "Mostrando productos del 0 al 0 de un total de 0",
            "sInfoFiltered": "(filtrado de un total de _MAX_ productos)",
            "sInfoPostFix":  "",
            "sSearch":       "Buscar:",
            "sUrl":          "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de forma ascendente",
                "sSortDescending": ": Activar para ordenar la columna de forma descendente"
            }
        },
        // Otras opciones de configuración que utilices
        columnDefs: [
            {
                targets: [0],
                orderData: [0, 1]
            },
            {
                targets: [1, 2, 4],
                searchable: true
            },
            {
                targets: [0, 3, 5],
                searchable: false
            }
        ]
    });
});

