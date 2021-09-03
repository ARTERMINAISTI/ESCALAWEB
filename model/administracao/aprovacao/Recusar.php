<?php

include_once('../../../controller/tecnologia/Sistema.php');
include_once('../../../controller/tecnologia/WS.php');

if (!isset($_SESSION['usuario']) and !isset($_SESSION['senha'])) {
    echo Sistema::retornoJson(500, "Erro ao recusar: favor atualizar a página antes de continuar");
} else {
    $aprovacoes = $_POST["APROVACAO"];
    $motivo = $_POST["MOTIVO"];
    $usuario = $_SESSION['handleUsuario'];

    foreach ($aprovacoes as $aprovacao) {
        WebService::setupCURL("administracao/aprovacao/recusar", ["APROVACAO" => $aprovacao, "MOTIVO" => $motivo, "USUARIO" => $usuario]);
        WebService::execute();

        $header = WebService::getHeader();
        $body = WebService::getBody();
    }

    if (strpos(substr($header, 1, 20), "200") > 0) {
        http_response_code(200);
        echo json_encode("");
    }
    else{
        http_response_code(500);

        echo json_encode([
            "code" => 500,
            "message" => $body
        ]);;
    }
}