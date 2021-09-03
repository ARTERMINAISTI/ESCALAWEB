<?php
include_once('../../controller/tecnologia/Sistema.php');
include_once('../../controller/tecnologia/WS.php');

date_default_timezone_set('America/Sao_Paulo');

$connect = Sistema::getConexao();

$ordem = Sistema::getPost('ORDEM');
$item = Sistema::getPost('ITEM');
$variacao = Sistema::getPost('VARIACAO');
$quantidade = Sistema::getPost('QUANTIDADE');
$valorunitario = Sistema::getPost('VALORUNITARIO');
$observacao = Sistema::getPost('OBSERVACAO');

WebService::setupCURL("venda/ordemvenda/criaritensordemvenda", [
    "ORDEM" => $ordem,
    "ITEM" => $item,
    "VARIACAO" => $variacao,
    "QUANTIDADE" => $quantidade,
    "VALORUNITARIO" => $valorunitario,
    "OBSERVACAO" => $observacao,
]);

WebService::execute();

$body = WebService::getBody();

$dados = json_decode($body, true);

if (isset($dados["HANDLE"])) {
    echo $dados["HANDLE"];
} else {
    echo Sistema::retornoJson(500, $body);
}