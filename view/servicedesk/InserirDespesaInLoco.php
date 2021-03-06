<?php
include_once('../../controller/tecnologia/Sistema.php');
if (!isset($_SESSION['usuario']) and ! isset($_SESSION['senha'])) {
    header('Location: ../../view/estrutura/login.php?success=F');
}// not isset sessions of login
else {
    $connect = Sistema::getConexao();
    $referencia = Sistema::getGet('referencia');
    $inLocoHandle = Sistema::getGet('handle');
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
            <script type="text/javascript" src="../tecnologia/js/scriptDespesaAtendimentoInLoco.js"></script>
            <link type="text/css" href="../tecnologia/css/jquery-ui.css" rel="stylesheet"/>
            <link type="text/css" href="../tecnologia/css/styleCustom.php" rel="stylesheet"/>
            <script type="text/javascript" src="../../view/tecnologia/js/blockUI.js"></script>
            <!--// End Custom -->
        </head>
        <body>
            <div class="main-content" id="bodyFullScreen"> 
                <?php
                include_once('../../model/servicedesk/retornoInserirAtendimentoInLoco.php');
                ?>
                <div id="loader"></div>
                <!-- header-starts -->
                <div class="sticky-header header-section" > 

                    <div id="toggle">
                        <!--toggle button start-->
                        <a href="<?php echo $referencia; ?>.php"><button id="showLeftPushVoltarForm"><i class="glyphicon glyphicon-menu-left"></i></button></a>
                        <a href="<?php echo $referencia; ?>.php" class="display" hidden="true"><button hidden="true" id="showLeftPush"><i class="glyphicon glyphicon-menu-left"></i></button></a>
                        <!--toggle button end-->
                    </div>  
                    <input type="text" hidden="true" class="display" id="editou" value="N">
                    <input type="text" hidden="true" class="display" id="referencia" value="<?php echo $referencia; ?>">   
                    <div class="topBar">Atendimento in loco</div>
                    <div class="topBarRight dropdown">
                        <button type="button" class="btn botaoTop dropdown-toggle desktopHide" role="button" aria-expanded="false" data-toggle="dropdown" ><i class="material-icons">&#xE5D4;</i></button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li><button name="GravarAtendimentoInLocoMobile" class="btn botaoMobile <?php echo $display; ?>" type="button" id="GravarAtendimentoInLocoMobile">Gravar</button></li>
                            <li><button name="LimparMobile" class="btn botaoMobile <?php echo $display; ?>" type="button" id="LimparMobile" data-toggle="modal" data-target="#LimparModal">Limpar</button></li>
                        </ul>
                    </div>

                    <div class="clearfix"> </div>
                </div>
                <!-- //header-ends --> 

                <!-- Start VoltarModal -->
                <div class="modal fade" id="VoltarModal"  role="dialog" aria-spanledby="VoltarModalspan">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="post" action="#">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-span="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="VoltarModalspan">O registro n??o foi salvo</h4>
                                </div>
                                <div class="modal-body"> Deseja salvar as altera????es realizadas neste formul??rio?
                                    <div class="clearfix"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="botaoBrancoLg" id="sim" onClick="submitAtendimentoInLocoForm()"> Sim </button>
                                    <button type="button" class="botaoBrancoLg" onClick="javascript:window.location.href = '<?php echo $referencia; ?>.php'"> N??o </button>
                                    <button type="button" class="botaoBranco"  data-dismiss="modal"> Cancelar </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- //End Modal voltar--> 
                <!-- main content start-->
                <div class="pageContent">
                    <form method="post" id="AtendimentoInLoco" action="../../controller/servicedesk/InserirAtendimentoInLocoController.php?referencia=<?php echo $referencia; ?>" enctype="multipart/form-data">
                        <div class="row">
                            <?php
                            include_once('../../model/servicedesk/modalInserirAtendimentoInLoco.php');
                            ?>
                        </div>

                        <div class="row">
                            <div class="formContent">
                                <div class="col-md-4 col-xs-9 pullBottom"> <span>Tipo</span>
                                    <div class="inner-addon right-addon"> <font size="-2"><i class="glyphicon glyphicon-triangle-bottom" id="spandown"></i></font>
                                        <input type="text" name="tipo" id="tipo" value="<?php echo $tipo; ?>" class="editou form-control pulaCampoEnter">
                                    </div>

                                    <input type="text" name="tipoHandle" value="<?php echo $tipoHandle; ?>" id="tipoHandle" hidden="true">
                                </div>
                                <div class="col-md-2 col-xs-3 pullBottom"> <span>In Loco</span>
                                    <div class="inner-addon right-addon"> <font size="-2"><i class="glyphicon glyphicon-triangle-bottom" id="spandown"></i></font>
                                        <input type="text" name="inLoco" id="inLoco"  value="<?php echo $inLocoView; ?>" <?php echo $disabled; ?> class="form-control">
                                    </div>
                                    <input type="text" name="inLocoHandle" id="inLocoHandle" value="<?php echo $inLocoHandle; ?>"   hidden="true">
                                </div>
                                <div class="col-md-4 col-xs-12 pullBottom"> <span>Despesa</span>
                                    <div class="inner-addon right-addon"> <font size="-2"><i class="glyphicon glyphicon-triangle-bottom" id="spandown"></i></font>
                                        <input type="text" name="despesa" value="<?php echo $despesa; ?>" id="despesa"  class="editou form-control pulaCampoEnter">
                                    </div>
                                    <input type="text" name="despesaHandle" value="<?php echo $despesaHandle; ?>" id="despesaHandle" hidden="true">
                                </div>
                                <div class="col-md-2 col-xs-6"> <span>Complemento</span>
                                    <input type="text" name="complemento" value="<?php echo $complemento; ?>"   id="complemento"  class="form-control pulaCampoEnter">
                                </div>
                                <div class="col-md-3 col-xs-6 pullBottom"> <span>Data</span>
                                    <input type='datetime-local' value="<?php echo $date . 'T' . $time; ?>" id="data" name="data" class="form-control pulaCampoEnter" />
                                </div>
                                <div class="col-md-2 col-xs-4 pullBottom"> <span>Quantidade</span>
                                    <input type="text" name="quantidade" id="quantidade" value="<?php echo $quantidade; ?>" onBlur="calcularInverso();" class="form-control pulaCampoEnter inputRight inputClass" >
                                </div>
                                <div class="col-md-2 col-xs-4 pullBottom"> <span>Valor</span>
                                    <input type="text" name="ValorUnitario" value="<?php echo $ValorUnitario; ?>" onBlur="calcularValor()" onClick="limpavalor()" id="ValorUnitario" class="form-control pulaCampoEnter inputRight inputClass" >
                                </div>
                                <div class="col-md-2 col-xs-4 pullBottom"> <span>Total</span>
                                    <input type="text" name="ValorTotal" id="ValorTotal" value="<?php echo $ValorTotal; ?>" disabled  class="form-control inputRight inputClass" >
                                </div>
                                <div class="col-md-1 col-xs-6 pullBottom"> <span>% Reembolso</span>
                                    <input type="text" name="percentualReembolso" id="percentualReembolso" value="<?php echo $percentualReembolso; ?>" onBlur="calcularPercentual();" disabled  class="form-control pulaCampoEnter inputRight inputClass" >
                                </div>
                                <div class="col-md-2 col-xs-6 pullBottom"> <span>Total reembolso</span>
                                    <input type="text" name="totalReembolso" id="totalReembolso" value="<?php echo $totalReembolso; ?>" disabled  class="form-control inputRight inputClass" >
                                </div>
                                <div class="col-xs-12"> <span>Observa????o</span>
                                    <textarea id="obs" class="form-control textarea pulaCampoEnter" name="observacao"><?php echo $observacao; ?></textarea>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <ul class="nav nav-tabs" id="myTabs" role="tablist">
                                <li role="presentation" class="active"><a href="#anexo" id="anexo-tab" role="tab" data-toggle="tab" aria-controls="AtendimentoInLoco" aria-expanded="true">Anexo</a></li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active in" role="tabpanel" id="anexo" aria-labelledby="anexo-tab">
                                    <div class="col-xs-12 bottonPull">
                                        <div class="left">
                                            <!-- botoes anexo aqui -->
                                        </div>
                                        <div class="right">
                                            <label for="image_src" class="botaoBranco1" disabled><font size="3px"  color="#A7A7A7"><i class="glyphicon glyphicon-plus"> </i> </font></label>
                                            <input accept="image/*" onchange="preview_image()" disabled type="file" name="image_src[]" id="image_src"  multiple/>
                                            <button type="button" disabled class="botaoBranco1"><font size="5px" color="#A7A7A7"><i class="fa fa-caret-up"> </i> </font></button>
                                            <button type="button" disabled class="botaoBranco1"><font size="4px" color="#A7A7A7"><i class="fa fa-minus"> </i> </font></button>
                                        </div>
                                        <div class="dividerH"></div>
                                        <p>
                                        <table class="table table-hover table-responsive">
                                            <thead>
                                                <tr>
                                                    <th class="tableth">Nome do anexo</th>
                                                    <th width="12%" class="tableth">Data</th>
                                                </tr>
                                            </thead>
                                            <tbody id="image_preview">
                                            </tbody>
                                        </table>
                                        <div ></div>
                                        <p></p>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- end table --> 
                        </div>
                </div>
                <!-- end row -->
                <div class="footerFixed mobileHide">
                    <div class="right">
                        <button type="button" class="botao <?php echo $display; ?>" name="GravarAtendimentoInLoco" id="GravarAtendimentoInLoco">Gravar</button>
                        <button type="button" class="botao <?php echo $display; ?>" name="Limpar" id="Limpar" data-toggle="modal" data-target="#LimparModal">Limpar</button>
                    </div>
                </div>
                <!-- end footer -->
            </form>
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
    <script src="../tecnologia/js/bootstrap.js"></script>
    </body>
    </html>
    <?php
}
?>