<?php
include_once('../../controller/tecnologia/Sistema.php');
include_once('../../controller/armazenagem/EstoqueArmazemController.php');

if (!isset($_SESSION['usuario']) and !isset($_SESSION['senha'])) {
    header('Location: ../estrutura/login.php?success=F');
} else {
    $connect = Sistema::getConexao();

    $estoqueArmazem = new EstoqueArmazemController($connect);
    $estoqueArmazem->montaFiltro();
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

        <link type="text/css" href="resource/estoqueArmazem.css" rel="stylesheet">

        <script type="text/javascript" src="resource/estoqueArmazem.js"></script>
        <script type="text/javascript" src="../tecnologia/js/exportar.js"></script>
        <script type="text/javascript" src="../tecnologia/js/tableToJson-mini.js"></script>
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
                <div class="topBar">Estoque armazém</div>
                <div class="topBarRight">
                    <button data-toggle="modal" class="botaoTop" title="Filtrar" onClick="multiselection();" data-target="#FiltroModal"><i class="glyphicon glyphicon-search"></i></button>
                    <button data-toggle="modal" class="botaoTop" title="Exportar" onClick="exportarOnHandler();"><i class="glyphicon glyphicon-export"></i></button>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="pageContent">
            <?php
            include('EstoqueArmazemModalFiltro.php');
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
                    <table id="tableEstoqueArmazem" class="table table-striped table-bordered" border="0">
                        <thead>
                        <tr class="Noactivetr">
                            <th hidden = 'true'></th>
                            <th>Produto</th>
                            <th>Descrição do produto</th>
                            <th>Lote</th>
                            <th>Validade</th>
                            <th>Fabricação</th>
                            <th>Nr Série</th>
                            <th>Nr Documento</th>
                            <th>Nr pedido</th>
                            <th>Unitização</th>
                            <th>Endereço</th>
                            <th>Disponível</th>
                            <th>Reservado</th>
                            <th>Bloqueado</th>
                            <th>Total</th>
                            <th>Peso bruto</th>
                            <th>Valor mercadoria</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        Sistema::iniciaCarregando();

                        $rows = $estoqueArmazem->getRegistro();

                        echo join(' ', $rows['DADOS']);
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="footerFixed">
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
    <script>
        var retornoJson = $('#tableEstoqueArmazem').tableToJSON();
    </script>
    </body>
    </html>
    <?php
}