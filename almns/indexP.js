$(document).ready(function () {
    listar();
    getGrados();
    guardarData();
    eliminarData();
    $("#NoControl").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            $("#help-block01").html("El numero de control debe contener solo numeros.").show().fadeOut(3000);
            return false;
        }
    });
    $("#foto").change(function (e) {
        let reader = new FileReader();
        reader.readAsDataURL(e.target.files[0]);
        reader.onload = function () {
            $("#img").attr('src', reader.result);
        }
    });
    $(".logout").on('click', function () {
        window.location.replace('../logout.php');
    });
});
var listar = function () {
    var table1a = $("#tblgpo1a").DataTable({
        destroy: true,
        responsive: true,
        language: langSpa,
        ajax: {
            method: "POST",
            data: { "gpo": 'A', "gdo": 1, "lvl":2 },
            url: "alumns-list.php",
        },
        "columns": [
            { "data": "noControl"},
            { "data": "nombre" },
            { "data": "apaterno" },
            { "data": "amaterno" },
            { "data": "telefono" },
            { "data": "email" },
            { "data": "usuario" },
            { "data": "fi" },
            { "data": "fe" },
            { "defaultContent": '<button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ]
    });
    getDocs("A", 1, "#tblgpo1a thead tr th span.ing", "#tblgpo1a thead tr th span.esp");
    
    var table1b = $("#tblgpo1b").DataTable({
        destroy: true,
        responsive: true,
        language: langSpa,
        ajax: {
            method: "POST",
            data: { "gpo": 'B', "gdo": 1,"lvl":2 },
            url: "alumns-list.php",
        },
        "columns": [
            { "data": "noControl" },
            { "data": "nombre" },
            { "data": "apaterno" },
            { "data": "amaterno" },
            { "data": "telefono" },
            { "data": "email" },
            { "data": "usuario" },
            { "data": "fi" },
            { "data": "fe" },
            { "defaultContent": '<button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ]
    });
    getDocs("B", 1, "#tblgpo1b thead tr th span.ing", "#tblgpo1b thead tr th span.esp");

    var table2a = $("#tblgpo2a").DataTable({
        destroy: true,
        responsive: true,
        language: langSpa,
        ajax: {
            method: "POST",
            data: { "gpo": 'A', "gdo": 2, "lvl":2 },
            url: "alumns-list.php",
        },
        "columns": [
            { "data": "noControl" },
            { "data": "nombre" },
            { "data": "apaterno" },
            { "data": "amaterno" },
            { "data": "telefono" },
            { "data": "email" },
            { "data": "usuario" },
            { "data": "fi" },
            { "data": "fe" },
            { "defaultContent": '<button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ]
    });
    getDocs("A", 2, "#tblgpo2a thead tr th span.ing", "#tblgpo2a thead tr th span.esp");
    
    var table2b = $("#tblgpo2b").DataTable({
        destroy: true,
        responsive: true,
        language: langSpa,
        ajax: {
            method: "POST",
            data: { "gpo": 'B', "gdo": 2, "lvl":2 },
            url: "alumns-list.php",
        },
        "columns": [
            { "data": "noControl" },
            { "data": "nombre" },
            { "data": "apaterno" },
            { "data": "amaterno" },
            { "data": "telefono" },
            { "data": "email" },
            { "data": "usuario" },
            { "data": "fi" },
            { "data": "fe" },
            { "defaultContent": '<button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ]
    });
    getDocs("B", 2, "#tblgpo2b thead tr th span.ing", "#tblgpo2b thead tr th span.esp");
    
    var table3a = $("#tblgpo3a").DataTable({
        destroy: true,
        responsive: true,
        language: langSpa,
        ajax: {
            method: "POST",
            data: { "gpo": 'A', "gdo": 3, "lvl":2 },
            url: "alumns-list.php",
        },
        "columns": [
            { "data": "noControl" },
            { "data": "nombre" },
            { "data": "apaterno" },
            { "data": "amaterno" },
            { "data": "telefono" },
            { "data": "email" },
            { "data": "usuario" },
            { "data": "fi" },
            { "data": "fe" },
            { "defaultContent": '<button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ]
    });
    getDocs("A", 3, "#tblgpo3a thead tr th span.ing", "#tblgpo3a thead tr th span.esp");
    
    var table3b = $("#tblgpo3b").DataTable({
        destroy: true,
        responsive: true,
        language: langSpa,
        ajax: {
            method: "POST",
            data: { "gpo": 'B', "gdo": 3, "lvl":2 },
            url: "alumns-list.php",
        },
        "columns": [
            { "data": "noControl" },
            { "data": "nombre" },
            { "data": "apaterno" },
            { "data": "amaterno" },
            { "data": "telefono" },
            { "data": "email" },
            { "data": "usuario" },
            { "data": "fi" },
            { "data": "fe" },
            { "defaultContent": '<button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ]
    });
    getDocs("B", 3, "#tblgpo3b thead tr th span.ing", "#tblgpo3b thead tr th span.esp");
    
    var table4a = $("#tblgpo4a").DataTable({
        destroy: true,
        responsive: true,
        language: langSpa,
        ajax: {
            method: "POST",
            data: { "gpo": 'A', "gdo": 4, "lvl":2 },
            url: "alumns-list.php",
        },
        "columns": [
            { "data": "noControl" },
            { "data": "nombre" },
            { "data": "apaterno" },
            { "data": "amaterno" },
            { "data": "telefono" },
            { "data": "email" },
            { "data": "usuario" },
            { "data": "fi" },
            { "data": "fe" },
            { "defaultContent": '<button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ]
    });
    getDocs("A", 4, "#tblgpo4a thead tr th span.ing", "#tblgpo4a thead tr th span.esp");
    
    var table4b = $("#tblgpo4b").DataTable({
        destroy: true,
        responsive: true,
        language: langSpa,
        ajax: {
            method: "POST",
            data: { "gpo": 'B', "gdo": 4, "lvl":2 },
            url: "alumns-list.php",
        },
        "columns": [
            { "data": "noControl" },
            { "data": "nombre" },
            { "data": "apaterno" },
            { "data": "amaterno" },
            { "data": "telefono" },
            { "data": "email" },
            { "data": "usuario" },
            { "data": "fi" },
            { "data": "fe" },
            { "defaultContent": '<button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ]
    });
    getDocs("B", 4, "#tblgpo4b thead tr th span.ing", "#tblgpo4b thead tr th span.esp");
    
    var table5a = $("#tblgpo5a").DataTable({
        destroy: true,
        responsive: true,
        language: langSpa,
        ajax: {
            method: "POST",
            data: { "gpo": 'A', "gdo": 5, "lvl":2 },
            url: "alumns-list.php",
        },
        "columns": [
            { "data": "noControl" },
            { "data": "nombre" },
            { "data": "apaterno" },
            { "data": "amaterno" },
            { "data": "telefono" },
            { "data": "email" },
            { "data": "usuario" },
            { "data": "fi" },
            { "data": "fe" },
            { "defaultContent": '<button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ]
    });
    getDocs("A", 5, "#tblgpo5a thead tr th span.ing", "#tblgpo5a thead tr th span.esp");
    
    var table5b = $("#tblgpo5b").DataTable({
        destroy: true,
        responsive: true,
        language: langSpa,
        ajax: {
            method: "POST",
            data: { "gpo": 'B', "gdo": 5, "lvl":2 },
            url: "alumns-list.php",
        },
        "columns": [
            { "data": "noControl" },
            { "data": "nombre" },
            { "data": "apaterno" },
            { "data": "amaterno" },
            { "data": "telefono" },
            { "data": "email" },
            { "data": "usuario" },
            { "data": "fi" },
            { "data": "fe" },
            { "defaultContent": '<button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ]
    });
    getDocs("B", 5, "#tblgpo5b thead tr th span.ing", "#tblgpo5b thead tr th span.esp");
    
    var table6a = $("#tblgpo6a").DataTable({
        destroy: true,
        responsive: true,
        language: langSpa,
        ajax: {
            method: "POST",
            data: { "gpo": 'A', "gdo": 6, "lvl":2 },
            url: "alumns-list.php",
        },
        "columns": [
            { "data": "noControl" },
            { "data": "nombre" },
            { "data": "apaterno" },
            { "data": "amaterno" },
            { "data": "telefono" },
            { "data": "email" },
            { "data": "usuario" },
            { "data": "fi" },
            { "data": "fe" },
            { "defaultContent": '<button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ]
    });
    getDocs("A", 6, "#tblgpo6a thead tr th span.ing", "#tblgpo6a thead tr th span.esp");
    
    var table6b = $("#tblgpo6b").DataTable({
        destroy: true,
        responsive: true,
        language: langSpa,
        ajax: {
            method: "POST",
            data: { "gpo": 'B', "gdo": 6, "lvl":2 },
            url: "alumns-list.php",
        },
        "columns": [
            { "data": "noControl" },
            { "data": "nombre" },
            { "data": "apaterno" },
            { "data": "amaterno" },
            { "data": "telefono" },
            { "data": "email" },
            { "data": "usuario" },
            { "data": "fi" },
            { "data": "fe" },
            { "defaultContent": '<button title="Editar" class="editar es btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ]
    });
    getDocs("B", 6, "#tblgpo6b thead tr th span.ing", "#tblgpo6b thead tr th span.esp");
    
    $("table").width("100%");
    nuevo_Alm();
    obtener_data_editar("#tblgpo1a tbody", table1a, 1 ,'A');
    obtener_data_eliminar("#tblgpo1a tbody", table1a);
    obtener_data_editar("#tblgpo1b tbody", table1b, 1 ,'B');
    obtener_data_eliminar("#tblgpo1b tbody", table1b);
    obtener_data_editar("#tblgpo2a tbody", table2a, 2 ,'A');
    obtener_data_eliminar("#tblgpo2a tbody", table2a);
    obtener_data_editar("#tblgpo2b tbody", table2b, 2 ,'B');
    obtener_data_eliminar("#tblgpo2b tbody", table2b);
    obtener_data_editar("#tblgpo3a tbody", table3a, 3 ,'A');
    obtener_data_eliminar("#tblgpo3a tbody", table3a);
    obtener_data_editar("#tblgpo3b tbody", table3b, 3 ,'B');
    obtener_data_eliminar("#tblgpo3b tbody", table3b);
    obtener_data_editar("#tblgpo4a tbody", table4a, 4 ,'A');
    obtener_data_eliminar("#tblgpo4a tbody", table4a);
    obtener_data_editar("#tblgpo4b tbody", table4b, 4 ,'B');
    obtener_data_eliminar("#tblgpo4b tbody", table4b);
    obtener_data_editar("#tblgpo5a tbody", table5a, 5 ,'A');
    obtener_data_eliminar("#tblgpo5a tbody", table5a);
    obtener_data_editar("#tblgpo5b tbody", table5b, 5 ,'B');
    obtener_data_eliminar("#tblgpo5b tbody", table5b);
    obtener_data_editar("#tblgpo6a tbody", table6a, 6 ,'A');
    obtener_data_eliminar("#tblgpo6a tbody", table6a);
    obtener_data_editar("#tblgpo6b tbody", table6b, 6 ,'B');
    obtener_data_eliminar("#tblgpo6b tbody", table6b);
    
}
var nuevo_Alm = function () {
    $("#addAlm").on("click", function () {
        limpiar_forms();
        $("#modal-form").modal("show");
    });
}
var getDocs = function (gpo, gdo, labeling, labelesp) {

    $.ajax({
        type: "POST",
        url: "process.php",
        data: { "gpo": gpo, "gdo": gdo, "opcion": "GETDOCS","nivel":2 },
        success: function (response) {
            var data = JSON.parse(response);
            $.each(data, function (item, value) {
                $(labelesp).text("Maestro: " + value.esp.nombre + " " + value.esp.apaterno + " " + value.esp.amaterno);
                $(labeling).text("Teacher: " + value.ing.nombre + " " + value.ing.apaterno + " " + value.ing.amaterno);
            });

        }
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
var guardarData = function () {
    $("#alum-form").on("submit", function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "process.php",
            data: new FormData(this),
            success: function (response) {
                val_respuesta(response);
                console.log(response);
            },
            processData: false,
            contentType: false,
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
                console.log(response);
                
            }
        });
    });
}
var obtener_data_editar = function (tbody, table, gdo, gpo){
    $(tbody).on("click", "button.editar", function () {
        limpiar_forms();
        var row = $(this).closest('tr');
        if (row.hasClass('child')) {
            row = row.prev();
        }
        var data = table.row(row).data();
        console.log(data);
        $("#iduser").val(data.usu_ID);
        $("#NoControl").val(data.noControl);
        $("#nombre").val(data.nombre);
        $("#a-paterno").val(data.apaterno);
        $("#a-materno").val(data.amaterno);
        $("#telefono").val(data.telefono);
        $("#email").val(data.email);
        $("#fechaI").val(data.fi);
        $("#fechaF").val(data.fe);
        $("#img").attr("src", data.foto);
        $("#nivel").val(2);
        $("#nivel").change();
        $("#grado").val(gdo);
        $("#grupo").val(gpo);
        $("#opcion").val("EDITAR");
    });
}
var obtener_data_eliminar = function (tbody, table) {
    $(tbody).on('click', 'button.eliminar', function () {
        var row = $(this).closest('tr');
        if (row.hasClass('child')) {
            row = row.prev();
        }
        var data = table.row(row).data();
        $("#nControlTodelete").val(data.noControl);
        $("#iduserTodelete").val(data.usu_ID);
        $('#message-confirm').html("¿Esta seguro de desactivar a " + data.nombre + "?");
    });
};
var limpiar_forms = function () {
    $('form').trigger("reset");
    $('#opcion').val("REGISTRAR");
    $('#opcion2').val("ELIMINAR");
    $("#img").attr("src","./images/defaultUser.png");
}
var val_respuesta= function(response){
    switch (response) {
        case 'ADDED':
            listar();
            alert("El alumno ha sido registrado con exito.");
            limpiar_forms();
            $('#modal-form').modal('hide');
            break;
        case 'EXISTALUMN':
            alert("el alumno ya se encuentra registrado.");
            $("#NoControl").focus();
            break;
        case 'WRONGGROUP':
            alert("Grupo seleccionado invalido.");
            break;
        case 'UPDATED':
            listar();
            alert("Datos del alumno actulizados.");
            limpiar_forms();
            $('#modal-form').modal('hide');
        break;
        case "DELETED":
            alert("Alumno desactivado con exito.");
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