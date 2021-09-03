<?php
	include_once('../../controller/tecnologia/Sistema.php');
	include_once('../../controller/tecnologia/WS.php');
	
	date_default_timezone_set('America/Sao_Paulo');
	
	$connect = Sistema::getConexao();
	
	$EHcancelar = Sistema::getPost('cancelar');
	
	if (isset($EHcancelar))
	{
		$handle = Sistema::getPost('handle');
		$motivo = Sistema::getPost('motivo');
		$usuario = Sistema::getPost('usuario');
		
		WebService::setupCURL("patio/movimentacaomanual/cancelar", [
			"HANDLE" => $handle,
			"MOTIVO" => $motivo,
			"USUARIO" => $handleUsuario
		]);
	}
		
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