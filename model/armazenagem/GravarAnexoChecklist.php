<?php

include_once('../../controller/tecnologia/Sistema.php');
include_once('../../controller/tecnologia/WS.php');

date_default_timezone_set('America/Sao_Paulo');

$connect = Sistema::getConexao();

if (isset($_FILES['files']['name'])) {
    if (($_FILES['files']['error']) || (filesize($_FILES['files']['tmp_name']) > (10 * 1024 * 1024))) {
        throw new Exception('Arquivo ' . $_FILES['files']['error'] . ' inválido, você somente pode enviar arquivos de até 10 MB.');
    } else {
        $nome = $_FILES['files']['name'];
        $arquivo = base64_encode(file_get_contents($_FILES['files']['tmp_name']));
        $arr = array("anexo" => array(
            'checklist' => Sistema::getPost('handleChecklist'),
			'nomeArquivo' => $_FILES['files']['name'],
			'data' => Sistema::getPost('dataAtual'),
            'arquivoBase64' => $arquivo));
        
        WebService::setupCURL("armazenagem/criar/anexoChecklist", $arr);
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