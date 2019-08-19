$(document).ready(function () {
    listar();
    getGrados();
    getDocs();
    guardarData();
    $(".logout").on('click', function () {
        window.location.replace('../logout.php');
    });
});
var listar = function () {
    var tablaPK = $("#tblPK").DataTable({
        destroy: true,
        language: langSpa,
        responsive: true,
        ajax:{
            method:"POST",
            url:"gpo-list.php",
            data:{"nivel":0}
        },
        columns:[
            {"data":"id"},
            {"data":"gpo"},
            {"data":"doc-esp"},
            {"data":"doc-ing"},
            {"defaultContent": `<button title="Ver Tareas" class="tareas btn btn-info btn-sm" data-toggle="modal" data-target="#modal-tareas"><i class="fa fa-book-open"></i></button> <button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>`, className:"max"}
        ]
    });
    var tablaK = $("#tblK").DataTable({
        destroy: true,
        language: langSpa,
        responsive: true,
        ajax:{
            method:"POST",
            url:"gpo-list.php",
            data:{"nivel":1}
        },
        columns:[
            {"data":"id"},
            {"data":"gpo"},
            {"data":"doc-esp"},
            {"data":"doc-ing"},
            {"defaultContent": `<button title="Ver Tareas" class="tareas btn btn-info btn-sm" data-toggle="modal" data-target="#modal-tareas"><i class="fa fa-book-open"></i></button> <button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>`, className:"max"}
        ]
    });
    var tablaP = $("#tblP").DataTable({
        destroy: true,
        language: langSpa,
        responsive: true,
        ajax:{
            method:"POST",
            url:"gpo-list.php",
            data:{"nivel":2}
        },
        columns:[
            {"data":"id"},
            {"data":"gpo"},
            {"data":"doc-esp"},
            {"data":"doc-ing"},
            {"defaultContent": `<button title="Ver Tareas" class="tareas btn btn-info btn-sm" data-toggle="modal" data-target="#modal-tareas"><i class="fa fa-book-open"></i></button> <button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>`, className:"max"}
        ]
    });
    var tablaS = $("#tblS").DataTable({
        destroy: true,
        language: langSpa,
        responsive: true,
        ajax:{
            method:"POST",
            url:"gpo-list.php",
            data:{"nivel":3}
        },
        columns:[
            {"data":"id"},
            {"data":"gpo"},
            {"data":"doc-esp"},
            {"data":"doc-ing"},
            {"defaultContent": `<button title="Ver Tareas" class="tareas btn btn-info btn-sm" data-toggle="modal" data-target="#modal-tareas"><i class="fa fa-book-open"></i></button> <button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>`, className:"max"}
        ]
    });
    nuevo_gpo();
    $("table").width("100%");
    obtener_data_editar("#tblPK tbody", tablaPK);
    obtener_data_eliminar("#tblPK tbody", tablaPK);
    obtener_data_editar("#tblK tbody", tablaK);
    obtener_data_eliminar("#tblK tbody", tablaK);
    obtener_data_editar("#tblP tbody", tablaP);
    obtener_data_eliminar("#tblP tbody", tablaP);
    obtener_data_editar("#tblS tbody", tablaS);
    obtener_data_eliminar("#tblS tbody", tablaS);
    getTareas("#tblPK tbody", tablaPK);
    getTareas("#tblK tbody", tablaK);
    getTareas("#tblP tbody", tablaP);
    getTareas("#tblS tbody", tablaS);
}
var nuevo_gpo = function () {  
    $("#addGpo").on('click', function () {
        limpiar_forms();
        $('#modal-form').modal('show');
    });
}
var getGrados = function () {
    $("#nivel").on('change', function () {
        var nivel = $(this).val();
        var template = '';
        switch (nivel) {
            case "0":
                template = `<option>1</option>`;
                break;
            case "1":
                template = `
                <option>1</option>
                <option>2</option>
                <option>3</option>`;
                break;
            case "2":
                template = `
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>`;
                break;
            case "3":
                template = `
                <option>1</option>
                <option>2</option>
                <option>3</option>`;
                break;
            default:
                break;
        }
        $("#grado").html(template);
    });
}

var getTareas = function (tbody, table) {
    $(tbody).on('click', 'button.tareas', function () {
        limpiar_forms();
        var row = $(this).closest('tr');
        if (row.hasClass('child')) {
            row = row.prev();
        }
        var data = table.row(row).data();
        $("#tblTareas").DataTable({
            destroy:true,
            language: langSpa,
            responsive: true,
            ajax:{
                method:"POST",
                url:"process.php",
                data:{"idgpo":data.id,"opcion":"GETTAREAS"}
            },
            columns:[
                {"data":"id"},
                {"data":"titulo"},
                {"data":"contenido"},
                {"data":"asignatura"},
                {"data":"docente"},
                {"data":"fi"},
                {"data":"fe"},
                {"data":"status"}
            ]
        });
    });
}
var limpiar_forms = function () {
    $('form').trigger("reset");
    $('#opcion').val("REGISTRAR");
    $('#opcion2').val("ELIMINAR");
}
var obtener_data_editar = function(tbody, table){
    $(tbody).on('click', 'button.editar', function () {
        limpiar_forms();
        var row = $(this).closest('tr');
        if (row.hasClass('child')) {
            row = row.prev();
        }
        var data = table.row(row).data();
        $("#idgpo").val(data.id);
        $("#nivel").val(data.nivel);
        $("#nivel").change();
        $("#grado").val(data.grado);
        $("#grupo").val(data.grupo);
        $("#doc-esp").val(data.id_doc_esp);
        $("#doc-ing").val(data.id_doc_ing);
        $("#opcion").val("EDITAR");
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
        $("#idgpoTodelete").val(data.id);
        $('#message-confirm').html("¿Esta seguro de desactivar al grupo de " + data.gpo + "?");
    });
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
        case 'UPDATED':
            listar();
            swal({
            title:'Listo!',
            text: 'Los datos del grupo han sido actualizados con exito',
            type: 'success'
            });
            limpiar_forms();
            $('#modal-form').modal('hide');
            break;
        case 'EXISTGPO':
            swal({
            title:'Ups!',
            text: 'El grupo ya se encuentra registrado',
            type: 'warning'
            });
            break;
        case 'ADDED':
            listar();
            swal({
            title:'Listo!',
            text: 'El grupo ha sido registrado con exito',
            type: 'success'
            });
            limpiar_forms();
            $('#modal-form').modal('hide');
            break;
        case 'DELETED':
            listar();
            swal({
            title:'Listo!',
            text: 'El grupo ha sido eliminado con exito',
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