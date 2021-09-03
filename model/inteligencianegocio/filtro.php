<?php
	include_once('../../controller/tecnologia/BancoDados.php');	
    include_once('../../controller/tecnologia/Sistema.php');
        
	include_once('../../model/inteligencianegocio/constantes.php');
    include_once('../../model/inteligencianegocio/sql.php');
   
	date_default_timezone_set('America/Sao_Paulo');	

    class Filtro {
        
        protected $connect;

		function __construct() {
            $this->connect = Sistema::getConexao(false);
        }

        public function getEstrutura($painel) {
			$filtros = array();
            
            $query = $this->connect->prepare("SELECT A.CONDICAO CONDICAO,
                                                     A.EHOBRIGATORIO EHOBRIGATORIO,
                                                     A.FORMATODATA FORMATODATA,
                                                     A.FORMATOHORA FORMATOHORA,
                                                     A.HANDLE HANDLE,
                                                     A.NOME NOME,
                                                     A.SEQUENCIAL SEQUENCIAL,
                                                     A.TIPO TIPO,
                                                     A.TIPODATA TIPODATA,
                                                     A.TITULO TITULO,
                                                     A.VALORPADRAODATA VALORPADRAODATA,
                                                     A.VALORPADRAONUMERICOATE VALORPADRAONUMERICOATE,
                                                     A.VALORPADRAONUMERICODE VALORPADRAONUMERICODE,
                                                     A.VALORPADRAOTABELA VALORPADRAOTABELA,
                                                     A.VALORPADRAOTEXTO VALORPADRAOTEXTO,

                                                     C.HANDLE TABELAHANDLE,
                                                     C.NOME TABELANOME,

                                                     (SELECT MAX(Z.HANDLE)
                                                        FROM BI_COMPONENTEFILTROREGISTRO Z
                                                       WHERE Z.COMPONENTEFILTRO = A.HANDLE
                                                         AND Z.EHVALORPADRAO = 'S') VALORPADRAOLISTA
															
												FROM BI_COMPONENTEFILTRO A
													
											   INNER JOIN BI_COMPONENTE B ON B.HANDLE = A.COMPONENTE
                                                LEFT JOIN MD_TABELA C ON C.HANDLE = A.TABELA
                                               
                                               INNER JOIN MS_STATUS D ON D.HANDLE = ". Constantes::StatusAtivo ."

											   WHERE A.STATUS = D.HANDLE
                                                 AND B.STATUS = D.HANDLE

												 AND EXISTS (SELECT Z.HANDLE FROM BI_PAINELCOMPONENTE Z WHERE Z.PAINEL = :PAINEL AND Z.COMPONENTE = B.HANDLE)

											   ORDER BY TITULO");

			$query->bindParam(":PAINEL", $painel, PDO::PARAM_INT);	
			$query->execute();		

			while ($queryItem = $query->fetch(PDO::FETCH_OBJ)) {
                if (!key_exists($queryItem->NOME, $filtros)) {
                    $filtro = array(
                        "ehobrigatorio" => $queryItem->EHOBRIGATORIO == "S",
                        "nome" => $queryItem->NOME,
                        "tipo" => intval($queryItem->TIPO),
                        "titulo" => $queryItem->TITULO
                    );

                    switch ($queryItem->TIPO) {
                        case Constantes::ComponenteTipoFiltroData:
                            $filtro["data"] = array(
                                "formatacao" => $this->getEstruturaFormatacaoData($queryItem),
                                "valorinicial" => $this->getValorData($queryItem, true),
                                "valorfinal" => $this->getValorData($queryItem, false),
                            );

                            break;

                        case Constantes::ComponenteTipoFiltroLista:
                            $campos = $this->getEstruturaCampoTabela(7408);
                            $sql = $this->getEstruturaSqlTabela("BI_COMPONENTEFILTROREGISTRO", $campos, " AND A.COMPONENTEFILTRO = " . $queryItem->HANDLE);

                            $filtro["tabela"] = array(
                                "valorhandle" => intval($queryItem->VALORPADRAOLISTA),
                                "valordescricao" => $this->getEstruturaValorDescricaoTabela($sql, $campos, intval($queryItem->VALORPADRAOLISTA)),
                                "sql" => strtr(base64_encode(gzcompress($sql)), "+/=", "-_,"),
                                "campo" => $campos
                            );

                            break;

                        case Constantes::ComponenteTipoFiltroNumerico:
                            $filtro["numerico"] = array(
                                "formato" => "#.##0,0000",
                                "valorinicial" => doubleval($queryItem->VALORPADRAONUMERICODE),
                                "valorfinal" => doubleval($queryItem->VALORPADRAONUMERICOATE)
                            );

                            break;

                        case Constantes::ComponenteTipoFiltroTabela:
                            $campos = $this->getEstruturaCampoTabela($queryItem->TABELAHANDLE);
                            $sql = $this->getEstruturaSqlTabela($queryItem->TABELANOME, $campos, $queryItem->CONDICAO);
                            $valordescricao = $this->getEstruturaValorDescricaoTabela($sql, $campos, intval($queryItem->VALORPADRAOTABELA));

                            $filtro["tabela"] = array(
                                "valorhandle" => $valordescricao != "" ? intval($queryItem->VALORPADRAOTABELA) : 0,
                                "valordescricao" => $valordescricao,
                                "sql" => strtr(base64_encode(gzcompress($sql)), "+/=", "-_,"),
                                "campo" => $campos
                            );

                            break;

                        case Constantes::ComponenteTipoFiltroTexto:
                            $filtro["texto"] = array(
                                "valor" => $queryItem->VALORPADRAOTEXTO
                            );

                            break;
                    }

                    $filtros[$queryItem->NOME] = $filtro;
                }
            }
	
			return array_values($filtros);
		}

        private function getEstruturaFormatacaoData($queryItem) {
			$formatacao = array(
                "exibicao" => "",
                "validacao" => "",
                "sugestao" => ""
            );

            if (in_array($queryItem->TIPODATA, [Constantes::ComponenteFiltroTipoDataData, Constantes::ComponenteFiltroTipoDataDataHora])) {
				if ($queryItem->FORMATODATA == Constantes::ComponenteFiltroFormatoDataDiaMesAno) {
					$formatacao["exibicao"] .= 'DD/MM/AAAA';
                    $formatacao["validacao"] .= "DD/MM/YYYY";
                    $formatacao["sugestao"] .= "##/##/####";
				}
				else {
                    $formatacao["exibicao"] .= 'MM/AAAA';
                    $formatacao["validacao"] .= "MM/YYYY";
                    $formatacao["sugestao"] .= "##/####";
				}
	
				if ($queryItem->TIPODATA == Constantes::ComponenteFiltroTipoDataDataHora) {
					$formatacao["exibicao"] .= " ";
                    $formatacao["validacao"] .= " ";
                    $formatacao["sugestao"] .= " ";
				}
			}
	
			if (in_array($queryItem->TIPODATA, [Constantes::ComponenteFiltroTipoDataDataHora, Constantes::ComponenteFiltroTipoDataHora])) {
				if ($queryItem->FORMATOHORA == Constantes::ComponenteFiltroFormatoHoraHoraMinutoSegundo) {
					$formatacao["exibicao"] .= 'HH:mm:ss';
                    $formatacao["validacao"] .= "HH:mm:ss";
                    $formatacao["sugestao"] .= "##:##:##";
				}
				else {
					$formatacao["exibicao"] .= 'HH:mm';
                    $formatacao["validacao"] .= "HH:mm";
                    $formatacao["sugestao"] .= "##:##";
				}
			}

            return $formatacao;
        }

        private function getEstruturaCampoTabela($tabela) {
            $campos = array();
			
			$tamanhoTotal = 0;
			
			$query = $this->connect->prepare('SELECT B.ORDEM ORDEM, 

													 C.DESCRICAO DESCRICAO,
													 C.NOME NOME,
													 C.TAMANHOSTRING TAMANHOSTRING,
													 C.TIPOCAMPO TIPOCAMPO

												FROM MD_TABELA A 
											    
												LEFT JOIN MD_TABELALOOKUP B ON B.TABELA = A.HANDLE AND B.TRADUCAO IS NULL
											    LEFT JOIN MD_CAMPO C ON C.HANDLE = B.CAMPO

											   WHERE A.HANDLE = :TABELA
											   
                                               ORDER BY ORDEM');
	
			$query->bindParam(':TABELA', $tabela, PDO::PARAM_INT);
			$query->execute();

			while ($queryItem = $query->fetch(PDO::FETCH_OBJ)) {			
                $tamanho = 150;
                
                switch ($queryItem->TIPOCAMPO) {
					case Constantes::ComponenteTipoCampoData:
						$tamanho = 110;

						break;

					case Constantes::ComponenteTipoCampoDuracao:
					case Constantes::ComponenteTipoCampoInteiro:
					case Constantes::ComponenteTipoCampoInteiro_Contador:
					case Constantes::ComponenteTipoCampoInteiro_Sequencial:
					case Constantes::ComponenteTipoCampoNumerico:
					case Constantes::ComponenteTipoCampoTabela:
						$tamanho = 85;

						break;
	
					case Constantes::ComponenteTipoCampoArquivo:
						$tamanho = 150;

						break;

					
					case Constantes::ComponenteTipoCampoImagem_GRID:
					case Constantes::ComponenteTipoCampoLogico:	
						$tamanho = 60;

						break;					

					case Constantes::ComponenteTipoCampoTipoString:
						$tamanho = intval($queryItem->TAMANHOSTRING);

						if ($tamanho < 100) {
							$tamanho = 100;
						}

						break;
				}

                $campos[] = array(
                    "nome" => $queryItem->NOME,
                    "titulo" => $queryItem->DESCRICAO,
                    "tamanho" => $tamanho
                );

				$tamanhoTotal += $tamanho;
			}

			if (count($campos) == 0) {
				$campos = array(
                    "nome" => "HANDLE",
                    "titulo" => "Handle",
                    "tamanho" => "100"
                );
			}
			else {
				$tamanhoSaldo = 100;

				foreach($campos as $indice => $campo) {
					if (count($campos) == ($indice + 1)) {
						$campo["tamanho"] = $tamanhoSaldo;
					}
					else {
						$campo["tamanho"] = floor(($campo["tamanho"] / $tamanhoTotal) * 100);
						$tamanhoSaldo -= $campo["tamanho"];
					}
				}
			}

			return $campos;
        }

        private function getEstruturaSqlTabela($tabela, $campos, $condicao) {
            $sql = "SELECT TOP 1000 A.HANDLE HANDLE ";

            foreach($campos as $campo) {
                $sql .= ", A." . $campo["nome"] . " " . $campo["nome"];
            }

            $sql .= " FROM " . $tabela . " A WHERE 1 = 1 ";

            if ($condicao != "") {
                $sql .= " " . $condicao . " ";
            }

            return SQL::parse($sql, "");
        }

        private function getEstruturaValorDescricaoTabela($sql, $campos, $handle) {
            if ($handle == 0) {
                return "";
            }

            $valorDescicao = "";

            $query = $this->connect->prepare($sql . " AND A.HANDLE = " . $handle);
            $query->execute();

            if ($queryItem = $query->fetch(PDO::FETCH_ASSOC)) {                
                foreach ($campos as $campo) {
                    if ($valorDescicao != "") {
                        $valorDescicao .= " - ";	
                    }
    
                    $valorDescicao .= $queryItem[$campo["nome"]];
                }
            }

            return $valorDescicao;
        }       

        private function getValorData($queryItem, $valorInicial) {
            $valor = null;

            switch ($queryItem->VALORPADRAODATA) {
                case Constantes::ComponenteFiltroTipoValorPadraoDiaAtual:
                    if ($valorInicial) {
                        $valor = (new datetime(date('Y-m-d')))->format("Y/m/d H:i");
                    }
                    else {
                        $valor = (new datetime(date('Y-m-d 23:59:00')))->format("Y/m/d H:i");
                    }

                    break;
            
                case Constantes::ComponenteFiltroTipoValorPadraoSemanaAtual:
                    $valorPadraoData = new DateTime();

                    if ($valorInicial) {
                        $valor = $valorPadraoData->modify('monday this week 00:00:00')->format("Y/m/d H:i");
                    }
                    else {
                        $valor = $valorPadraoData->modify('sunday this week 23:59:00')->format("Y/m/d H:i");
                    }
                    
                    break;
                
                case Constantes::ComponenteFiltroTipoValorPadraoMesAtual:
                    if ($valorInicial) {
                        $valor = (new datetime(date('Y-m-1')))->format("Y/m/d H:i");
                    }
                    else {
                        $valor = (new datetime(date('Y-m-t 23:59:00')))->format("Y/m/d H:i");
                    }

                    break;
                
                case Constantes::ComponenteFiltroTipoValorPadraoAnoAtual:
                    if ($valorInicial) {
                        $valor = (new datetime(date('Y-1-1')))->format("Y/m/d H:i");
                    }
                    else {
                        $valor = (new datetime(date('Y-12-31 23:59:00')))->format("Y/m/d H:i");
                    }
                    
                    break;
                
                default:
                    if ($valorInicial) {
                        $valorPadraoData = (new datetime(date('1899-12-01 00:00:00')))->format("Y/m/d H:i");
                    }
                    else {
                        $valorPadraoData = (new datetime(date('1899-12-01 00:00:00')))->format("Y/m/d H:i");
                    }
                
                    break;
            }  
            
            return $valor;
        }

        public function getValorTabela($parametro) {
            $registro = array();
            
            $parametro->sql = $parametro->sql != null ? gzuncompress(base64_decode(strtr($parametro->sql, "-_,", "+/="))) : null;

            if ($parametro->condicao != "") {
                $condicao = "";

                foreach ($parametro->campo as $campo) {
                    if ($condicao != "") {
                        $condicao .= " OR ";	
                    }
    
                    $condicao .= " (A.". $campo->nome . " LIKE :" . $campo->nome. ")";
                }

                $parametro->sql .= "AND (" . $condicao . ")";
            }

			if ($parametro->campoorderby != "") {
				$parametro->sql .= " ORDER BY " . $parametro->campoorderby;
			}
			else {
				$parametro->sql .= " ORDER BY 1";

                if (count($parametro->campo) > 0) {
                    $parametro->campoorderby = $parametro->campo[0]->nome;
                }
			}  
            
			if (!$parametro->orderbyasc) {
				$parametro->sql .= " DESC ";
			}

			$query = $this->connect->prepare($parametro->sql);	

            if ($parametro->condicao != "") {
				$condicao = "%" . $parametro->condicao . "%";

                foreach ($parametro->campo as $campo) {
					$query->bindParam(':'. $campo->nome, $condicao, PDO::PARAM_STR);
				}
			}

			$query->execute();

            while ($queryItem = $query->fetch(PDO::FETCH_ASSOC)) {
                $traducao = "";
                $valor = array();

                foreach ($parametro->campo as $campo) {
                    if ($traducao != "") {
                        $traducao .= " - ";	
                    }
    
                    $traducao .= $queryItem[$campo->nome];
                    $valor[$campo->nome] = $queryItem[$campo->nome];
                }

                $registro[] = array(
                    "handle" => intval($queryItem["HANDLE"]),
                    "traducao" => $traducao,
                    "valor" => $valor
                );
            }

            return array(
                "campoorderby" => $parametro->campoorderby != "" ? $parametro->campoorderby : "",
                "orderbyasc" => $parametro->orderbyasc,
                "registro" => $registro);
        }
	}
?>