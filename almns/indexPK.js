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
    var table1a = $("#tblpre").DataTable({
        destroy: true,
        responsive: true,
        language: langSpa,
        ajax: {
            method: "POST",
            data: { "gpo": 'A', "gdo": 1, "lvl":0 },
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
    $("table").width("100%");
    nuevo_Alm();
    buscar_Alm();
    buscar_data();
    obtener_data_editar("#tblpre tbody", table1a, 0 ,'A');
    obtener_data_eliminar("#tblpre tbody", table1a);
    $('.fixed-action-btn').floatingActionButton();
}
var nuevo_Alm = function () {
    $("#addAlm").on("click", function () {
        limpiar_forms();
        $("#modal-form").modal("show");
    });
}
var buscar_Alm = function () {
    $("#searchAlm").on('click', function () {
        $("#result-search").html('');
        $('#frm-buscar').trigger("reset");
        $("#modal-buscar").modal("show");

    });
}
var buscar_data = function () {
    $("#frm-buscar").on('submit', function (e) {
        $("#result-search").html('');
        var $btn = $("#frm-buscar button[type='submit']").button('loading');
        e.preventDefault();
        var frm = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "process.php",
            data: frm,
            success: function (response) {
                var data = JSON.parse(response);
                var template = ``;
                $btn.button('reset');
                if(data == "empty"){
                    swal({
                    title:'Sin resultados',
                    text: 'No obtuvimos datos de ningun alumno con ese No. de control.',
                    type: 'warning'
                    });
                    return;
                }
                $.map(data, function (value, index) {
                    template = `
                    <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <h3 style="text-align: center;">Datos del Alumno</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12" align="center">
                                <img src="${value.imagen}" alt="Fotografia">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 1.5rem;" align="center">
                                <label style="font-size: 1.5rem; color: black;">Nombre: ${value.nombre}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12" style="margin-top: 1rem;" align="center">
                                <label style="font-size: 1.5rem; color: black;">Grupo: ${value.grado}°${value.grupo}</label>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12" style="margin-top: 1rem;" align="center">
                                <label style="font-size: 1.5rem; color: black;">Nivel: ${value.nivel}</label>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12" style="margin-top: 1rem;" align="center">
                                <label style="font-size: 1.5rem; color: black;">Estado: ${value.estado}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 1rem;" align="center">
                                <label style="font-size: 1.5rem; color: black;">Ingreso: ${value.fi}</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 1rem;" align="center">
                                <label style="font-size: 1.5rem; color: black;">Egreso: ${value.fe}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 1rem;" align="center">
                                <label style="font-size: 1.5rem; color: black;">Correo: ${value.email}</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 1rem;" align="center">
                                <label style="font-size: 1.5rem; color: black;">Telefono: ${value.telefono}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 1.5rem;" align="center">
                                <label style="font-size: 1.5rem; color: black;">Clave ´para CIAIGapp: ${value.usuario}</label>
                            </div>
                        </div>
                    `;
                });
                $("#result-search").html(template);
            }
        });
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
        var $btn = $("#alum-form button[type='submit']").button('loading');
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "process.php",
            data: new FormData(this),
            success: function (response) {
                val_respuesta(response);
                $btn.button('reset');
            },
            processData: false,
            contentType: false,
        });
    });
}
var eliminarData = function () {
    $('#form-delete').on('submit', function (e) {
        var $btn = $("#form-delete button[type='submit']").button('loading');
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
                $btn.button('reset');
                
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
        $("#nivel").val(0);
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
            swal({
                title:"Listo!",
                text:"El alumno ha sido registrado con exito.",
                type:"success"
            });
            limpiar_forms();
            $('#modal-form').modal('hide');
            break;
        case 'EXISTALUMN':
                swal({
                    title:"Ups!",
                    text:"el alumno ya se encuentra registrado",
                    type:"error"
                });
            $("#NoControl").focus();
            break;
        case 'WRONGGROUP':
                swal({
                    title:"Ups!",
                    text:"Grupo seleccionado invalido",
                    type:"error"
                });
            break;
        case 'UPDATED':
            listar();
            swal({
                title:"Listo!",
                text:"Datos del alumno actulizados",
                type:"success"
            });
            limpiar_forms();
            $('#modal-form').modal('hide');
        break;
        case "DELETED":
                swal({
                    title:"Listo!",
                    text:"Alumno desactivado con exito",
                    type:"success"
                });
                listar();
                limpiar_forms();
            break;
        default:
                swal({
                    title:"Algo salio mal :(",
                    text:"Problemas con el servidor al momento de realizar la petición. Contacte al administrador",
                    type:"warning"
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