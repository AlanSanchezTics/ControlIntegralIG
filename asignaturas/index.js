$(document).ready(function () {
    getDocs();
    listar();
    guardarData();
    $(".logout").on('click', function () {
        window.location.replace('../logout.php');
    });
});
var listar = function(){
    var table = $("#asigtable").DataTable({
        destroy: true,
        language: langSpa,
        ajax: {
            "method": "POST",
            "url": "asig-list.php"
        },
        "columns": [
            { "data": "id" },
            { "data": "materia" },
            { "data": "docente" },
            { "defaultContent": '<button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ],
        responsive: true
    });
    $("#asigtable").width("100%");
    nueva_Asig();
    obtener_data_editar("#asigtable tbody", table);
    obtener_data_eliminar("#asigtable tbody", table);
}
var getDocs = function () {
    $.ajax({
        type: "POST",
        url: "process.php",
        data: {'opcion':'GETDOCS'},
        success: function (response) {
            var data = JSON.parse(response);
            var template = ``;
            $.each(data, function (index, value) { 
                $.map(value, function (element, item) {
                    template += `<option value="${element.id}">${element.nombre} ${element.apaterno} ${element.amaterno}</option>`;
                });
            });
            $(".docs").html(template);
        }
    });
}
var nueva_Asig = function () {
    $("#addAsig").on("click", function () {
        limpiar_forms();
        $("#modal-form").modal("show");
    });
}
var limpiar_forms = function () {
    $('form').trigger("reset");
    $('#opcion').val("REGISTRAR");
    $('#opcion2').val("ELIMINAR");
}
var obtener_data_editar = function (tbody, table) {  
    $(tbody).on('click', 'button.editar', function () {
        limpiar_forms();
        var row = $(this).closest('tr');
        if (row.hasClass('child')) {
            row = row.prev();
        }
        var data = table.row(row).data();
        $("#opcion").val("EDITAR");
        $("#asignatura").val(data.materia);
        $("#docente").val(data.iddoc);
        $("#idasignatura").val(data.id);
    });
}
var obtener_data_eliminar = function (tbody, table) {
    $(tbody).on('click', 'button.eliminar', function () {
        limpiar_forms();
        var row = $(this).closest('tr');
        if (row.hasClass('child')) {
            row = row.prev();
        }
        var data = table.row(row).data();
        $("#idasigTodelete").val(data.id);
        $('#message-confirm').html("¿Esta seguro de eliminar la asignatura " + data.materia + "?");
    });
}
var guardarData = function () {
    $('form').on('submit', function (e) {
        var $btn = $("form button[type='submit']").button('loading');
        e.preventDefault();
        var frm = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "process.php",
            data: frm,
            success: function (response) {
                val_respuesta(response);
                $btn.button('reset');
            }
        });
    });
}
var val_respuesta = function (response) {
    switch (response) {
        case 'EXIST':
            swal({
            title:'Ups!',
            text: 'La asignatura ya se encuentra registrada',
            type: 'warning'
            });
            break;
        case 'UPDATED':
            listar();
            swal({
            title:'Listo!',
            text: 'Los datos de la asignatura han sido actualizados con exito',
            type: 'success'
            });
            limpiar_forms();
            $('#modal-form').modal('hide');
            break;
        case 'ADDED':
            listar();
            swal({
            title:'Listo!',
            text: 'La asignatura ha sido registrada con exito',
            type: 'success'
            });
            limpiar_forms();
            $('#modal-form').modal('hide');
            break;
        case 'DELETED':
            listar();
            swal({
            title:'Listo!',
            text: 'La asignatura ha sido eliminada con exito',
            type: 'success'
            });
            limpiar_forms();
            $('#modal-confirm').modal('hide');
            break;
        default:
            swal({
            title:'Ups!',
            text: 'Problemas con el servidor al momento de realizar la petición. Contacte al administrador. '+response,
            type: 'warning'
            });
            break;
    }
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