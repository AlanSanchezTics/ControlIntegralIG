$(document).ready(function () {
    login();
});
var login = function () {
    $('form').on('submit', function (e) {
        e.preventDefault();
        var frm = $(this).serialize();
        NProgress.start();
        NProgress.inc(0.5);
        $.ajax({
            type: "POST",
            url: "validation.php",
            data: frm,
            success: function (response) {
                var data = JSON.parse(response);
                val_respuesta(data);
            }
        });
    });
}
var val_respuesta=function(response){
    switch (response.response) {
        case 'DONE':
            NProgress.done();
            switch (response.dashboard) {
                case 'S':
                    window.location.replace("./inicio/");
                    break;
                case 'D':
                    window.location.replace("./dPanel/inicio/");
                    break;
            }
            break;
        case 'DENIED':
            NProgress.done();
            $("#message").html('<img src="./images/error-icon.png" width="80px" height="80px"/><br><br>Datos de usuario incorrectos. <br>Intente nuevamente.');
            $("#modal-confirm").modal('show');
            break;
        default:
            alert("Problemas con el servidor al momento de realizar la petición. Contacte al administrador.");
        break;
    }
}