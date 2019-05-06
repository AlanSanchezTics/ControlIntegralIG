<?php
    session_name("webSession");
    session_start();
    if( !(isset($_SESSION['TIPO'])) || $_SESSION['TIPO']!='S'){
        session_destroy();
        die(header('Location: ../page_404.html'));
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../icon.ico">
    <title>Control Integral Indira Gandhi | Avisos</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendors/fontawesome-5.7.2-web/css/all.min.css" />
    <!--DataTables-->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <!-- Include Editor style -->
    <link href="../vendors/froala-editor/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <link href="../vendors/froala-editor/css/froala_style.min.css" rel="stylesheet" type="text/css" />

    <link href="../vendors/switchery/dist/switchery.min.css" rel="stylesheet" />
    <!-- Custom Theme Style -->
    <link rel="stylesheet" href="../vendors/nprogress/nprogress.css">
    <link href="../build/css/custom.min.css" rel="stylesheet" />

    <style>
        .right_col {
            color: black !important;
        }

        .d-none {
            display: none !important
        }

        .d-block {
            display: block !important
        }

        @media(min-width:576px) {
            .d-sm-block {
                display: block !important
            }
            .d-sm-none {
                display: none !important
            }
        }

        .max {
            min-width: 100px;
        }

        .fr-view {
            font-size: 20px;
            color: #444444;
        }
        .contenido, .titulo{
            font-size: 22px;
            color: black;
        }
        .fechaF{
            font-weight: bold;
        }
        .imagePreview {
            display: none;
            width: 100%;
            height: 400px;
            background-position: center center;
            background: url('') no-repeat center;
            background-color: #FFF;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }
    .imgAviso{
        width: 100%;
        height: 400px;
        background-position: center center;
        background: url('') no-repeat center;
        background-color: #FFF;
        background-size: 100% 100%;
        background-repeat: no-repeat;
    }
        label.btn-primary {
            display: block;
            border-radius: 0px;
            box-shadow: 0px 4px 6px 2px rgba(0, 0, 0, 0.2);
            margin-top: -5px;
            width: 100%;
        }

        i.del {
            position: absolute;
            top: 0px;
            right: 15px;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            background-color: rgba(255, 255, 255, 0.685);
            cursor: pointer;
            display: none;
        }
    </style>

</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col menu_fixed">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title">
                        <a class="site_title"><i class="fa fa-cog"></i> <span>Panel de control</span></a>
                    </div>
                    <div class="clearfix"></div>
                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="../images/user3.png" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Hola,</span>
                            <h2>
                                <?php echo $_SESSION['NOMBRE']; ?>
                            </h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->
                    <br />
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a href="../inicio/"><i class="fa fa-home"></i>Inicio</a>
                                </li>
                                <li><a href="../adm/"><i class="fas fa-user-friends"></i>Administradores</a>
                                </li>
                                <li><a href="../doc/"><i class="fas fa-chalkboard-teacher"></i>Docentes</a>
                                </li>
                                <li><a><i class="fas fa-user-graduate"></i>Alumnos <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="../almns/indexPK.php">Pre kinder</a></li>
                                        <li><a href="../almns/indexK.php">Preescolar</a></li>
                                        <li><a href="../almns/indexP.php">Primaria</a></li>
                                        <li><a href="../almns/indexS.php">Secundaria</a></li>
                                    </ul>
                                </li>
                                <li class="active"><a><i class="fas fa-bell"></i>Avisos</a>
                                </li>
                                <li><a href="../gpos/"><i class="fas fa-users"></i>Grupos</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>
            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars" style="color:#D9DEE4;"></i></a>
                        </div>
                        <div class="navbar-brand">
                            <span class="d-none d-sm-block">Control Integral del alumno</span>
                            <span class="d-block d-sm-none">CIAIG</span>
                        </div>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="../images/user3.jpg" alt=""><span style="color:#D9DEE4; font-weight: bold;">
                                        <?php echo $_SESSION['NOMBRE']; ?></span>
                                    <span class=" fa fa-angle-down" style="color:#D9DEE4; font-weight: bold;"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a class="logout"><i class="fa fa-sign-out-alt pull-right"></i>Cerrar sesión</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->
            <!-- page content -->
            <div class="right_col hero" role="main">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Panel de Avisos</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!-- Activos -->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Lista de Avisos</h2>
                                <ul class="nav navbar-right panel_toolbox" style="min-width: 0px;">
                                    <li><a id="addAviso" data-toggle="tooltip" data-placement="top" title="" data-original-title="Publicar Aviso">
                                            <span class="fas fa-comment-medical" aria-hidden="true" style="color:green;"></span>
                                        </a></li>
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="table-responsive" role="tabpanel" data-example-id="togglable-tabs">
                                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#tab_contentG" id="G-tab" role="tab"
                                                data-toggle="tab" aria-expanded="true">Generales</a>
                                        </li>
                                        <li role="presentation" class=""><a href="#tab_contentN" role="tab" id="N-tab" data-toggle="tab"
                                                aria-expanded="false">De nivel</a>
                                        </li>
                                        <li role="presentation" class=""><a href="#tab_contentGpo" role="tab" id="Gpo-tab"
                                                data-toggle="tab" aria-expanded="false">Grupales</a>
                                        </li>
                                        <li role="presentation" class=""><a href="#tab_contentP" role="tab" id="P-tab" data-toggle="tab"
                                                aria-expanded="false">Personalizados</a>
                                        </li>
                                    </ul>
                                    <div id="myTabContent" class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade active in" id="tab_contentG" aria-labelledby="home-tab">
                                            <div class="table-responsive">
                                                <table id="tblGenerales" class="table table-hover table-striped" data-order='[[ 0, "desc" ]]'>
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="head" data-class-name="priority">#</th>
                                                            <th scope="col" class="head">Titulo</th>
                                                            <th scope="col" class="head">Emisor</th>
                                                            <th scope="col" class="head">Fecha de suceso</th>
                                                            <th scope="col" class="head"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab_contentN" aria-labelledby="profile-tab">
                                            <div class="table-responsive">
                                                <table id="tblNivel" class="table table-hover table-striped" data-order='[[ 0, "desc" ]]'>
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="head" data-class-name="priority">#</th>
                                                            <th scope="col" class="head">Titulo</th>
                                                            <th scope="col" class="head">Emisor</th>
                                                            <th scope="col" class="head">Dirigido a</th>
                                                            <th scope="col" class="head">Fecha de suceso</th>
                                                            <th scope="col" class="head"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab_contentGpo" aria-labelledby="profile-tab">
                                            <div class="table-responsive">
                                                <table id="tblGrupales" class="table table-hover table-striped" data-order='[[ 0, "desc" ]]'>
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="head" data-class-name="priority">#</th>
                                                            <th scope="col" class="head">Titulo</th>
                                                            <th scope="col" class="head">Emisor</th>
                                                            <th scope="col" class="head">Dirigido a</th>
                                                            <th scope="col" class="head">Fecha de suceso</th>
                                                            <th scope="col" class="head"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab_contentP" aria-labelledby="profile-tab">
                                            <div class="table-responsive">
                                                <table id="tblPersonales" class="table table-hover table-striped" data-order='[[ 0, "desc" ]]'>
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="head" data-class-name="priority">#</th>
                                                            <th scope="col" class="head">Titulo</th>
                                                            <th scope="col" class="head">Emisor</th>
                                                            <th scope="col" class="head">Dirigido a</th>
                                                            <th scope="col" class="head">Fecha de suceso</th>
                                                            <th scope="col" class="head"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Activos -->
                    </div>
                </div>
            </div>
            <!-- /page content -->
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form id="avisos-form" class="form-horizontal form-label-left input_mask">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal-title">Datos del Aviso</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idAviso" name="idAviso">
                        <input type="hidden" id="opcion" name="opcion" value="REGISTRAR">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                <label for="tipo">El aviso va dirigido a</label>
                                <input type="hidden" name="tipo">
                                <select id="tipo" class="form-control" required>
                                    <option value="general">A todo alumno inscrito</option>
                                    <option value="grupo">Grupo</option>
                                    <option value="nivel">Nivel</option>
                                    <option value="alumno">Alumno</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="destinatario col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                <label id="lbldestino" for="destinatario"></label>
                                <input type="hidden" name="destinatario">
                                <select id="destinatario" class="form-control">

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                <label for="titulo">Titulo del aviso</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Titulo del Aviso" required>
                                <span class="fa fa-marker form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                <label for="contenido">Contenido</label>
                                <textarea style="font-size: 30px;" name="contenido" id="contenido" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group imgUp">
                                <input type="hidden" name="imgName">
                                <div class="imagePreview"></div>
                                <label class="btn btn-primary">
                                    Subir Foto<input type="file" name="imagen" class="uploadFile img" value="Upload Photo"
                                        style="width: 0px;height: 0px;overflow: hidden;">
                                </label><i class="fas fa-times del"></i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <label for="fechaI">Inicio del aviso</label>
                                <input type="date" name="fechaI" id="fechaI" class="form-control has-feedback-left" style="padding-right: 0px;" required>
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <div id="help-block10" class="help-box"></div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <label for="fechaI">Fecha de acontecimiento</label>
                                <input type="date" name="fechaF" id="fechaF" class="form-control has-feedback-left" style="padding-right: 0px;">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <div id="help-block11" class="help-box"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="notificar col-md-12 col-sm-12 col-xs-12 form-group has-feedback form-inline">
                                <label style="display: flex;">
                                    <input type="checkbox" class="js-switch" id="notificar" name="notificar" checked/> Notificar
                                    a usuarios
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="margin-top: 2%;">
                        <button type="submit" class="btn btn-success" data-loading-text="Espere..." autocomplete="off">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--/Modal-->
    <!--ModalConfirm-->
    <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form id="form-delete">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal-title">Mensaje de Confirmación</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idavisoTodelete" name="idAviso">
                        <input type="hidden" id="tipoTodelete" name="tipo">
                        <input type="hidden" id="opcion2" name="opcion" value="ELIMINAR">
                        <div id="message-confirm">
                        </div>
                    </div>
                    <div class="modal-footer" style="margin-top: 2%;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" data-loading-text="Espere..." class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--/ModalConfirm---->
    <!--ModalView-->
    <div class="modal fade" id="ModalView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="titulo modal-title" id="myModalLabel"></h4>
                    <p class="fechaI"></p>
                </div>
                <div  class="contenido modal-body">
                    
                </div>
                <div style="padding: 15px; text-align: left; border-top: 1px solid #e5e5e5;">
                    <p class="fechaF"></p>
                </div>
            </div>
        </div>
    </div>
    <!--/ModalView-->
    <!-- jQuery-->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap-->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!--DataTables-->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/switchery/dist/switchery.min.js" type="text/javascript"></script>
    <script src="../vendors/moment/min/moment-with-locales.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <script src="../build/js/custom.js"></script>
    <script src="data.js"></script>
    <script src="froala_editor.min.js"></script>
</body>

</html>