<?php
include_once('../../controller/tecnologia/Sistema.php');

if (!isset($_SESSION['usuario']) and !isset($_SESSION['senha'])) {
    header('Location: ../../view/estrutura/login.php?success=F');
}// not isset sessions of login
else {
    $connect = Sistema::getConexao();

    include_once('../../model/patio/VisualizarConteinerController.php');
    ?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <title>Escalasoft</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="icon" type="image/png" href="../tecnologia/img/favicon.png"/>
        <!-- Bootstrap Core CSS -->
        <link href="../tecnologia/css/bootstrap.php" rel='stylesheet' type='text/css'/>
        <!-- Custom CSS -->
        <link href="../tecnologia/css/style.php" rel='stylesheet' type='text/css'/>
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
        <link rel="stylesheet" href="../tecnologia/css/clndr.css" type="text/css"/>
        <script src="../tecnologia/js/underscore-min.js" type="text/javascript"></script>
        <script src="../tecnologia/js/moment-2.2.1.js" type="text/javascript"></script>
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
        <script type="text/javascript" src="../tecnologia/js/bootbox.js"></script>
        <link type="text/css" href="../tecnologia/css/jquery-ui.css" rel="stylesheet"/>
        <link type="text/css" href="../tecnologia/css/styleCustom.php" rel="stylesheet"/>
        <script type="text/javascript" src="../../view/tecnologia/js/blockUI.js"></script>
        <link type="text/css" href="../tecnologia/css/jquery.scrolling-tabs.css" rel="stylesheet"/>
        <script type="text/javascript" src="../tecnologia/js/scriptConteiner.js"></script>

        <!--// End Custom -->
    </head>
    <body>
    <div class="main-content" id="bodyFullScreen">
        <div id="loader"></div>
        <?php
        include_once('../../model/patio/VisualizarConsultaConteinerModel.php');
        ?>
        <!-- header-starts -->
        <div class="sticky-header header-section ">

            <a href="ConsultaConteiner.php">
                <button id="showLeftPushVoltarForm"><i class="glyphicon glyphicon-menu-left"></i></button>
            </a>
            <a href="ConsultaConteiner.php" class="display" hidden="true">  
                <button hidden="true" id="showLeftPush"><i class="glyphicon glyphicon-menu-left"></i></button>
            </a>
            <!--toggle button end-->

            <div class="topBar mobileHide" style="text-align:left; width:90%;">Visualização de contêiner - 
            <fontcolor="#D1D1D1"><?php echo $situacao . ' desde ' . $statusData . ' às ' . $statusHora; ?></font>
            </div>
            <div class="topBar desktopHide">Detalhe de contêiner</div>

            <div class="clearfix"></div>
        </div>
        <!-- //header-ends -->        
        <!-- main content start-->
        <div class="pageContent">

            <form method="post" id="VisualizaConteiner" action="#" enctype="multipart/form-data">
                <div class="row">
                    <div class="formContent">   
                        <div class="col-md-4 col-xs-6 pullBottom"><span>Filial</span>
                            <div class="inner-addon right-addon">
                                <input type="text" name="filial" id="filial" value="<?php echo $filial; ?>"
                                       class="form-control" disabled>
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-6 pullBottom"><span>Cliente</span>
                            <input type="text" name="cliente" id="cliente" value="<?php echo $cliente; ?>"
                                   class="form-control" disabled>
                        </div>

                        <div class="col-md-2 col-xs-3 pullBottom"><span>Tipo de operação</span>
                            <div class="inner-addon right-addon">
                                <input type="text" name="tipooperacao" id="tipooperacao"
                                       value="<?php echo $tipooperacao; ?>" class="form-control" disabled>
                            </div>
                        </div>    

                        <div class="col-md-2 col-xs-3 pullBottom"><span>Tipo de contêiner</span>
                            <div class="inner-addon right-addon">
                                <input type="text" name="tipoconteiner" id="tipoconteiner" value="<?php echo $tipoconteiner; ?>"
                                       class="form-control" disabled>
                            </div>
                        </div>

                        <div class="col-md-2 col-xs-6 pullBottom"><span>Contêiner</span>
                            <input type="text" name="conteiner" id="conteiner"
                                   value="<?php echo $codigoconteiner; ?>" class="form-control" disabled>
                        </div>                       

                        <div class="col-md-2 col-xs-6 pullBottom"><span>Localização</span>
                            <div class="inner-addon right-addon">
                                <input type="text" name="localizacao" id="localizacao" value="<?php echo $localizacao; ?>"
                                       class="form-control" disabled>
                            </div>
                        </div>

                        <div class="col-md-2 col-xs-3 pullBottom"><span>Dias pátio</span>
                            <input type="text" name="diaspatio" id="diaspatio" value="<?php echo $diaspatio; ?>"
                                   class="form-control" disabled>
                        </div>

                        <div class="col-md-2 col-xs-3 pullBottom"><span>Entrada</span>
                            <div class="inner-addon right-addon">
                                <input type="text" name="entrada" id="entrada"
                                       value="<?php echo $entrada; ?>" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="col-md-2 col-xs-3 pullBottom"><span>Saída</span>
                            <input type="text" name="saida" id="saida"
                                   value="<?php echo $saida; ?>" class="form-control inputLeft"
                                   disabled>
                        </div>

                        <div class="col-md-2 col-xs-3 pullBottom"><span>Demurrage</span>
                            <input type="text" name="demurrage" id="demurrage" value="<?php echo $demurrage; ?>"
                                   class="form-control inputLeft" disabled>
                        </div>
                        
                        <div class="col-md-2 col-xs-3 pullBottom"><span>Classificação ISO</span>
                            <div class="inner-addon right-addon">
                                <input type="text" name="classificacaoiso" id="classificacaoiso"
                                       value="<?php echo $classificacaoiso; ?>" class="form-control" disabled>
                            </div>
                        </div>       
                        
                        <div class="col-md-2 col-xs-3 pullBottom"><span>Finalidade</span>
                        <div class="inner-addon right-addon">
                            <input type="text" name="valorMerc" id="valorMerc"
                                   value="<?php echo $finalidade; ?>" class="form-control inputLeft"
                                   disabled>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
                <!-- end row -->
            </form>
            <div class="row" style="margin: 0.2em 0 0;">
                <?php
                include_once('../../model/patio/VisualizarConsultaConteinerTabsModel.php');
                ?>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="Detalhe">
                        <div class="col-xs-12 bottonPull">
                            <div class="formContent">
                                <br>
                                <div class="col-md-3 col-xs-6 pullBottom">
                                    <span>Altura</span>
                                    <input type="text" name="quantidade" id="quantidade"
                                           value="<?php echo $altura; ?>" class="form-control" disabled>
                                </div>
                                <div class="col-md-3 col-xs-6 pullBottom">
                                    <span>Largura</span>
                                    <input type="text" name="quantidade" id="quantidade"
                                           value="<?php echo $largura; ?>" class="form-control"
                                           disabled>
                                </div>
                                <div class="col-md-3 col-xs-6 pullBottom">
                                    <span>Comprimento</span>
                                    <input type="text" name="quantidade" id="quantidade"
                                           value="<?php echo $comprimento; ?>" class="form-control"
                                           disabled>
                                </div>
                                <div class="col-md-3 col-xs-6 pullBottom">
                                    <span>Capacidade</span>
                                    <input type="text" name="quantidade" id="quantidade"
                                           value="<?php echo $capacidade; ?>" class="form-control" disabled>
                                </div>

                                <div class="col-md-3 col-xs-6 pullBottom">
                                    <span>Tara (kg)</span>
                                    <div class="inner-addon right-addon">
                                        <input type="text" name="quantidade" id="quantidade"
                                               value="<?php echo $tarakg; ?>" class="form-control"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-6 pullBottom">
                                    <span>Mgw (kg)</span>
                                    <div class="inner-addon right-addon">
                                        <input type="text" name="quantidade" id="quantidade"
                                               value="<?php echo $mgwkg; ?>" class="form-control"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-6 pullBottom">
                                    <span>Fabricação</span>
                                    <div class="inner-addon right-addon">
                                        <input type="text" name="quantidade" id="quantidade"
                                               value="<?php echo $fabricacao; ?>" class="form-control"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-6 pullBottom">
                                    <span>Armador</span>
                                    <div class="inner-addon right-addon">
                                        <input type="text" name="quantidade" id="quantidade"
                                               value="<?php echo $armador; ?>" class="form-control"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-6 pullBottom">
                                    <span>Natureza de operação</span>
                                    <div class="inner-addon right-addon">
                                        <input type="text" name="quantidade" id="quantidade"
                                               value="<?php echo $naturezaoperacao; ?>" class="form-control"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-6 pullBottom">
                                    <span>Navio</span>
                                    <div class="inner-addon right-addon">
                                        <input type="text" name="quantidade" id="quantidade"
                                               value="<?php echo $navio; ?>" class="form-control"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-6 pullBottom">
                                    <span>Booking</span>
                                    <div class="inner-addon right-addon">
                                        <input type="text" name="quantidade" id="quantidade"
                                               value="<?php echo $booking; ?>" class="form-control"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-6 pullBottom">
                                    <span>Processo</span>
                                    <div class="inner-addon right-addon">
                                        <input type="text" name="quantidade" id="quantidade"
                                               value="<?php echo $processo; ?>" class="form-control"
                                               disabled>
                                    </div>
                                </div>
                                
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <?php
                        ?>
                        <div role="tabpanel" class="tab-pane " id="Movimentacao">

                            <div class="col-xs-12 bottonPull">
                                <div class="left">
                                    <button type="button" class="botaoBranco" id="MovimentarConteiner" data-toggle="modal" data-target="#MovimentarConteinerModal" name="MovimentarConteiner">Movimentar</button>
                                    <div class="modal fade" id="MovimentarConteinerModal"  role="dialog" aria-spanledby="MovimentarConteinerModalspan">
                                        <div class="modal-dialog modal-lg "role="document">
                                            <div class="modal-content">
                                            <form method="post" action="#">
                                                    <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-span="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="MovimentarConteinerModalspan">Deseja movimentar o contêiner?</h4>
                                                </div>
                                                    <div class="modal-body">
                                                    <?php   
                                                        $sqlHandleConteiner = "SELECT HANDLE
                                                                                    FROM PA_CONTEINER 
                                                                                WHERE CODIGO = '$codigoconteiner'";
                                                                                
                                                        $query = $connect->prepare($sqlHandleConteiner);
                                                        $query->execute();

                                                        $handleConteiner = $row['HANDLE'];
                                                    ?>
                                                        <div class="col-md-6">												
                                                            <span>Tipo de movimentação</span>
                                                                <select class="form-control" id="tipomovimentacao" name="tipomovimentacao" class="editou form-control pulaCampoEnter" required="required">
                                                                    <option selected disabled value="">Selecione...</option>
                                                                    <?php 
                                                                        foreach ($tiposMovimentacao as $tipoMovimentacao) { ?>
                                                                            <option value="<?= $tipoMovimentacao["HANDLE"], ','.$tipoMovimentacao["HANDLEFINALIDADE"], ','.$handleConteiner ?>"><?= $tipoMovimentacao["NOME"] ?></option>
                                                                    <?php } ?>
                                                                </select>		
                                                        </div>		
                                                        <div class="col-md-6">												
                                                            <span>Finalidade</span>
                                                                <select class="form-control" id="tipofinalidade" name="tipofinalidade" class="editou form-control pulaCampoEnter" required="required" disabled>
                                                                    <option selected disabled value=""></option>
                                                                    <?php 
                                                                        foreach ($tiposFinalidade as $tipoFinalidade) { ?>  
                                                                            <option value="<?= $tipoFinalidade["HANDLE"] ?>"><?= $tipoFinalidade["NOME"] ?></option>
                                                                    <?php } ?>
                                                                </select>			
                                                        </div>		    
                                                        <div class="col-md-4">
                                                            <span>Data</span>
                                                            <input type='datetime-local' value="<?php echo Date('Y-m-d\TH:i',time()) ?>" id="dataMovimentacao" name="dataMovimentacao" class="form-control pulaCampoEnter" required="required" />
                                                        </div>
                                                        <div class="col-md-5">												
                                                            <span>Filial</span>
                                                                <select class="form-control" id="filialSelect" name="filialSelect" class="editou form-control pulaCampoEnter" required="required" disabled>
                                                                    <option selected disabled value="">Selecione...</option>
                                                                    <?php 
                                                                        foreach ($listaFiliais as $listaFilial) { ?>  
                                                                            <option value="<?= $listaFilial["HANDLE"], ',' . $_SESSION['empresa'] ?>"<?php if($_SESSION['filial'] == $listaFilial["HANDLE"]) echo " selected"?>><?= $listaFilial["NOME"] ?></option>
                                                                    <?php } ?>
                                                                </select>		
                                                        </div>	
                                                        <div class="col-md-3">												
                                                            <span>Localização</span>
                                                                <select class="form-control" id="localizacaoSelect" name="localizacaoSelect" class="editou form-control pulaCampoEnter" required="required">
                                                                    <option selected disabled value="">Selecione...</option>
                                                                    <?php 
                                                                        $filialLogada = $_SESSION['filial'];
                                                                        $empresaLogada = $_SESSION['empresa'];

                                                                        $sqlLocalizacoes = "SELECT TOP 1000 A.HANDLE, A.POSICAO C1
                                                                                              FROM PA_TERMINALLOCALIZACAO A 		
                                                                                             WHERE (EXISTS (SELECT PA_TERMINAL.HANDLE 
                                                                                                              FROM PA_TERMINAL 
                                                                                                             WHERE PA_TERMINAL.HANDLE = A.TERMINAL 
                                                                                                               AND PA_TERMINAL.FILIAL = '$filialLogada'
                                                                                                               AND PA_TERMINAL.STATUS = 3))  
                                                                                               AND (NOT EXISTS (SELECT Z.HANDLE                     
                                                                                                                  FROM PA_CONTEINERMOVIMENTACAO Z                    
                                                                                                                 WHERE Z.LOCALIZACAO = A.HANDLE                      
                                                                                                                   AND Z.FILIAL = '$filialLogada'
                                                                                                                   AND Z.DATA = (SELECT MAX(XX.DATA) 
                                                                                                                                   FROM PA_CONTEINERMOVIMENTACAO XX 
                                                                                                                                  WHERE XX.LOCALIZACAO = Z.LOCALIZACAO)                      
                                                                                                                   AND Z.ORDEM = (SELECT MAX(XX.ORDEM) 
                                                                                                                                    FROM PA_CONTEINERMOVIMENTACAO XX 
                                                                                                                                   WHERE XX.LOCALIZACAO = Z.LOCALIZACAO 
                                                                                                                                     AND XX.DATA = Z.DATA)                      
                                                                                                                   AND Z.TIPOOPERACAO <> 2          
                                                                                                                   AND (NOT EXISTS (SELECT X.HANDLE                             
                                                                                                                                      FROM PA_CONTEINERMOVIMENTACAO X                            
                                                                                                                                     WHERE X.CONTEINER = Z.CONTEINER                              
                                                                                                                                       AND X.TIPOOPERACAO = 4                              
                                                                                                                                       AND X.FILIAL = Z.FILIAL                              
                                                                                                                                       AND X.DATA > Z.DATA )))       
                                                                                                                   OR A.EHPERMITIRMULTIPLOCONTEINER = 'S') 
                                                                                               AND EXISTS(SELECT X.HANDLE  
                                                                                                            FROM PA_TERMINALLOCALIZACAOSITUACAO X  
                                                                                                           INNER JOIN PA_TERMINALLOCALIZACAO Y ON Y.HANDLE = X.TERMINALLOCALIZACAO AND Y.HANDLE = A.HANDLE  
                                                                                                           INNER JOIN PA_TERMINAL Z ON Z.HANDLE = Y.TERMINAL  
                                                                                                           WHERE Z.FILIAL = '$filialLogada'  
                                                                                                             AND X.STATUSCONTEINER = '$situacaoHandle')  
                                                                                               OR NOT EXISTS(SELECT X.HANDLE  
                                                                                                               FROM PA_TERMINALLOCALIZACAOSITUACAO X  
                                                                                                              INNER JOIN PA_TERMINALLOCALIZACAO Y ON Y.HANDLE = X.TERMINALLOCALIZACAO  
                                                                                                              INNER JOIN PA_TERMINAL Z ON Z.HANDLE = Y.TERMINAL  
                                                                                                              WHERE X.STATUSCONTEINER = '$situacaoHandle'
                                                                                                                AND Z.FILIAL = '$filialLogada')";  
                                                                                                                                    														
                                                                        $query = $connect->prepare($sqlLocalizacoes);
                                                                        $query->execute();
                                                                    
                                                                        $listaLocalizacoes = [];
                                                                    
                                                                        while($rowQuery = $query->fetch(PDO::FETCH_ASSOC)){
                                                                            $listaLocalizacoes[] = $rowQuery;
                                                                        }

                                                                        foreach ($listaLocalizacoes as $listaLocalizacao) { ?>  
                                                                            <option value="<?= $listaLocalizacao["HANDLE"] ?>"><?= $listaLocalizacao["C1"] ?></option>
                                                                    <?php }
                                                                      ?>
                                                                </select>		
                                                        </div>	
                                                        <div class="col-md-12">
                                                            <span>Observação</span>
                                                            <input type='text' value="" id="observacaoSelect" name="observacaoSelect" class="form-control pulaCampoEnter" required="required" />
                                                        </div>
                                                    </div>				
                                                <div class="clearfix"></div><br>                                                                                              
                                            <div class="modal-footer">
                                                <button type="button" class="botaoBrancoLg" data-dismiss="modal">Não</button>
                                                <button type="button" class="botaoBrancoLg" id="confirmar" onClick="MovimentarConteiner()">Sim</button>
                                            </div>
                                                </form>
                                        </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="left">
                                </div>
                                <div class="right">
                                    <button type="button" class="botaoBranco1" id="" disabled><font size="3px"><i
                                                    class="glyphicon glyphicon-plus"> </i> </font></button>
                                    <button type="button" class="botaoBranco1" id="" disabled><font size="5px"><i
                                                    class="fa fa-caret-up"> </i> </font></button>
                                    <button type="button" class="botaoBranco1" id="" disabled><font size="4px"><i
                                                    class="fa fa-minus"> </i> </font></button>
                                </div>
                                <div class="dividerH"></div>
                                <p>

                                <table class="table table-responsive table-striped bottomPull" id="movimentacoestable"
                                       border="0">
                                    <thead>
                                    <th class='text-center'>Data</th>
                                    <th>Filial</th>
                                    <th>Tipo de operação</th>
                                    <th>Finalidade</th>
                                    <th>Localização</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    include_once('../../model/patio/VisualizarConsultaConteinerMovimentacaoTabelaModel.php');
                                    ?>
                                    </tbody>
                                </table>

                                <div class="clearfix"></div>
                                </p>
                            </div>

                        </div>
                        <?php
                        ?>
                        <div role="tabpanel" class="tab-pane" id="MovimentacaoManual">

                            <div class="col-xs-12 bottonPull">
                                <div class="left">
                                    <button type="button" class="botaoBranco" id="CancelarConteiner" data-toggle="modal" data-target="#CancelarConteinerModal" name="CancelarConteiner">Cancelar</button>
                                    <div class="modal fade" id="CancelarConteinerModal"  role="dialog" aria-spanledby="CancelarConteinerModalspan">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <form method="post" action="#">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-span="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="CancelarConteinerModalspan">Deseja cancelar o contêiner?</h4>
                                            </div>
                                                <div class="modal-body">Informe o motivo
                                                <input class="form-control" type="text" name="motivo" id="motivo">
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="botaoBrancoLg" id="sim" onClick="CancelarMovimentacaoManual()">Sim</button>
                                                <button type="button" class="botaoBrancoLg" data-dismiss="modal">Não</button>
                                            </div>
                                                </form>
                                        </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="right">
                                    <button type="button" class="botaoBranco1" id="" disabled><font size="3px"><i
                                                    class="glyphicon glyphicon-plus"> </i> </font></button>
                                    <button type="button" class="botaoBranco1" id="" disabled><font size="5px"><i
                                                    class="fa fa-caret-up"> </i> </font></button>
                                    <button type="button" class="botaoBranco1" id="" disabled><font size="4px"><i
                                                    class="fa fa-minus"> </i> </font></button>
                                </div>
                                <div class="dividerH"></div>
                                <p>

                                <table class="table table-responsive table-striped bottomPull" id="movimentacoesmanuaistable"
                                       border="0">
                                    <thead>
                                    <th>&nbsp;</th>
                                    <th class="text-center">Data</th>
                                    <th>Filial</th>
                                    <th>Tipo de operação</th>
                                    <th>Finalidade</th>
                                    <th>Localização</th>

                                    </thead>
                                    <tbody>
                                    <?php
                                    include_once('../../model/patio/VisualizarConsultaConteinerMovimentacaoManualTabelaModel.php');
                                    ?>
                                    </tbody>
                                </table>

                                <div class="clearfix"></div>
                                </p>
                            </div>

                        </div>
                        <?php
                    ?>
                </div><!-- end tab-content -->


            </div><!-- end row -->

        </div><!-- end pageContent -->
        
        <div class="footerFixed mobileHide">
            <div class="right">
                &nbsp;
            </div>
        </div>
        <!-- end footer -->

        <div class="clearfix"></div>
    </div>
    </div>
    <script type="text/javascript" src="../../view/tecnologia/js/jquery.scrolling-tabs.js" id="tabnav"></script>
    <script>
        $('.nav-tabs').scrollingTabs();
    </script> 
    <script>
    $("body").on('change', '#tipomovimentacao', function(){
        var finalidadeMovimentacao = $('#tipomovimentacao').val().split(',');
        $('#tipofinalidade').val(finalidadeMovimentacao[1]);
    });
    </script>
    <script>
    $(document).ready(function() {
        var situacao = '<?php echo $situacaoHandle; ?>';
        $("#MovimentarConteiner").toggle(!([1, 2, 3, 15].includes(parseInt(situacao))));
    });
    </script>
    <!-- Classie -->
    <script src="../tecnologia/js/classie.js"></script>
    <!--scrolling js-->
    <script src="../tecnologia/js/jquery.nicescroll.js"></script>
    <script src="../tecnologia/js/script.js"></script>
    <!--//scrolling js-->
    <!-- Bootstrap Core JavaScript -->
    <script src="../tecnologia/js/bootstrap.js"></script>
    <!-- SweetAlert -->
<script type="text/javascript" src="../tecnologia/js/sweetalert/sweetalert.min.js"></script>
    </body>
    </html>
    <?php include_once('../../model/patio/ModalConsultaConteinerOcorrencia.php') ?>
    <?php
     
}