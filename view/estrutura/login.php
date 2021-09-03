<!DOCTYPE HTML>
<html>
    <head>
        <title>AR Terminais </title>
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
        <!-- js-->
        <script src="../tecnologia/js/jquery-1.11.1.min.js"></script>
        <script src="../tecnologia/js/modernizr.custom.js"></script>

        <!-- Custom -->
        <link type="text/css" href="../tecnologia/css/styleCustom.php" rel="stylesheet"/>
        <script src="../tecnologia/js/bootstrap-show-password.js"></script>    
    </head> 
    <body class="fundoAzul" id="bodyFullScreen">

        <!--<button type="button" id="clicar" onclick="toggleFullScreen()">FullScreen</button>-->

        <div class="main-content">
            <?php
            /*
            $tentativasLogin = null;
            $dataProximaTentativaLogin = null;
            setcookie("tentativasLogin", null); 
            setcookie("dataProximaTentativaLogin", null); 
            */
            
            $retornoComFalha = (isset($_GET["success"])) && ($_GET["success"] == "F");

            if ($retornoComFalha){
                if (isset($_COOKIE["tentativasLogin"])){
                    $tentativasLogin = $_COOKIE["tentativasLogin"];
                    if (isset($_COOKIE["dataProximaTentativaLogin"])){
                        $dataProximaTentativaLogin = $_COOKIE["dataProximaTentativaLogin"];
                        
                        if ($retornoComFalha){
                            if (($dataProximaTentativaLogin + 180) < time()){
                                $tentativasLogin += 1;
                                setcookie("tentativasLogin", $tentativasLogin);
                                
                                if (($tentativasLogin % 3) == 0){
                                    $dataProximaTentativaLogin = time();
                                    setcookie("dataProximaTentativaLogin", $dataProximaTentativaLogin);
                                }
                            }
                        }
                    }
                    else{
                        if ($retornoComFalha){
                            $tentativasLogin += 1;
                            setcookie("tentativasLogin", $tentativasLogin);

                            if (($tentativasLogin % 3) == 0){
                                $dataProximaTentativaLogin = time();
                                setcookie("dataProximaTentativaLogin", $dataProximaTentativaLogin);
                            }
                        }                            
                    }
                }
                else{
                    $tentativasLogin = 0;
                    setcookie("tentativasLogin", $tentativasLogin);
                }        
            }
            else{
                if (isset($_COOKIE["tentativasLogin"])){
                    $tentativasLogin = $_COOKIE["tentativasLogin"];
                
                    if (isset($_COOKIE["dataProximaTentativaLogin"])){
                        $dataProximaTentativaLogin = $_COOKIE["dataProximaTentativaLogin"];
                    }
                }
                else{
                    $tentativasLogin = 0;
                    setcookie("tentativasLogin", $tentativasLogin);
                }                
            }
            /*
            var_dump($tentativasLogin);
            echo "<br>";
            var_dump(($tentativasLogin % 3));
            echo "<br>";
            var_dump($dataProximaTentativaLogin);
            */
            //echo "<p>".$tentativasLogin."";

            include_once('../../model/estrutura/loginModal.php');
            ?>
            <!-- main content start-->
            <div>
                <div class="main-page login-page  FlexContainer">
                    <img src="../tecnologia/img/logologin.png" class="logologin" alt="Escalasoft tecnologia">
                    <br>
                    <div class="login-body FlexItem">
                        <form method="post" action="../../controller/estrutura/LoginController.php">
                            <div class="inner-addon left-addon pullBottomLogin">
                                <i class="icone fa fa-user"></i> 
                                <input type="text"  name="usuario" value="<?php echo $ultimologin; ?>" id="usuario" class="form-control" placeholder="Usuário" required>
                            </div>
                            <div class="inner-addon left-addon">
                                <i class="icone fa fa-lock"></i> 
                                <input type="password" name="senha" id="senha" style="border-right:none;" data-toggle="password" class="form-control" data-placement="after" placeholder="Senha" required> 
                                <!-- data-toggle="password" data-placement="after" -->
                            </div>
                            <input type="submit" id="entrar" name="entrar" value="Entrar" >
                        </form>
                    </div>
                </div>
            </div>
            <!--footer -->
            <div class="footer">
                <p></p>
            </div>
            <!--//footer-->
        </div>
        <!-- Classie -->
        <script src="../tecnologia/js/classie.js"></script>
        <!--scrolling js-->
        <script src="../tecnologia/js/jquery.nicescroll.js"></script>
        <!--script src="../tecnologia/js/script.js"></script-->
        <!--//scrolling js-->
        <!-- Bootstrap Core JavaScript -->
        <script src="../tecnologia/js/bootstrap.js"></script>
        <script>
            function focosenha() {
                $('#senha').focus();
            }

            let btnEntrar = $('#entrar')[0];
            btnEntrar.onclick = function(){
                <?php 
                    if ((isset($tentativasLogin)) && 
                       (isset($dataProximaTentativaLogin)) && 
                       (($tentativasLogin % 3) == 0)){
                    ?>
                        if ((Date.now()) > (<?= $dataProximaTentativaLogin; ?>000 + 180000)){
                            return true;
                        }
                        else{
                            alert("Você ultrapassou o limite de tentativas no período de tempo! Próxima tentativda disponível: <?= date("d/m/Y H:i:s" ,$dataProximaTentativaLogin + 180) ?>");
                            return false;
                        }
                    <?php 
                        }
                        else{
                    ?>      
                        return true;
                    <?php 
                        }
                    ?>
            }
        </script>
    </body>
</html>