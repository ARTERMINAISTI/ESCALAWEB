<?php

include_once('../../controller/tecnologia/Sistema.php');
if (!isset($_SESSION['usuario']) and ! isset($_SESSION['senha'])) {
    header('Location: ../../view/estrutura/login.php?success=F');
}// not isset sessions of login
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
            <link href="../tecnologia/css/bootstrap.php" rel='stylesheet' type='text/css' />
            <!-- Custom CSS -->
            <link href="../tecnologia/css/style.php" rel='stylesheet' type='text/css' />
            <!-- font CSS -->
            <!-- font-awesome icons -->
            <link href="../tecnologia/css/font-awesome.css" rel="stylesheet"> 
            <!-- //font-awesome icons -->
            <!-- material icons -->
            <link href="../../view/tecnologia/css/material-icons.css" rel="stylesheet"> 
            <!-- //material icons -->
            <!-- js-->
            <script src="../tecnologia/js/jquery-1.11.1.min.js"></script>
            <script src="../tecnologia/js/modernizr.custom.js"></script>
            <!--animate-->
            <link href="../tecnologia/css/animate.css" rel="stylesheet" type="text/css" media="all">
            <script src="../tecnologia/js/wow.min.js"></script>
            <script>
                new WOW().init();
            </script>
            <!--//end-animate-->
            <!-- chart -->
            <script src="../tecnologia/js/Chart.js"></script>
            <!-- //chart -->
            <!--Calendario-->
            <link rel="stylesheet" href="../tecnologia/css/clndr.css" type="text/css" />
            <script src="../tecnologia/js/underscore-min.js" type="text/javascript"></script>
            <script src= "../tecnologia/js/moment-2.2.1.js" type="text/javascript"></script>
            <script src="../tecnologia/js/clndr.js" type="text/javascript"></script>
            <script src="../tecnologia/js/site.js" type="text/javascript"></script>
            <!--End Calendario-->
            <!-- Menu Lateral -->
            <script src="../tecnologia/js/metisMenu.min.js"></script>
            <script src="../tecnologia/js/custom.js"></script>
            <link href="../tecnologia/css/custom.php" rel="stylesheet">
            <!--//Menu Lateral-->
            <!-- Custom -->
            <script type="text/javascript" src="../tecnologia/js/jquery-ui.js"></script>
            <script type="text/javascript" src="../tecnologia/js/exportar.js"></script>
            <script type="text/javascript" src="../tecnologia/js/bootbox.js"></script>
            <link type="text/css" href="../tecnologia/css/jquery-ui.css" rel="stylesheet"/>
            <link type="text/css" href="../tecnologia/css/styleCustom.php" rel="stylesheet"/>
            <link type="text/css" href="../../view/tecnologia/css/jquery.multiselect.css" rel="stylesheet"/>
            <script type="text/javascript" src="../../view/tecnologia/js/jquery.multiselect.js"></script>
            <script type="text/javascript" src="../../view/tecnologia/js/blockUI.js"></script>
            <!--// End Custom -->
            <!-- shortTable -->
            <link href="../../view/tecnologia/css/theme.bootstrap_3.min.css" rel="stylesheet">
            <script src="../../view/tecnologia/js/jquery.tablesorter.js"></script>
            <script src="../../view/tecnologia/js/jquery.tablesorter.widgets.js"></script>

            <link href="../../view/tecnologia/css/TabelasPadrao.css" rel="stylesheet">

            <script type="text/javascript" src="../operacional/js/scriptRastreioPedido.js"></script>
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

                function LoadFilter() {
                    setTimeout(function(){
                        <?php
                        if (!isset($_GET["EDIT"])) {
                        ?>
                        let btnFiltrar = $("#btnFiltrar")[0];

                        btnFiltrar.click();
                        <?php
                        }
                        ?>
                    }, 1000);                    
                    
                };
            </script>
            <!--// End shortTable -->
            <style>
                body{
                        overflow: auto;
                    } 
                @media screen and (min-height: 750px) {  
                    body{
                        overflow: hidden;
                    }                                  
                }
                .alturaFixa{
                    width:100%;
                    overflow-y: scroll;  
                    overflow: hidden;
                }   
                
                .selected {
                    background-color: #2b9bcb !important;
                }

                
                .table {
					padding: 0px;
				}
				
				.table.dataTable th  {
					 padding: 2px;
					 font-size:10px;					  
					 vertical-align: middle;
				}
								
				.table.dataTable td {
					padding: 2px;
					font-size:10px;					  
					white-space: nowrap;
					overflow: hidden;
					text-overflow: ellipsis;
					border-top: none;
					border-bottom: 1px solid  #111;
					border-right: 0 !important;
				}

            </style>
        </head> 
        <body class="cbp-spmenu-push" id="bodyFullScreen" onload="LoadFilter()">
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

                    <div class="topBar">Rastreio de transporte</div>

                    <div class="topBarRight">
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li>
                                <button name="visualizarRastreioPedidoMobile" class="btn botaoMobile display" type="button" id="visualizarRastreioPedidoMobile">Visualizar</button>
                            </li>
                        </ul>

                        <button data-toggle="modal" class="botaoTop btn" id="btnFiltrar" title="Filtrar" onClick="multiselection();" data-target="#FiltroModal">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>

                        <button data-toggle="modal" class="botaoTop btn btnPendente" title="Pendente">
                          <span class="glyphicon glyphicon-list" style="color: white"></i>
                        </button>

                        <button data-toggle="modal" class="botaoTop btn btnExportar" title="Exportar" onclick="">
                            <i class="glyphicon glyphicon-export"></i>
                        </button>
                    </div>
                </div>

                <div class="clearfix"> </div>	
            </div>
            <!-- //header-ends -->
            <?php include_once('../../model/operacional/ModalRastreioPedido.php') ?>
            <!-- main content start-->
            <div class="pageContent">
                <form method="post" >    
                    <div class="table-responsive alturaFixa">
                        <div clas id="container-fluid">
                            <div class="larguraInteira">
                                <table id="reqtablenew" class="table table-striped table-bordered" cellspacing="0" style="width:100%">
                                    <thead>
                                        <tr class="Noactivetr">  
                                            <th></th>                                    
                                            <th class="text-center">Rastreamento</th>                                       
                                            <th style="min-width:85px;" class="text-center">Data emissão</th>                              
                                            <th class="text-center" style="min-width:100px;">Tipo</th>                                    
                                            <th style="min-width:70px;" class="text-center">Doc transporte</th>   
                                            <th style="min-width:60px;" class="text-center">Nr nota fiscal</th>  
                                            <th style="min-width:150px;">Destinatário</th>
                                            <th style="min-width:90px;">Destino</th>
                                            <th >UF</th>
                                            <th style="min-width:65px;" class="text-center">Vlr mercadoria</th>                                                                                                                         
                                            <th style="min-width:60px;" class="text-right">Peso real</th>
                                            <th style="min-width:60px;" class="text-right">Peso cubado</th>
                                            <th style="min-width:30px;" class="text-right">Volumes</th>
                                            <th style="min-width:70px;" class="text-center">Data da etapa</th>   
                                            <th style="min-width:120px;">Etapa atual</th>   
                                            <th style="min-width:60px;" class="text-center">Prev. entrega</th> 
                                            <th style="min-width:60px;" class="text-center">Entrega</th>
                                            <th style="min-width:150px;"class="text-left">Remetente</th>
                                            <th style="min-width:65px;" class="text-center">Nr pedido</th>
                                            <th style="min-width:60px;" class="text-center">Nr controle</th>                    
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="footerNotThatFixed">
                        <div class="col-xs-1">
                            <button type="button" class="span">&nbsp;</button>
                        </div>
                    </div><!-- end footer -->
                </form>
            </div><!-- end pageContent -->          

            <div class="clearfix"> </div>

            <!-- Classie -->
            <script src="../tecnologia/js/classie.js"></script>

            <!-- DataTables -->
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/r-2.2.2/datatables.min.css" />
            <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/r-2.2.2/datatables.min.js"></script>

            <!--scrolling js-->
            <script src="../tecnologia/js/jquery.nicescroll.js"></script>
            <script src="../tecnologia/js/script.js"></script>
            <!--//scrolling js-->

            <!-- SweetAlert -->
            <script type="text/javascript" src="../tecnologia/js/sweetalert/sweetalert.min.js"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src="../tecnologia/js/bootstrap.js"></script>
        </body>
    </html>

    <?php
}
