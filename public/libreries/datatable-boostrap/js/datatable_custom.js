$(document).ready(function () {

    //code datatable
    var table = $('#example').DataTable({
        lengthMenu: [[10, 20, 50, 100, 1000, 10000], ['10', '20', '50', '100', '1000', '10000']],
        "lengthChange": false,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "paging": true,
        //colReorder: true,
        "searching": true,
        "language": {
            
            "sProcessing": '<p style="color: #012d02;">Cargando. Por favor espere...</p>',
            //"sProcessing": '<img src="https://media.giphy.com/media/3o7bu3XilJ5BOiSGic/giphy.gif" alt="Funny image">',
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": 'Buscar Datos:',
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": 'Primero',
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        },
        "bDestroy": true,
        "bJQueryUI": true,
        //datos
        "ajax": {
            "url": "index.php?r=cobros-varios/datatable",
            //"type": "POST"
            //sirve para enviar variables en la peticion http
            "data": function (d) {
                //console.log(d);
                //d.myKey = "myValue";
                d.search_custon = d.search.value;  //usar variables para filtros.
                // d.custom = $('#myInput').val();
            }
        },
        // "rowCallback": function( row, data ) { //para diferenciar las columnas
        //     //console.log(data);
        //     // if ( true ) {
        //     //     $(row).addClass('selected');
        //     // }
        // },
        "columns": [
            {
                sortable: false,
                "render": function (data, type, row, meta) {
                    var value = meta.row + meta.settings._iDisplayStart + 1; //contador de numeros.
                    return value.toString();
                }
            },
            { "data": "num_sec.toString()"},
            { "data": "estado" },
            { "data": "ci" },
            { "data": "nombre" },
            { "data": "direccion" },
            // { "data": "actividad" },
            //{'defaultContent': '<button value="'+"ci"+'">Click!</button>'} //contenido default
            {
                sortable: false,
                "render": function (data, type, row, meta) {
                    //console.log(row);
                    return '<button value="' + row.nombre + '" type="button" class="btn btn-primary">OK</button>';
                }
            }
        ],
        dom: 'Bfrtip',
        buttons: ['pageLength', {
            extend: 'excelHtml5',
            titleAttr: 'Se exportará el reporte según a la cantidad de filas.',
            autoFilter: true,
            title: 'Reporte de Boleta de Infracción',
            text: 'EXPORTAR EXEL',
            //message: "Any message for header inside the file. I am not able to put message in next row in excel file but you can use \n",
            customize: function (xlsx) {
            },
            
        },
      
            // export funtion pdf
            // {
            //     extend: 'pdfHtml5',
            //     titleAttr: 'Exportar el resporte a PDF',
            //     text: 'EXPORTAR PDF',
            //     title: 'REPORTE DE FUNCIONARIOS',
            //     alignment: 'center',
            //     orientation: 'landscape',
            //     customize: function (doc) {

            //         doc.content.splice(0, 0, {
            //             margin: [0, 0, 0, -25],
            //             alignment: 'left',
            //             image: '',
            //             width: 260,
            //         });
            //         doc.styles.tableHeader.fillColor = '#CEF6F5';
            //         doc.styles.tableHeader.color = '#0B4C5F';
            //         doc.defaultStyle.fillColor = '#EFF5FB';
            //         doc.defaultStyle.fontSize = 8;
            //         doc.defaultStyle.alignment = 'center';
            //         doc.styles.tableHeader.fontSize = 8;
            //         //doc.content.splice(0,1);
            //         var now = new Date();
            //         var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear();

            //         doc['footer'] = (function (page, pages) {
            //             return {
            //                 columns: [
            //                     {
            //                         alignment: 'left',
            //                         text: ['Generado el: ', {text: jsDate.toString()}]
            //                     },
            //                     {
            //                         alignment: 'right',
            //                         text: ['Pagina ', {text: page.toString()}, ' de ', {text: pages.toString()}]
            //                     }
            //                 ],
            //                 margin: 20
            //             }
            //         });

            //     }
            // },
            {
                extend: 'csvHtml5',
                titleAttr: 'Exportar el resporte a CSV',
                text: 'EXPORTAR CSV',
                title: 'Any title for the file',
                customize: function (csv) {
                    
                    return "Any heading for the csv file can be separated with , and for new line use \n" + csv;
                }
            },
             {
                extend: 'copyHtml5',
                text: 'COPIAR',
                titleAttr: 'Copiar en el portapapeles'
            },
        ]
    });

    //buscador por filtro en un datatable
    // $('#dropdown1').on('change', function () {
    //     table.columns(2).search( this.value ).draw(); //es para filtrar datos desde un dropdawn
    // } );
    
    // $('#dropdown2').on('change', function () {
    //     table.columns(2).search( this.value ).draw();
    // } );

});