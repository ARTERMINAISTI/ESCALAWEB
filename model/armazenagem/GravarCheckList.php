<?php
    include_once('../../controller/tecnologia/Sistema.php');
    include_once('../../controller/tecnologia/WS.php');

    date_default_timezone_set('America/Argentina/Buenos_aires');

    $connect = Sistema::getConexao();

    WebService::setupCURL("armazenagem/executar/checklist", [
        "Checklist" => $_POST,
		"Usuario" => $handleUsuario
	]);

    WebService::execute();

	$body = WebService::getBody();
	
	$retorno = json_decode($body, true);
	
	if (isset($retorno["RETORNO"])) 
	{	
		echo $retorno["RETORNO"];
	} 
	else 
	{
		echo Sistema::retornoJson(500, $body);
	}