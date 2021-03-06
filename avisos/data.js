$(document).ready(function () {
    moment.locale('es');
    $('#txtfechaI').bootstrapMaterialDatePicker({
        format: 'DD/MMMM/YYYY',
        minDate: moment().add(1, 'd'),
        time: false,
        clearButton: true,
        weekStart: 1,
        shortTime: true,
        lang: 'es',
        clearText: "Limpiar",
        okText: "Ok",
        cancelText: "Cancelar",
    }).on('change', function (e, date) {
        $('input[name="fechaI"]').val(moment(date).format("YYYY-MM-DD"));
    });
    $('#txtfechaF').bootstrapMaterialDatePicker({
        format: 'DD/MMMM/YYYY',
        minDate: moment().add(1, 'd'),
        time: false,
        clearButton: true,
        weekStart: 1,
        lang: 'es',
        clearText: "Limpiar",
        okText: "Ok",
        cancelText: "Cancelar",
    }).on('change', function (e, date) {
        $('input[name="fechaF"]').val(moment(date).format("YYYY-MM-DD"));
    });
    listar();
    editor();
    setDestinatarios();
    nuevo_Aviso();
    guardarData();
    eliminarData();
    loadFoto();
    changeCombos();
    $("#tipo").change(function () { 
        setDestinatarios("");
    });
    $(".logout").on('click', function () {
        window.location.replace('../logout.php');
    });
    $("#image").change(function (e) {
        let reader = new FileReader();
        reader.readAsDataURL(e.target.files[0]);
        reader.onload = function () {
            $("#img").attr('src', reader.result);
        }
    });
    $( '#programar' ).on( 'click', function() {
        if( $(this).is(':checked') ){
            // Hacer algo si el checkbox ha sido seleccionado
            $('#txtfechaI').attr('disabled',false);
            $('#txtfechaI').val("");
            $('#fechaI').val("");
        } else {
            // Hacer algo si el checkbox ha sido deseleccionado
            $('#txtfechaI').val(moment().format('DD/MMMM/YYYY'));
            $('#txtfechaI').attr('disabled',true);
            $('#fechaI').val(moment().format('YYYY-MM-DD'));
        }
    });
    
});

var listar = function () {
    var tablaG = $("#tblGenerales").DataTable({
        destroy:true,
        language: langSpa,
        ajax: {
            "method": "POST",
            "url": "avisos-list.php",
            "data": {"tipo":"Generales"}
        },
        "columns": [
            { "data": "id" },
            { "data": "titulo" },
            { "data": "admin" },
            { "data": "fe" },
            { "data": "estado" },
            { "defaultContent": '<button title="Ver aviso" class="view btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalView"><i class="fas fa-eye"></i></button><button data-loading-text="Espere..." title="Reenviar aviso" class="reenviar btn btn-info btn-sm"><i class="fa fa-sync"></i></button> <button title="Editar" class="editar es btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ],
        responsive: true
    });
    var tablaN = $("#tblNivel").DataTable({
        destroy:true,
        language: langSpa,
        ajax: {
            "method": "POST",
            "url": "avisos-list.php",
            "data": {"tipo":"Nivel"}
        },
        "columns": [
            { "data": "id" },
            { "data": "titulo" },
            { "data": "admin" },
            { "data": "nivel"},
            { "data": "fe" },
            { "data": "estado" },
            { "defaultContent": '<button title="Ver aviso" class="view btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalView"><i class="fas fa-eye"></i></button><button data-loading-text="Espere..." title="Reenviar aviso" class="reenviar btn btn-info btn-sm"><i class="fa fa-sync"></i></button> <button title="Editar" class="editar es btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ],
        responsive: true
    });
    var tablaGpo = $("#tblGrupales").DataTable({
        destroy:true,
        language: langSpa,
        ajax: {
            "method": "POST",
            "url": "avisos-list.php",
            "data": {"tipo":"Grupo"}
        },
        "columns": [
            { "data": "id" },
            { "data": "titulo" },
            { "data": "admin" },
            { "data": "gpo"},
            { "data": "fe" },
            { "data": "estado" },
            { "defaultContent": '<button title="Ver aviso" class="view btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalView"><i class="fas fa-eye"></i></button><button data-loading-text="Espere..." title="Reenviar aviso" class="reenviar btn btn-info btn-sm"><i class="fa fa-sync"></i></button> <button title="Editar" class="editar es btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ],
        responsive: true
    });
    var tablaP = $("#tblPersonales").DataTable({
        destroy:true,
        language: langSpa,
        ajax: {
            "method": "POST",
            "url": "avisos-list.php",
            "data": {"tipo":"Personal"}
        },
        "columns": [
            { "data": "id" },
            { "data": "titulo" },
            { "data": "admin" },
            { "data": "alumno"},
            { "data": "fe" },
            { "data": "estado" },
            { "defaultContent": '<button title="Ver aviso" class="view btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalView"><i class="fas fa-eye"></i></button><button data-loading-text="Espere..." title="Reenviar aviso" class="reenviar btn btn-info btn-sm"><i class="fa fa-sync"></i></button> <button title="Editar" class="editar es btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ],
        responsive: true
    });
    $("table").width("100%");
    obtener_data_view("#tblGenerales tbody", tablaG);
    obtener_data_view("#tblNivel tbody", tablaN);
    obtener_data_view("#tblGrupales tbody", tablaGpo);
    obtener_data_view("#tblPersonales tbody", tablaP);

    obtener_data_editar("#tblGenerales tbody", tablaG);
    obtener_data_editar("#tblNivel tbody", tablaN);
    obtener_data_editar("#tblGrupales tbody", tablaGpo);
    obtener_data_editar("#tblPersonales tbody", tablaP);

    obtener_data_reenviar("#tblGenerales tbody", tablaG);
    obtener_data_reenviar("#tblNivel tbody", tablaN);
    obtener_data_reenviar("#tblGrupales tbody", tablaGpo);
    obtener_data_reenviar("#tblPersonales tbody", tablaP);

    obtener_data_eliminar("#tblGenerales tbody", tablaG);
    obtener_data_eliminar("#tblNivel tbody", tablaN);
    obtener_data_eliminar("#tblGrupales tbody", tablaGpo);
    obtener_data_eliminar("#tblPersonales tbody", tablaP);
}
var obtener_data_view = function(tbody, table){
    $(tbody).on('click', 'button.view', function () {
        var row = $(this).closest('tr');
        if (row.hasClass('child')) {
            row = row.prev();
        }
        var data = table.row(row).data();
        $("h4.titulo").html(data.titulo);
        $("p.fechaI").html(moment(data.fechaI).format("LL"));
        $("div.contenido").html(data.contenido);
        if(data.imagen != ""){
            $("div.contenido").append("<div class='imgAviso'></div>");
            $(".imgAviso").css("background-image", "url(" + data.imagen + ")");
        }
        $("p.fechaF").html("Para el "+moment(data.fechaF).format("LL"));
    });
}
var obtener_data_editar = function(tbody, table){
    $(tbody).on('click', 'button.editar', function () {
        limpiar_forms();
        var row = $(this).closest('tr');
        if (row.hasClass('child')) {
            row = row.prev();
        }
        var data = table.row(row).data();
        $("#tipo").val(data.tipo);
        $("input[name='tipo']").val(data.tipo);
        setDestinatarios(data.destinatario);
        $("#contenido").summernote('code', data.contenido);
        $("#titulo").val(data.titulo);
        $("#fechaI").val(data.fechaI);
        $("#txtfechaI").val(moment(data.fechaI).format('DD/MMMM/YYYY'));
        $("#fechaF").val(data.fechaF);
        $("#txtfechaF").val(moment(data.fechaF).format('DD/MMMM/YYYY'));
        $("#idAviso").val(data.id);
        $("#programar").parent().hide();
        $("#opcion").val("EDITAR");
        if(data.estado == "Programado"){
            $("#programar").click();
            $("#txtfechaI").val(moment(data.fechaI).format('DD/MMMM/YYYY'));
            $("#txtfechaI").attr("disabled",true);
            $("#fechaI").val(data.fechaI);
        }else{
            $("#programar").attr("checked", false);
        }
        $("#tipo").attr('disabled', true);
        $("#destinatario").attr('disabled', true);
        if(data.imagen != ""){
            $('.imagePreview').css("background-image", "url(" + data.imagen + ")");
            $(".imgUp").find('.imagePreview').css("display",'inline-block');
            $("i.del").css("display","block");
            $("input[name='imgName']").val(data.imagen);
        }
        
    });
}
var obtener_data_reenviar = function (tbody, table) {
    $(tbody).on('click', 'button.reenviar', function () {
        btn = $(this).button('loading');
        NProgress.start();
        NProgress.inc(0.3);
        var row = $(this).closest('tr');
        if (row.hasClass('child')) {
            row = row.prev();
        }
        var data = table.row(row).data();
        if(data.estado == "Programado"){
            swal({
                title: "El aviso ya esta programado",
                text: "Solo se pueden reenviar los avisos que han sido ya enviados.",
                type: "warning"
            });
            btn.button('reset');
            NProgress.done();
        }else{
            $.ajax({
                type: "POST",
                url: "process.php",
                data: {idAviso:data.id,opcion:"RESEND",destinatario:data.destinatario, tipo: data.tipo},
                success: function (response) {
                    val_respuesta(response);
                    btn.button('reset');
                    NProgress.done();
                }
            });
        }
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
        $("#idavisoTodelete").val(data.id);
        $("#tipoTodelete").val(data.tipo);
        $('#message-confirm').html("¿Esta seguro de eliminar el aviso de titulo: <b>" + data.titulo + "</b>?");
    });
}
var guardarData = function () {
    $('#avisos-form').on('submit', function (e) {
        var $btn = $("#avisos-form button[type='submit']").button('loading');
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "process.php",
            processData: false,
            contentType: false,
            data: new FormData(this),
            success: function (response) {
                val_respuesta(response);
                $btn.button('reset');
            }
        });
    });
}
var eliminarData = function () {
    $("#form-delete").on('submit',function (e) {
        e.preventDefault();
        var $btn = $("#form-delete button[type='submit']").button('loading');
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
var nuevo_Aviso = function () {
    $("#addAviso").on("click", function () {
        limpiar_forms();
        $("#destinatario").removeAttr('disabled');
        $("#destinatario").removeAttr('readonly');
        $("#tipo").removeAttr('disabled');
        $("#fechaI").val(moment().format('YYYY-MM-DD'));
        $('#txtfechaI').val(moment().format('DD/MMMM/YYYY'));
        $('#txtfechaI').attr('disabled',true);
        $("#modal-form").modal("show");
        $("#programar").parent().show();
    });
};
var limpiar_forms = function () {
    $('form').trigger("reset");
    setDestinatarios("");
    $(".notificar").hide();
    $('#opcion').val("REGISTRAR");
    $('#opcion2').val("ELIMINAR");
    $("input[name='imgName']").val("");
    $("#contenido").summernote('code',"");
    $('.imagePreview').css("background-image", "");
    $('.imagePreview').css("display",'none');
    $("i.del").css("display","none");
    $("#fechaF").val("");
    $('#txtfechaI').attr('disabled',true);
    $('.js-switch').attr('checked', false);
    
}
var editor = function(){
    var textarea = $('#contenido').summernote({
        placeholder: "Escribe aqui...",
        height: 300,
        minHeight: 300,
        toolbar: [
            ['style', ['bold', 'italic', 'strikethrough','underline']],
            ['links', ['link']],
            ['list', ['ul', 'ol']],
            ['misc', ['undo','redo']]
        ],
        callbacks: { 
            onPaste: function (e) { 
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text'); 
                e.preventDefault();
                setTimeout(function () {
                    document.execCommand('insertText', false, bufferText); 
                }, 10); 
            } 
        } 
    });
}
var setDestinatarios = function(e){
    var tipo = $("#tipo").val();
        $("#destinatario").html("");
        $("#destinatario").attr('required', true);
        $("#destinatario").attr('disabled', false);
        switch (tipo) {
            case 'general':
                $(".destinatario").hide();
                $("#destinatario").removeAttr('required');
                $("#destinatario").attr('disabled', true);
                $("#lbldestino").text("");
                $("input[name='destinatario']").val("");
                break;
            case 'nivel':
                $(".destinatario").show();
                $("#lbldestino").text("Nivel");

                var template = `<option value="0">Prekinder</option>
                            <option value="1">Preescolar</option>
                            <option value="2">Primaria</option>
                            <option value="3">Secundaria</option>`;
                $("#destinatario").html(template);
                $("#destinatario").val(e);
                $("input[name='destinatario']").val(e);
                break;
            case 'grupo':
                $(".destinatario").show();
                $("#lbldestino").text("Grupo");
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {'opcion':'GETGPOS'},
                    success: function (response) {
                        var template = ``;
                        var data = JSON.parse(response);
                        $.each(data, function (index, value) { 
                            $.map(value, function (element, item) {
                                template += `
                                <option value="${element.id}">${element.gpo}</option>`;
                            });
                        });
                        $("#destinatario").html(template);
                        $("#destinatario").val(e);
                        $("input[name='destinatario']").val(e);
                    }
                });
                break;
            case 'alumno':
                $(".destinatario").show();
                $("#lbldestino").text("Alumno");
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {'opcion':'GETALUMNOS'},
                    success: function (response) {
                        var template = ``;
                        var data = JSON.parse(response);
                        $.each(data, function (index, value) { 
                            $.map(value, function (element, item) {
                                template += `
                                <option value="${element.id}">${element.id} - ${element.alumno}</option>`;
                            });
                        });
                        $("#destinatario").html(template);
                        $("#destinatario").val(e);
                        $("input[name='destinatario']").val(e);
                    }
                });
                break;
        }
}
var val_respuesta = function (response) {
    switch (response) {
        case 'UPDATED':
            listar();
            swal({
                title: "Aviso actualizado y enviado con exito",
                type: "success"
            });
            limpiar_forms();
            $('#modal-form').modal('hide');
            break;
        case 'SEND':
            swal({
                title: "Aviso reenviado con exito",
                type: "success"
            });
            break;
        case 'ADDED':
            listar();
            swal({
                title: "Aviso enviado con exito",
                type: "success"
            });
            limpiar_forms();
            $('#modal-form').modal('hide');
            break;
        case 'DELETED':
            swal({
                title: "Aviso eliminado con exito",
                type: "success"
            });
            listar();
            limpiar_forms();
            $('#modal-confirm').modal('hide');
            break;
        default:
            console.log(response);
            swal({
                title: "Ups!",
                text: "Hubo un problema al momento de realizar la petición. Contacte al administrador.",
                type: "error"
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
var changeCombos = function () {
    $("#tipo").on('change', function () {
        var tipo = $(this).val();
        $("input[name='tipo']").val(tipo);
    });
    $("#destinatario").on('change', function () {
        var destinatario = $(this).val();
        $("input[name='destinatario']").val(destinatario);
    });
    $("#tipo").change();
}
var loadFoto = function () {
    $(document).on("change", ".uploadFile", function () {
        var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
        if(files[0].size > 8388608 ){swal({title:"Ups!",text:"El tamaño de la imagen no debe de ser mayor a 7MB.",type:"warning"}); return;}
        if (/^image/.test(files[0].type)) { // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function () { // set image data as background of div
                uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url(" + this.result + ")");
                uploadFile.closest(".imgUp").find('.imagePreview').css("display",'inline-block');
                $("i.del").css("display","block");
                $("input[name='imgName']").val("");
            }
        }
    });
    $(document).on("click", "i.del" , function() {
        $(".uploadFile").val("");
        $('.imagePreview').css("background-image", "");
        $('.imagePreview').css("display",'none');
        $("i.del").css("display","none");
        $("input[name='imgName']").val(""); 
    });
}