<?php
	include_once('../../controller/tecnologia/BancoDados.php');	
    include_once('../../controller/tecnologia/Sistema.php');
        
    include_once('../../model/inteligencianegocio/constantes.php');
    include_once('../../model/inteligencianegocio/sql.php');

    include_once('../../model/inteligencianegocio/componente.php');
    
	date_default_timezone_set('America/Sao_Paulo');	

    class Tabela extends Componente {

		public function getEstrutura($componente) {
            return array(
                "ehexibirdivisorcoluna" => $componente->EHEXIBIRDIVISORCOLUNATABELA === "S", 
                "ehexibirdivisorlinha" => $componente->EHEXIBIRDIVISORLINHATABELA === "S",                
                "sql" => SQL::parse($componente->SQLCOMUM, $componente->SQLORACLE),
                
                "titulo" => array(
                    "ehdestacar" => $componente->EHDESTACARCABECALHOTABELA === "S", 
                    "ehexibir" => $componente->EHEXIBIRCABECALHOTABELA === "S", 
                    "fonte" => intval($componente->FONTECABECALHOTABELA + Constantes::TamanhoFonteAuxiliar),
                ),
                
                "grid" => array(
                    "ehzebrado" => $componente->EHEXIBIRTABELAZEBRADA === "S",
                    "fonte" => intval($componente->FONTEGRIDTABELA + Constantes::TamanhoFonteAuxiliar)                    
                ),
                
                "campo" => $this->getEstruturaCampoSQL($componente)
            );
        }

        protected function getEstruturaCampoSQL($componente) {
            $campos = array();            
            $marcadores = $this->getEstruturaCampoSQLMarcador($componente);
            
            $query = $this->connect->prepare("SELECT A.*
                                                FROM BI_COMPONENTECAMPO A 
                                               WHERE A.COMPONENTE = :COMPONENTE
                                               ORDER BY ORDEM");

            $query->bindParam("COMPONENTE", $componente->HANDLE, PDO::PARAM_INT);	
            $query->execute();

            while ($queryItem = $query->fetch(PDO::FETCH_OBJ)) {
                $campos[] = array(
                    "ehtotalizar" => $queryItem->EHTOTALIZAR == "S",
                    "formatacao" => $componente->TIPO == Constantes::ComponenteTipoGrafico ? $queryItem->FORMATACAO : $this->getEstruturaFormatacaoJS($queryItem->TIPO, $queryItem->FORMATACAO),
                    "formautilizacao" => intval($queryItem->FORMAUTILIZACAO),
                    "handle" => intval($queryItem->HANDLE),
                    "nome" => $queryItem->NOME,
                    "sequencial" => intval($queryItem->SEQUENCIALSQL) - 1,
                    "tamanho" => intval($queryItem->TAMANHO),
                    "tipo" => intval($queryItem->TIPO),
                    "titulo" => $queryItem->TITULO,
                    "marcador" => key_exists($queryItem->HANDLE, $marcadores) ? $marcadores[$queryItem->HANDLE] : null
                );
            }

            return $campos;
        }

        private function getEstruturaCampoSQLMarcador($componente) {
            $marcadores = array();
            
            $query = $this->connect->prepare("SELECT A.ORDEM ORDEM,
                                                     A.REGRA REGRACOMPARACAO,
                                                     A.SQLCOMUMVALORVARIAVEL SQLCOMUMVALORVARIAVEL,
                                                     A.SQLORACLEVALORVARIAVEL SQLORACLEVALORVARIAVEL,
                                                     A.TIPOVALOR TIPOVALOR,
                                                     A.VALORFIXO VALORFIXO,

                                                     B.HANDLE COMPONENTECAMPO,

                                                     C.SEQUENCIALSQL CAMPOCOMPARACAO,

                                                     E.VALORRGB CORFONTE,

                                                     F.VALORRGB CORFUNDO
                                                        
                                                FROM BI_COMPONENTECAMPOMARCADOR A
                                                
                                               INNER JOIN BI_COMPONENTECAMPO B ON B.HANDLE = A.CAMPODESTINO
                                               INNER JOIN BI_COMPONENTECAMPO C ON C.HANDLE = A.CAMPOCOMPARACAO

                                              INNER JOIN BI_COMPONENTE D ON D.HANDLE = B.COMPONENTE AND D.HANDLE = C.COMPONENTE

                                               LEFT JOIN MS_COR E ON E.HANDLE = A.CORFONTE
                                               LEFT JOIN MS_COR F ON F.HANDLE = A.CORFUNDO

                                              WHERE D.HANDLE = :COMPONENTE

                                              ORDER BY ORDEM");

            $query->bindParam("COMPONENTE", $componente->HANDLE, PDO::PARAM_INT);	
            $query->execute();	

            while ($queryItem = $query->fetch(PDO::FETCH_OBJ)) {
                if ($queryItem->TIPOVALOR == Constantes::ComponenteMarcadorTipoComparacaoValorVariavel) {
                    $valor = SQL::solverToNumber(SQL::parse($queryItem->SQLCOMUMVALORVARIAVEL, $queryItem->SQLORACLEVALORVARIAVEL), null);
                }
                else {
                    $valor = doubleval($queryItem->VALORFIXO);
                }

                $marcadores[$queryItem->COMPONENTECAMPO][] = array(
                    "campocomparacao" => intval($queryItem->CAMPOCOMPARACAO) - 1,
                    "regracomparacao" => intval($queryItem->REGRACOMPARACAO),
                    "corfonte" => $queryItem->CORFONTE,
                    "corfundo" => $queryItem->CORFUNDO,
                    "valorcomparacao" => $valor
                );
            }

            return $marcadores;
        }

        public function getValor($componente) {
            if (!isset($componente->tabela)) {
                return;
            }

            $componente->total = [];
           
            return array(
                "ehexibirdivisorcoluna" => $componente->tabela->ehexibirdivisorcoluna,
                "ehexibirdivisorlinha" => $componente->tabela->ehexibirdivisorlinha,               
                "titulo" => $this->getValorTitulo($componente, null),
                "corpo" => $this->getValorCorpo($componente),
                "rodape" => $this->getValorRodape($componente, null)
            );            
        }

        private function getValorCorpo($componente) {
            if (!isset($componente->tabela->grid)) {
                return;
            }

            $linhas = array();

            $query = SQL::solverToArray($componente->tabela->sql, $componente->filtro);

            foreach ($query as $queryIndice => $queryItem) {
				$colunas = array();

                if (isset($componente->tabela->campo)) {
                    foreach ($componente->tabela->campo as $indice => $campo) {
                        if ($campo->formautilizacao != Constantes::ComponenteCampoFormaUilizacaoNaoUtilizar) {
                            $coluna = array(
                                "handle" => $campo->handle,
                                "tamanho" => $campo->tamanho,
                                "tamanhofonte" => $componente->tabela->grid->fonte,
                                "tipo" => $campo->tipo
                            );

                            switch ($campo->tipo) {
                                case Constantes::ComponenteTipoCampoData:                                
                                    $coluna["alinhamento"] = Constantes::AlinhamentoTextoCentro;
                                    $coluna["formatacao"] = $campo->formatacao;
                                    $coluna["valor"] = ($queryItem[$campo->sequencial] != "") && ($queryItem[$campo->sequencial] != null) ? (new DateTime($queryItem[$campo->sequencial]))->format("Y/m/d H:i") : null;

                                    break;                            

                                case Constantes::ComponenteTipoCampoInteiro:
                                    $coluna["alinhamento"] = Constantes::AlinhamentoTextoDireita;
                                    $coluna["valor"] = intval($queryItem[$campo->sequencial]);

                                    break;

                                case Constantes::ComponenteTipoCampoNumerico:
                                    $coluna["alinhamento"] = Constantes::AlinhamentoTextoDireita;
                                    $coluna["formatacao"] = $campo->formatacao;
                                    $coluna["valor"] = doubleval($queryItem[$campo->sequencial]);

                                    break;

                                default:
                                    $coluna["alinhamento"] = Constantes::AlinhamentoTextoEsquerda;
                                    $coluna["valor"] = $queryItem[$campo->sequencial];

                                    break;
                            }

                            if (isset($campo->marcador)) {
                                foreach ($campo->marcador as $marcador) {
                                    $achouMarcador = false;

                                    switch ($marcador->regracomparacao) {
                                        case Constantes::ComponenteMarcadorRegraComparacaoValorDiferente:
                                            $achouMarcador = $marcador->valorcomparacao != $queryItem[$marcador->campocomparacao];
                                            break;
        
                                        case Constantes::ComponenteMarcadorRegraComparacaoValorIgualA:
                                            $achouMarcador = $marcador->valorcomparacao == $queryItem[$marcador->campocomparacao];
                                            break;
        
                                        case Constantes::ComponenteMarcadorRegraComparacaoValorMenorQue:
                                            $achouMarcador = $marcador->valorcomparacao > $queryItem[$marcador->campocomparacao];
                                            break;
        
                                        case Constantes::ComponenteMarcadorRegraComparacaoValorMenorOuIgualA:
                                            $achouMarcador = $marcador->valorcomparacao >= $queryItem[$marcador->campocomparacao];
                                            break;
        
                                        case Constantes::ComponenteMarcadorRegraComparacaoValorMaiorQue:
                                            $achouMarcador = $marcador->valorcomparacao < $queryItem[$marcador->campocomparacao];
                                            break;
                                    
                                        case Constantes::ComponenteMarcadorRegraComparacaoValorMaiorOuIgualA:
                                            $achouMarcador = $marcador->valorcomparacao <= $queryItem[$marcador->campocomparacao];
                                            break;
                                    }	
        
                                    if ($achouMarcador)	{
                                        if ($marcador->corfonte != "") {
                                            $coluna["corfonte"] = "rgb(" . $marcador->corfonte . ")";
                                        }

                                        if ($marcador->corfundo != "") {
                                            $coluna["corfundo"] = "rgb(" . $marcador->corfundo . ")";
                                        }

                                        break;
                                    }
                                }
                            }

                            $colunas[] = $coluna;

                            if ($campo->ehtotalizar) {
                                $componente->total[$campo->sequencial] = !isset($componente->total[$campo->sequencial]) ? $coluna["valor"] : $coluna["valor"] + $componente->total[$campo->sequencial];
                            }
                        }
                    }
                }

                $linhas[] = $colunas;			
			}

			return array(
                "ehzebrado" => $componente->tabela->grid->ehzebrado,
                "valor" => $linhas
            );
        }
        
        protected function getValorRodape($componente, $filtros) {
            if (count($componente->total) === 0) {
                return;
            }

            $colunas = array();

			if (isset($componente->tabela->campo)) {
				foreach ($componente->tabela->campo as $indice => $campo) {
                    if ($campo->formautilizacao != Constantes::ComponenteCampoFormaUilizacaoNaoUtilizar) {
                        $coluna = array(
                            "handle" => $campo->handle,
                            "tamanho" => $campo->tamanho,
                            "tamanhofonte" => $componente->tabela->grid->fonte
                        );

                        if ($campo->ehtotalizar) {
                            switch ($campo->tipo) {
                                case Constantes::ComponenteTipoCampoInteiro:
                                case Constantes::ComponenteTipoCampoNumerico:
                                    $coluna["formatacao"] = $campo->formatacao;
                                    $coluna["valor"] = $componente->total[$campo->sequencial];
                                    
                                    break;
                            } 
                        }
                        else {
                            $coluna["valor"] = $indice === 0 ? "Total" : null;
                        }

                        $colunas[] = $coluna;
                    }
				}
            }

            return array(
                "valor" => $colunas
            );
        }

        protected function getValorTitulo($componente, $filtros) {
            if ((!isset($componente->tabela->titulo)) || (!$componente->tabela->titulo->ehexibir)) {
                return;
            }

            $colunas = array();

			if (isset($componente->tabela->campo)) {
				foreach ($componente->tabela->campo as $indice => $campo) {
                    if ($campo->formautilizacao != Constantes::ComponenteCampoFormaUilizacaoNaoUtilizar) {   
                        switch ($campo->tipo) {
                            case Constantes::ComponenteTipoCampoData:
                            case Constantes::ComponenteTipoCampoInteiro:
                            case Constantes::ComponenteTipoCampoNumerico:
                                $alinhameto = Constantes::AlinhamentoTextoCentro;
                                
                                break;
                        
                            default:
                                $alinhameto = Constantes::AlinhamentoTextoEsquerda;

                                break;
                        } 

                        $colunas[] = array(
                            "alinhamento" => $alinhameto,
                            "handle" => $campo->handle,
                            "tamanho" => $campo->tamanho,
                            "tamanhofonte" => $componente->tabela->titulo->fonte,
                            "tipo" => $campo->tipo,
                            "valor" => $campo->titulo
                        );
                    }
				}
            }

            return array(
                "ehdestacar" => $componente->tabela->titulo->ehdestacar,
                "valor" => $colunas
            );
        }
	}
?>