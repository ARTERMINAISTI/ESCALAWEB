<?php
	include_once('../../controller/tecnologia/BancoDados.php');	
    include_once('../../controller/tecnologia/Sistema.php');
        
	include_once('../../model/inteligencianegocio/constantes.php');
    include_once('../../model/inteligencianegocio/sql.php');

    include_once('../../model/inteligencianegocio/grafico.php');
    include_once('../../model/inteligencianegocio/indicador.php');
    include_once('../../model/inteligencianegocio/medidor.php');    
    include_once('../../model/inteligencianegocio/tabela.php');
    
	date_default_timezone_set('America/Sao_Paulo');	

    class Componente {

        protected $connect;

		function __construct() {
            $this->connect = Sistema::getConexao(false);
        }

		public function getEstrutura($parametro) {
            $query = $this->connect->prepare("SELECT *                                          
                                                FROM BI_COMPONENTE 
                                               WHERE IDENTIFICADORINTERNO = :IDENTIFICADORINTERNO");
            $query->bindParam(":IDENTIFICADORINTERNO", $parametro->identificador, PDO::PARAM_STR);
            $query->execute();

            $componente = $query->fetch(PDO::FETCH_OBJ);

            if ($componente->STATUS != Constantes::StatusAtivo) {
                return array(
                    "tipo" => intval($componente->TIPO),
                    "estrutura" => null
                );
            }

            $estrutura = array(                
                "handle" => intval($componente->HANDLE),    
                "ehexibirborda" => $componente->EHEXIBIRBORDA === "S",
                "rodape" => $this->getEstruturaRodape($componente), 
                "tipo" => intval($componente->TIPO),
                "titulo" => $this->getEstruturaTitulo($componente)
            );

            switch ($componente->TIPO) {
                case Constantes::ComponenteTipoGrafico:
                    $grafico = new Grafico();

                    $estrutura["grafico"] = $grafico->getEstrutura($componente);

                    break;

                case Constantes::ComponenteTipoIndicadorValor:
                    $indicador = new Indicador();

                    $estrutura["indicador"] = $indicador->getEstrutura($componente);

                    break;

                case Constantes::ComponenteTipoMedidor:
                    $medidor = new Medidor();

                    $estrutura["medidor"] = $medidor->getEstrutura($componente);

                    break;

                case Constantes::ComponenteTipoTabela:
                    $tabela = new Tabela();

                    $estrutura["tabela"] = $tabela->getEstrutura($componente);

                    break;                
            }

            return array(
                "tipo" => intval($componente->TIPO),
                "estrutura" => strtr(base64_encode(gzcompress(serialize(json_encode($estrutura)))), "+/=", "-_,")
            );
		}

        protected function getEstruturaFormatacaoJS($tipo, $formatacao) {
            $valor = "";
            
            switch ($tipo) {
                case Constantes::ComponenteTipoCampoData:
                    $valor = strtoupper($formatacao);
					$valor = str_replace("SS", "ss", $valor);
                    $valor = str_replace("HHMM", "HHmm", $valor);
					$valor = str_replace("HH-MM", "HH-mm", $valor);
					$valor = str_replace("HH:MM", "HH:mm", $valor);
                    
                    break;

                case Constantes::ComponenteTipoCampoInteiro:
                case Constantes::ComponenteTipoCampoNumerico:
                    $valor = $formatacao;
					$valor = str_replace(",", "maistarde", $valor);
                    $valor = str_replace(".", ",", $valor);
					$valor = str_replace("maistarde", ".", $valor);

                    if (!strpos($valor, ",")) {
                        $valor .= ",";
                    }

                    break;

                default:
                    $valor = $formatacao;

                    break;
            }

            return $valor;
        }

        protected function getEstruturaFormatacaoPHP($tipo, $formatacao) {
            $valor = "";
            
			switch ($tipo) {
				case Constantes::ComponenteTipoCampoData:
					$valor = strtoupper($formatacao);
					$valor = str_replace('DD', 'd', $valor);
					$valor = str_replace('YYYY', 'Y', $valor);
					$valor = str_replace('MM', 'm', $valor);
					$valor = str_replace('HHm', 'Hi', $valor);
					$valor = str_replace('HH-m', 'H-i', $valor);
					$valor = str_replace('HH:m', 'H:i', $valor);

					break;

				case Constantes::ComponenteTipoCampoNumerico:
					$valor = strtoupper($formatacao);
					$valor = str_replace('#', '', $valor);
					$valor = str_replace('0.', '', $valor);
					$valor = str_replace('0,', '', $valor);
					$valor = str_replace('.', '', $valor);
					$valor = str_replace(',', '', $valor);
					$valor = str_replace(' ', '', $valor);
					$valor = strlen($valor);

					break;

                default:
                    $valor = $formatacao;

                    break;
			}

			return $valor;
        }

        protected function getEstruturaRodape($componente) {
            return array(
                "alinhamento" => intval($componente->ALINHAMENTORODAPE),
                "ehdestacar" => $componente->EHDESTACARRODAPE === "S", 
                "ehexibir" => $componente->EHEXIBIRRODAPE === "S", 
                "fonte" => intval($componente->FONTERODAPE + Constantes::TamanhoFonteAuxiliar),
                "valorfixo" => $componente->RODAPEFIXO, 
                "valorvariavel" => SQL::parse($componente->SQLRODAPEVARIAVEL, "")
            ); 
        } 

        protected function getEstruturaTitulo($componente) {
            return array(
                "alinhamento" => intval($componente->ALINHAMENTOTITULO),
                "ehdestacar" => $componente->EHDESTACARTITULO === "S", 
                "ehexibir" => $componente->EHEXIBIRTITULO === "S", 
                "fonte" => intval($componente->FONTETITULO + Constantes::TamanhoFonteAuxiliar),
                "valorfixo" => $componente->TITULOFIXO, 
                "valorvariavel" => SQL::parse($componente->SQLTITULOVARIAVEL, "")
            );
        }

        public function getValor($parametro) {
            $componente = $parametro->estrutura != null ? json_decode(unserialize(gzuncompress(base64_decode(strtr($parametro->estrutura, "-_,", "+/="))))) : null;

            $valor = array(
                "rodape" => $this->getValorRodape($componente, $parametro->filtro),
                "titulo" => $this->getValorTitulo($componente, $parametro->filtro)
            );

            if (isset($componente)) {
                $componente->filtro = $parametro->filtro;
                
                $valor["ehexibirborda"] = $componente->ehexibirborda;
                
                switch ($componente->tipo) {
                    case Constantes::ComponenteTipoGrafico:
                        $grafico = new Grafico();
    
                        $valor["corpo"] = $grafico->getValor($componente);
    
                        break;
    
                    case Constantes::ComponenteTipoIndicadorValor:
                        $indicador = new Indicador();
    
                        $valor["corpo"] = $indicador->getValor($componente);
    
                        break;
    
                    case Constantes::ComponenteTipoMedidor:
                        $medidor = new Medidor();
    
                        $valor["corpo"] = $medidor->getValor($componente);
    
                        break;
    
                    case Constantes::ComponenteTipoTabela:
                        $tabela = new Tabela();
    
                        $valor["corpo"] = $tabela->getValor($componente);

                        break;
                    
                    default:
                        $valor["corpo"] = array(
                            "handle" => $componente->handle
                        );

                        break;
                }
            }

            return $valor;
        }

        protected function getValorRodape($componente, $filtros) {
            if ((!isset($componente)) || (!isset($componente->rodape)) || (!$componente->rodape->ehexibir)) {
                return;
            }

            $valor = SQL::solverToString($componente->rodape->valorvariavel, $filtros);

            if ($valor == "") {
                $valor = $componente->rodape->valorfixo;
            }

            return array(
                "alinhamento" => $componente->rodape->alinhamento,
                "ehdestacar" => $componente->rodape->ehdestacar,
                "tamanhofonte" => $componente->rodape->fonte,
                "valor" => $valor
            );            
        }

        protected function getValorTitulo($componente, $filtros) {
            if ((!isset($componente)) || (!isset($componente->titulo)) || (!$componente->titulo->ehexibir)) {
                return;
            }

            $valor = SQL::solverToString($componente->titulo->valorvariavel, $filtros);

            if ($valor == "") {
                $valor = $componente->titulo->valorfixo;
            }

            return array(
                "alinhamento" => $componente->titulo->alinhamento,
                "ehdestacar" => key_exists("ehdestacar", $componente->titulo) ? $componente->titulo->ehdestacar : null,
                "tamanhofonte" => $componente->titulo->fonte,
                "valor" => $valor
            );            
        }
	}
?>