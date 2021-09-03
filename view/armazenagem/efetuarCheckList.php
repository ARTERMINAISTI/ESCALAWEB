<?php
include_once('../../controller/tecnologia/Sistema.php');
include_once('../../controller/armazenagem/efetuarChecklistController.php');


if (!isset($_SESSION['usuario']) and !isset($_SESSION['senha'])) {
    header('Location: ../estrutura/login.php?success=F');
} else {
    $connect = Sistema::getConexao();

    $checklist = new efetuarChecklistController($connect);
    
?>
    <!DOCTYPE HTML>
    <html>

    <head>
        <title>Escalasoft</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <?php
        include_once('../tecnologia/importCSS.php');
        include_once('../tecnologia/importJavascript.php');
        ?>
        <link type="text/css" href="resource/efetuarChecklist.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <script src="resource/roteiroAnalise.js"></script>
		<script type="text/javascript" src="../tecnologia/js/sweetalert/sweetalert.min.js"></script>         	
        <script type="text/javascript" src="../tecnologia/js/exportar.js"></script>
        <script type="text/javascript" src="../tecnologia/js/tableToJson-mini.js"></script>
    </head>

    <body class="cbp-spmenu-push" id="bodyFullScreen">
        <div>
            <div id="loader"></div>
            <div class="main-content">
                <div class="sticky-header header-section ">
                    <a href="../armazenagem/roteiroAnalise.php">
                    <button id="showLeftPush"><i class="glyphicon glyphicon-menu-left"></i></button></a>
                    <div class="topBar">Efetuar Checklist</div>
                    <div class="topBarRight">

                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="pageContent">
                <div id="registroNaoEncontrato" style="display: none;">
                    <div class="alert alert-warning" style="margin-bottom: 0;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Atenção: </strong> Não encontramos registros a serem exibidos!
                    </div>
                </div>
                <div class="table-responsive ">
                    <div class="larguraInteira">
                        <table id="tableEfetuarChecklist" class="table table-striped table-bordered" border="0">
                            <thead>
                                <th>Item do checklist</th>
                                <th>Valor</th>
                                <th>Observação</th>
                                <th>Anexo</th>      
                            </thead>
                            <tbody>
                                <form method='POST' id='formChecklist'>
                                    <?php
                                    Sistema::iniciaCarregando();

                                    $rows = $checklist->getRegistro();
                                
                                    echo join(' ', $rows['DADOS']);
                                    
                                    ?>
                                </form>
                            </tbody>
                            
                        </table>
                        <div class="row">
                            <div class="col-md-12">
                            
                                <div class="btn-group pull-right" style="padding-left: 5px;"  role="group">
                                    <button type="button" class="btn btn-cancel Cancelar"  onclick="window.location = ('roteiroAnalise.php'); return false;">Fechar</button>
                                </div>
                                <div class="btn-group pull-right" role="group">
                                    <button type="submit" class="btn btn-success" onclick="EfetuarChecklistFun()">Enviar</button>
                                </div>
                            </div>
                        </div>    
                    </div>
                    
                </div>
                
            </div>

    <div class="modal fade" id="AnexoChecklistModal" role="dialog" aria-spanledby="AnexoChecklistModalspan">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-span="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="BaixarModalspan">Anexo do checklist</h4>
                </div>
                <div class="modal-body">
                    <div class="col-xs-6 col-md-6 pullBottom">
                        <span>Data</span>
                        <input type='datetime-local' value="<?php echo $date.'T'.$time; ?>" id="data" name="data" class="form-control pulaCampoEnter" readonly/>
                    </div>
                    <div class="col-xs-6 col-md-6 pullBottom">
                    <div class="form-group">
                        <span>Usuário</span>
                        <input type="text" class="form-control" value="<?=$loginUsuario?>" required="required" id='USUARIO'
                                  name="USUARIO" readonly></textarea> 
                    </div>
                </div>  
                    <div class="col-sm-12 pullBottom">
                        <span>Anexo</span>
                        <input id="anexos" type="file" style="display: block;" name="anexos[]" class="form-control pulaCampoEnter" multiple>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="botaoBranco pullTop" data-dismiss="modal">Cancelar</button>
                    <button id="gravar" type="button" class="botaoBranco pullTop" onclick="$('#AnexoChecklistModal').modal('hide');">Ok</button>
                </div>
            </div>
            </div>
        </div>
    </div>

        <div class="clearfix"></div>
        </div>

        <!-- jQuery Mask -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

        <script src="../tecnologia/js/classie.js"></script>
        <script src="../tecnologia/js/jquery.nicescroll.js"></script>
        <script src="../tecnologia/js/script.js"></script>
        <script src="../tecnologia/js/bootstrap.js"></script>
        
    </body>

    </html>
<?php
}
