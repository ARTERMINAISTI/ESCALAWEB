<?php

    include_once('../../controller/tecnologia/Sistema.php');
    
    date_default_timezone_set('America/Bahia');


    $acao = $_POST['ACAO'];

    if ($acao == "getData"){
        //echo Sistema::getDataAtual();
        
        echo "{
            \"data\":\"".Sistema::getDataAtual()."\"
           }";
    }

    else{
        throw new Exception("Ação inválida",
                            "Ação: ".$acao);
    }

    ?>