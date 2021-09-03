<?php
	include_once('../../controller/tecnologia/BancoDados.php');	
    include_once('../../controller/tecnologia/Sistema.php');
        
    include_once('../../model/inteligencianegocio/constantes.php');
    include_once('../../model/inteligencianegocio/sql.php');

    include_once('../../model/inteligencianegocio/componente.php');
    
	date_default_timezone_set('America/Sao_Paulo');	

    class Medidor extends Componente {

		public function getEstrutura($componente) {
            return array(
                "organizarregistro" => intval($componente->ORGANIZARREGISTRO),
                "quantidaderegirstro" => intval($componente->QUANTIDADEREGISTRO),
                "item" => $this->getEstruturaItem($componente)
            );
        }

        private function getEstruturaItem($componente) {
            $itens = array();
            $grupos = $this->getEstruturaItemGrupo($componente);
            
            $query = $this->connect->prepare("SELECT A.*
                                                FROM BI_COMPONENTEMEDIDOR A 
                                               WHERE A.COMPONENTE = :COMPONENTE
                                                 AND A.STATUS = " . Constantes::StatusAtivo. "
                                               ORDER BY ORDEM");

            $query->bindParam("COMPONENTE", $componente->HANDLE, PDO::PARAM_INT);	
            $query->execute();

            while ($queryItem = $query->fetch(PDO::FETCH_OBJ)) {
                $itens[] = array(
                    "ehdestacar" => $queryItem->EHDESTACAR === "S", 
                    "ehexibirborda" => $queryItem->EHEXIBIRBORDA === "S", 
                    "ehexibirescala" => $queryItem->EHEXIBIRESCALADEVALOR === "S", 
                    
                    "titulo" => array(
                        "alinhamento" => intval($queryItem->ALINHAMENTOTITULO),
                        "ehexibir" => $queryItem->EHEXIBIRTITULO === "S", 
                        "fonte" => intval($componente->FONTETITULOMEDIDOR + Constantes::TamanhoFonteAuxiliar),
                        "valorfixo" => $queryItem->TITULOFIXO, 
                        "valorvariavel" => SQL::parse($queryItem->SQLTITULOVARIAVEL, "")                        
                    ),

                    "valor" => array(
                        "escalainicial" => doubleval($queryItem->VALORINICIAL),
                        "escalafinal" => doubleval($queryItem->VALORFINAL),
                        "formatacao" => $this->getEstruturaFormatacaoJS(Constantes::ComponenteTipoCampoNumerico, $queryItem->FORMATACAO), 
                        "sql" => SQL::parse($queryItem->SQLCOMUMVALOR, $queryItem->SQLORACLEVALOR) 
                    ),
                    
                    "grupo" => key_exists($queryItem->HANDLE, $grupos) ? $grupos[$queryItem->HANDLE] : null
                );
            }            

            return $itens;
        }  

        private function getEstruturaItemGrupo($componente) {
            $grupos = array();

			$query = $this->connect->prepare("SELECT A.TITULO TITULO,
												     A.VALORINICIAL VALORINICIAL,
													 A.VALORFINAL VALORFINAL,

													 A.COMPONENTEMEDIDOR COMPONENTEMEDIDOR, 

													 C.VALORRGB COR
															
												FROM BI_COMPONENTEMEDIDORGRUPO A

											   INNER JOIN BI_COMPONENTEMEDIDOR B ON B.HANDLE = A.COMPONENTEMEDIDOR

											    LEFT JOIN MS_COR C ON C.HANDLE = A.COR

											   WHERE B.COMPONENTE = :COMPONENTE
												 AND B.STATUS = " . Constantes::StatusAtivo. "

											   ORDER BY VALORINICIAL");

			$query->bindParam(":COMPONENTE", $componente->HANDLE, PDO::PARAM_INT);	
			$query->execute();	

            while ($queryItem = $query->fetch(PDO::FETCH_OBJ)) {
                $grupos[$queryItem->COMPONENTEMEDIDOR][] = array(
                    "cor" => "rgb(" . $queryItem->COR . ")",
                    "titulo" => $queryItem->TITULO,
                    "valorinicial" => doubleval($queryItem->VALORINICIAL),
                    "valorfinal" => doubleval($queryItem->VALORFINAL)
                );
            }

            return $grupos;
        }

        public function getValor($componente) {
            if (!isset($componente->medidor)) {
                return;
            }

            return array(
                "organizarregistro" => $componente->medidor->organizarregistro,
                "quantidaderegirstro" => $componente->medidor->quantidaderegirstro,
                "item" => $this->getValorItem($componente)
            );
        }

        private function getValorItem($componente) {
            if (!isset($componente->medidor->item)) {
                return;
            }

            $valores = array();

            foreach ($componente->medidor->item as $indice => $item) {
                
                $valores[] = array(
                    "ehdestacar" => $item->ehdestacar,
                    "ehexibirborda" => $item->ehexibirborda,
                    "ehexibirescala" => $item->ehexibirescala,
                    "titulo" => $this->getValorTitulo($item, $componente->filtro),
                    "valor" => array(
                        "escalainicial" => $item->valor->escalainicial,
                        "escalafinal" => $item->valor->escalafinal,
                        "formatacao" => $item->valor->formatacao,
                        "valor" => SQL::solverToNumber($item->valor->sql, $componente->filtro)
                    ),
                    "grupo" => $item->grupo
                );
            }

            return $valores;
        }
	}
?>