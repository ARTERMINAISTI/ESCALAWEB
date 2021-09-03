<?php
	include_once('../../controller/tecnologia/BancoDados.php');	
    include_once('../../controller/tecnologia/Sistema.php');
        
    include_once('../../model/inteligencianegocio/constantes.php');
    include_once('../../model/inteligencianegocio/sql.php');

    include_once('../../model/inteligencianegocio/tabela.php');
    
	date_default_timezone_set('America/Sao_Paulo');	

    class Grafico extends Tabela {
		
        public function getEstrutura($componente) {
            return array(
                "ehexibirlegenda" => $componente->EHEXIBIRLEGENDAGRAFICO === "S",
                "ehexibirvalor" => $componente->EHEXIBIRVALORGRAFICO === "S", 
                "sql" => SQL::parse($componente->SQLCOMUM, $componente->SQLORACLE),
                "tipo" => intval($componente->TIPOGRAFICO),                
                "campo" => $this->getEstruturaCampoSQL($componente),
                "cor" => $this->getEstruturaCor($componente)
            );
        }

        private function getEstruturaCor($componente) {
			$cores = null;
            
            $query = $this->connect->prepare("SELECT A.ORDEM ORDEM,

													 B.VALORRGB COR
															
												FROM BI_COMPONENTECOR A

											    LEFT JOIN MS_COR B ON B.HANDLE = A.COR

											   WHERE A.COMPONENTE = :COMPONENTE

											   ORDER BY ORDEM");

			$query->bindParam(":COMPONENTE", $componente->HANDLE, PDO::PARAM_INT);	
			$query->execute();		
            
            while ($queryItem = $query->fetch(PDO::FETCH_OBJ)) {
                $cores[] = array(
                    "nome" => "rgb(" . $queryItem->COR . ")"
                );
            }

            if (!isset($cores)) {
                $cores = array(
                    array("nome" => "rgb(0,0,0)"),
                    array("nome" => "rgb(153,51,102)"),
                    array("nome" => "rgb(0,0,255)"),
                    array("nome" => "rgb(102,0,102)"),
                    array("nome" => "rgb(112,112,112)"),
                    array("nome" => "rgb(0,128,0)"),
                    array("nome" => "rgb(128,0,128)"),
                    array("nome" => "rgb(0,0,128)"),
                    array("nome" => "rgb(179,8,14)"),
                    array("nome" => "rgb(255,0,255)"),
                    array("nome" => "rgb(68,102,163)"),
                    array("nome" => "rgb(29,123,99)"),
                    array("nome" => "rgb(43,64,107)"),
                    array("nome" => "rgb(128,0,0)"),
                    array("nome" => "rgb(0,102,204)"),
                    array("nome" => "rgb(255,0,255)"),
                    array("nome" => "rgb(0,255,128)"),
                    array("nome" => "rgb(0,128,128)"),
                    array("nome" => "rgb(201,60,12)"),
                    array("nome" => "rgb(37,149,169)"),
                    array("nome" => "rgb(243,156,53)"),
                    array("nome" => "rgb(255,153,204)"),
                    array("nome" => "rgb(78,151,168)"),
                    array("nome" => "rgb(0,255,255)"),
                    array("nome" => "rgb(255,128,128)"),
                    array("nome" => "rgb(242,192,93)"),
                    array("nome" => "rgb(93,183,158)"),
                    array("nome" => "rgb(153,153,255)")
                );
            }

			return $cores;
        }

        public function getValor($componente) {
            if (!isset($componente->grafico)) {
                return;
            }
            
            $componente->grafico->eixox = [];
            $componente->grafico->eixoy["valorfinal"] = 0;
            $componente->grafico->legenda = [];
            $componente->grafico->serie = [];

            $this->processarQuery($componente);

            return array(
                "ehexibirlegenda" => $componente->grafico->ehexibirlegenda,
                "tipo" => $componente->grafico->tipo,
                "eixox" => $componente->grafico->eixox,
                "eixoy" => $componente->grafico->eixoy,
                "legenda" => $componente->grafico->legenda,
                "serie" => $componente->grafico->serie
            );
        }

        private function getValorEixo($queryItem, $campo, $eixoCampo) {
            $valor = "";
            
            foreach ($eixoCampo as $indice) {
                if ($valor != ""){
                    $valor .= " - ";
                }

                if ($queryItem[$campo[$indice]->sequencial] != "") {
                    switch ($campo[$indice]->tipo) {
                        case Constantes::ComponenteTipoCampoNumerico:
                            $valor .= number_format($queryItem[$campo[$indice]->sequencial], $this->getEstruturaFormatacaoPHP($campo[$indice]->tipo, $campo[$indice]->formatacao), ',', '.');

                            break;

                        case Constantes::ComponenteTipoCampoData:
                            $valor .= (new DateTime($queryItem[$campo[$indice]->sequencial]))->format($this->getEstruturaFormatacaoPHP($campo[$indice]->tipo, $campo[$indice]->formatacao));

                            break;
                        default:
                            $valor .= $queryItem[$campo[$indice]->sequencial];

                            break;
                    }
                }
            }

            return $valor;
        }

        private function processarQuery($componente) {
            $eixoXCampo = array_keys(array_column($componente->grafico->campo, "formautilizacao"), Constantes::ComponenteCampoFormaUilizacaoEixoX);
			$eixoYCampo = array_keys(array_column($componente->grafico->campo, "formautilizacao"), Constantes::ComponenteCampoFormaUilizacaoEixoY);
			$eixoZCampo = array_keys(array_column($componente->grafico->campo, "formautilizacao"), Constantes::ComponenteCampoFormaUilizacaoEixoZ);
            
            $query = SQL::solverToArray($componente->grafico->sql, $componente->filtro);

            foreach ($query as $queryIndice => $queryItem) {
               
                $eixoXLegenda = $this->getValorEixo($queryItem, $componente->grafico->campo, $eixoXCampo);
                $eixoZLegenda = $this->getValorEixo($queryItem, $componente->grafico->campo, $eixoZCampo);

                if (!key_exists($eixoXLegenda, $componente->grafico->eixox)) {
                    $componente->grafico->eixox[$eixoXLegenda] = array(
                        "EIXOX" => $eixoXLegenda
                    );
                }

                foreach ($eixoYCampo as $eixoYCampoIndice) {					
					if ((count($eixoZCampo) == 0) || (count($eixoYCampo) > 1)) {
						$eixoYLegenda = $componente->grafico->campo[$eixoYCampoIndice]->titulo;

						if ($eixoZLegenda != "") {
							$eixoYLegenda = $eixoZLegenda . " - " . $eixoYLegenda;
						}
					}
					else {
						$eixoYLegenda = $eixoZLegenda;
					}					
                    
                    $eixoYValor = 0;

                    switch ($componente->grafico->campo[$eixoYCampoIndice]->tipo) {
						case Constantes::ComponenteTipoCampoInteiro:
						case Constantes::ComponenteTipoCampoNumerico:                           

							$eixoYValor = doubleval($queryItem[$componente->grafico->campo[$eixoYCampoIndice]->sequencial]);

							break;
					}

                    if ($eixoYLegenda != "") {
                        if (!key_exists($eixoYLegenda, $componente->grafico->serie)) {
                            $componente->grafico->serie[$eixoYLegenda] = array(
                                "ehexibirvalor" => $componente->grafico->ehexibirvalor,
                                "nome" => "SERIE_" . count($componente->grafico->serie),
                                "formatacao" => $componente->grafico->campo[$eixoYCampoIndice]->formatacao,
                                "legenda" => $eixoYLegenda
                            );
                        }

                        if (!key_exists($componente->grafico->serie[$eixoYLegenda]["nome"], $componente->grafico->eixox[$eixoXLegenda])) {
                            $componente->grafico->eixox[$eixoXLegenda][$componente->grafico->serie[$eixoYLegenda]["nome"]] = $eixoYValor;
                        }
                        else {
                            $componente->grafico->eixox[$eixoXLegenda][$componente->grafico->serie[$eixoYLegenda]["nome"]] += $eixoYValor;
                        }

                        $componente->grafico->eixoy["valorfinal"] = max($componente->grafico->eixoy["valorfinal"], $eixoYValor);
                    }
				}                
            }

            ksort($componente->grafico->eixox);

            $componente->grafico->eixox = array_values($componente->grafico->eixox);
            $componente->grafico->serie = array_values($componente->grafico->serie);

            $indiceCorAtual = 0;

            if (count($componente->grafico->serie) > 1) {
                foreach ($componente->grafico->serie as $indice => $serie) {
                    $componente->grafico->serie[$indice]["cor"] = "rgb(black)";

                    if (count($componente->grafico->cor) > 0) {
                        if ($indiceCorAtual >= count($componente->grafico->cor)) {
                            $indiceCorAtual = 0;                        
                        }

                        $componente->grafico->serie[$indice]["cor"] = $componente->grafico->cor[$indiceCorAtual]->nome;

                        $indiceCorAtual = $indiceCorAtual + 1;
                    }
                }
            } 
            else {               
                foreach ($componente->grafico->eixox as $indice => $eixox) {
                    $componente->grafico->eixox[$indice]["cor"] = "rgb(black)";

                    if (count($componente->grafico->cor) > 0) {
                        if ($indiceCorAtual >= count($componente->grafico->cor)) {
                            $indiceCorAtual = 0;                        
                        }

                        $componente->grafico->eixox[$indice]["cor"] = $componente->grafico->cor[$indiceCorAtual]->nome;

                        $indiceCorAtual = $indiceCorAtual + 1;
                    }
                }
            }
        }  
    }
?>
