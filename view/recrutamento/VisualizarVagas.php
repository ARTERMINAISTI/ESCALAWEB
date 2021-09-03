<?php
include_once('../../controller/tecnologia/Sistema.php');

if((!isset($_SESSION['CPF'])) and (!isset($_SESSION['SENHAWEB']))) {
    header('Location: ../../view/estrutura/acesso.php?success=F');
} else {

require '../../model/recrutamento/getDados.php';

$curriculoHandle = Sistema::getGet('handle');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="../tecnologia/img/favicon.png"/>
    <title>Vagas disponíveis - Escalatalentos</title>
    <script type="text/javascript" src="../tecnologia/js/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="../tecnologia/js/datatables/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="../tecnologia/css/bootstrap3/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../tecnologia/css/datatable/datatables.min.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
    <link rel="stylesheet" type="text/css" href="../tecnologia/css/recrutamento.css"/>
    <link href="../../view/tecnologia/css/bootstrap.php" rel='stylesheet' type='text/css' />
    <link href="../../view/tecnologia/css/style.php" rel='stylesheet' type='text/css' />
    <link href="../../view/tecnologia/css/font-awesome.css" rel="stylesheet"> 
    <link href="../../view/tecnologia/css/material-icons.css" rel="stylesheet">
    <link href="../../view/tecnologia/css/custom.php" rel="stylesheet"> 
    <script src="../tecnologia/js/classie.js"></script>
    <script src="../tecnologia/js/script.js"></script>
    <script src="../../view/tecnologia/js/jquery-1.11.1.min.js"></script>
    <script src="../../view/tecnologia/js/modernizr.custom.js"></script>
    <script type="text/javascript" src="../tecnologia/js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="../tecnologia/js/bootstrap3/bootstrap.min.js"></script>
    <script type="text/javascript" src="../tecnologia/js/momentjs/moment.js"></script>
    <script type="text/javascript" src="../tecnologia/js/momentjs/moment-duration-format.js"></script>
    <script type="text/javascript" src="../tecnologia/js/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        Dropzone.prototype.defaultOptions.dictRemoveFile = "Remover Arquivo";
    </script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="//d2wy8f7a9ursnm.cloudfront.net/v6/bugsnag.min.js"></script>
    <script>window.bugsnagClient = bugsnag('9f6cc1049582acdb30bc5fff5e922e62')</script>
    <script type="text/javascript" src="../tecnologia/js/scriptVagaCandidatar.js"></script>
</head>

<body>
    <div class="main-content">
        <div id="loader"></div>
        <div class=" sidebar" role="navigation">
            <div class="navbar-collapse">
                <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
                    <?php
                        include('../../view/estrutura/menuCurriculo.php');
                    ?>
                </nav>
            </div>
        </div>
            
        <div class="sticky-header header-section ">
            <button class="btn" id="showLeftPush"><i class="fa fa-bars"></i></button>
            <div class="topBar">Vagas disponíveis</div>
        </div>

        <div class="container">
            <br><br><br><br><br>
            <div class="erro"></div>
        <?php if (!empty($vagas)) { ?>
            <table class="vagas">
                <tr>
                    <td><h2>Descrição das vagas</h2></td>
                    <td style="text-align: center;"><h2>Vagas</h2></td>
                    <td style="text-align: center;"><h2>Local</h2></td>
                    <td style="text-align: center;"><h2>Início</h2></td>
                    <td style="text-align: center;"><h2>Término</h2></td>
                    <td colspan="2" style="text-align: center;"><h2>Opções</h2></td>                   
                </tr>
                <?php foreach ($vagas as $vaga) { ?>
                <tr>
                    <td><span class="vagaSelecionada" value="<?= $vaga["HANDLEVAGA"]; ?>"><?= $vaga["TIPOVAGA"]; ?></span></td>
                    <td style="text-align: center;"><span><?= $vaga["QUANTIDADEVAGA"]; ?></span></td>
                    <?php 
                    $identifica     = strstr($vaga["NOMEFILIAL"],'-');
                    $cortaFilial    = substr($identifica, 2);
                    ?>
                    <td style="text-align: center;"><span><?= $cortaFilial; ?></span></td>
                    <td style="text-align: center;"><span><?php echo date("d/m/Y", strtotime($vaga["DATAINICIOVAGA"])); ?></span></td>
                    <td style="text-align: center;"><span><?php echo date("d/m/Y", strtotime($vaga["DATAFINALVAGA"])); ?></span></td>
                    <td style="text-align: center;"><button value="<?= $vaga["OBSERVACAOVAGA"]; ?>" class="detalhesVagas">Mais detalhes</button></td>
                    <td style="text-align: center;"><button id="<?= $vaga["HANDLEVAGA"]; ?>" value="<?= $vaga["TIPOVAGA"]; ?>" class="showVaga">Candidatar-se</button></td>
                </tr>

            <?php } ?>

            </table>
            <div style="float: left; width: 100%; border: 1px solid #ccc;"class="visualizarVaga slide">
                <textarea style="width: 100%; padding: 10px; resize: none; border: none; margin: 0 0 30px 0;" readonly class="descricaoDetalhadaVaga">
                    
                </textarea> 
            </div>
                
                        <?php  
               $queryVerificaCurriculoPendente = $connect->prepare (" SELECT A.HANDLE CURRICULO, 
                                                                             A.FILIAL FILIAL 
                                                                        FROM RC_CURRICULO A
                                                                       WHERE A.HANDLE = $curriculoHandle
                                                           ");
               $queryVerificaCurriculoPendente->execute();

               $rowVerificaCurriculoPendente = $queryVerificaCurriculoPendente->fetch(PDO::FETCH_ASSOC);
               $pegaCurriculo                = $rowVerificaCurriculoPendente['CURRICULO'];
               $pegaFilial                   = $rowVerificaCurriculoPendente['FILIAL'];

               if (($pegaCurriculo == $curriculoHandle) && (is_null($pegaFilial))) { ?>
                    
                   <a style="font-style: italic;" href="VisualizarCurriculo.php?handle=<?=$curriculoHandle;?>">Antes de enviar sua candidatura a vaga, verifique se seu currículo está atualizado.</a>
                    
                <?php }             
       } else { ?>
            <table class="vagas">
                <tr>
                    <td style="text-align: center;">
                        <span>
                            Nenhuma vaga em aberto no momento!
                        </span>
                    </td>
                </tr>
            </table>
                <div class="row">
                    <div class="col-md-13">
                        <a style="float: right;" style="margin-left: 20px;" href="CurriculoListar.php" title="Voltar a listagem do Currículo" class="voltarVaga">Voltar</a>
                    </div>
                </div>
        <?php } ?>

            <form method="POST" id="formularioVaga" class="formularioVaga">
                <input type="text" name="HANDLE" id="HANDLE" value="0" hidden="true" class="display">
                <input type="text" name="HANDLECURRICULO" id="HANDLECURRICULO" value="<?php echo $handleCurriculo; ?>" hidden="true" class="display">    
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <span>Nome</span>
                           <input type="text" class="form-control" id="NOME" name="NOME" value="<?php echo $nome; ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span>CPF</span>
                            <input type="text" class="form-control" id="CPF" name="CPF" value="<?php echo $cpf; ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span>Vaga selecionada</span>
                            <input type="text" class="form-control" id="VAGASELECIONADA" name="VAGASELECIONADA" value="" readonly="readonly">
                            <input type="text" style="display: none;" class="form-control" id="VAGASELECIONADAHANDLE" name="VAGASELECIONADAHANDLE" value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <span>Preencha ou altere suas observações</span>
                            <textarea class="form-control" id="OBSERVACAO" name="OBSERVACAO" value="" rows="4" cols="50" style="height: 200px !important; resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12" style="display: none;">
                        <div class="form-group">
                            <span>Data e horário*</span>
                            <input type="text" class="form-control" id="DATAHORARIO" name="DATAHORARIO" value="<?= date('d/m/Y h:i:s') ?>" readonly="readonly">
                        </div>
                    </div>
                </div>
                <div class="row" style="display: none;">
                    <div class="col-md-12">
                        <span>Anexo</span>
                        <div class="dropzone">
                            <div class="dz-message" data-dz-message>
                                <span>Clique ou solte arquivos aqui para anexar.</span>
                            </div>
                            <div class="fallback">
                                <input name="file" type="file" value="file" multiple/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="botoes-pagina-candidatar">
                    <div class="col-md-13">
                        <div class="btn-group pull-right" role="group">
                            <a href="CurriculoListar.php" title="Voltar a listagem do Currículo" class="voltar">Voltar</a>
                            <button style="margin-right: 20px;" type="submit" class="btn btn-success">Cadastrar</button>
                        </div>
                    </div>
                </div>
                <br>
            </form>
        </div>    
    </div>
</body>

<script src="../../view/tecnologia/js/metisMenu.min.js"></script>
<script src="../../view/tecnologia/js/custom.js"></script>

</html>
<?php } ?>