<?php

include_once('../../controller/tecnologia/Sistema.php');
include_once('../../controller/tecnologia/WS.php');

date_default_timezone_set('America/Sao_Paulo');

$connect = Sistema::getConexao();

if (isset($_FILES['files']['name'])) {
    if (($_FILES['files']['error']) || (filesize($_FILES['files']['tmp_name']) > (4 * 1024 * 1024))) {
        throw new Exception('Arquivo ' . $_FILES['files']['name'] . ' inválido, você somente pode enviar arquivos de até 4 MB.');
    } else {
        $nome = $_FILES['files']['name'];
        $arquivo = base64_encode(file_get_contents($_FILES['files']['tmp_name']));
        $arr = array("anexo" => array(
            'ocorrencia' => Sistema::getPost('handleOcorrencia'),
            'descricao' => $nome,
            'arquivoBase64' => $arquivo));
        
        WebService::setupCURL("armazenagem/criar/anexoOcorrenciaCargadescarga", $arr);
        WebService::execute();
        $body = WebService::getBody();
        $dados = json_decode($body);
        if (isset($dados->CHAVE)) {
            $retorno = $dados->CHAVE;
        } else {
            $retorno = Sistema::retornoJson(500, $body);
        }
    }
}

Sistema::echoToJson($retorno);
