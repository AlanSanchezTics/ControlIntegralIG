$(document).ready(function () {
    listar();
    guardarData();
    eliminarData();
    $(".logout").on('click', function () {
        window.location.replace('../logout.php');
    });
});
var listar = function () {
    var table = $("#admintable").DataTable({
        destroy: true,
        language: langSpa,
        ajax: {
            "method": "POST",
            "url": "admin-list.php"
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
    $("#admintable").width("100%");
    obtener_data_editar("#admintable tbody", table);
    obtener_data_eliminar("#admintable tbody", table);
    nuevo_Admin();
};

var obtener_data_eliminar = function (tbody, table) {
    $(tbody).on('click', 'button.eliminar', function () {
        var row = $(this).closest('tr');
        if (row.hasClass('child')) {
            row = row.prev();
        }
        var data = table.row(row).data();
        $("#idadminTodelete").val(data.id);
        $("#iduserTodelete").val(data.usu_ID);
        $('#message-confirm').html("¿Esta seguro de desactivar a " + data.nombre + "?");
    });
}
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
        $("#idadmin").val(data.id);
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
var nuevo_Admin = function () {
    $("#addAdmin").on("click", function () {
        limpiar_forms();
        $("#labelpass").html("Contraseña");
        $("#labelpass2").html("Confirmar contraseña");
        $("#modal-form").modal("show");
    });
}
var guardarData = function () {
    $('#admin-form').on('submit', function (e) {
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
                console.log(response);

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
            alert("Los datos del administrador han sido actualizados con exito.");
            limpiar_forms();
            $('#modal-form').modal('hide');
            break;
        case "EXISTADMIN":
            alert("Los datos coinciden con otro administrador registrado.");
            break;
        case "WRONGPASS":
            alert("La contraseña anterior es incorrecta.");
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
            alert("El usuario ya esta siendo usado por otro administrador.");
            $("#usuario").focus();
            break;
        case "DELETED":
            alert("Administrador desactivado con exito.");
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
            alert("El administrador ha sido registrado con exito.");
            limpiar_forms();
            $('#modal-form').modal('hide');
            break;
        case "ACTIVED":
            alert("El administrador ha sido activado con exito.");
            break;
        default:
            alert("Problemas con el servidor al momento de realizar la petición. Contacte al administrador.");
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