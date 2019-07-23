$(document).ready(function () {
    listar();
    guardarData();
    eliminarData();
    $(".logout").on('click', function () {
        window.location.replace('../logout.php');
    });
});

var listar = function () {
    var table = $("#DocTable").DataTable({
        destroy: true,
        language: langSpa,
        ajax: {
            "method": "POST",
            "url": "doc-list.php"
        },
        "columns": [
            { "data": "id" },
            { "data": "nombre" },
            { "data": "apaterno" },
            { "data": "amaterno" },
            { "data": "telefono" },
            { "data": "email" },
            { "data": "usuario" },
            { "defaultContent": '<button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ],
        responsive: true
    });
    table.ajax.reload();
    $("#DocTable").width("100%");
    obtener_data_eliminar("#DocTable tbody",table);
    obtener_data_editar("#DocTable tbody",table);
    nuevo_Doc();
}
var nuevo_Doc = function () {
    $("#addDoc").on("click", function () {
        limpiar_forms();
        $("#labelpass").html("Contraseña");
        $("#labelpass2").html("Confirmar contraseña");
        $("#modal-form").modal("show");
    });
};
var obtener_data_eliminar = function (tbody, table) {
    $(tbody).on('click', 'button.eliminar', function () {
        var row = $(this).closest('tr');
        if (row.hasClass('child')) {
            row = row.prev();
        }
        var data = table.row(row).data();
        $("#iddocTodelete").val(data.id);
        $("#iduserTodelete").val(data.usu_ID);
        $('#message-confirm').html("¿Esta seguro de desactivar a " + data.nombre + "?");
    });
};
var obtener_data_editar = function (tbody, table) {
    $(tbody).on('click', 'button.editar', function () {
        limpiar_forms();
        $("#labelpass").html("Contraseña anterior");
        $("#labelpass2").html("Nueva contraseña");
        var row = $(this).closest('tr');
        if (row.hasClass('child')) {
            row = row.prev();
        }
        var data = table.row(row).data();
        $("#iddoc").val(data.id);
        $("#iduser").val(data.usu_ID);
        $("#nombre").val(data.nombre);
        $("#a-paterno").val(data.apaterno);
        $("#a-materno").val(data.amaterno);
        $("#telefono").val(data.telefono);
        $("#email").val(data.email);
        $("#usuario").val(data.usuario);
        $("#opcion").val("EDITAR");
    });
};
var guardarData = function () {
    $('#doc-form').on('submit', function (e) {
        e.preventDefault();
        var div = $("#pass2")[0].parentElement;
        $(div).removeClass("has-error");
        $("#help-block08").html("");
        var frm = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "process.php",
            data: frm,
            success: function (response) {
                val_respuesta(response);
            }
        });
    });
}
var eliminarData = function () {
    $('#form-delete').on('submit', function (e) {
        e.preventDefault();
        var frm = $(this).serialize();
        $("#modal-confirm").modal('hide');
        $.ajax({
            type: "POST",
            url: "process.php",
            data: frm,
            success: function (response) {
                listar();
                limpiar_forms();
                val_respuesta(response);
            }
        });
    });
}
var limpiar_forms = function () {
    $('form').trigger("reset");
    $('#opcion').val("REGISTRAR");
    $('#opcion2').val("ELIMINAR");
}
var val_respuesta = function (response) {
    switch (response) {
        case "UPDATED":
            listar();
            swal({
            title:'Listo!',
            text: 'Los datos del docente han sido actualizados con exito.',
            type: 'success'
            });
            limpiar_forms();
            $('#modal-form').modal('hide');
            break;
        case "EXISTDOC":
            swal({
            title:'Ups!',
            text: 'Los datos coinciden con otro docente registrado.',
            type: 'warning'
            });
            break;
        case "WRONGPASS":
            swal({
            title:'Ups!',
            text: 'La contraseña anterior es incorrecta',
            type: 'error'
            });
            $("#pass").focus();
            break;
        case "EMPTYPASS":
            var div = $("#pass2")[0].parentElement;
            $("#help-block08").addClass("help-block");
            $("#help-block08").html("Existe inconsistencia en las contraseñas, reviselas.");
            $(div).addClass("has-error");
            $("#pass2").focus();
            break;
        case "EXISTUSER":
            swal({
            title:'Ups!',
            text: 'El usuario ya esta siendo usado por otro docente',
            type: 'warning'
            });
            $("#usuario").focus();
            break;
        case "DELETED":
            swal({
            title:'Listo!',
            text: 'Docente desactivado con exito',
            type: 'success'
            });
            break;
        case "INCOMPATIBLE":
            var div = $("#pass2")[0].parentElement;
            $("#help-block08").addClass("help-block");
            $("#help-block08").html("Existe inconsistencia en las contraseñas, reviselas.");
            $(div).addClass("has-error");
            $("#pass2").focus();
            break;
        case "ADDED":
            listar();
            swal({
            title:'Listo!',
            text: 'El Docente ha sido registrado con exito',
            type: 'success'
            });
            limpiar_forms();
            $('#modal-form').modal('hide');
            break;
        case "ACTIVED":
            swal({
            title:'Listo!',
            text: 'El Docente ha sido activado con exito',
            type: 'success'
            });
            break;
        default:
            swal({
            title:'Ups!',
            text: 'Problemas con el servidor al momento de realizar la petición. Contacte al administrador',
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