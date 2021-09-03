<?php
include_once('../../controller/tecnologia/Sistema.php');
include_once('../../controller/patio/ConsultaConteinerController.php');

if (!isset($_SESSION['usuario']) and !isset($_SESSION['senha'])) {
    header('Location: ../estrutura/login.php?success=F');
} else {
    $connect = Sistema::getConexao();

    $ConsultaConteiner = new ConsultaConteinerController($connect);
    $ConsultaConteiner->montaFiltro();
    ?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <title>Escalasoft</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>


        <?php
        include_once('../tecnologia/importCSS.php');
        include_once('../tecnologia/importJavascript.php');
        ?>

        <link type="text/css" href="resource/ConsultaConteiner.css" rel="stylesheet">

        <script type="text/javascript" src="resource/ConsultaConteiner.js"></script>
    </head>
    <body class="cbp-spmenu-push" id="bodyFullScreen">
    <div>
        <div id="loader"></div>
        <div class="main-content">
            <div class=" sidebar" role="navigation">
                <div class="navbar-collapse">
                    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
                        <?php
                        include('../estrutura/menu.php');
                        ?>
                    </nav>
                </div>
            </div>
            <div class="sticky-header header-section ">
                <button id="showLeftPush"><i class="fa fa-bars"></i></button>
                <div class="topBar">Consulta de contêiner</div>
                <div class="topBarRight">
                   
                    <button data-toggle="modal" class="botaoTop" title="Filtrar" onClick="multiselection();" data-target="#FiltroModal"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="pageContent">
            <?php
            include('ConsultaConteinerModalFiltro.php');
            ?>
            <div id="registroNaoEncontrato" style="display: none;">
                <div class="alert alert-warning" style="margin-bottom: 0;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Atenção: </strong> Não encontramos registros a serem exibidos!
                </div>
            </div>
            <div class="table-responsive">
                <div class="larguraInteira">
                    <table id="tableConsultaConteiner" class="table table-striped table-bordered" border="0">
                        <thead>
                        <tr class="Noactivetr">
                            <th>&nbsp;</th> 
                            <th>Conteiner</th>
                            <th>Filial</th>
                            <th>Tipo de contêiner</th>
                            <th>Classificação ISO</th>
                            <th>Cliente</th>
                            <th>Localização</th>
                            <th>Entrada</th>
                            <th>Saida</th>
                            <th>Dias pátio</th>
                            <th>Tipo de operação</th>
                            <th>Finalidade</th>
                            <th>Demurrage</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        Sistema::iniciaCarregando();

                        $rows = $ConsultaConteiner->getRegistro();

                        echo join(' ', $rows['DADOS']);
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="footerFixed mobileHide">
                <div class="col-xs-1">
                    <button type="button" class="span">&nbsp;</button>
                </div>
                <div class="col-xs-11">
                    <div class="right">

                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <script src="../tecnologia/js/classie.js"></script>
    <script src="../tecnologia/js/jquery.nicescroll.js"></script>
    <script src="../tecnologia/js/script.js"></script>
    <script src="../tecnologia/js/bootstrap.js"></script>
    </body>
    </html>
    <?php
}