<?php
include_once('../../controller/tecnologia/Sistema.php');
require '../../model/recrutamento/getDados.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="../tecnologia/img/favicon.png"/>
    <title>Alterar senha de acesso - Escalasoft</title>
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
    <link rel="stylesheet" type="text/css" href="../tecnologia/css/recrutamento.css"/>
    <link href="../tecnologia/css/style.php" rel='stylesheet' type='text/css' />
    <link type="text/css" href="../tecnologia/css/styleCustom.php" rel="stylesheet"/>
    <link href="../tecnologia/css/font-awesome.css" rel="stylesheet"> 
</head>

<body class="fundoAzul" id="bodyFullScreen">
    <div class="main-content">
        <div class="main-page login-page  FlexContainer">
            <div class="erro"></div>
            <img src="../tecnologia/img/logologin.png" class="logologin" alt="Escalasoft tecnologia">
            <br>
            <div class="login-body FlexItem">
                <form method="POST" id="formNovaSenhaCurriculo" style="width: 337px;" action="novasenhacurriculo_query.php">
                    <input type="text" name="HANDLE" id="HANDLE" value="0" hidden="true" class="display">
                    <input type="hidden" class="form-control" name="CHAVE" value="<?= Sistema::criarGuid() ?>"/>

                    <div class="inner-addon left-addon pullBottomLogin">
                        <i class="icone fa fa-address-card-o"></i> 
                        <input type="text" class="form-control" placeholder="Digite seu CPF" id="CPF" name="CPF" required="required">
                    </div>
                    <input type="submit" name="receberemail" value="Receber e-mail">
                    <a title="Voltar" href="../estrutura/acesso.php" class="botaoVoltar">Voltar</a>
                </form>
            </div>
        </div>
    </div>
<!-- jQuery -->
<script type="text/javascript" src="../tecnologia/js/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script type="text/javascript" src="../tecnologia/js/bootstrap3/bootstrap.min.js"></script>
<!-- DataTables -->
<script type="text/javascript" src="../tecnologia/js/datatables/datatables.min.js"></script>
<script type="text/javascript" src="../tecnologia/js/datatables/dataTables.bootstrap4.min.js"></script>
<!-- MomentJS -->
<script type="text/javascript" src="../tecnologia/js/momentjs/moment.js"></script>
<script type="text/javascript" src="../tecnologia/js/momentjs/moment-duration-format.js"></script>
<!-- SweetAlert -->
<script type="text/javascript" src="../tecnologia/js/sweetalert/sweetalert.min.js"></script>
<!-- DropZone -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<!-- jQueryUI -->
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- jQuery Mask -->
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<!-- Scripts -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script>
    $(function () {
        $('#CPF').mask('000.000.000-00');
    });
</script>
</body>

</html>