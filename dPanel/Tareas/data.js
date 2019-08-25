$(function () {
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
    nueva_tarea();
    editor();
    loadFoto();
    limpiar_forms();
    changeCombos();
    getGpos();
    guardarData();
    eliminarData();
    $(".logout").on('click', function () {
        window.location.replace('../../logout.php');
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
    var tablaTareas = $("#tblTareas").DataTable({
        destroy:true,
        language: langSpa,
        ajax: {
            "method": "POST",
            "url": "process.php",
            "data": {opcion:'GETTAREAS'}
        },
        "columns": [
            { "data": "id" },
            { "data": "titulo" },
            { "data": "asignatura" },
            { "data": "grupo"},
            { "data": "fe" },
            { "data": "estado"},
            { "defaultContent": '<button title="Ver tarea" class="view btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalView"><i class="fas fa-eye"></i></button><button data-loading-text="Espere..." title="Reenviar tarea" class="reenviar btn btn-info btn-sm"><i class="fa fa-sync"></i></button> <button title="Editar" class="editar es btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-form"><i class="fas fa-edit"></i></button> <button class="eliminar ds btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-confirm" title="Eliminar"><i class="fas fa-trash"></i></button>', className:"max" }
        ],
        responsive: true,
    });
    $("table").width("100%");
    obtener_data_editar("#tblTareas tbody", tablaTareas);
    obtener_data_eliminar("#tblTareas tbody", tablaTareas);
    obtener_data_view("#tblTareas tbody", tablaTareas);
    obtener_data_reenviar("#tblTareas tbody", tablaTareas);
    setInterval( function () {
        tablaTareas.ajax.reload( null, false ); // user paging is not reset on reload
    }, 5000 );
}
var nueva_tarea = function () {
    $("#addTarea").on('click', function () {
        limpiar_forms();
        $("#destinatario").removeAttr('disabled');
        $("#tipo").removeAttr('disabled');
        $("#fechaI").val(moment().format('YYYY-MM-DD'));
        $('#txtfechaI').val(moment().format('DD/MMMM/YYYY'));
        $('#txtfechaI').attr('disabled',true);
        $("#modal-form").modal("show");
        $("#programar").parent().show();
        $("#destinatario").change();
        $("#tipo").change();
    });
}
var limpiar_forms = function () {
    $('form').trigger("reset");
    $(".notificar").hide();
    $('#opcion').val("REGISTRAR");
    $('#opcion2').val("ELIMINAR");
    $("#contenido").summernote('code',"");
    $("input[name='imgName']").val("");
    $('.imagePreview').css("background-image", "");
    $('.imagePreview').css("display",'none');
    $("i.del").css("display","none");
    $("#fechaF").val("");
    $('#txtfechaI').attr('disabled',true);
    $('.js-switch').attr('checked', false);
}
var obtener_data_view = function (tbody, table) {
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
                title: "La tarea ya esta programada",
                text: "Solo se pueden reenviar las tareas que han sido ya enviadas.",
                type: "warning"
            });
            btn.button('reset');
            NProgress.done();
        }else{
            $.ajax({
                type: "POST",
                url: "process.php",
                data: {idTarea:data.id,opcion:"RESEND",destinatario:data.IDgrupo},
                success: function (response) {
                    val_respuesta(response);
                    btn.button('reset');
                    NProgress.done();
                }
            });
        }
    });
}
var obtener_data_editar = function (tbody, table) {
    $(tbody).on('click', 'button.editar', function () {
        limpiar_forms();
        var row = $(this).closest('tr');
        if (row.hasClass('child')) {
            row = row.prev();
        }
        var data = table.row(row).data();
        $("#idTarea").val(data.id);
        $("input[name='destinatario']").val(data.IDgrupo);
        $("#destinatario").val(data.IDgrupo);
        $("input[name='tipo']").val(data.tipo);
        $("#tipo").val(data.tipo);
        $("#titulo").val(data.titulo);
        $("#contenido").summernote('code',data.contenido);
        $("#fechaI").val(data.fechaI);
        $("#txtfechaI").val(moment(data.fechaI).format('DD/MMMM/YYYY'));
        $("#fechaF").val(data.fechaF);
        $("#txtfechaF").val(moment(data.fechaF).format('DD/MMMM/YYYY'));
        $("#opcion").val("EDITAR");
        $("#programar").parent().hide();
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
var obtener_data_eliminar = function (tbody, table) {
    $(tbody).on('click', 'button.eliminar', function () {
        var row = $(this).closest('tr');
        if (row.hasClass('child')) {
            row = row.prev();
        }
        var data = table.row(row).data();
        $("#idtareaToDelete").val(data.id);
        $("#message-confirm").html("¿Esta seguro de eliminar la tarea de titulo: <b>" + data.titulo + "</b> del grupo <b>"+data.grupo+"</b>?");
    });
}
var guardarData = function () {
    $("#tareas-form").on('submit', function (e) {
        e.preventDefault();
        var $btn = $("#tareas-form button[type='submit']").button('loading');
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
var changeCombos = function () {
    $("#tipo").on('change', function () {
        var tipo = $(this).val();
        $("input[name='tipo']").val(tipo);
    });
    $("#destinatario").on('change', function () {
        var destinatario = $(this).val();
        $("input[name='destinatario']").val(destinatario);
        var template = ``;
        $.ajax({
            type: "POST",
            url: "process.php",
            data: {opcion: "GETASIGNATURAS", gpo: destinatario},
            success: function (response) {
                if(response == "NONE"){
                    template = `
                    <option value="es">Español</option>
                    <option value="en">Ingles</option>
                    <option value="co">Computación</option>
                    <option value="ms">Música</option>
                    <option value="ef">Deportes</option>`;
                    $("#tipo").html(template);
                }else{
                    var data = JSON.parse(response);
                    $.each(data, function (index, value) { 
                        $.map(value, function (element, item) {
                            template += `
                            <option value="${element.tipo}">${element.materia}</option>`;
                        });
                    });
                    $("#tipo").html(template);
                }
            }
        });
    });
    $("#destinatario").change();
    $("#tipo").change();
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
        ]
    });
    
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
var getGpos = function () {
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
            $("#destinatario").change();
        }
    });
}
var val_respuesta = function (response) {
    switch (response) {
        case 'UPDATED':
            listar();
            swal({
                title: "La tarea ha sido actualizada y reenviada con exito",
                type: "success"
            });
            limpiar_forms();
            $('#modal-form').modal('hide');
            break;
        case 'SEND':
            swal({
                title: "La tarea ha sido reenviada con exito",
                type: "success"
            });
            break;
        case 'ADDED':
            listar();
            swal({
                title: "La tarea ha sido registrada y enviada con exito",
                type: "success"
            });
            limpiar_forms();
            $('#modal-form').modal('hide');
            break;
        case 'DELETED':
            listar();
            swal({
                title: "La tarea ha sido eliminada con exito",
                type: "success"
            });
            limpiar_forms();
            $('#modal-confirm').modal('hide');
            break;
        default:
            swal({
                title: "Problemas con el servidor al momento de realizar la petición. Contacte al administrador."+response,
                type: "warning"
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