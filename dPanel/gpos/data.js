$(function () {
    listar();
    $(".logout").on('click', function () {
        window.location.replace('../../logout.php');
    });
});
var listar = function () {
    
    $.ajax({
        type: "POST",
        url: "process.php",
        data: {'opcion':"GETGPOS"},
        success: function (response) {
            var gpos = JSON.parse(response);
            var templateTabs = ``;
            var templateDivs =``;
            $.map(gpos, function (element, index) {
                templateTabs += `<li role="presentation" class="${index==0 ? 'active' : ''}"><a href="#tab_${element.gpo}" id="${element.gpo}-tab" role="tab" data-toggle="tab" aria-expanded="true">${element.gpo}</a>`;
                templateDivs += `
                <div role="tabpanel" class="tab-pane fade ${index == 0 ? 'active in':''}" id="tab_${element.gpo}" aria-labelledby="home-tab">
                    <div class="table-responsive">
                        <table id="tbl-${element.gpo}" data-ref="${element.id}" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" class="head">No. Control</th>
                                    <th scope="col" class="head">Nombre(s)</th>
                                    <th scope="col" class="head">Apellido Paterno</th>
                                    <th scope="col" class="head">Apellido Materno</th>
                                    <th scope="col" class="head">Telefono</th>
                                    <th scope="col" class="head">Correo</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>`;
            });
            $("#myTab").html(templateTabs);
            $("#myTabContent").html(templateDivs);
            $.map(gpos, function (element, index) {
                var table = "#tbl-"+element.gpo;
                //console.log($(table).attr("data-ref"));
                $(table).DataTable({
                    destroy: true, 
                    responsive: true,
                    language: langSpa,
                    ajax: {
                        method: "POST",
                        data: { 'opcion': 'GETALUMNOS', 'grupo': $(table).attr("data-ref") },
                        url: "process.php",
                    },
                    "columns": [
                        { "data": "noControl" },
                        { "data": "nombre" },
                        { "data": "apaterno" },
                        { "data": "amaterno" },
                        { "data": "telefono" },
                        { "data": "email" },
                    ]
                });
            });
            $("table").width("100%");
        }
    });
}
var langSpa = {
    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
    "sUrl": "",
    "sInfoThousands": ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
};