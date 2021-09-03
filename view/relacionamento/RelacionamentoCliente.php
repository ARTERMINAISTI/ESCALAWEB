<?php
include_once('../../controller/tecnologia/Sistema.php');
require '../../model/relacionamento/getDados.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/png" href="../tecnologia/img/favicon.png"/>
        <title>Abertura de Ticket</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="../tecnologia/css/bootstrap3/bootstrap.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" type="text/css" href="../tecnologia/css/datatable/datatables.min.css"/>
        <!-- FontAwessome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
              integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <!-- DropZone -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="../tecnologia/css/relacionamento.css"/>
            
        <!-- Bootstrap Core CSS -->
        <link href="../../view/tecnologia/css/bootstrap.php" rel='stylesheet' type='text/css' />
        <!-- Custom CSS -->
        <link href="../../view/tecnologia/css/style.php" rel='stylesheet' type='text/css' />
        <!-- font CSS -->
        <!-- font-awesome icons -->
        <link href="../../view/tecnologia/css/font-awesome.css" rel="stylesheet">
        <!-- //font-awesome icons -->
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

        <!-- Menu Lateral -->
        <script src="../../view/tecnologia/js/metisMenu.min.js"></script>
        <script src="../../view/tecnologia/js/custom.js"></script>
        <link href="../../view/tecnologia/css/custom.php" rel="stylesheet">
        <!--//Menu Lateral-->
        <!-- Custom -->
        <script type="text/javascript" src="../tecnologia/js/jquery-ui.js"></script>
        <link type="text/css" href="../tecnologia/css/styleCustom.php" rel="stylesheet"/>
        <link type="text/css" href="../../view/tecnologia/css/jquery.multiselect.css" rel="stylesheet"/>
        <script type="text/javascript" src="../../view/tecnologia/js/jquery.multiselect.js"></script>
        <script type="text/javascript" src="../../view/tecnologia/js/blockUI.js"></script>
        <!--// End Custom -->
        <!-- shortTable -->
        <link href="../../view/tecnologia/css/theme.bootstrap_3.min.css" rel="stylesheet">
        <script src="../../view/tecnologia/js/jquery.tablesorter.js"></script>
        <script src="../../view/tecnologia/js/jquery.tablesorter.widgets.js"></script>

    </head>

    <body class="cbp-spmenu-push" id="bodyFullScreen">
        <div class="sticky-header header-section">

            <!--div class="container">
                <div class="topBar container">Abertura de Ticket</div>
            </div-->

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
                    <div class="topBar"><?php include('../../view/estrutura/navBarLogo.php'); ?>Abertura de Ticket</div>
                </div>
                <div class="clearfix"> </div>   
            </div>
        </div>

        <div class="page-content">
            <div class="espaço" style="margin: 70px 0 0 0;"></div>
            <div class="container">
                <div class="erro"></div>
                <form method="POST" id="formRelacionamento">
                    <input type="hidden" class="form-control" name="CHAVE" value="<?= Sistema::criarGuid() ?>"/>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <span>Nome*</span>
                                <input type="text" class="form-control" placeholder="Nome" id="NOME" name="NOME"
                                       required="required">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <span>E-mail*</span>
                                <input type="email" class="form-control" placeholder="E-mail" name="EMAIL" required="required">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <span>Telefone*</span>
                                <input type="text" class="form-control" placeholder="Telefone" name="TELEFONE"
                                       required="required">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <span>Tipo*</span>
                                <select class="form-control" name="TIPO" required="required">
                                    <option selected disabled value="">Selecione...</option>
                                    <?php foreach ($tipos as $tipo) { ?>
                                        <option value="<?= $tipo["HANDLE"] ?>"><?= $tipo["NOME"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span>Descrição detalhada*</span>
                                <textarea class="form-control" rows="4" placeholder="Descrição detalhada" required="required"
                                          name="DESCRICAO"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span>Anexo</span>
                            <div class="dropzone">
                                <div class="dz-message" data-dz-message><span>Clique ou solte arquivos aqui para anexar.</span>
                                </div>
                                <div class="fallback">
                                    <input name="file" type="file" multiple/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group pull-right" role="group">
                                <button type="submit" class="btn btn-success">Enviar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- jQuery -->
        <!--script type="text/javascript" src="../tecnologia/js/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="../tecnologia/js/bootstrap3/bootstrap.min.js"></script>
        <script type="text/javascript" src="../tecnologia/js/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="../tecnologia/js/datatables/dataTables.bootstrap4.min.js"></script-->
        <!-- MomentJS -->
        <script type="text/javascript" src="../tecnologia/js/momentjs/moment.js"></script>
        <script type="text/javascript" src="../tecnologia/js/momentjs/moment-duration-format.js"></script>
        <!-- SweetAlert -->
        <script type="text/javascript" src="../tecnologia/js/sweetalert/sweetalert.min.js"></script>
        <!-- DropZone -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
        <script>
            Dropzone.autoDiscover = false;
            Dropzone.prototype.defaultOptions.dictRemoveFile = "Remover Arquivo";
        </script>
        <!-- jQueryUI -->
        <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <!-- jQuery Mask -->
        <script type="text/javascript"
                src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <!-- Scripts -->
        <script src="//d2wy8f7a9ursnm.cloudfront.net/v6/bugsnag.min.js"></script>
        <script>window.bugsnagClient = bugsnag('9f6cc1049582acdb30bc5fff5e922e62')</script>
        <script type="text/javascript" src="../tecnologia/js/relacionamento.js"></script>
        <script src="../tecnologia/js/classie.js"></script>
        <!--scrolling js-->
        <script src="../tecnologia/js/jquery.nicescroll.js"></script>
        <script src="../tecnologia/js/script.js"></script>
        <!--//scrolling js-->
        <!-- Bootstrap Core JavaScript -->
        <script src="../tecnologia/js/bootstrap.js"></script>
    </body>

</html>