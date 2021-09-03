<?php
	include_once('../../controller/tecnologia/BancoDados.php');	
    include_once('../../controller/tecnologia/Sistema.php');
        
    include_once('../../model/inteligencianegocio/constantes.php');
    include_once('../../model/inteligencianegocio/sql.php');

    include_once('../../model/inteligencianegocio/componente.php');
    
	date_default_timezone_set('America/Sao_Paulo');	

    class Indicador extends Componente {

		public function getEstrutura($componente) {
            return array(
                "organizarregistro" => intval($componente->ORGANIZARREGISTRO),
                "quantidaderegirstro" => intval($componente->QUANTIDADEREGISTRO),
                "item" => $this->getEstruturaItem($componente)
            );
        }

        private function getEstruturaItem($componente) {
            $itens = array();
            $marcadores = $this->getEstruturaItemMarcador($componente);
            
            $query = $this->connect->prepare("SELECT A.*
                                                FROM BI_COMPONENTEINDICADOR A 
                                               WHERE A.COMPONENTE = :COMPONENTE
                                                 AND A.STATUS = " . Constantes::StatusAtivo. "
                                               ORDER BY ORDEM");

            $query->bindParam("COMPONENTE", $componente->HANDLE, PDO::PARAM_INT);	
            $query->execute();

            while ($queryItem = $query->fetch(PDO::FETCH_OBJ)) {
                $itens[] = array(
                    "ehdestacar" => $queryItem->EHDESTACAR === "S", 
                    "ehexibirborda" => $queryItem->EHEXIBIRBORDA === "S", 
                    
                    "titulo" => array(
                        "alinhamento" => intval($queryItem->ALINHAMENTOTITULO),
                        "ehexibir" => $queryItem->EHEXIBIRTITULO === "S", 
                        "fonte" => intval($componente->FONTETITULOINDICADOR + Constantes::TamanhoFonteAuxiliar),
                        "valorfixo" => $queryItem->TITULOFIXO, 
                        "valorvariavel" => SQL::parse($queryItem->SQLTITULOVARIAVEL, "")                        
                    ),

                    "valor" => array(
                        "alinhamento" => intval($queryItem->ALINHAMENTOVALOR),
                        "fonte" => intval($componente->FONTEVALORINDICADOR + Constantes::TamanhoFonteAuxiliar),
                        "formatacao" => $this->getEstruturaFormatacaoJS($queryItem->TIPOVALOR, $queryItem->FORMATACAO), 
                        "sql" => SQL::parse($queryItem->SQLCOMUMVALOR, $queryItem->SQLORACLEVALOR),
                        "tipo" => intval($queryItem->TIPOVALOR)
                    ),
                    
                    "marcador" => key_exists($queryItem->HANDLE, $marcadores) ? $marcadores[$queryItem->HANDLE] : null
                );
            }            

            return $itens;
        }  

        private function getEstruturaItemMarcador($componente) {
            $marcadores = array();
            
            $query = $this->connect->prepare("SELECT A.IMAGEM IMAGEM,
                                                     A.ORDEM ORDEM,
                                                     A.REGRA REGRACOMPARACAO,
                                                     A.SQLCOMUMVALORVARIAVEL SQLCOMUMVALORVARIAVEL,
                                                     A.SQLORACLEVALORVARIAVEL SQLORACLEVALORVARIAVEL,
                                                     A.TIPOVALOR TIPOVALOR,
                                                     A.VALORFIXODATA VALORFIXODATA,
                                                     A.VALORFIXONUMERICO VALORFIXONUMERICO,
                                                     A.VALORFIXOTEXTO VALORFIXOTEXTO,

                                                     A.COMPONENTEINDICADOR COMPONENTEINDICADOR, 

                                                     B.TIPOVALOR TIPOVALORINDICADOR, 

                                                     E.VALORRGB CORFONTE,

                                                     F.VALORRGB CORFUNDO
                                                        
                                                FROM BI_COMPONENTEINDICADORMARCADOR A
                                                
                                               INNER JOIN BI_COMPONENTEINDICADOR B ON B.HANDLE = A.COMPONENTEINDICADOR

                                               INNER JOIN BI_COMPONENTE D ON D.HANDLE = B.COMPONENTE

                                               LEFT JOIN MS_COR E ON E.HANDLE = A.CORFONTE
                                               LEFT JOIN MS_COR F ON F.HANDLE = A.CORFUNDO

                                              WHERE D.HANDLE = :COMPONENTE

                                              ORDER BY ORDEM");

            $query->bindParam("COMPONENTE", $componente->HANDLE, PDO::PARAM_INT);	
            $query->execute();	

            while ($queryItem = $query->fetch(PDO::FETCH_OBJ)) {
                if ($queryItem->TIPOVALOR == Constantes::ComponenteMarcadorTipoComparacaoValorVariavel) {
                    if ($queryItem->TIPOVALORINDICADOR == Constantes::ComponenteTipoCampoTexto) {
                        $valor = SQL::solverToString(SQL::parse($queryItem->SQLCOMUMVALORVARIAVEL, $queryItem->SQLORACLEVALORVARIAVEL), null);
                    }
                    else {
                        $valor = SQL::solverToNumber(SQL::parse($queryItem->SQLCOMUMVALORVARIAVEL, $queryItem->SQLORACLEVALORVARIAVEL), null);
                    }
                }					
                else {
                    switch ($queryItem->TIPOVALORINDICADOR) {
                        case Constantes::ComponenteTipoCampoData:
                            $valor = $queryItem->VALORFIXODATA;

                            break;

                        case Constantes::ComponenteTipoCampoInteiro:
                        case Constantes::ComponenteTipoCampoNumerico:
                            $valor = doubleval($queryItem->VALORFIXONUMERICO);

                            break;                        
                   
                        default:
                            $valor = $queryItem->VALORFIXOTEXTO;

                            break;
                    }			
                }

                $marcadores[$queryItem->COMPONENTEINDICADOR][] = array(
                    "regracomparacao" => intval($queryItem->REGRACOMPARACAO),
                    "corfonte" => $queryItem->CORFONTE,
                    "corfundo" => $queryItem->CORFUNDO,
                    "imagem" => intval($queryItem->IMAGEM),
                    "valorcomparacao" => $valor
                );
            }

            return $marcadores;
        }

        public function getValor($componente) {
            if (!isset($componente->indicador)) {
                return;
            }

            return array(
                "organizarregistro" => $componente->indicador->organizarregistro,
                "quantidaderegirstro" => $componente->indicador->quantidaderegirstro,
                "item" => $this->getValorItem($componente)
            );
        }

        private function getValorItem($componente) {
            if (!isset($componente->indicador->item)) {
                return;
            }

            $valores = array();

            foreach ($componente->indicador->item as $indice => $item) {
                $valor = array(
                    "ehdestacar" => $item->ehdestacar, 
                    "ehexibirborda" => $item->ehexibirborda,                     
                    "titulo" => $this->getValorTitulo($item, $componente->filtro),
                    "valor" => array(
                        "alinhamento" => $item->valor->alinhamento,
                        "tamanhofonte" =>  $item->valor->fonte,
                        "tipo" => $item->valor->tipo
                    )
                );

                switch ($item->valor->tipo) {
                    case Constantes::ComponenteTipoCampoData:	
                        $resultadoSql = SQL::solverToNumber($item->valor->sql, $componente->filtro);

                        $valor["valor"]["formatacao"] = $item->valor->formatacao;
                        $valor["valor"]["valor"] = $resultadoSql != 0 ? (new DateTime($resultadoSql))->format("Y/m/d H:i") : null;

                        break;                            

                    case Constantes::ComponenteTipoCampoInteiro:
                    case Constantes::ComponenteTipoCampoNumerico:
                        $resultadoSql = SQL::solverToNumber($item->valor->sql, $componente->filtro);

                        $valor["valor"]["formatacao"] = $item->valor->formatacao;
                        $valor["valor"]["valor"] = $resultadoSql;

                        break;

                    default:
                        $valor["valor"]["valor"] = SQL::solverToString($item->valor->sql, $componente->filtro);

                        break;
                }

                $marcador = array();

                if (isset($item->marcador)) {
                    foreach ($item->marcador as $item => $marcador) {
                        $achouMarcador = false;

                        switch ($marcador->regracomparacao) {
                            case Constantes::ComponenteMarcadorRegraComparacaoValorDiferente:
                                $achouMarcador = $marcador->valorcomparacao != $valor["valor"]["valor"];
                                break;

                            case Constantes::ComponenteMarcadorRegraComparacaoValorIgualA:
                                $achouMarcador = $marcador->valorcomparacao == $valor["valor"]["valor"];
                                break;

                            case Constantes::ComponenteMarcadorRegraComparacaoValorMenorQue:
                                $achouMarcador = $marcador->valorcomparacao > $valor["valor"]["valor"];
                                break;

                            case Constantes::ComponenteMarcadorRegraComparacaoValorMenorOuIgualA:
                                $achouMarcador = $marcador->valorcomparacao >= $valor["valor"]["valor"];
                                break;

                            case Constantes::ComponenteMarcadorRegraComparacaoValorMaiorQue:
                                $achouMarcador = $marcador->valorcomparacao < $valor["valor"]["valor"];
                                break;
                        
                            case Constantes::ComponenteMarcadorRegraComparacaoValorMaiorOuIgualA:
                                $achouMarcador = $marcador->valorcomparacao <= $valor["valor"]["valor"];
                                break;
                        }	

                        if ($achouMarcador)	{
                            $valor["imagem"] = $marcador->imagem;

                            if ($marcador->corfonte != "") {
                                $valor["corfonte"] = "rgb(" . $marcador->corfonte . ")";
                            }

                            if ($marcador->corfundo != "") {
                                $valor["corfundo"] = "rgb(" . $marcador->corfundo . ")";
                            }

                            break;
                        }					
                    }
                }
                
                $valores[] = $valor;
            }

            return $valores;
        }
	}
?>