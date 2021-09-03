<?php
    include_once('../../controller/tecnologia/Sistema.php');
    
	date_default_timezone_set('America/Sao_Paulo');

	class SQL
	{
		public static function parse($text) {
			$antigo[] = ['à', 'â', 'ê', 'ô', 'û', 'ã', 'õ', 'á', 'é', 'í', 'ó', 'ú', 'ç', 'ü', 'À', 'Â', 'Ê', 'Ô', 'Û', 'Ã', 'Õ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ç', 'Ü'];
			$novo[]   = ['a', 'a', 'e', 'o', 'u', 'a', 'o', 'a', 'e', 'i', 'o', 'u', 'c', 'u', 'A', 'A', 'E', 'O', 'U', 'A', 'O', 'A', 'E', 'I', 'O', 'U', 'C', 'U'];

			foreach ($antigo as $indice => $valor) {
				$text = str_replace($antigo[$indice], $novo[$indice], $text);				
			}

			return $text;
		}

		public static function solver($sqlComum, $sqlOracle, $filtro) {
			$connect = Sistema::getConexao(false);

			$sql = '';
			
			if (($sqlOracle != '') && (Sistema::IsOracle())) {
				$sql = $sqlOracle;
			}
			else {
				$sql = $sqlComum;
			}
			
			$sql = str_replace('@EMPRESAATUAL', $_SESSION['empresa'], $sql);
			$sql = str_replace('@EMPRESALOGADA', $_SESSION['empresa'], $sql);
			$sql = str_replace('@EMPRESA', $_SESSION['empresa'], $sql);
			
			$sql = str_replace('@FILIALATUAL', $_SESSION['filial'], $sql);
			$sql = str_replace('@FILIALLOGADA', $_SESSION['filial'], $sql);
			$sql = str_replace('@FILIAL', $_SESSION['filial'], $sql);
			
			$sql = str_replace('@PESSOAUSUARIOLOGADO', $_SESSION['pessoa'], $sql);
			
			$sql = str_replace('@USUARIOATUAL', $_SESSION['handleUsuario'], $sql);
			$sql = str_replace('@USUARIOLOGADO', $_SESSION['handleUsuario'], $sql);
			$sql = str_replace('@USUARIO', $_SESSION['handleUsuario'], $sql);

			foreach ($filtro as $filtroItem) {
				$filtroItem->quantidadeParametro = 0;

				if (in_array($filtroItem->tipo, [Constantes::ComponenteTipoFiltroLista, Constantes::ComponenteTipoFiltroNumerico, Constantes::ComponenteTipoFiltroTabela])) {
					if (($filtroItem->valor == '') || ($filtroItem->valor == '.0000')) {
						$filtroItem->valor = '0';
					}
					else {
						$filtroItem->valor = str_replace(',', '0', $filtroItem->valor);
					}	

					$sql = str_replace('@'. $filtroItem->nome, $filtroItem->valor, $sql); 
				}
				else {						
					while (strpos($sql, '@'. $filtroItem->nome) !== false) { 
						$filtroItem->quantidadeParametro++;
					
						$sql = substr_replace($sql, ':'. $filtroItem->nome. $filtroItem->quantidadeParametro, strpos($sql, '@'. $filtroItem->nome), strlen('@'. $filtroItem->nome)); 
					}
				}
			}

			$query = $connect->prepare($sql);	

			foreach ($filtro as $filtroItem) {
				for ($indice = 1; $indice <= $filtroItem->quantidadeParametro; $indice++) {
					switch ($filtroItem->tipo) {							
						case Constantes::ComponenteTipoFiltroData:
							$filtroItem->valor = Sistema::formataDataHoraMascara($filtroItem->valor, Conexao::getMascaraDataHora());

							$query->bindParam(':'. $filtroItem->nome. $indice, $filtroItem->valor, PDO::PARAM_STR);

							break;
							
							$query->bindParam(':'. $filtroItem->nome. $indice, $filtroItem->valor, PDO::PARAM_STR);

							break;
							
						case Constantes::ComponenteTipoFiltroTexto:
							$query->bindParam(':'. $filtroItem->nome. $indice, $filtroItem->valor, PDO::PARAM_STR);

							break;
					}
				}
			}
				
			$query->execute();

			return $query;
		}
			
		public static function solverToString($sqlComum, $sqlOracle, $filtro) {
			if (((Sistema::IsOracle()) && ($sqlOracle == '') && ($sqlComum == '')) || ((!Sistema::IsOracle()) && ($sqlComum == ''))) {
				return '';
			}
			else {
				$query = self::solver($sqlComum, $sqlOracle, $filtro);			
				
				$row = $query->fetch(PDO::FETCH_COLUMN, 0);
				
				if (count($row) > 0) {
					return $row;
				}
				else {
					return '';
				}
			}
		}
		
		public static function solverToNumber($sqlComum, $sqlOracle, $filtro) {
			if (((Sistema::IsOracle()) && ($sqlOracle == '') && ($sqlComum == '')) || ((!Sistema::IsOracle()) && ($sqlComum == ''))) {
				return 0;
			}
			else {
				$query = self::solver($sqlComum, $sqlOracle, $filtro);			
				
				$row = $query->fetch(PDO::FETCH_COLUMN, 0);
				
				if (count($row) > 0) {
					return $row;
				}
				else {
					return 0;
				}
			}
		}		
	}
?>