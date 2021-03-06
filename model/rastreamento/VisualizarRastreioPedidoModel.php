<?php

$dataRastreamento = null;
$clienteRastreamento = null;
$statusRastreamento = null;
$numeroRastreamento = null;
$numeroPedido = null;
$numeroControle = null;
$filialRastreamento = null;
$Rastreamento = null;
$valormercadoriaRastreamento = null;
$remetenteRastreamento = null;
$destinatarioRastreamento = null;
$munColetaRastreamento = null;
$ufColetaRastreamento = null;
$munEntregaRastreamento = null;
$ufEntregaRastreamento = null;
$situacaoRastreamento = null;
$statusDataRastreamento = null;
$statusHoraRastreamento = null;
$tipoRastreamento = null;
$quantidadeRastreamento = null;
$volumeRastreamento = null;
$pesoRastreamento = null;
$dataColetaRastreamento = null;
$dataEntregaAteRastreamento = null;
$dataEntregaRastreamento = null;
$bairroColetaRastreamento = null;
$bairroEntregaRastreamento = null;
$ruaColetaRastreamento = null;
$ruaEntregaRastreamento = null;
$numeroColetaRastreamento = null;
$numeroEntregaRastreamento = null;
$cepColetaRastreamento = null;
$cepEntregaRastreamento = null;
$paisColetaRastreamento = null;
$paisEntregaRastreamento = null;
$documentoRastreamento = null;

$pedidoRastreamento = Sistema::getGet('pedido');
$query = $connect->prepare("SELECT A.HANDLE, 
									   A.STATUS, 
									   A.NUMERO, 
									   A.NUMEROPEDIDO,
									   A.NUMEROCONTROLE,
									   C.NOME FILIAL, 
									   A.DATA, 
									   A.RASTREAMENTO, 
									   A.VALORMERCADORIA, 
									   A.NOMEREMETENTE REMETENTE, 
									   A.NOMEDESTINATARIO DESTINATARIO, 
									   A.MUNICIPIOREMETENTE MUNICIPIOCOLETA, 
									   A.UFREMETENTE ESTADOCOLETA, 
									   A.MUNICIPIODESTINATARIO MUNICIPIOENTREGA, 
									   A.UFDESTINATARIO ESTADOENTREGA,
									   M.NOME SITUACAO,
									   A.STATUSDATA,
									   N.NOME TIPO,
									   A.QUANTIDADE,
									   A.VOLUME,
									   A.PESO,
									   A.DATACOLETA,
									   A.DATAENTREGAATE,
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
									   A.TIPOREMETENTE TIPOLOGRADOUROENDERECOCOLETA,
									   A.TIPODESTINATARIO TIPOLOGRADOUROENDEREENTREGA,
									   A.CNPJCPFREMETENTE CNPJCPFREMETENTE,
									   A.CNPJCPFDESTINATARIO CNPJCPFDESTINATARIO,
									   A.COMPLEMENTOREMETENTE COMPLEMENTOREMETENTE, 
									   A.COMPLEMENTODESTINATARIO COMPLEMENTODESTINATARIO,
									   A.TELEFONEREMETENTE TELEFONEREMETENTE,
									   A.TELEFONEDESTINATARIO TELEFONEDESTINATARIO,
									   A.CELULARREMETENTE CELULARREMETENTE,
									   A.CELULARDESTINATARIO CELULARDESTINATARIO,
									   A.EMAILREMETENTE EMAILREMETENTE,
									   A.EMAILDESTINATARIO EMAILDESTINATARIO,
                                       G.APELIDO CLIENTE,
									   V.CODIGOREFERENCIA UNIDADENEGOCIO,
									   V.NOME NOMEUNIDADENEGOCIO
								  FROM RA_PEDIDO A (NOLOCK)
			            		  LEFT JOIN RA_STATUSPEDIDO B (NOLOCK) ON A.STATUS = B.HANDLE 
				        		  LEFT JOIN MS_FILIAL C (NOLOCK) ON A.FILIAL = C.HANDLE
                                  LEFT JOIN MS_PESSOA D (NOLOCK) ON A.REMETENTE = D.HANDLE 
                                  LEFT JOIN MS_PESSOA E (NOLOCK) ON A.DESTINATARIO = E.HANDLE 
                                  LEFT JOIN MS_USUARIO F (NOLOCK) ON A.LOGUSUARIOCADASTRO = F.HANDLE
                                  LEFT JOIN MS_PESSOA G (NOLOCK) ON G.HANDLE = A.CLIENTE                                                
								  LEFT JOIN RA_STATUSPEDIDO M (NOLOCK) ON A.STATUS = M.HANDLE
                                  LEFT JOIN RA_TIPOPEDIDO N (NOLOCK) ON A.TIPO = N.HANDLE
                                  LEFT JOIN RA_PEDIDOMOVIMENTACAO U (NOLOCK) ON A.HANDLE = U.PEDIDO
								  LEFT JOIN MS_UNIDADENEGOCIOCLIENTE V (NOLOCK) ON V.HANDLE = A.UNIDADENEGOCIOCLIENTE
                                                
					       WHERE A.HANDLE = '" . $pedidoRastreamento . "'
					       ORDER BY A.NUMERO ASC ");
$query->execute();

$row = $query->fetch(PDO::FETCH_ASSOC);

$dataRastreamento = Sistema::formataDataHora($row['DATA']);
$clienteRastreamento = $row['CLIENTE'];
$statusRastreamento = $row['STATUS'];
$numeroRastreamento = $row['NUMERO'];
$numeroPedido = $row['NUMEROPEDIDO'];
$numeroControle = $row['NUMEROCONTROLE'];
$filialRastreamento = $row['FILIAL'];
$Rastreamento = $row['RASTREAMENTO'];
$tipoLogradouroEnderecoColeta = $row['TIPOLOGRADOUROENDERECOCOLETA'];
$tipoLogradouroEnderecoEntrega = $row['TIPOLOGRADOUROENDEREENTREGA'];
$valormercadoriaRastreamento = number_format($row['VALORMERCADORIA'], '2', ',', '.');

if ($valormercadoriaRastreamento == null) {
    $valormercadoriaRastreamento = '0,00';
}

$unidadeNegocio = $row['UNIDADENEGOCIO'] . ' - ' . $row['NOMEUNIDADENEGOCIO'];
$remetenteRastreamento = $row['REMETENTE'];
$destinatarioRastreamento = $row['DESTINATARIO'];
$munColetaRastreamento = $row['MUNICIPIOCOLETA'];
$ufColetaRastreamento = $row['ESTADOCOLETA'];
$munEntregaRastreamento = $row['MUNICIPIOENTREGA'];
$ufEntregaRastreamento = $row['ESTADOENTREGA'];
$situacaoRastreamento = $row['SITUACAO'];
$statusDataRastreamento = Sistema::formataData($row['STATUSDATA']);
$statusHoraRastreamento = Sistema::formataHora($row['STATUSDATA']);
$tipoRastreamento = $row['TIPO'];
$quantidadeRastreamento = number_format($row['QUANTIDADE'], '4', ',', '.');
$volumeRastreamento = number_format($row['VOLUME'], '6', ',', '.');
$pesoRastreamento = number_format($row['PESO'], '4', ',', '.');
$dataColetaRastreamento = Sistema::formataDataHora($row['DATACOLETA']);
$dataEntregaAteRastreamento = Sistema::formataDataHora($row['DATAENTREGAATE']);
$dataEntregaRastreamento = Sistema::formataDataHora($row['DATAENTREGA']);
$bairroColetaRastreamento = $row['BAIRROCOLETA'];
$bairroEntregaRastreamento = $row['BAIRROENTREGA'];
$ruaColetaRastreamento = $row['RUACOLETA'];
$ruaEntregaRastreamento = $row['RUAENTREGA'];
$numeroColetaRastreamento = $row['NUMEROCOLETA'];
$numeroEntregaRastreamento = $row['NUMEROENTREGA'];
$cepColetaRastreamento = $row['CEPCOLETA'];
$cepEntregaRastreamento = $row['CEPENTREGA'];
$paisColetaRastreamento = "Brasil";
$paisEntregaRastreamento = "Brasil";
$documentoRastreamento = $row['DOCUMENTO'];
$cpnjCpfRemetenteRastreamento = $row['CNPJCPFREMETENTE'];
$cpnjCpfDestinatarioRastreamento = $row['CNPJCPFDESTINATARIO'];
$complementoRemetenteRastreamento = $row['COMPLEMENTOREMETENTE'];
$complementoDestinatarioRastreamento = $row['COMPLEMENTODESTINATARIO'];
$telefoneRemetenteRastreamento = $row['TELEFONEREMETENTE'];
$telefoneDestinatarioRastreamento = $row['TELEFONEDESTINATARIO'];
$celularRemetenteRastreamento = $row['CELULARREMETENTE'];
$celularDestinatarioRastreamento = $row['CELULARDESTINATARIO'];
$emailRemetenteRastreamento = $row['EMAILREMETENTE'];
$emailDestinatarioRastreamento = $row['EMAILDESTINATARIO'];

//existe documento
$queryMovimentacaoOrigem = $connect->prepare("SELECT A.HANDLE, 
												  A.ORIGEM, 
												  A.HANDLEORIGEM,
												  B.NOME NOMEORIGEM
												  FROM RA_PEDIDOMOVIMENTACAO A (NOLOCK)
												  INNER JOIN MD_TABELA B (NOLOCK) ON B.HANDLE = A.ORIGEM
												  WHERE PEDIDO = '" . $pedidoRastreamento . "'
												 ");

$queryMovimentacaoOrigem->execute();

$rowMovimentacaoOrigem = $queryMovimentacaoOrigem->fetch(PDO::FETCH_ASSOC);
$movimentacaoOrigem = $rowMovimentacaoOrigem['NOMEORIGEM'];
$movimentacaoHandleOrigem = $rowMovimentacaoOrigem['HANDLEORIGEM'];

$queryDocumento = $connect->prepare("SELECT DISTINCT A.HANDLE, 
									     A.NUMERO, 
										 B.SIGLA TIPO, 
									     A.VALORLIQUIDO, 
									     C.NOME FILIAL, 
									     A.DATAEMISSAO,
									     A.STATUS STATUSDOCUMENTO,
									     D.APELIDO PESSOA
				  	   FROM GD_DOCUMENTO A (NOLOCK)  
			  LEFT JOIN TR_TIPODOCUMENTO B (NOLOCK) ON A.TIPODOCUMENTOFISCAL = B.HANDLE 
				     LEFT JOIN MS_FILIAL C (NOLOCK) ON A.FILIAL = C.HANDLE
				     LEFT JOIN MS_PESSOA D (NOLOCK) ON A.PESSOA = D.HANDLE
	     LEFT JOIN RA_PEDIDOMOVIMENTACAO E (NOLOCK) ON A.HANDLE = E.DOCUMENTO
								   WHERE EXISTS ( SELECT X.HANDLE             
												  FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK)            
												  WHERE X.PEDIDO = '" . $pedidoRastreamento . "'       
												  AND X.HANDLEORIGEM = A.HANDLE              
												  AND X.ORIGEM = 1371

												  UNION ALL 

												  SELECT X.HANDLE             
												  FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK)            
												  WHERE X.PEDIDO = '" . $pedidoRastreamento . "'       
												  AND X.HANDLEORIGEM = A.DOCUMENTOTRANSPORTE              
												  AND X.ORIGEM = 2042
												)
										 AND A.EHCANCELADO <> 'S'
										ORDER BY A.NUMERO										
							   			");


$queryDocumento->execute();

$rowDocumentoExiste = $queryDocumento->fetch(PDO::FETCH_ASSOC);
$documentoExiste = $rowDocumentoExiste['HANDLE'];

$queryDocumentoOriginario = $connect->prepare("SELECT A.HANDLE, 
                                                      A.NUMERO, 
                                                      B.SIGLA TIPO, 
                                                      A.VALORTOTAL, 
                                                      C.NOME FILIAL, 
                                                      A.DATAEMISSAO,
                                                      A.STATUS STATUSDOCUMENTO,
                                                      D.APELIDO PESSOA,
                                                      A.PESOBRUTO PESO,
                                                      A.VOLUME,
                                                      F.NOME STATUSNOME,
                                                      G.RESOURCENAME RESOURCENAME
						 FROM GD_ORIGINARIO A (NOLOCK)  
						 LEFT JOIN GD_TIPOORIGINARIO B (NOLOCK) ON A.TIPO = B.HANDLE 
						 LEFT JOIN MS_FILIAL C (NOLOCK) ON A.FILIAL = C.HANDLE
						 LEFT JOIN MS_PESSOA D (NOLOCK) ON A.EMITENTE = D.HANDLE
				         LEFT JOIN RA_PEDIDOMOVIMENTACAO E (NOLOCK) ON A.HANDLE = E.DOCUMENTO
						 LEFT JOIN GD_STATUSORIGINARIO F (NOLOCK) ON F.HANDLE = A.STATUS
						 LEFT JOIN MD_IMAGEM G (NOLOCK) ON G.HANDLE = F.IMAGEM
					        WHERE EXISTS ( SELECT X.HANDLE             
							         FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK)            
							        WHERE X.PEDIDO = '" . $pedidoRastreamento . "'       
  							          AND X.HANDLEORIGEM = A.HANDLE              
							          AND X.ORIGEM = 1890
									  
									  UNION ALL
									  
									  SELECT X.HANDLE             
							         FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK)            
									 INNER JOIN GD_DOCUMENTOTRANSPORTE X1 (NOLOCK) ON X1.HANDLE = X.HANDLEORIGEM
									 INNER JOIN GD_DOCUMENTOORIGINARIO X2 (NOLOCK) ON X2.DOCUMENTO = X1.DOCUMENTO
									 INNER JOIN GD_ORIGINARIO X3 (NOLOCK) ON X3.HANDLE = X2.ORIGINARIO
							        WHERE X.PEDIDO = '" . $pedidoRastreamento . "'         	
									  AND X3.HANDLE = A.HANDLE						          
							          AND X.ORIGEM = 2042
									  )
					        ORDER BY A.NUMERO");
$queryDocumentoOriginario->execute();

$rowDocumentoOriginarioExiste = $queryDocumentoOriginario->fetch(PDO::FETCH_ASSOC);
$documentoOriginarioExiste = $rowDocumentoOriginarioExiste['HANDLE'];


//existe ocorr??ncia de transporte
$queryOcorrenciaTransporte = $connect->prepare("SELECT A.HANDLE HANDLE, 
													   A.TIPO TIPO,  
													   A.STATUS STATUS,  
													   A.ORDEM ORDEM,  
													   A.NUMERO NUMERO,  
													   B1.SIGLA FILIAL, 
													   A.DATA DATA, 
													   B2.NOME TIPO, 
													   B3.NOME ACAO 
											      FROM OP_OCORRENCIA A (NOLOCK)  
											      LEFT JOIN OP_STATUSOCORRENCIA B0 (NOLOCK) ON A.STATUS = B0.HANDLE 
											      LEFT JOIN MS_FILIAL B1 (NOLOCK) ON A.FILIAL = B1.HANDLE 
											      LEFT JOIN OP_TIPOOCORRENCIA B2 (NOLOCK) ON A.TIPO = B2.HANDLE 
											      LEFT JOIN OP_ACAOOCORRENCIA B3 (NOLOCK) ON A.ACAO = B3.HANDLE
											     WHERE A.STATUS = 4 
											       AND B2.EHEXIBIRWEBCARGAS = 'S'
												   AND A.DOCUMENTOTRANSPORTE IS NOT NULL
												   AND A.ORIGINARIO IS NULL
											       AND EXISTS ( SELECT X.HANDLE                 
																  FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK)           
																 INNER JOIN GD_DOCUMENTOTRANSPORTE W (NOLOCK) ON W.DOCUMENTO = X.HANDLEORIGEM                
																 WHERE X.PEDIDO = '" . $pedidoRastreamento . "'                    
																   AND W.HANDLE = A.DOCUMENTOTRANSPORTE                  
																   AND X.ORIGEM = 1371 
												
																 UNION ALL

																SELECT X.HANDLE             
																  FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK)            
																 INNER JOIN GD_DOCUMENTOTRANSPORTE X1 (NOLOCK) ON X1.HANDLE = X.HANDLEORIGEM
																 WHERE X.PEDIDO = '" . $pedidoRastreamento . "'         	
																   AND X1.HANDLE = A.DOCUMENTOTRANSPORTE         
																   AND X.ORIGEM = 2042) 
																 ORDER BY DATA DESC");
$queryOcorrenciaTransporte->execute();
$rowOcorrenciaTransporteExiste = $queryOcorrenciaTransporte->fetch(PDO::FETCH_ASSOC);
$OcorrenciaTransporteExiste = $rowOcorrenciaTransporteExiste['HANDLE'];


//existe posi????o
$queryPosicao = $connect->prepare("SELECT A.HANDLE, 
									  A.DATA, 
									  B.PLACA VEICULO, 
									  C.NUMERO VIAGEM, 
									  A.LOCALIZACAO, 
									  A.LATITUDE, 
									  A.LONGITUDE
			   FROM OP_POSICAOVEICULO A (NOLOCK)  
				 LEFT JOIN MF_VEICULO B (NOLOCK) ON A.VEICULO = B.HANDLE 
				  LEFT JOIN OP_VIAGEM C (NOLOCK) ON A.VIAGEM = C.HANDLE
				  WHERE EXISTS(SELECT X.HANDLE           
								FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK)          
								INNER JOIN GD_DOCUMENTO  X1 (NOLOCK) ON X1.HANDLE = X.HANDLEORIGEM AND X.ORIGEM = 1371
								INNER JOIN OP_VIAGEMROMANEIOITEM X2 (NOLOCK) ON X2.DOCUMENTOTRANSPORTE = X1.DOCUMENTOTRANSPORTE          
								WHERE X.PEDIDO = '" . $pedidoRastreamento . "'            
								  AND X2.VIAGEM = A.VIAGEM)  
							ORDER BY  A.HANDLE ASC
							");

$queryPosicao->execute();

$rowPosicaoExiste = $queryPosicao->fetch(PDO::FETCH_ASSOC);

$PosicaoExiste = $rowPosicaoExiste['HANDLE'];
$latitudeExiste = $rowPosicaoExiste['LATITUDE'];
$longitudeExiste = $rowPosicaoExiste['LONGITUDE'];


//existe etapa
$queryEtapa = $connect->prepare("SELECT A.STATUS STATUS, 
										A.HANDLE, 
										A.DATA DATA,
										B1.CODIGO CODIGO, 
										A.TITULO ETAPA,
										A.SEQUENCIAL,
										A.OBSERVACAO,
                                    	D.RESOURCENAME
								   FROM RA_PEDIDOETAPA A (NOLOCK)  
								   LEFT JOIN MS_STATUS B0 (NOLOCK) ON A.STATUS = B0.HANDLE 
								   LEFT JOIN RA_TIPOETAPA B1 (NOLOCK) ON A.ETAPA = B1.HANDLE
                                   LEFT JOIN MS_STATUS C (NOLOCK) ON C.HANDLE = A.STATUS
                                   LEFT JOIN MD_IMAGEM D (NOLOCK) ON D.HANDLE = C.IMAGEM
								  INNER JOIN RA_PEDIDO E (NOLOCK) ON E.HANDLE = A.PEDIDO
								  INNER JOIN RA_TIPOPEDIDO F (NOLOCK) ON F.HANDLE = E.TIPO
								  WHERE A.PEDIDO = '" . $pedidoRastreamento . "'
								    AND ((F.EHEXIBIRETAPAEXECUTADA = 'S' AND A.STATUS = 9) OR (F.EHEXIBIRETAPAEXECUTADA = 'N'))  
								  ORDER BY A.DATA ASC
									");

$queryEtapa->execute();

$rowEtapaExiste = $queryEtapa->fetch(PDO::FETCH_ASSOC);
$EtapaExiste = $rowEtapaExiste['HANDLE'];