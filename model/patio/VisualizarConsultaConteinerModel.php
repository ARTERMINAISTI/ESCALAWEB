<?php

$codigo = null;
$filial = null;
$tipoconteiner = null;
$classificacaoiso = null;
$cliente = null;
$localizacao = null;
$entrada = null;
$saida = null;
$diaspatio = null;
$tipooperacao = null;
$finalidade = null;
$demurrage = null;
$altura = null;
$largura = null;
$comprimento = null;
$capacidadem3 = null;
$tara = null;
$mgw = null;
$fabricacao = null;
$armador = null;
$naturezaoperacao = null;
$navio = null;
$booking = null;
$processo = null;

$conteiner = Sistema::getGet('conteiner');
$query = $connect->prepare("SELECT A.HANDLE,
								   A.STATUSDATA,
								   P.NOME SITUACAO,
								   P.HANDLE SITUACAOHANDLE,
							       A.CODIGO CODIGOCONTEINER,
							       E.NOME FILIAL,
							       C.NOME TIPOCONTEINER,
							       D.NOME CLASSIFICACAOISO,
							       G.NOME CLIENTE,
							       F.POSICAO LOCALIZACAO,
							       B.ENTRADA,
							       B.SAIDA,
							       B.DIAS DIASPATIO,
							       I.NOME TIPOOPERACAO,
							       J.NOME FINALIDADE,
							       B.DEMURRAGE DEMURRAGE,
							       A.ALTURA,
							       A.LARGURA,
							       A.COMPRIMENTO,
							       A.CAPACIDADEM3,
							       A.TARA,
							       A.MGW,
							       A.FABRICACAO FABRICACAO,
							       K.APELIDO ARMADOR,
							       L.NOME NATUREZAOPERACAO,
							       M.NOME NAVIO,
							       N.NUMERO BOOKING,
							       O.NOME PROCESSO   

							  FROM PA_CONTEINER A
							  LEFT JOIN PA_CONTEINERENTRADA B ON B.CONTEINER = A.HANDLE
							  LEFT JOIN PA_TIPOEQUIPAMENTO C ON C.HANDLE = A.TIPOEQUIPAMENTO
							  LEFT JOIN PA_CLASSIFICACAOISO D ON D.HANDLE = A.CLASSIFICACAOISO
							  LEFT JOIN MS_FILIAL E ON E.HANDLE = B.FILIAL
							  LEFT JOIN PA_TERMINALLOCALIZACAO F ON F.HANDLE = B.LOCALIZACAO
							  LEFT JOIN MS_PESSOA G ON G.HANDLE = B.CLIENTE
							  LEFT JOIN PA_TIPOMOVIMENTACAO H ON H.HANDLE = B.TIPOMOVIMENTACAO
							  LEFT JOIN PA_TIPOOPERACAO I ON I.HANDLE = H.TIPOOPERACAO
							  LEFT JOIN PA_FINALIDADEMOVIMENTACAO J ON J.HANDLE = B.FINALIDADE
							  LEFT JOIN MS_PESSOA K ON K.HANDLE = A.ARMADOR
							  LEFT JOIN PA_NATUREZAOPERACAO L ON L.HANDLE = B.NATUREZAOPERACAO
							  LEFT JOIN PA_NAVIO M ON M.HANDLE = B.NAVIO
							  LEFT JOIN PA_BOOKING N ON N.HANDLE = B.BOOKING
							  LEFT JOIN PA_PROCESSO O ON O.HANDLE = B.PROCESSO
							  LEFT JOIN PA_STATUSCONTEINER P ON P.HANDLE = A.STATUS
                                              
					         WHERE A.HANDLE = '" . $conteiner . "'
					         ORDER BY B.LOGDATACADASTRO DESC ");
$query->execute();

$row = $query->fetch(PDO::FETCH_ASSOC);

$codigoconteiner = $row['CODIGOCONTEINER'];
$filial = $row['FILIAL'];
$statusData = Sistema::formataData($row['STATUSDATA']);
$statusHora = Sistema::formataHora($row['STATUSDATA']);
$situacao = $row['SITUACAO'];
$situacaoHandle = $row['SITUACAOHANDLE'];
$tipoconteiner = $row['TIPOCONTEINER'];
$classificacaoiso = $row['CLASSIFICACAOISO'];
$cliente = $row['CLIENTE'];
$localizacao = $row['LOCALIZACAO'];
$entrada = Sistema::formataDataHora($row['ENTRADA']);
$saida = Sistema::formataDataHora($row['SAIDA']);
$diaspatio = $row['DIASPATIO'];
$tipooperacao = $row['TIPOOPERACAO'];
$finalidade = $row['FINALIDADE'];
$demurrage = Sistema::formataDataHora($row['DEMURRAGE']);
$altura = SISTEMA::formataValor($row['ALTURA']);
$largura = SISTEMA::formataValor($row['LARGURA']);
$comprimento = SISTEMA::formataValor($row['COMPRIMENTO']);
$capacidade = SISTEMA::formataValor($row['CAPACIDADEM3']);
$tarakg = $row['TARA'];
$mgwkg = $row['MGW'];
$fabricacao = $row['FABRICACAO'];
$armador = $row['ARMADOR'];
$naturezaoperacao = $row['NATUREZAOPERACAO'];
$navio = $row['NAVIO'];
$booking = $row['BOOKING'];
$processo = $row['PROCESSO'];

$queryMovimentacaoConteiner = $connect->prepare("SELECT A.HANDLE, 
														A.DATA DATA, 
														A.CONTEINER CONTEINERHANDLE,
														B0.SIGLA FILIAL, 
														B1.NOME TIPOOPERACAO, 
														B2.NOME FINALIDADEMOVIMENTACAO, 
														B3.POSICAO LOCALIZACAO 
												   FROM PA_CONTEINERMOVIMENTACAO A  
												   LEFT JOIN MS_FILIAL B0 ON A.FILIAL = B0.HANDLE 
												   LEFT JOIN PA_TIPOOPERACAO B1 ON A.TIPOOPERACAO = B1.HANDLE 
												   LEFT JOIN PA_FINALIDADEMOVIMENTACAO B2 ON A.FINALIDADE = B2.HANDLE 
												   LEFT JOIN PA_TERMINALLOCALIZACAO B3 ON A.LOCALIZACAO = B3.HANDLE 
												  WHERE A.CONTEINER = '" . $conteiner . "'         							
									              ORDER BY A.DATA DESC");
$queryMovimentacaoConteiner->execute();

$queryMovimentacaoManual = $connect->prepare("SELECT A.HANDLE, 
													 A.STATUS STATUS,
													 A.NUMERO NUMERO,
													 A.DATA DATA, 
													 B1.SIGLA FILIAL,
													 B5.NOME TIPOOPERACAO,
													 B4.NOME FINALIDADE, 
													 B3.POSICAO LOCALIZACAO,
													 B7.RESOURCENAME
												FROM PA_MOVIMENTACAOMANUAL A  
												LEFT JOIN PA_STATUSMOVIMENTACAOMANUAL B0 ON       A.STATUS = B0.HANDLE 
												LEFT JOIN MS_FILIAL B1 ON A.FILIAL = B1.      HANDLE 
												LEFT JOIN PA_TIPOMOVIMENTACAOMANUAL B2 ON A.      TIPO = B2.HANDLE 
												LEFT JOIN PA_TERMINALLOCALIZACAO B3 ON A.      LOCALIZACAO = B3.HANDLE 
												LEFT JOIN PA_FINALIDADEMOVIMENTACAO B4 ON B4.      HANDLE = B2.FINALIDADE
												LEFT JOIN PA_TIPOOPERACAO B5 ON B5.HANDLE =       B2.TIPOOPERACAO
												LEFT JOIN PA_STATUSMOVIMENTACAOMANUAL B6 ON B6.HANDLE = A.STATUS
												LEFT JOIN MD_IMAGEM B7 ON B7.HANDLE = B6.IMAGEM
											   WHERE A.CONTEINER = '" . $conteiner . "'  
									           ORDER BY A.DATA DESC
									        ");
$queryMovimentacaoManual->execute();