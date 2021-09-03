<?php
	include_once('../../controller/tecnologia/Sistema.php');
	include_once('../../controller/tecnologia/WS.php');
	
	date_default_timezone_set('America/Sao_Paulo');
	
	$connect = Sistema::getConexao();
	
	$tipoMovimentacao = Sistema::getPost('tipoMovimentacao');
	$dataMovimentacao = Sistema::getPost('dataMovimentacao');
	$filial = Sistema::getPost('filial');
	$empresa = Sistema::getPost('empresa');
	$localizacao = Sistema::getPost('localizacao');
	$observacao = Sistema::getPost('observacao');
	$handleConteiner = Sistema::getPost('handleConteiner');
	$usuario = Sistema::getPost('usuario');
	
	WebService::setupCURL("patio/movimentacaomanual/movimentar", [
		"TIPOMOVIMENTACAO" => $tipoMovimentacao,
		"DATAMOVIMENTACAO" => $dataMovimentacao,
		"FILIAL" => $filial,
		"EMPRESA" => $empresa, 
		"LOCALIZACAO" => $localizacao, 
		"OBSERVACAO" => $observacao,
		"CONTEINER" => $handleConteiner,
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