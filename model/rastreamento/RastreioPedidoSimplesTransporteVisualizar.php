<?php


$numeroDocumento = Sistema::getGet('n');
$remetente = Sistema::getGet('rem');
$destinatario = Sistema::getGet('dest');
	
$remetente = str_Replace(".", "", $remetente); 
$remetente = str_Replace("/", "", $remetente);
$remetente = str_Replace("-", "", $remetente);

$destinatario = str_Replace(".", "", $destinatario);
$destinatario = str_Replace("/", "", $destinatario);
$destinatario = str_Replace("-", "", $destinatario);

if ($numeroDocumento != null)
{	
	$numeroDocumento = substr($numeroDocumento, 0, 9);

	$handleRastreamentoUltimaEtapa = NULL;
	$etapaRastreamentoUltimaEtapa = NULL;
	$dataRastreamentoUltimaEtapa = NULL;
	$observacaoRastreamentoUltimaEtapa = NULL;	

	$queryDestinatario = " SELECT HANDLE
                           FROM MS_PESSOA 
                          WHERE CNPJCPFSEMMASCARA = :DESTINATARIO";
	$queryDestinatario = $connect->prepare($queryDestinatario);
	$queryDestinatario->execute(['DESTINATARIO' => $destinatario]);

	$rowDestinatario = $queryDestinatario->fetch(PDO::FETCH_ASSOC);
	$destinatario = $rowDestinatario ['HANDLE'];

	if ($remetente != '') {	
		$queryRemetente = " SELECT HANDLE
							FROM MS_PESSOA 
							WHERE CNPJCPFSEMMASCARA = :REMETENTE";
		$queryRemetente = $connect->prepare($queryRemetente);
		$queryRemetente->execute(['REMETENTE'=>$remetente]);

		$rowRemetente= $queryRemetente->fetch(PDO::FETCH_ASSOC);
		$remetente = $rowRemetente['HANDLE'];				
	} else {
		$remetente = 0;
	}

	$handlePedido = getPedidoDocumentoOriginario($numeroDocumento, $remetente, $destinatario);	

	$queryRastreamento = "SELECT DISTINCT 
	                        A.HANDLE HANDLE, 	                        
							A.STATUS, 
							A.NUMEROPEDIDO, 
							C.NOME FILIAL, 
							A.CODIGORASTREAMENTO,
							A.DATA, 
							A.RASTREAMENTO, 
							A.VALORMERCADORIA, 
							A.NOMEREMETENTE REMETENTE, 
							A.NOMEDESTINATARIO DESTINATARIO, 
							A.MUNICIPIOREMETENTE MUNICIPIOCOLETA, 
							A.UFREMETENTE ESTADOCOLETA, 
							A.MUNICIPIODESTINATARIO MUNICIPIOENTREGA, 
							A.UFDESTINATARIO ESTADOENTREGA,
							N.NOME TIPO,
							A.QUANTIDADE,
							A.QUANTIDADEVOLUME,
							A.VOLUME,
							A.PESO,
							A.DATACOLETA,
							A.DATAENTREGAATE,
							A.PRAZOENTREGA,
							A.DATAENTREGA,
							A.BAIRROREMETENTE BAIRROCOLETA,
							A.BAIRRODESTINATARIO BAIRROENTREGA,
							A.LOGRADOUROREMETENTE RUACOLETA,
							A.LOGRADOURODESTINATARIO RUAENTREGA,
							A.NUMEROREMETENTE NUMEROCOLETA,
							A.NUMERODESTINATARIO NUMEROENTREGA,
							A.CEPREMETENTE CEPCOLETA,
							A.CEPDESTINATARIO CEPENTREGA,
							U.DOCUMENTO,
							X.NOME RAZAOSOCIALEMPRESA,
							X.CNPJCPF CNPJCPFEMPRESA,
							A.RASTREAMENTO,
							A.TIPOREMETENTE TIPOLOGRADOUROCOLETA,
							A.TIPODESTINATARIO TIPOLOGRADOUROENTREGA,
							T.APELIDO TRANSPORTADORA, 
							A.LOGDATACADASTRO DATACADASTRO
						FROM RA_PEDIDO A (NOLOCK)
					LEFT JOIN RA_STATUSPEDIDO B (NOLOCK) ON A.STATUS = B.HANDLE 
					LEFT JOIN MS_FILIAL C (NOLOCK) ON A.FILIAL = C.HANDLE
					LEFT JOIN MS_PESSOA D (NOLOCK) ON A.REMETENTE = D.HANDLE 
					LEFT JOIN MS_PESSOA E (NOLOCK) ON A.DESTINATARIO = E.HANDLE 
					LEFT JOIN MS_USUARIO F (NOLOCK) ON A.LOGUSUARIOCADASTRO = F.HANDLE
					LEFT JOIN RA_STATUSPEDIDO M (NOLOCK) ON A.STATUS = M.HANDLE
					LEFT JOIN RA_TIPOPEDIDO N (NOLOCK) ON A.TIPO = N.HANDLE
					LEFT JOIN RA_PEDIDOMOVIMENTACAO U (NOLOCK) ON A.HANDLE = U.PEDIDO
					LEFT JOIN MS_EMPRESA V (NOLOCK) ON A.EMPRESA = V.HANDLE
					LEFT JOIN MS_PESSOA X (NOLOCK) ON V.PESSOA = X.HANDLE
					LEFT JOIN MS_PESSOA T (NOLOCK) ON T.HANDLE = A.TRANSPORTADORA
					WHERE A.STATUS <> 3
					  AND A.HANDLE = :PEDIDO
										
						ORDER BY HANDLE";

											
	$queryRastreamento = $connect->prepare($queryRastreamento);

	$queryRastreamento->execute(['PEDIDO' => $handlePedido]);

	$rowRastreamento = $queryRastreamento->fetch(PDO::FETCH_ASSOC);

	if ($rowRastreamento['HANDLE'] <= 0) {
		$_SESSION['retorno'] = 'Documento não localizado.';
		$_SESSION['rastreamento'] = $numeroDocumento;
		//echo "<script>history.go(-1)</script>";
	}
	else {

		$numeroRastreamento = $rowRastreamento['RASTREAMENTO'];
		$handleRastreamento = $rowRastreamento['HANDLE'];
		$numeroPedidoRastreamento = $rowRastreamento['NUMEROPEDIDO'];
		$filialRastreamento = $rowRastreamento['FILIAL'];
		$valorMercadoriaRastreamento = $rowRastreamento['VALORMERCADORIA'];
		$remetenteRastreamento = $rowRastreamento['REMETENTE'];
		$destinatarioRastreamento = $rowRastreamento['DESTINATARIO'];
		$municipioColetaRastreamento = $rowRastreamento['MUNICIPIOCOLETA'];
		$ufColetaRastreamento = $rowRastreamento['ESTADOCOLETA'];
		$municipioEntregaRastreamento = $rowRastreamento['MUNICIPIOENTREGA'];
		$ufEntregaRastreamento = $rowRastreamento['ESTADOENTREGA'];
		$tipoRastreamento = $rowRastreamento['TIPO'];
		$quantidadeRastreamento = $rowRastreamento['QUANTIDADE'];
		$quantidadeVolumeRastreamento = $rowRastreamento['QUANTIDADEVOLUME'];
		$volumeRastreamento = $rowRastreamento['VOLUME'];
		$pesoRastreamento = $rowRastreamento['PESO'];
		$dataColetaRastreamento = $rowRastreamento['DATACOLETA'];
		$prazoEntrega = $rowRastreamento['PRAZOENTREGA'] == 0 ? '' : $rowRastreamento['PRAZOENTREGA'];
		$dataEntregaAteRastreamento = ($rowRastreamento['DATAENTREGAATE'] != 0) ? date('d/m/Y', strtotime($rowRastreamento['DATAENTREGAATE'])) : '';
		$dataEntregaRastreamento = $rowRastreamento['DATAENTREGA'];
		$bairroColetaRastreamento = $rowRastreamento['BAIRROCOLETA'];
		$ruaColetaRastreamento = $rowRastreamento['RUACOLETA'];
		$ruaEntregaRastreamento = $rowRastreamento['RUAENTREGA'];
		$numeroColetaRastreamento = $rowRastreamento['NUMEROCOLETA'];
		$numeroEntregaRastreamento = $rowRastreamento['NUMEROENTREGA'];
		$cepColetaRastreamento = $rowRastreamento['CEPCOLETA'];
		$cepEntregaRastreamento = $rowRastreamento['CEPENTREGA'];
		$paisColetaRastreamento = "Brasil";
		$documentoRastreamento = $rowRastreamento['DOCUMENTO'];
		$razaoSocialEmpresaRastreamento = $rowRastreamento['RAZAOSOCIALEMPRESA'];
		$cnpjEmpresaRastreamento = $rowRastreamento['CNPJCPFEMPRESA'];
		$paisEntregaRastreamento = "Brasil";
		$tipoLogradouroColetaRastreamento = $rowRastreamento['TIPOLOGRADOUROCOLETA'];
		$tipoLogradouroEntregaRastreamento = $rowRastreamento['TIPOLOGRADOUROENTREGA'];
		$transportadora = $rowRastreamento['TRANSPORTADORA'];
		$codigoRastreamento = $rowRastreamento['CODIGORASTREAMENTO'];
		$dataCadastro = $rowRastreamento['DATACADASTRO'];

		if (isset($rowRastreamento['DATA'])) {
			$dataRastreamento = date('d/m/Y H:i:s', strtotime($rowRastreamento['DATA']));
		} else {
			$dataRastreamento = "";
		}

		$queryRastreamentoUltimaEtapa = "SELECT TOP 1 HANDLE, DATA, ETAPA, OBSERVACAO
										FROM (
										SELECT  A.HANDLE HANDLE, A.DATA DATA, A.TITULO ETAPA, B1.OBSERVACAO OBSERVACAO
										FROM RA_PEDIDOETAPA A  
										LEFT JOIN MS_STATUS B0 ON A.STATUS = B0.HANDLE 
										LEFT JOIN RA_TIPOETAPA B1 ON A.ETAPA = B1.HANDLE 
										WHERE A.PEDIDO = '" . $handleRastreamento . "'
																		AND A.STATUS = 9

										UNION ALL

										SELECT A.HANDLE HANDLE, A.DATA DATA, B3.NOME ETAPA, A.OBSERVACAO OBSERVACAO
										FROM OP_OCORRENCIA A  
										LEFT JOIN OP_STATUSOCORRENCIA B0 ON A.STATUS = B0.HANDLE 
										LEFT JOIN MS_FILIAL B1 ON A.FILIAL = B1.HANDLE 
										LEFT JOIN OP_TIPOOCORRENCIA B2 ON A.TIPO = B2.HANDLE 
										LEFT JOIN OP_ACAOOCORRENCIA B3 ON A.ACAO = B3.HANDLE 
										WHERE A.EMPRESA IN (1)  
																		AND A.STATUS = 4
										AND EXISTS(SELECT X.HANDLE           
											FROM RA_PEDIDOMOVIMENTACAO X          
											INNER JOIN GD_DOCUMENTO  X1 ON X1.HANDLE = X.DOCUMENTO          
											WHERE X.PEDIDO = '" . $handleRastreamento . "'         
											AND X1.DOCUMENTOTRANSPORTE = A.DOCUMENTOTRANSPORTE) 
										) 
										AS ETAPAS
										ORDER BY DATA DESC
										";
		$queryRastreamentoUltimaEtapa = $connect->prepare($queryRastreamentoUltimaEtapa);

		$queryRastreamentoUltimaEtapa->execute();

		while ($rowRastreamentoUltimaEtapa = $queryRastreamentoUltimaEtapa->fetch(PDO::FETCH_ASSOC)) {
			$handleRastreamentoUltimaEtapa = $rowRastreamentoUltimaEtapa['HANDLE'];
			$etapaRastreamentoUltimaEtapa = $rowRastreamentoUltimaEtapa['ETAPA'];
			$dataRastreamentoUltimaEtapa = date('d/m/Y H:i:s', strtotime($rowRastreamentoUltimaEtapa['DATA']));
			$observacaoRastreamentoUltimaEtapa = $rowRastreamentoUltimaEtapa['OBSERVACAO'];
		}
		
		if ($etapaRastreamentoUltimaEtapa == null)
		{
			$etapaRastreamentoUltimaEtapa = 'Ag. inicio execução';
			$dataRastreamentoUltimaEtapa =  date('d/m/Y H:i:s', strtotime($dataCadastro));
		}
			
		if ($handleRastreamento <= 0) {
			$_SESSION['retorno'] = 'Etapas do transporte não encontradas.';
			$_SESSION['rastreamento'] = $numeroDocumento;
			//header('Location: RastreioPedidoSimplesTransporte.php');
		}


		# ETAPA
		$queryRastreamentoEtapa = "SELECT HANDLE, DATA, ETAPA, OBSERVACAO, LOWER(REPLACE(ETAPAIMAGEMSTATUS, '_', '/')) ETAPAIMAGEMSTATUS
									FROM (
									SELECT  A.HANDLE HANDLE, A.DATA DATA, A.TITULO ETAPA, A.OBSERVACAO OBSERVACAO, B01.RESOURCENAME ETAPAIMAGEMSTATUS
									FROM RA_PEDIDOETAPA A  
									LEFT JOIN MS_STATUS B0 ON A.STATUS = B0.HANDLE 
									LEFT JOIN MD_IMAGEM B01 ON B01.HANDLE = B0.IMAGEM
									LEFT JOIN RA_TIPOETAPA B1 ON A.ETAPA = B1.HANDLE 
									WHERE A.PEDIDO = '" . $handleRastreamento . "'
																AND A.STATUS = 9

									UNION ALL

									SELECT A.HANDLE HANDLE, A.DATA DATA, B3.NOME ETAPA, A.OBSERVACAO OBSERVACAO, NULL STATUS
									FROM OP_OCORRENCIA A  
									LEFT JOIN OP_STATUSOCORRENCIA B0 ON A.STATUS = B0.HANDLE 
									LEFT JOIN MS_FILIAL B1 ON A.FILIAL = B1.HANDLE 
									LEFT JOIN OP_TIPOOCORRENCIA B2 ON A.TIPO = B2.HANDLE 
									LEFT JOIN OP_ACAOOCORRENCIA B3 ON A.ACAO = B3.HANDLE 
									WHERE A.EMPRESA IN (1)
																AND A.STATUS = 4
									AND EXISTS(SELECT X.HANDLE           
										FROM RA_PEDIDOMOVIMENTACAO X          
										INNER JOIN GD_DOCUMENTO  X1 ON X1.HANDLE = X.DOCUMENTO          
										WHERE X.PEDIDO = '" . $handleRastreamento . "'         
										AND X1.DOCUMENTOTRANSPORTE = A.DOCUMENTOTRANSPORTE) 
									) 
									AS ETAPAS
									ORDER BY DATA DESC
									";
		$queryRastreamentoEtapa = $connect->prepare($queryRastreamentoEtapa);
		$queryRastreamentoEtapa->execute();

		$rowRastreamentoEtapa = $queryRastreamentoEtapa->fetch(PDO::FETCH_ASSOC);

		$handleRastreamentoEtapa = $rowRastreamentoEtapa['HANDLE'];		

		$queryRastreamentoDocumento = "SELECT A.HANDLE, 
												A.NUMERODOCUMENTO NUMERODOCUMENTO, 
												B3.SIGLA TIPODOCUMENTO, 
												A.DATAEMISSAO DATAEMISSAO, 
												A.VALORBRUTO VALORDOCUMENTO,
												B5.APELIDO TOMADOR, 
												B7.OCORRENCIA HANDLEOCORRENCIACOMPROVANTE, 
												B7.HANDLE HANDLEANEXOCOMPROVANTE
									
								FROM GD_DOCUMENTO A  
								LEFT JOIN GD_STATUSDOCUMENTO B0 ON A.STATUS = B0.HANDLE 
								LEFT JOIN GD_DOCUMENTOTRANSPORTE B1 ON A.DOCUMENTOTRANSPORTE = B1.HANDLE 
								LEFT JOIN GD_STATUSDOCUMENTOTRANSPORTE B2 ON B1.STATUS = B2.HANDLE 
								LEFT JOIN TR_TIPODOCUMENTO B3 ON A.TIPODOCUMENTOFISCAL = B3.HANDLE 
								LEFT JOIN TR_MODELODOCUMENTO B4 ON A.MODELO = B4.HANDLE 
								LEFT JOIN MS_PESSOA B5 ON A.PESSOA = B5.HANDLE
								LEFT JOIN OP_OCORRENCIAANEXO B7 ON B7.HANDLE = (SELECT MAX(X1.HANDLE) 
								                                             FROM OP_OCORRENCIAANEXO X1
                                                                       INNER JOIN OP_OCORRENCIA X2 ON X1.OCORRENCIA = X2.HANDLE
																		WHERE X2.DOCUMENTOTRANSPORTE = A.DOCUMENTOTRANSPORTE
																		  AND X1.TIPO = 8)
								WHERE EXISTS ( 												
												SELECT X.HANDLE             
												FROM RA_PEDIDOMOVIMENTACAO X
												INNER JOIN GD_DOCUMENTOORIGINARIO Y ON Y.DOCUMENTO = A.HANDLE            
												WHERE X.PEDIDO = '" . $handleRastreamento . "'           
												AND X.HANDLEORIGEM = B1.HANDLE
												AND X.ORIGEM = 2042 		

												UNION ALL
																							
												SELECT X.HANDLE             
												FROM RA_PEDIDOMOVIMENTACAO X
												INNER JOIN GD_DOCUMENTOORIGINARIO Y ON Y.DOCUMENTO = A.HANDLE            
												WHERE X.PEDIDO = '" . $handleRastreamento . "'         
												AND X.HANDLEORIGEM = A.HANDLE
												AND X.ORIGEM = 1371 											
											) 
								  AND A.EHCANCELADO <> 'S'
									ORDER BY  NUMERODOCUMENTO, TIPODOCUMENTO, DATAEMISSAO, VALORDOCUMENTO ASC
											";
		$queryRastreamentoDocumento = $connect->prepare($queryRastreamentoDocumento);
		$queryRastreamentoDocumento->execute();

		$rowRastreamentoDocumento = $queryRastreamentoDocumento->fetch(PDO::FETCH_ASSOC);

		$handleRastreamentoDocumento = $rowRastreamentoDocumento['HANDLE'];
		
		
		# DOCUMENTO ORIGINARIO
		$queryRastreamentoDocumentoOriginario = "SELECT A.HANDLE, 
														A.NUMERO NUMERODOCUMENTO,
														A.SERIE SERIE,  
														B.SIGLA TIPODOCUMENTO, 
														A.VALORTOTAL, 
														C.NOME FILIAL, 
														A.DATAEMISSAO DATAEMISSAO,
														A.STATUS STATUSDOCUMENTO,
														D.APELIDO EMITENTE,
														A.PESOBRUTO PESO,
														A.VOLUME, 
														A.CHAVEDOCUMENTOELETRONICO
										FROM GD_ORIGINARIO A  
									LEFT JOIN GD_TIPOORIGINARIO B ON A.TIPO = B.HANDLE 
									LEFT JOIN MS_FILIAL C ON A.FILIAL = C.HANDLE
									LEFT JOIN MS_PESSOA D ON A.EMITENTE = D.HANDLE
									WHERE EXISTS ( SELECT X.HANDLE             
														   FROM RA_PEDIDOMOVIMENTACAO X            
														  WHERE X.PEDIDO = '" . $handleRastreamento . "'       
															AND X.HANDLEORIGEM = A.HANDLE              
															AND X.ORIGEM = 1890

															UNION ALL

															SELECT X.HANDLE
															  FROM GD_DOCUMENTOORIGINARIO X
														     INNER JOIN GD_ORIGINARIO X1 ON X1.HANDLE = X.ORIGINARIO
															 WHERE X1.HANDLE = A.HANDLE
															   AND X.DOCUMENTO = '". $handleRastreamentoDocumento ."'
															   AND NOT EXISTS (SELECT Y.HANDLE
															                     FROM RA_PEDIDOMOVIMENTACAO Y
																				WHERE Y.PEDIDO = '" . $handleRastreamento . "' 																				  
																				  AND Y.ORIGEM = 1890)
												)
												ORDER BY A.NUMERO
											";
		$queryRastreamentoDocumentoOriginario = $connect->prepare($queryRastreamentoDocumentoOriginario);		

	}	

}

function getPedidoDocumentoOriginario($prDocumento, $prRemetente, $prDestinatario) {
	$connect = Sistema::getConexao(false);

	if (is_numeric($prDocumento) == false) {
		return 0;
	}

	if($prRemetente != 0) {
		$remetenteSQL = "AND A.REMETENTE = :REMETENTE";	
	} else {
		$remetenteSQL = "AND 0 = :REMETENTE";	
	}	

	$queryOriginario = "SELECT A.HANDLE
						  FROM GD_ORIGINARIO A							 
						 WHERE A.NUMERODOCUMENTO = :NUMERODOCUMENTO 
						   AND A.STATUS <> 3
						   AND A.EHTRANSPORTE = 'S'
						   AND A.DESTINATARIO = :DESTINATARIO						    
						   $remetenteSQL ";

	$queryOriginario = $connect->prepare($queryOriginario);

	$queryOriginario->execute(['NUMERODOCUMENTO' => $prDocumento, 
							   'REMETENTE' => $prRemetente,
							   'DESTINATARIO' => $prDestinatario]);
							   
	$rowOriginario= $queryOriginario->fetch(PDO::FETCH_ASSOC);
	$originario = $rowOriginario['HANDLE'];	
	
	if ($originario != 0) {
		$queryPedido = "SELECT A.PEDIDO HANDLE 
						 FROM RA_PEDIDOMOVIMENTACAO A
						INNER JOIN RA_PEDIDO B ON B.HANDLE = A.PEDIDO
						WHERE A.HANDLEORIGEM = :ORIGINARIO 
						  AND A.ORIGEM = 1890 				
						  AND B.STATUS <> 3			
						ORDER BY A.PEDIDO DESC";
		$queryPedido = $connect->prepare($queryPedido);

		$queryPedido->execute(['ORIGINARIO' => $originario]);
		$rowPedido = $queryPedido->fetch(PDO::FETCH_ASSOC);
		$pedido = $rowPedido['HANDLE'];			

		if ($pedido != 0) {
			return $pedido;
		} else {
			return getPedidoDocumentoTransporte($originario);
		}
	} else {
		return 0;
	}	
}

function getPedidoDocumentoTransporte($prOriginario) {
	$connect = Sistema::getConexao(false);

	$queryDocumento = "SELECT C.DOCUMENTOTRANSPORTE HANDLE
						  FROM GD_ORIGINARIO A		
						 INNER JOIN GD_DOCUMENTOORIGINARIO B ON B.ORIGINARIO = A.HANDLE
						 INNER JOIN GD_DOCUMENTO C ON C.HANDLE = B.DOCUMENTO					 
						 WHERE C.EHCANCELADO <> 'S'
						   AND C.EHCOMPLEMENTAR <> 'S'
						   AND A.HANDLE = :ORIGINARIO						   
					  ORDER BY C.HANDLE DESC";

	$queryDocumento = $connect->prepare($queryDocumento);

	$queryDocumento->execute(['ORIGINARIO' => $prOriginario]);
							   
	$rowDocumento = $queryDocumento->fetch(PDO::FETCH_ASSOC);
	$documento = $rowDocumento['HANDLE'];	
	
	if ($documento != 0) {
		$queryPedido = "SELECT A.PEDIDO HANDLE 
						  FROM RA_PEDIDOMOVIMENTACAO A
						 INNER JOIN RA_PEDIDO B ON B.HANDLE = A.PEDIDO
						 WHERE A.HANDLEORIGEM = :DOCUMENTO 
						   AND A.ORIGEM = 2042 
						   AND B.STATUS <> 3
						 ORDER BY A.PEDIDO DESC";
		$queryPedido = $connect->prepare($queryPedido);

		$queryPedido->execute(['DOCUMENTO' => $documento]);
		$rowPedido = $queryPedido->fetch(PDO::FETCH_ASSOC);
		$pedido = $rowPedido['HANDLE'];			

		if ($pedido != 0) {
			return $pedido;
		} else {
			return 0;
		}
	} else {
		return 0;
	}
}	