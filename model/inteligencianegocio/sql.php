<?php
    include_once("../../controller/tecnologia/Sistema.php");
    
	date_default_timezone_set("America/Sao_Paulo");

	class SQL
	{
        public static function parse($sqlComum, $sqlOracle) {
			if (($sqlOracle != "") && (Sistema::IsOracle())) {
				$sql = $sqlOracle;
			}
			else {
				$sql = $sqlComum;
			}

			$sql = str_replace("@EMPRESAATUAL", $_SESSION["empresa"], $sql);
			$sql = str_replace("@EMPRESALOGADA", $_SESSION["empresa"], $sql);
			$sql = str_replace("@EMPRESA", $_SESSION["empresa"], $sql);
			
			$sql = str_replace("@FILIALATUAL", $_SESSION["filial"], $sql);
			$sql = str_replace("@FILIALLOGADA", $_SESSION["filial"], $sql);
			$sql = str_replace("@FILIAL", $_SESSION["filial"], $sql);
			
			$sql = str_replace("@PESSOAUSUARIOLOGADO", $_SESSION["pessoa"], $sql);
			
			$sql = str_replace("@USUARIOATUAL", $_SESSION["handleUsuario"], $sql);
			$sql = str_replace("@USUARIOLOGADO", $_SESSION["handleUsuario"], $sql);
			$sql = str_replace("@USUARIO", $_SESSION["handleUsuario"], $sql);
			$sql = str_replace("@TABELA", "A", $sql);

            return $sql;
        }

		public static function solver($sql, $filtros) {
			$connect = Sistema::getConexao(false);

			if (isset($filtros)) {
				foreach ($filtros as $filtro) {
					switch ($filtro->tipo) {
						case Constantes::ComponenteTipoFiltroLista:
						case Constantes::ComponenteTipoFiltroTabela:
							$sql = str_replace("@" . $filtro->nome, $filtro->valor, $sql); 

							break;

						case Constantes::ComponenteTipoFiltroNumerico:
							$sql = str_replace("@" . $filtro->nome . "ATE", $filtro->valorate, $sql); 
							$sql = str_replace("@" . $filtro->nome . "DE", $filtro->valorde, $sql); 

							break;

						case Constantes::ComponenteTipoFiltroData:
							$filtro->quantidadeAte = 0;
							$filtro->quantidadeDe = 0;

							while (strpos($sql, "@" . $filtro->nome . "ATE") !== false) { 
								$filtro->quantidadeAte++;
							
								$sql = substr_replace($sql, ":" . $filtro->nome . "ATE" . $filtro->quantidadeAte, strpos($sql, "@" . $filtro->nome . "ATE"), strlen("@" . $filtro->nome . "ATE")); 
							}
							
							while (strpos($sql, "@" . $filtro->nome . "DE") !== false) { 
								$filtro->quantidadeDe++;
							
								$sql = substr_replace($sql, ":" . $filtro->nome . "DE" . $filtro->quantidadeDe, strpos($sql, "@" . $filtro->nome . "DE"), strlen("@" . $filtro->nome . "DE")); 
							}

							break;


						case Constantes::ComponenteTipoFiltroTexto:						
							$filtro->quantidadeAte = 0;
							$filtro->quantidadeDe = 0;
								
							while (strpos($sql, "@" . $filtro->nome) !== false) { 
								$filtro->quantidadeDe++;
								$sql = substr_replace($sql, ":" . $filtro->nome . $filtro->quantidadeDe, strpos($sql, "@" . $filtro->nome), strlen("@" . $filtro->nome)); 
							}

							break;
					}
				}
			}

			$query = $connect->prepare($sql);

			if (isset($filtros)) {
				foreach ($filtros as $filtro) {
					switch ($filtro->tipo) {
						case Constantes::ComponenteTipoFiltroData:
						case Constantes::ComponenteTipoFiltroTexto:	

							for ($indice = 1; $indice <= $filtro->quantidadeAte; $indice++) {
								$filtro->valorate = Sistema::formataDataHoraMascara($filtro->valorate, Conexao::getMascaraDataHora());
								$query->bindParam(":" . $filtro->nome . "ATE" . $indice, $filtro->valorate, PDO::PARAM_STR);
							}

							for ($indice = 1; $indice <= $filtro->quantidadeDe; $indice++) {
								if ($filtro->tipo == Constantes::ComponenteTipoFiltroData) {
									$filtro->valorde = Sistema::formataDataHoraMascara($filtro->valorde, Conexao::getMascaraDataHora());
									$query->bindParam(":" . $filtro->nome . "DE" . $indice, $filtro->valorde, PDO::PARAM_STR);
								}
								else {
									$query->bindParam(":" . $filtro->nome . $indice, $filtro->valor, PDO::PARAM_STR);
								}
							}
							
							break;
					}
				}
			}

			$query->execute();

			return $query;
		}

		public static function solverToArray($sql, $filtros) {
			if ($sql == "") {
				return null;
			}
			else {
				$valores = array();

				$query = self::solver($sql, $filtros);			
				
				while ($queryItem = $query->fetch(PDO::FETCH_ASSOC)) {
					$linha = array();

					$sequencial = 0;

					foreach ($queryItem as $indice => $item) {
						$linha[$sequencial] = $item;

						$sequencial += 1;
					}

					$valores[] = $linha;
				}

				return $valores;
			}
		}

		public static function solverToNumber($sql, $filtros) {
			if ($sql == "") {
				return 0;
			}
			else {
				$query = self::solver($sql, $filtros);			
				
				$row = $query->fetch(PDO::FETCH_COLUMN, 0);
				
				if (isset($row) > 0) {
					return doubleval($row);
				}
				else {
					return 0;
				}
			}
		}

		public static function solverToString($sql, $filtros) {
			if ($sql == "") {
				return "";
			}
			else {
				$query = self::solver($sql, $filtros);			
				
				$row = $query->fetch(PDO::FETCH_COLUMN, 0);
				
				if (isset($row) > 0) {
					return $row;
				}
				else {
					return "";
				}
			}
		}
    }
?>