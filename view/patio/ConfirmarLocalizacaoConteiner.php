<?php
include_once('../../controller/tecnologia/Sistema.php');
include_once('../../controller/patio/ConfirmarLocalizacaoConteinerController.php');

if (!isset($_SESSION['usuario']) and !isset($_SESSION['senha'])) {
    header('Location: ../estrutura/login.php?success=F');
} else {
    $connect = Sistema::getConexao();

    $ConfirmarLocalizacaoConteiner = new ConfirmarLocalizacaoConteinerController($connect);
    $ConfirmarLocalizacaoConteiner->montaFiltro();
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

        <link type="text/css" href="resource/ConfirmarLocalizacaoConteiner.css" rel="stylesheet">

        <!-- SweetAlert -->
        <script type="text/javascript" src="../tecnologia/js/sweetalert/sweetalert.min.js"></script>        
		<script type="text/javascript" src="../tecnologia/js/scriptConfirmarLocalizacaoConteiner.js"></script>
        <script type="text/javascript" src="resource/ConfirmarLocalizacaoConteiner.js"></script>
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
                <div class="topBar">Confirmar localização de contêiner</div>
                    <div class="topBarRight dropdown">
                        <button type="button" class="btn botaoTop dropdown-toggle desktopHide" role="button" aria-expanded="false" data-toggle="dropdown"><i class="material-icons">&#xE5D4;</i></button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><button type="button" class="btn botaoMobile" id="confirmarMobile" data-toggle="modal"  data-target="#confirmarModal" name="confirmarMobile">Confirmar</button></li>
                            </ul>
                        <button data-toggle="modal" class="botaoTop" title="Filtrar" onClick="multiselection();" data-target="#FiltroModal"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            <div class="clearfix"></div>
        </div>
        <div class="pageContent">

            <?php
            include('ConfirmarConteinerModalFiltro.php');
            include('../../model/patio/modalConfirmarLocalizacao.php');
            ?>            
            <div id="registroNaoEncontrato" style="display: none;">
                <div class="alert alert-warning" style="margin-bottom: 0;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Atenção: </strong> Não encontramos registros a serem exibidos!
                </div>
            </div>
            <form method="post" action="#">
                <div class="table-responsive">
                    <div class="larguraInteira">
                        <table id="tableConfirmaConteiner" class="table table-striped table-bordered " id="reqtablenew" border="0">
                            <thead>
                            <tr class="Noactivetr">
                                <th>Número</th>
                                <th>Filial</th>
                                <th>Data</th>
                                <th>Cliente</th>
                                <th>Contêiner</th>
                                <th>Localização</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            Sistema::iniciaCarregando();

                            $rows = $ConfirmarLocalizacaoConteiner->getRegistro();

                            echo join(' ', $rows['DADOS']);
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>  
            
            <div class="footerFixed mobileHide">
                <div class="right">
                    <div class="col-xs-1">
                    <button type="button" class="span">&nbsp;</button>
                    </div>
                        <div class="col-xs-11">
                            <div class="right">
                            <button type="button" class="botao display" id="confirmar" data-toggle="modal"  data-target="#confirmarModal" name="confirmar">Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>

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
