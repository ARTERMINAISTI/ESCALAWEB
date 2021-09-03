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
        <script type="text/javascript" src="../tecnologia/js/scriptLoteDistribuicao.js"></script>
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
                <div class="topBar"><?php include('../../view/estrutura/navBarLogo.php'); ?>Visualizar lote de distribuição</div>
                <div class="topBarRight">
                    <button id="botaoDownloadVisualizarLote" type="button" title="Baixar lote" data-placement="bottom" data-toggle="modal" class="botaoTop" onClick="exportarLote(<?php echo Sistema::getGet("lote");?>);">
                        <i class="glyphicon glyphicon-download"></i>
                    </button>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
        <!-- //header-ends -->
        <!-- main content start-->
        <?php
            include_once('../../model/fiscal/VisualizarLoteDistribuicaoModel.php');
        ?>
        <div class="pageContent">
            <form method="post" id="LoteDistribuicao" action="#" enctype="multipart/form-data">
                <div class="row">
                    <div class="formContent">
                        <input id="statusLote" style="display: none;" type="button" value="<?php echo $situacaoHandle;?>">

                        <div class="col-md-6 col-xs-12 pullBottom">
                            <span>Cliente</span>
                            <div class="inner-addon right-addon">
                                <font size="-2">
                                    <i class="glyphicon glyphicon-triangle-bottom" id="spandown"></i>
                                </font>
                                <input type="text" name="cliente" id="cliente" value="<?php echo $cliente; ?>" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="col-md-3 col-xs-6">
                            <span>Número</span>
                            <div class="inner-addon right-addon">
                                <input type="text" name="numeroLote" id="numeroLote" value="<?php echo $numeroLote; ?>" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="col-md-3 col-xs-6 pullBottom">
                            <span>Tipo extração</span>
                            <div class="inner-addon right-addon">
                                <font size="-2">
                                    <i class="glyphicon glyphicon-triangle-bottom" id="spandown"></i>
                                </font>
                                <input type="text" name="tipoExtracao" id="tipoExtracao" value="<?php echo $tipoExtracao; ?>" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-3 col-xs-6">
                            <span>Qtd. Documento</span>
                            <div class="inner-addon right-addon">
                                <input type="text" name="quantidadeDoc" id="quantidadeDoc" value="<?php echo $quantidadeDoc; ?>" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6 pullBottom">
                            <span>Data</span>
                            <div class="inner-addon right-addon">
                                <input type="text" name="data" id="data" value="<?php echo $data; ?>" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <span>Data inicial</span>
                            <div class="inner-addon right-addon">
                                <input type="text" name="dataInicial" id="dataInicial" value="<?php echo $dataInicial; ?>" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <span>Data final</span>
                            <div class="inner-addon right-addon">
                                <input type="text" name="dataFinal" id="dataFinal" value="<?php echo $dataFinal; ?>" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
            <!-- end row -->
            </form>
            <div class="row" style="margin: 0.2em 0 0;">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#Documento" id="Documento-tab" role="tab" data-toggle="tab" aria-expanded="true">Documento</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="Documento">
                        <div class="table-responsive">
                            <div class="AlturaInteira">
                                <table class="table table-responsive table-striped bottomPull" id="reqtableAnexo" border="0">
                                    <thead>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th class="text-right">Número</th>
                                        <th>Tipo</th>
                                        <th>Emissão</th>
                                        <th class="text-right">Valor</th>
                                        <th>Remetente</th>
                                        <th>Destinatário</th>
                                        <th>Tomador</th>
                                        <th>Filial</th>
                                        <th>Filial origem</th>
                                        <th>Filial destino</th>
                                        <th>Atual</th>
                                        <th>Origem</th>
                                        <th>Destino</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include_once('../../model/fiscal/VisualizarLoteDistribuicaoDocumentoTabelaModel.php');
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end pageContent -->
        <div class="clearfix"></div>
        <!-- Classie -->
        <script src="../tecnologia/js/classie.js"></script>
        <!--scrolling js-->
        <script src="../tecnologia/js/jquery.nicescroll.js"></script>
        <script src="../tecnologia/js/script.js"></script>
        <!--//scrolling js-->
        <!-- Bootstrap Core JavaScript -->
        <script src="../tecnologia/js/bootstrap.js"></script>
    </body>
</html>
<?php
}
?>