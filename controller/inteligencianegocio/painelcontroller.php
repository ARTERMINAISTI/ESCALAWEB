<?php
    include_once('../../model/inteligencianegocio/componente.php');
    include_once('../../model/inteligencianegocio/filtro.php');
    include_once('../../model/inteligencianegocio/painel.php');
   
    try {
        $json_params = file_get_contents("php://input");
       
        $decoded_params = json_decode($json_params);

        if (!class_exists($decoded_params->destino)) {
            throw new Exception("Não foi possível identificar o destino da requisição");            
        }

        $response = call_user_func(array(new $decoded_params->destino, $decoded_params->metodo), $decoded_params->parametro);

        if (key_exists("errors", $response)) {
            http_response_code($response["errors"]["status"]);
        }

        echo json_encode($response);
        
    } catch (Exception $e) {
        http_response_code(500);

        echo json_encode(
            array(
                "errors" => array(
                    "status" => 500,
                    "detail" => $e->getMessage()
                )
            )
        );
    }
?>