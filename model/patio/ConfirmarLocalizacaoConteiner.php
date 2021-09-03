<?php
	include_once('../../controller/tecnologia/Sistema.php');
	include_once('../../controller/tecnologia/WS.php');
	
	date_default_timezone_set('America/Sao_Paulo');
	
	$connect = Sistema::getConexao();
	
	$handleOrdem = Sistema::getPost('handleOrdem');
	$handleLocalizacao = Sistema::getPost('handleLocalizacao');
	
	WebService::setupCURL("patio/ordem/confirmar", [
		"ORDEM" => $handleOrdem,
		"LOCALIZACAO" => $handleLocalizacao,
		"USUARIO" => $handleUsuario
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