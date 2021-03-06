<?php
include_once('../../controller/tecnologia/Sistema.php');

if (!isset($_SESSION['usuario']) and !isset($_SESSION['senha'])) {
    header('Location: ../../view/estrutura/login.php?success=F');
}
else {
    $connect = Sistema::getConexao();
    ?>
<!DOCTYPE HTML>
    <html>
        <head>
            <title>Escalasoft</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <link rel="icon" type="image/png" href="../tecnologia/img/favicon.png" />
            <!-- Bootstrap Core CSS -->
            <link href="../../view/tecnologia/css/bootstrap.php" rel='stylesheet' type='text/css' />
            <!-- Custom CSS -->
            <link href="../../view/tecnologia/css/style.php" rel='stylesheet' type='text/css' />
            <!-- font CSS -->
            <!-- font-awesome icons -->
            <link href="../../view/tecnologia/css/font-awesome.css" rel="stylesheet">
            <!-- //font-awesome icons -->
            <!-- material icons -->
            <link href="../../view/tecnologia/css/material-icons.css" rel="stylesheet">
            <!-- //material icons -->
            <!-- js-->
            <script src="../../view/tecnologia/js/jquery-1.11.1.min.js"></script>
            <script src="../../view/tecnologia/js/modernizr.custom.js"></script>
            <!--animate-->
            <link href="../../view/tecnologia/css/animate.css" rel="stylesheet" type="text/css" media="all">
            <script src="../../view/tecnologia/js/wow.min.js"></script>
            <script>
                new WOW().init();
            </script>
            <!--//end-animate-->
            <!-- chart -->
            <script src="../tecnologia/js/Chart.js"></script>
            <!-- //chart -->
            <!--Calendario-->
            <link rel="stylesheet" href="../../view/tecnologia/css/clndr.css" type="text/css" />
            <script src="../../view/tecnologia/js/underscore-min.js" type="text/javascript"></script>
            <script src= "../../view/tecnologia/js/moment-2.2.1.js" type="text/javascript"></script>
            <script src="../../view/tecnologia/js/clndr.js" type="text/javascript"></script>
            <script src="../../view/tecnologia/js/site.js" type="text/javascript"></script>
            <!--End Calendario-->
            <!-- Menu Lateral -->
            <script src="../../view/tecnologia/js/metisMenu.min.js"></script>
            <script src="../../view/tecnologia/js/custom.js"></script>
            <link href="../../view/tecnologia/css/custom.php" rel="stylesheet">
            <!--//Menu Lateral-->
            <!-- Custom -->
            <script type="text/javascript" src="../tecnologia/js/jquery-ui.js"></script>
            <script type="text/javascript" src="../tecnologia/js/scriptPedidoDeVenda.js"></script>
            <link type="text/css" href="../tecnologia/css/styleCustom.php" rel="stylesheet"/>
            <link type="text/css" href="../../view/tecnologia/css/jquery.multiselect.css" rel="stylesheet"/>
            <script type="text/javascript" src="../../view/tecnologia/js/jquery.multiselect.js"></script>
            <script type="text/javascript" src="../../view/tecnologia/js/blockUI.js"></script>
            <script type="text/javascript" src="../../view/tecnologia/js/scriptFiltroPedidoDeVenda.js"></script>
            <!--// End Custom -->
            <!-- shortTable -->
            <link href="../../view/tecnologia/css/theme.bootstrap_3.min.css" rel="stylesheet">
            <script src="../../view/tecnologia/js/jquery.tablesorter.js"></script>
            <script src="../../view/tecnologia/js/jquery.tablesorter.widgets.js"></script>
            <script>
                $(function () {
                    $('table').tablesorter({
                        widgets: ['zebra', 'columns'],
                        usNumberFormat: false,
                        sortReset: true,
                        sortRestart: true,
                        dateFormat: 'pt'
                    });
                });
            </script>
            <!--// End shortTable -->
            <style>
                body{
                    overflow: hidden;	
                }
                @media screen and (max-width: 768px) {
                    body{
                        overflow: auto;	
                    }
                }
            </style>
        </head>
        <body class="cbp-spmenu-push" id="bodyFullScreen">
            <div id="loader"></div>
                <div class="main-content">
                    <!--left-fixed -navigation-->
                    <div class=" sidebar" role="navigation">
                        <div class="navbar-collapse">
                            <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
                                <?php include('../../view/estrutura/menu.php') ?>
                            </nav>
                        </div>
                    </div>                
                    <!--left-fixed -navigation-->
                    <!-- header-starts -->
                    <div class="sticky-header header-section ">
                        <!--toggle button start-->
                        <button id="showLeftPush"><i class="fa fa-bars"></i></button>
                        <!--toggle button end-->
                        <div class="topBar"><?php include('../../view/estrutura/navBarLogo.php'); ?>Pedido de venda</div>
                        <div class="topBarRight">
                        <button data-toggle="modal" class="botaoTop"  onClick="multiselection();" data-target="#FiltroModal"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                    <div class="clearfix"> </div>	
                </div>
                <!-- //header-ends -->
                <!-- main content start-->
                <div class="pageContent">
                    <?php
                    include_once('../../model/comercial/retornoPedidoDeVenda.php');
                    include('../../model/comercial/modalPedidoDeVendaFiltro.php');
                    ?>
                    <form method="post" action="#">
                    <div class="table-responsive">
                        <div class="larguraInteira">
                            <table class="table table-striped table-bordered bottomPull" id="reqtablenew" border="0">
                                <thead>
                                <tr class="Noactivetr">
                                    <th hidden="true">#</th>
                                    <th>&nbsp;</th>
                                    <th>Pedido</th>
                                    <th>Data</th>
                                    <th>Tipo</th>
                                    <th>Cliente</th>
                                    <th>Quantidade</th>
                                    <th>Valor total</th>
                                    <th>Condi????o de pagamento</th>
                                    <th>Forma de pagamento</th>
                                    <th>Conta de tesouraria</th>
                                    <th>Frete</th>
                                    <th>Transportador</th>
                                    <th>Data de inclus??o</th>
                                    <th>Usu??rio inclus??o</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    include_once('../../model/comercial/pedidoDeVendaTabelaModelFiltro.php'); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="footerFixed">
                        <div class="right">
                            <div class="col-xs-1">
                                <button type="button" class="span">&nbsp;</button>
                            </div>
                            <div class="col-xs-11">
                                <div class="right">
                                <a href="InserirPedidoDeVenda.php">
                                <button name="adicionarPedido" class="botao" type="button" id="adicionarPedido">Inserir</button>
                                </a>
                                <button name="visualizarPedido" class="botao display" type="button" id="visualizarPedido">Visualizar</button>
                                <button type="button" class="botao display" id="cancelarPedido" data-toggle="modal"  data-target="#CancelarPedidoModal"  name="cancelarPedido">Cancelar</button>
                                <button type="button" class="botao display" id="excluirPedido"  name="excluirPedido" data-toggle="modal"  data-target="#ExcluirPedidoModal">Excluir</button>
                                <button type="button" class="botao display" id="liberarPedido" data-toggle="modal"  data-target="#LiberarPedidoModal" name="liberarPedido">Liberar</button>
                                <button type="button" class="botao display" id="voltarPedido" data-toggle="modal"  data-target="#VoltarPedidoModal" name="voltarPedido">Voltar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end footer -->
                    </form>
                </div>
                <!-- end pageContent -->
                <div class="clearfix"> </div>
            </div>
            </div>
            <!-- Classie -->
            <script src="../tecnologia/js/classie.js"></script>
            <!--scrolling js-->
            <script src="../tecnologia/js/jquery.nicescroll.js"></script>
            <script src="../tecnologia/js/script.js"></script>
            <!--//scrolling js-->
            <!-- Bootstrap Core JavaScript -->
            <script src="../tecnologia/js/bootstrap.js"> </script>
        </body>
    </html>
<?php
}
?>