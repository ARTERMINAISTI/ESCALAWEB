<?php

	include_once('../../controller/tecnologia/BancoDados.php');	
	include_once('../../model/painelindicador/constantes.php');
    include_once('../../controller/tecnologia/Sistema.php');	 
	include_once('../../model/painelindicador/sql.php');
    
	date_default_timezone_set('America/Sao_Paulo');	

    class PainelIndicador {

        private $connect;

		function __construct() {
            $this->connect = Sistema::getConexao(false);
        }

		public function atualizarPainel($parametroPainel, $alturaPainel, $larguraPainel, $filtroPainel) {
			$componente = unserialize(gzuncompress(base64_decode(strtr($parametroPainel, '-_,', '+/=')))); 
			$componenteValor = [];
			$filtroPainel = json_decode($filtroPainel);

			foreach ($componente as $componenteItem) {
				try {
					switch ($componenteItem['TIPO']) 
					{
						case Constantes::ComponenteTipoCalendario:
							$componenteValor[] = $this->calendarioAtualizarValor((object)$componenteItem, $alturaPainel, $filtroPainel);
		
							break;
	
						
						case Constantes::ComponenteTipoGrafico:
							$componenteValor[] = $this->graficoAtualizarValor((object)$componenteItem, $alturaPainel, $filtroPainel);
		
							break;
	
						case Constantes::ComponenteTipoIndicadorValor:
							$componenteValor[] = $this->indicadorAtualizarValor((object)$componenteItem, $alturaPainel, $larguraPainel, $filtroPainel);
	
							break;
	
						case Constantes::ComponenteTipoMedidor:
							$componenteValor[] = $this->medidorAtualizarValor((object)$componenteItem, $alturaPainel, $larguraPainel, $filtroPainel);
	
							break;
	
						case Constantes::ComponenteTipoTabela:
							$componenteValor[] = $this->tabelaAtualizarValor((object)$componenteItem, $alturaPainel, $larguraPainel, $filtroPainel);
	
							break;	
					}	
				} catch (Exception $e) {
					$elementoHtml = $this->elementoHtmlNovo(null, 'div');

					$elementoHtmlTitulo = $this->elementoHtmlNovo($elementoHtml, 'h6');
					$elementoHtmlTitulo->atributo['style'][] = 'color:red';
					$elementoHtmlTitulo->conteudo = 'Erro ao atualizado os dados do componente '. $componenteItem['CODIGO']. ' - '. strtolower($componenteItem['NOME']);

					$elementoHtmMensagem = $this->elementoHtmlNovo($elementoHtml, 'h6');
					$elementoHtmMensagem->atributo['style'][] = 'color:red';
					$elementoHtmMensagem->conteudo = $e->getMessage();

					$componenteValor[] = [
						'elementoDestino' => $componenteItem['IDENTIFICADORINTERNO']. '_corpo',
						'tipo' => 'texto',
						'valor' => $this->elementoHtmlGerarTextoHtml($elementoHtml)
					];
				}
			}			
		
			echo json_encode($componenteValor);
		}
		
		public function calendarioAtualizarValor($componente, $alturaPainel, $filtroPainel) {	
			$retorno = [];
			
			$elementoHtml = $this->elementoHtmlNovo(null, 'div');
			$elementoHtml->atributo['id'] = $componente->IDENTIFICADORINTERNO. '_corpo_calendario';

			$retorno[] = (object)[
				'elementoDestino' => $componente->IDENTIFICADORINTERNO. '_corpo',
				'tipo' => 'texto',
				'valor' => $this->elementoHtmlGerarTextoHtml($elementoHtml)
			];	
			
			$retorno[] = (object)[
				'elementoDestino' => $componente->IDENTIFICADORINTERNO. '_corpo_calendario',
				'altura' => floor(($componente->ALTURA / Constantes::AlturaPainel) * $alturaPainel),
				'tipo' => 'calendario'
			];

			return $retorno;
		}	

		private function campoGerarFormatacao($tipoCampo, $formatacaoCampo) {
			switch ($tipoCampo) {
				case Constantes::ComponenteTipoCampoData:
					$formatacaoCampo = strtoupper($formatacaoCampo);
					$formatacaoCampo = str_replace('DD', 'd', $formatacaoCampo);
					$formatacaoCampo = str_replace('YYYY', 'Y', $formatacaoCampo);
					$formatacaoCampo = str_replace('MM', 'm', $formatacaoCampo);
					$formatacaoCampo = str_replace('HHm', 'Hi', $formatacaoCampo);
					$formatacaoCampo = str_replace('HH-m', 'H-i', $formatacaoCampo);
					$formatacaoCampo = str_replace('HH:m', 'H:i', $formatacaoCampo);

					break;

				case Constantes::ComponenteTipoCampoInteiro:
					$formatacaoCampo = '0';
	
					break;

				case Constantes::ComponenteTipoCampoNumerico:
					$formatacaoCampo = strtoupper($formatacaoCampo);

					$formatacaoCampo = str_replace('#', '', $formatacaoCampo);
					$formatacaoCampo = str_replace('0.', '', $formatacaoCampo);
					$formatacaoCampo = str_replace('0,', '', $formatacaoCampo);
					$formatacaoCampo = str_replace('.', '', $formatacaoCampo);
					$formatacaoCampo = str_replace(',', '', $formatacaoCampo);
					$formatacaoCampo = str_replace(' ', '', $formatacaoCampo);

					$formatacaoCampo = strlen($formatacaoCampo);

					break;
			}

			return $formatacaoCampo;
		}

        public function carregarPainel($handlePainel, $larguraPainel) {
			$componente = $this->painelBuscarComponente($handlePainel);

			$elementoHtml = $this->elementoHtmlNovo(null, 'div');
			$elementoHtml->item[] = $this->painelGerarElementoHtmlComponente($this->painelBuscarAlinhamentoComponente($handlePainel), (object)['largura' => Constantes::LarguraPainel, 'saldoLargura' => 100, 'quantidadeItem' => 1], $larguraPainel, $componente);
			$elementoHtml->item[] = $this->painelGerarElementoHtmlParametro($componente);
			$elementoHtml->item[] = $this->painelGerarElementoHtmlFiltro($componente);
			$elementoHtml->item[] = $this->painelGerarElementoHtmlFiltroSelecao();

			echo $this->elementoHtmlGerarTextoHtml($elementoHtml);		
        }

		private function componenteGerarElementoHtml($componente) {
		
			$elementoHtml[] = $this->componenteGerarElementoHtmlTitulo($componente);
			$elementoHtml[] = $this->componenteGerarElementoHtmlCorpo($componente);
			$elementoHtml[] = $this->componenteGerarElementoHtmlRodape($componente);

			return $elementoHtml;
		}

		public function componenteGerarElementoHtmlCorpo($componente) {
			$elementoHtml = $this->elementoHtmlNovo(null, 'div');
			$elementoHtml->atributo['id'] = $componente->IDENTIFICADORINTERNO. '_corpo';
			$elementoHtml->atributo['class'][] = 'col-md-12';
			$elementoHtml->atributo['class'][] = 'col-xs-12';
			$elementoHtml->atributo['class'][] = 'componente-body';

			return $elementoHtml;
		}

		private function componenteGerarElementoHtmlRodape($componente)	{
			if ($componente->EHEXIBIRRODAPE == 'S') 
			{
				$elementoHtml = $this->elementoHtmlNovo(null, 'div');
				$elementoHtml->atributo['id'] = $componente->IDENTIFICADORINTERNO. '_rodape';
				$elementoHtml->conteudo = $componente->RODAPEFIXO;

				switch ($componente->ALINHAMENTORODAPE) {
					case Constantes::AlinhamentoTextoCentro:
						$elementoHtml->atributo['class'][] = 'text-center';

						break;

					case Constantes::AlinhamentoTextoDireita:
						$elementoHtml->atributo['class'][] = 'text-right';

						break;				
				}
				if ($componente->EHDESTACARRODAPE == 'S') {
					$elementoHtml->atributo['class'][] = 'componente-active';
				}

				$elementoHtml->atributo['style'][] = 'font-size:'. $componente->FONTERODAPE. 'px';

				return $elementoHtml;
			}
		}

		private function componenteGerarElementoHtmlTitulo($componente)	{
			
			if (($componente->EHEXIBIRTITULO == 'S') || ($componente->TIPO == Constantes::ComponenteTipoTabela))
			{				
				$elementoHtml = $this->elementoHtmlNovo(null, 'div');
				$elementoHtml->atributo['id'] = $componente->IDENTIFICADORINTERNO. '_titulo';
				$elementoHtml->atributo['class'][] = 'componente-header';
				$elementoHtml->atributo['style'][] = 'height:20px';

				if ($componente->EHDESTACARTITULO == 'S') {
					$elementoHtml->atributo['class'][] = 'componente-active';
				}					

				if ($componente->EHEXIBIRTITULO == 'S') {					
					$elementoHtmlConteudo = $this->elementoHtmlNovo($elementoHtml, 'div');
					$elementoHtmlConteudo->atributo['class'][] = 'col-md-10';					

					$elementoHtmlConteudo->conteudo = $componente->TITULOFIXO;

					if ($componente->EHDESTACARTITULO == 'S') {
						$elementoHtmlConteudo->atributo['class'][] = 'componente-active';
					}					

					switch ($componente->ALINHAMENTOTITULO) {
						case Constantes::AlinhamentoTextoCentro:
							$elementoHtmlConteudo->atributo['class'][] = 'text-center';

							break;

						case Constantes::AlinhamentoTextoDireita:
							$elementoHtmlConteudo->atributo['class'][] = 'text-right';

							break;				
					}
					
					$elementoHtmlConteudo->atributo['style'][] = 'font-size:'. $componente->FONTETITULO. 'px';
				}				

				if ($componente->TIPO == Constantes::ComponenteTipoTabela){
					$elementoHtmlBotaoExportarXlsx = $this->elementoHtmlNovo($elementoHtml, 'div');
					$elementoHtmlBotaoExportarXlsx->atributo['class'][] = 'col-md-1';
					$elementoHtmlBotaoExportarXlsx->atributo['class'][] = 'btn';
					$elementoHtmlBotaoExportarXlsx->atributo['class'][] = 'text-right';	
					$elementoHtmlBotaoExportarXlsx->atributo['id'] = $componente->IDENTIFICADORINTERNO. '_botao_exportar_xlsx';
					$elementoHtmlBotaoExportarXlsx->atributo['onclick'] = 'exportarComponenteTabelaXlsx(this)';
					$elementoHtmlBotaoExportarXlsx->atributo['style'][] = 'font-size:10px';
					$elementoHtmlBotaoExportarXlsx->conteudo = 'Exportar xlsx';	

					if ($componente->EHDESTACARTITULO == 'S') {
						$elementoHtmlBotaoExportarXlsx->atributo['class'][] = 'componente-active';
					}	

					$elementoHtmlBotaoExportarCsv = $this->elementoHtmlNovo($elementoHtml, 'div');
					$elementoHtmlBotaoExportarCsv->atributo['class'][] = 'col-md-1';
					$elementoHtmlBotaoExportarCsv->atributo['class'][] = 'btn';
					$elementoHtmlBotaoExportarCsv->atributo['class'][] = 'text-right';	
					$elementoHtmlBotaoExportarCsv->atributo['id'] = $componente->IDENTIFICADORINTERNO. '_botao_exportar_csv';
					$elementoHtmlBotaoExportarCsv->atributo['onclick']	 = 'exportarComponenteTabelaCsv(this)';
					$elementoHtmlBotaoExportarCsv->atributo['style'][] = 'font-size:10px';
					$elementoHtmlBotaoExportarCsv->conteudo = 'Exportar csv';

					if ($componente->EHDESTACARTITULO == 'S') {
						$elementoHtmlBotaoExportarCsv->atributo['class'][] = 'componente-active';
					}						
				}

				return $elementoHtml;
			}
		}
		
		private function elementoHtmlGerarTextoHtml($elementoHtml) {
			$textoHtml = '';

			if (isset($elementoHtml->nome)) {
				$textoHtml .= '<'. $elementoHtml->nome;
				
				if (isset($elementoHtml->atributo)) {
					foreach	($elementoHtml->atributo as $atributoIndice => $atributoValor) {
						if (is_array($atributoValor)) {
							if ($atributoIndice == 'style') {
								$textoHtml .= ' ' . $atributoIndice. '="'. implode(';', $atributoValor). '"';
							}
							else {
								$textoHtml .= ' ' . $atributoIndice. '="'. implode(' ', $atributoValor). '"';
							}							
						}
						else {
							$textoHtml .= ' ' . $atributoIndice. '="'. $atributoValor. '"';
						}						
					}
				}

				$textoHtml .= '>';

				if (isset($elementoHtml->conteudo)) {
					$textoHtml .= $elementoHtml->conteudo;
				}				

				if (isset($elementoHtml->item)) {
					foreach ($elementoHtml->item as $elementoHtmlItem) {	
						$textoHtml .= $this->elementoHtmlGerarTextoHtml($elementoHtmlItem);
					}
				}

				$textoHtml .= '</'. $elementoHtml->nome. '>';
			}
			else if (is_array($elementoHtml)) {
				foreach ($elementoHtml as $elementoHtmlItem) {	
					$textoHtml .= $this->elementoHtmlGerarTextoHtml($elementoHtmlItem);
				}
			}			

			return $textoHtml;
		}

		public function elementoHtmlNovo($elementoHtmlNivelSuperior, $nome) {
			$elementoHtml = (object)[];
			$elementoHtml->nome = $nome;

			if (isset($elementoHtmlNivelSuperior)) {
				$elementoHtmlNivelSuperior->item[] = $elementoHtml;
			}

			return $elementoHtml;
		}

		public function filtroSelecaoBuscarQuery($tabela, $campo, $localwheredefault, $localwhereusuario, $campoordenacao, $ordenacaoasc) {
			$sql = 'SELECT TOP 20 ';
			$localWhereCampo = '';			

			foreach ($campo as $campoItem) {
				$sql .= 'A.'. $campoItem->nome. ' '. $campoItem->nome. ', ';

				if ($localwhereusuario != '') {
					if ($localWhereCampo != ''){
						$localWhereCampo .= ' OR ';	
					}

					$localWhereCampo .= ' (A.'. $campoItem->nome . ' LIKE :'. $campoItem->nome. ')';
				}
			}

			$sql .= ' A.HANDLE HANDLE FROM '. $tabela. ' A WHERE 1 = 1 ' ;
			
			if ($localwheredefault != '') {
				$sql .= ' AND '. $localwheredefault;
			}
			
			if ($localWhereCampo != '') {
				$sql .= ' AND ('. $localWhereCampo .')';
			}			
			
			if ($campoordenacao != '') {
				$sql .= ' ORDER BY A.'. $campoordenacao;
			}
			else {
				$sql .= ' ORDER BY 1';
			}

			if (!$ordenacaoasc) {
				$sql .= ' DESC';
			}

			$query = $this->connect->prepare($sql);

			if ($localwhereusuario != '') {
				foreach ($campo as $campoItem) {
					$valor = '%'. $localwhereusuario. '%';
					$query->bindParam(':'. $campoItem->nome, $valor, PDO::PARAM_STR);
				}
			}

			$query->execute();

			return $query;
		}

		public function filtroSelecaoBuscarRegistro($filtroBuscarRegistro) {
			$filtroBuscarRegistro = json_decode($filtroBuscarRegistro);
			
			$query = $this->filtroSelecaoBuscarQuery($filtroBuscarRegistro->tabela, 
				$filtroBuscarRegistro->campo, 
				$filtroBuscarRegistro->localwheredefault, 
				$filtroBuscarRegistro->localwhereusuario, 
				$filtroBuscarRegistro->campoordenacao, 
				$filtroBuscarRegistro->ordenacaoasc);

			// monta o cabecalho
			$elementoHtmlTable = $this->elementoHtmlNovo(null, 'table');
			$elementoHtmlTable->atributo['class'][] = 'table';
			$elementoHtmlTable->atributo['class'][] = 'table-hover';
			$elementoHtmlTable->atributo['class'][] = 'table-bordered';
			$elementoHtmlTable->atributo['class'][] = 'table-striped';
			$elementoHtmlTable->atributo['class'][] = 'table-head';

			$elementoHtmlThead = $this->elementoHtmlNovo($elementoHtmlTable, 'thead');		
			$elementoHtmlTr = $this->elementoHtmlNovo($elementoHtmlThead, 'tr');

			foreach ($filtroBuscarRegistro->campo as $campoIndice => $campoItem) {
				$elementoHtmlTh = $this->elementoHtmlNovo($elementoHtmlTr, 'th');
				$elementoHtmlTh->conteudo = $campoItem->titulo;
				
				$elementoHtmlTh->atributo['id'] = 'painel_filtro_selecao_tabela_'. $campoItem->nome;
				$elementoHtmlTh->atributo['name'] = $campoItem->nome;
				$elementoHtmlTh->atributo['onclick'] = 'ordernarTabelaModalFiltroSelecao(this.id)';
				$elementoHtmlTh->atributo['style'][] = 'font-size:12px';
				$elementoHtmlTh->atributo['style'][] = 'width:'. $campoItem->tamanho. '%';

				if (($filtroBuscarRegistro->campoordenacao == $elementoHtmlTh->atributo['name']) || (($filtroBuscarRegistro->campoordenacao == '') && ($campoIndice == 0))) {
					if (!$filtroBuscarRegistro->ordenacaoasc) {
						$elementoHtmlTh->atributo['class'][] = 'th-desc';
					}
					else {
						$elementoHtmlTh->atributo['class'][] = 'th-asc';
					}
				}
			}

			//-- monta a tabela de retorno
			$elementoHtmlBody = $this->elementoHtmlNovo($elementoHtmlTable, 'body');
			
			while ($queryItem = $query->fetch(PDO::FETCH_ASSOC)) {
				$elementoHtmlTr = $this->elementoHtmlNovo($elementoHtmlBody, 'tr');
				$elementoHtmlTr->atributo['value'] = '';

				foreach ($filtroBuscarRegistro->campo as $campoItem) {
					$elementoHtmlTd = $this->elementoHtmlNovo($elementoHtmlTr, 'td');

					$elementoHtmlTd->atributo['style'][] = 'width:'. $campoItem->tamanho. '%';
					$elementoHtmlTd->atributo['style'][] = 'font-size:12px';
					$elementoHtmlTd->atributo['style'][] = 'cursor: pointer';
					$elementoHtmlTd->atributo['ondblclick'][] = 'selecionarRegistroTabelaModalFiltroSelecao(this)';
					$elementoHtmlTd->atributo['value'] = $queryItem['HANDLE'];
					$elementoHtmlTd->conteudo = $queryItem[$campoItem->nome];
					
					if ($elementoHtmlTr->atributo['value'] != '')
						$elementoHtmlTr->atributo['value'] .= ' - ';
					
					$elementoHtmlTr->atributo['value'] .= $queryItem[$campoItem->nome];
				}
			}

			echo $this->elementoHtmlGerarTextoHtml($elementoHtmlTable);
		}

		public function graficoAtualizarValor($componente, $alturaPainel, $filtroPainel) {
			$retorno = [];

			//-- cria uma div para armazenar o grid
			$elementoHtml = $this->elementoHtmlNovo(null, 'div');
			$elementoHtml->atributo['id'] = $componente->IDENTIFICADORINTERNO. '_corpo_grafico';
			$elementoHtml->atributo['style'][] = 'height:'. floor(($componente->ALTURA / Constantes::AlturaPainel) * $alturaPainel). 'px';

			$retorno[] = (object)[
				'elementoDestino' => $componente->IDENTIFICADORINTERNO. '_corpo',
				'tipo' => 'texto',
				'valor' => $this->elementoHtmlGerarTextoHtml($elementoHtml)
			];

			// monta dados do eixo x, y
			$eixoX = [];
			$eixoY = [];

			$eixoYMaiorNumero = 0.0;

			$eixoXCampo = array_keys(array_column($componente->CAMPO, 'FORMAUTILIZACAO'), Constantes::ComponenteCampoFormaUilizacaoEixoX);
			$eixoYCampo = array_keys(array_column($componente->CAMPO, 'FORMAUTILIZACAO'), Constantes::ComponenteCampoFormaUilizacaoEixoY);
			$eixoZCampo = array_keys(array_column($componente->CAMPO, 'FORMAUTILIZACAO'), Constantes::ComponenteCampoFormaUilizacaoEixoZ);

			$query = SQL::solver($componente->SQLCOMUM, $componente->SQLORACLE, $filtroPainel);

			while ($queryItem = $query->fetch(PDO::FETCH_ASSOC)) {
				$eixoXLegenda = '';
				$eixoYLegenda = '';
				$eixoZLegenda = '';				
				
				foreach ($eixoXCampo as $eixoXCampoIndice) {
					if ($eixoXLegenda != ''){
						$eixoXLegenda .= ' - ';
					}

					if ($queryItem[$componente->CAMPO[$eixoXCampoIndice]->NOME] != '') {

						switch ($componente->CAMPO[$eixoXCampoIndice]->TIPO) {
							case Constantes::ComponenteTipoCampoInteiro:
							case Constantes::ComponenteTipoCampoNumerico:
								$eixoXLegenda .= number_format($queryItem[$componente->CAMPO[$eixoXCampoIndice]->NOME], $componente->CAMPO[$eixoXCampoIndice]->FORMATACAO, ',', '.');

								break;

							case Constantes::ComponenteTipoCampoData:
								if ($queryItem[$componente->CAMPO[$eixoXCampoIndice]->NOME] != '0') {
									$eixoXLegenda .= (new DateTime($queryItem[$componente->CAMPO[$eixoXCampoIndice]->NOME]))->format($componente->CAMPO[$eixoXCampoIndice]->FORMATACAO);
								}

								break;
							default:
								$eixoXLegenda .= $queryItem[$componente->CAMPO[$eixoXCampoIndice]->NOME];

								break;								
						}
					}
				}

				foreach ($eixoZCampo as $eixoZCampoIndice) {
					if ($eixoZLegenda != '') {
						$eixoZLegenda .= ' - ';
					}

					if ($queryItem[$componente->CAMPO[$eixoZCampoIndice]->NOME] != '') {

						switch ($componente->CAMPO[$eixoZCampoIndice]->TIPO) {
							case Constantes::ComponenteTipoCampoInteiro:
							case Constantes::ComponenteTipoCampoNumerico:
								$eixoZLegenda .= number_format($queryItem[$componente->CAMPO[$eixoZCampoIndice]->NOME], $componente->CAMPO[$eixoZCampoIndice]->FORMATACAO, ',', '.');

								break;

							case Constantes::ComponenteTipoCampoData:
								if ($queryItem[$componente->CAMPO[$eixoZCampoIndice]->NOME] != '0') {
									$eixoZLegenda .= (new DateTime($queryItem[$componente->CAMPO[$eixoZCampoIndice]->NOME]))->format($componente->CAMPO[$eixoZCampoIndice]->FORMATACAO);
								}

								break;
							default:
								$eixoZLegenda .= $queryItem[$componente->CAMPO[$eixoZCampoIndice]->NOME];

								break;								
						}
					}
				}

				foreach ($eixoYCampo as $eixoYCampoIndice) {					
					$eixoYValor = 0.0;
					
					if ($queryItem[$componente->CAMPO[$eixoYCampoIndice]->NOME] != '') {

						switch ($componente->CAMPO[$eixoYCampoIndice]->TIPO) {
							case Constantes::ComponenteTipoCampoInteiro:
							case Constantes::ComponenteTipoCampoNumerico:
								$eixoYValor = $queryItem[$componente->CAMPO[$eixoYCampoIndice]->NOME];

								break;								
						}
					}
				
					if ((count($eixoZCampo) == 0) || (count($eixoZCampo) > 1)) {
						$eixoYLegenda = $componente->CAMPO[$eixoYCampoIndice]->TITULO;

						if ($eixoZLegenda != '') {
							$eixoYLegenda = $eixoZLegenda . ' - ' . $eixoYLegenda;
						}
					}
					else {
						$eixoYLegenda = $eixoZLegenda;
					}

					if (!array_key_exists($eixoYLegenda, $eixoY)) {
						$eixoY[$eixoYLegenda] = [
							'nome' => 'SERIE_' . count($eixoY),
							'formatacao' => $componente->CAMPO[$eixoYCampoIndice]->FORMATACAO,
							'legenda' => $eixoYLegenda
						];
					}

					if (!isset($eixoX[$eixoXLegenda][$eixoY[$eixoYLegenda]['nome']])) {
						$eixoX[$eixoXLegenda][$eixoY[$eixoYLegenda]['nome']] = 0;
					}

					$eixoX[$eixoXLegenda][$eixoY[$eixoYLegenda]['nome']] += $eixoYValor;

					if ($eixoX[$eixoXLegenda][$eixoY[$eixoYLegenda]['nome']] > $eixoYMaiorNumero) {
						$eixoYMaiorNumero = $eixoX[$eixoXLegenda][$eixoY[$eixoYLegenda]['nome']];
					}
				}
			}

			//-- monta resultado
			$jsonCor = [];
			$jsonSerie = [];
			$jsonValor = [];

			ksort($eixoX);

			if (isset($componente->COR)) {
				foreach ($componente->COR as $componenteIndice => $componenteCor){
					$jsonCor[] = (object)[
						'nome' => $componenteCor->COR
					];
				}	
			}
			else {
				$jsonCor[] = (object)[
						'nome' => 'rgb(0,0,0)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(153,51,102)'
					];
					
				$jsonCor[] = (object)[
						'nome' => 'rgb(0,0,255)'
					];
					
				$jsonCor[] = (object)[
						'nome' => 'rgb(102,0,102)'
					];
					
				$jsonCor[] = (object)[
						'nome' => 'rgb(112,112,112)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(0,128,0)'
					];
					
				$jsonCor[] = (object)[
						'nome' => 'rgb(128,0,128)'
					];
					
				$jsonCor[] = (object)[
						'nome' => 'rgb(0,0,128)'
					];
					
				$jsonCor[] = (object)[
						'nome' => 'rgb(179,8,14)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(255,0,255)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(68,102,163)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(29,123,99)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(43,64,107)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(128,0,0)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(0,102,204)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(255,0,255)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(0,255,128)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(0,128,128)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(201,60,12)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(37,149,169)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(243,156,53)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(255,153,204)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(78,151,168)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(0,255,255)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(255,128,128)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(242,192,93)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(93,183,158)'
					];

				$jsonCor[] = (object)[
						'nome' => 'rgb(153,153,255)'
					];				
			}

			foreach ($eixoY as $eixoYIndice => $eixoYItem){
				$jsonSerie[] = (object)$eixoYItem;
			}

			foreach ($eixoX as $eixoXIndice => $eixoXItem){
				$jsonValorItem = (object)$eixoXItem;
				$jsonValorItem->EIXOX = $eixoXIndice;

				$jsonValor[] = $jsonValorItem;
			}

			$retorno[] = (object)[
				'cor' => $jsonCor,
				'eixoymaiornumero' => $eixoYMaiorNumero,
				'elementoDestino' => $componente->IDENTIFICADORINTERNO. '_corpo_grafico',
				'exibirlegenda' => $componente->EHEXIBIRLEGENDAGRAFICO,
				'exibirvalorserie' => $componente->EHEXIBIRVALORGRAFICO,
				'tipo' => 'grafico',				
				'tipografico' => $componente->TIPOGRAFICO,
				'serie' => $jsonSerie,
				'valor' => $jsonValor
			];

			return $retorno;
		}

		public function indicadorAtualizarValor($componente, $alturaPainel, $larguraPainel, $filtroPainel) {
			$elementoHtml = [];

			$quantidadeRegistro = $componente->QUANTIDADEREGISTRO;
	
			if ($quantidadeRegistro > count($componente->INDICADOR)) {
				$quantidadeRegistro = count($componente->INDICADOR);
			}
			
			if ($quantidadeRegistro > 0) {
				if ($componente->ORGANIZARREGISTRO == Constantes::ComponenteOrganizarRegistroLinha)	{
					$quantidadeColuna = floor(count($arrayComponenteIndicador) / $quantidadeColuna);
					$quantidadeLinha = $quantidadeRegistro;
				}
				else {
					$quantidadeColuna = $quantidadeRegistro;
					$quantidadeLinha = ceil(count($componente->INDICADOR) / $quantidadeRegistro);
				}
			}

			$alturaIndicadorValor = floor((($componente->ALTURA / Constantes::AlturaPainel) * $alturaPainel) / $quantidadeLinha);

			if ($larguraPainel >= 800) {
				$larguraIndicador = 100 / $quantidadeColuna;
			}
			else {
				$larguraIndicador = 100;
			}

			foreach ($componente->INDICADOR as $componenteIndice => $componenteIndicador) {
				if ($componenteIndicador->EHEXIBIRTITULO == 'S') {
					$alturaIndicadorCabecalho = $componente->FONTETITULOINDICADOR;
				} else {
					$alturaIndicadorCabecalho = 0;
				}

				$elementoHtmlIndicador = $this->elementoHtmlNovo(null, 'div');
				$elementoHtmlIndicador->atributo['style'][] = 'width:'. $larguraIndicador. '%';
				$elementoHtmlIndicador->atributo['style'][] = 'float:left';
				$elementoHtmlIndicador->atributo['style'][] = 'text-align: center';
								
				$elementoHtmlIndicadorCabecalho = $this->elementoHtmlNovo($elementoHtmlIndicador, 'div');
				$elementoHtmlIndicadorCabecalho->atributo['style'][] = 'height:'. $alturaIndicadorCabecalho. 'px';

				$elementoHtmlIndicadorCorpo = $this->elementoHtmlNovo($elementoHtmlIndicador, 'div');
				$elementoHtmlIndicadorCorpo->atributo['class'][] = 'painel-body';
				$elementoHtmlIndicadorCorpo->atributo['style'][] = 'height:'. ($alturaIndicadorValor - $alturaIndicadorCabecalho). 'px';

				$elementoHtmlIndicadorCorpoImagem = $this->elementoHtmlNovo($elementoHtmlIndicadorCorpo, 'div');

				$elementoHtmlIndicadorCorpoImagemSpan = $this->elementoHtmlNovo($elementoHtmlIndicadorCorpoImagem, 'span');
				$elementoHtmlIndicadorCorpoImagemSpan->atributo['class'][] = 'glyphicon';
				$elementoHtmlIndicadorCorpoImagemSpan->atributo['style'][] = 'font-size:10px';

				$elementoHtmlIndicadorCorpoValor = $this->elementoHtmlNovo($elementoHtmlIndicadorCorpo, 'div');
				$elementoHtmlIndicadorCorpoValor->atributo['class'][] = 'text-muted';

				// borda
				if ($componenteIndicador->EHEXIBIRBORDA == 'S') {
					$elementoHtmlIndicador->atributo['class'][] = 'componente-bordered';
				}

				// cabecalho
				if ($componenteIndicador->EHEXIBIRTITULO == 'S') {
					$elementoHtmlIndicadorCabecalho->conteudo = SQL::solverToString($componenteIndicador->SQLTITULOVARIAVEL, '', $filtroPainel);

					if ($elementoHtmlIndicadorCabecalho->conteudo == '') {
						$elementoHtmlIndicadorCabecalho->conteudo = $componenteIndicador->TITULOFIXO;
					}

					switch ($componenteIndicador->ALINHAMENTOTITULO) {
						case Constantes::AlinhamentoTextoCentro:
							$elementoHtmlIndicadorCabecalho->atributo['class'][] = 'text-center';

							break;

						case Constantes::AlinhamentoTextoDireita:							
							$elementoHtmlIndicadorCabecalho->atributo['class'][] = 'text-right';
							
							break;				
					}

					$elementoHtmlIndicadorCabecalho->atributo['style'][] = 'font-size:'. $componente->FONTETITULOINDICADOR. 'px';
				}

				// valor
				$valorSQL = SQL::solverToNumber($componenteIndicador->SQLCOMUMVALOR, $componenteIndicador->SQLORACLEVALOR, $filtroPainel);

				switch ($componenteIndicador->TIPOVALOR) {
					case Constantes::ComponenteTipoCampoInteiro:
						if ($valorSQL == '') {
							$valorSQL = 0;
						}

						$elementoHtmlIndicadorCorpoValor->conteudo = $valorSQL;

						break;
					
					case Constantes::ComponenteTipoCampoNumerico:
						if ($valorSQL == '') {
							$valorSQL = 0;
						}

						$elementoHtmlIndicadorCorpoValor->conteudo = number_format($valorSQL, $componenteIndicador->FORMATACAO, ',', '.');

						break;

					case Constantes::ComponenteTipoCampoData:
						if (($valorSQL != '') && ($valorSQL != '0')) {
							$elementoHtmlIndicadorCorpoValor->conteudo = (new DateTime($valorSQL))->format($componenteIndicador->FORMATACAO);						
						}
						
						break;
					
					default:
						$elementoHtmlIndicadorCorpoValor->conteudo = $valorSQL;		

						break;			
				}

				switch ($componenteIndicador->ALINHAMENTOVALOR) {
					case Constantes::AlinhamentoTextoCentro:
						$elementoHtmlIndicadorCorpoValor->atributo['class'][] = 'text-center';

						break;

					case Constantes::AlinhamentoTextoDireita:
						$elementoHtmlIndicadorCorpoValor->atributo['class'][] = 'text-right';
						
						break;				
				}

				if ($componente->FONTEVALORINDICADOR > 0) {
					$elementoHtmlIndicadorCorpoValor->atributo['style'][] = 'font-size:'. $componente->FONTEVALORINDICADOR. 'px';
				}
				else {
					$elementoHtmlIndicadorCorpoValor->atributo['style'][] = 'font-size:15px';
				}

				// marcadores
				$achouMarcador = false;
				$temImagem = false;

				if (isset($componenteIndicador->INDICADORMARCADOR)) {					
					foreach ($componenteIndicador->INDICADORMARCADOR as $componenteIndicadorMarcador) {						
						switch ($componenteIndicadorMarcador->REGRACOMPARACAO) {
							case Constantes::ComponenteMarcadorRegraComparacaoValorDiferente:
								$achouMarcador = $componenteIndicadorMarcador->VALORCOMPARACAO != $valorSQL;

								break;

							case Constantes::ComponenteMarcadorRegraComparacaoValorIgualA:
								$achouMarcador = $componenteIndicadorMarcador->VALORCOMPARACAO == $valorSQL;

								break;

							case Constantes::ComponenteMarcadorRegraComparacaoValorMenorQue:
								$achouMarcador = $componenteIndicadorMarcador->VALORCOMPARACAO > $valorSQL;

								break;

							case Constantes::ComponenteMarcadorRegraComparacaoValorMenorOuIgualA:
								$achouMarcador = $componenteIndicadorMarcador->VALORCOMPARACAO >= $valorSQL;

								break;

							case Constantes::ComponenteMarcadorRegraComparacaoValorMaiorQue:
								$achouMarcador = $componenteIndicadorMarcador->VALORCOMPARACAO < $valorSQL;

								break;

							case Constantes::ComponenteMarcadorRegraComparacaoValorMaiorOuIgualA:
								$achouMarcador = $componenteIndicadorMarcador->VALORCOMPARACAO <= $valorSQL;

								break;
						}

						if ($achouMarcador)	{
							switch ($componenteIndicadorMarcador->IMAGEM) {
								case Constantes::ComponenteMarcadorImagemParaCima:
									$elementoHtmlIndicadorCorpoImagemSpan->atributo['class'][] = 'glyphicon-chevron-up';
									$temImagem = true;

									break;

								case Constantes::ComponenteMarcadorImagemParaBaixo:
									$elementoHtmlIndicadorCorpoImagemSpan->atributo['class'][] = 'glyphicon-chevron-down';
									$temImagem = true;

									break;				
							}

							if ($componenteIndicadorMarcador->CORFONTE != '') {
								$elementoHtmlIndicadorCorpoImagemSpan->atributo['style'][] = 'color:rgb('. $componenteIndicadorMarcador->CORFONTE. ')';
								$elementoHtmlIndicadorCorpoValor->atributo['style'][] = 'color:rgb('. $componenteIndicadorMarcador->CORFONTE. ')';
							}
							else if (($componenteIndicadorMarcador->CORFUNDO != '') || ($componenteIndicador->EHDESTACAR == 'S')) {
								$elementoHtmlIndicadorCabecalho->atributo['style'][] = 'color:black;';
								$elementoHtmlIndicadorCorpoImagemSpan->atributo['style'][] = 'color:black;';	
								$elementoHtmlIndicadorCorpoValor->atributo['style'][] = 'color:black;';
							}
						
							if ($componenteIndicadorMarcador->CORFUNDO != '') {
								$elementoHtmlIndicador->atributo['style'][] = 'background-color:rgb('. $componenteIndicadorMarcador->CORFUNDO. ')';
								$elementoHtmlIndicadorCabecalho->atributo['style'][] = 'background-color:rgb('. $componenteIndicadorMarcador->CORFUNDO. ')';
								$elementoHtmlIndicadorCorpoImagemSpan->atributo['style'][] = 'background-color:rgb('. $componenteIndicadorMarcador->CORFUNDO. ')';								
							}
							else if ($componenteIndicador->EHDESTACAR == 'S') {
								$elementoHtmlIndicador->atributo['style'][] = 'background-color:#f5f5f5';
								$elementoHtmlIndicadorCabecalho->atributo['style'][] = 'background-color:#f5f5f5';
								$elementoHtmlIndicadorCorpoImagemSpan->atributo['style'][] = 'background-color:#f5f5f5';
							}
							else {
								$elementoHtmlIndicador->atributo['style'][] = 'background-color:white';
								$elementoHtmlIndicadorCabecalho->atributo['style'][] = 'background-color:white';
								$elementoHtmlIndicadorCorpoImagemSpan->atributo['style'][] = 'background-color:white';
							}

							break;
						}					
					}
				}
				
				if (!$achouMarcador) {
					$elementoHtmlIndicador->atributo['style'][] = 'background-color:white';
					$elementoHtmlIndicadorCabecalho->atributo['style'][] = 'background-color:white';
					$elementoHtmlIndicadorCorpoImagemSpan->atributo['style'][] = 'background-color:white';	
				}

				if ($temImagem) {
					$elementoHtmlIndicadorCorpoImagem->atributo['style'][] = 'width:10%';
					$elementoHtmlIndicadorCorpoValor->atributo['style'][] = 'width:90%';					
				}
				else {
					$elementoHtmlIndicadorCorpoImagem->atributo['style'][] = 'width:1%';
					$elementoHtmlIndicadorCorpoValor->atributo['style'][] = 'width:99%';
				}

				$elementoHtml[] = $elementoHtmlIndicador;
			}

			return  (object)[
				'elementoDestino' => $componente->IDENTIFICADORINTERNO. '_corpo',
				'tipo' => 'texto',
				'valor' => $this->elementoHtmlGerarTextoHtml($elementoHtml)
			];
		}

		public function medidorAtualizarValor($componente, $alturaPainel, $larguraPainel, $filtroPainel) {
			$retorno[] = $this->medidorGerarElementoHtml($componente, $alturaPainel, $larguraPainel, $filtroPainel);
			$retorno[] = $this->medidorGerarValor($componente, $filtroPainel);

			return $retorno;
		}

		public function medidorGerarElementoHtml($componente, $alturaPainel, $larguraPainel, $filtroPainel) {
			$elementoHtml = [];

			$quantidadeRegistro = $componente->QUANTIDADEREGISTRO;
	
			if ($quantidadeRegistro > count($componente->MEDIDOR)) {
				$quantidadeRegistro = count($componente->MEDIDOR);
			}
			
			if ($quantidadeRegistro > 0) {
				if ($componente->ORGANIZARREGISTRO == Constantes::ComponenteOrganizarRegistroLinha)	{
					$quantidadeColuna = floor(count($arrayComponenteMedidor) / $quantidadeColuna);
					$quantidadeLinha = $quantidadeRegistro;
				}
				else {
					$quantidadeColuna = $quantidadeRegistro;
					$quantidadeLinha = count($componente->MEDIDOR) / $quantidadeRegistro;
				}
			}

			$alturaMedidorValor = floor((($componente->ALTURA / Constantes::AlturaPainel) * $alturaPainel) / $quantidadeLinha);

			if ($larguraPainel >= 800) {
				$larguraMedidor = 100 / $quantidadeColuna;
			}
			else {
				$larguraMedidor = 100;
			}

			foreach ($componente->MEDIDOR as $componenteIndice => $componenteMedidor) {
				if ($componenteMedidor->EHEXIBIRTITULO == 'S') {
					$alturaMedidorCabecalho = $componente->FONTETITULOMEDIDOR;
				} else {
					$alturaMedidorCabecalho = 0;
				}

				$elementoHtmlMedidor = $this->elementoHtmlNovo(null, 'div');
				$elementoHtmlMedidor->atributo['style'][] = 'width:'. $larguraMedidor. '%';
				$elementoHtmlMedidor->atributo['style'][] = 'float:left';
				$elementoHtmlMedidor->atributo['style'][] = 'text-align: center';
								
				$elementoHtmlMedidorCabecalho = $this->elementoHtmlNovo($elementoHtmlMedidor, 'div');
				$elementoHtmlMedidorCabecalho->atributo['style'][] = 'height:'. $alturaMedidorCabecalho. 'px';

				$elementoHtmlMedidorCorpo = $this->elementoHtmlNovo($elementoHtmlMedidor, 'div');
				$elementoHtmlMedidorCorpo->atributo['class'][] = 'painel-body';
				$elementoHtmlMedidorCorpo->atributo['id'] = $componente->IDENTIFICADORINTERNO. '_corpo_medidor_'. $componenteMedidor->HANDLE;
				$elementoHtmlMedidorCorpo->atributo['style'][] = 'height:'. ($alturaMedidorValor - $alturaMedidorCabecalho). 'px';

				// borda
				if ($componenteMedidor->EHEXIBIRBORDA == 'S') {
					$elementoHtmlMedidor->atributo['class'][] = 'componente-bordered';
				}

				// cabecalho
				if ($componenteMedidor->EHEXIBIRTITULO == 'S') {
					$elementoHtmlMedidorCabecalho->conteudo = SQL::solverToString($componenteMedidor->SQLTITULOVARIAVEL, '', $filtroPainel);

					if ($elementoHtmlMedidorCabecalho->conteudo == '') {
						$elementoHtmlMedidorCabecalho->conteudo = $componenteMedidor->TITULOFIXO;
					}

					switch ($componenteMedidor->ALINHAMENTOTITULO) {
						case Constantes::AlinhamentoTextoCentro:
							$elementoHtmlMedidorCabecalho->atributo['class'][] = 'text-center';

							break;

						case Constantes::AlinhamentoTextoDireita:							
							$elementoHtmlMedidorCabecalho->atributo['class'][] = 'text-right';
							
							break;				
					}

					$elementoHtmlMedidorCabecalho->atributo['style'][] = 'font-size:'. $componente->FONTETITULOMEDIDOR. 'px';
				}				

				$elementoHtml[] = $elementoHtmlMedidor;
			}

			return  (object)[
				'elementoDestino' => $componente->IDENTIFICADORINTERNO. '_corpo',
				'tipo' => 'texto',
				'valor' => $this->elementoHtmlGerarTextoHtml($elementoHtml)
			];
		}

		public function medidorGerarValor($componente, $filtroPainel) {
			$retorno = [];

			foreach ($componente->MEDIDOR as $componenteIndice => $componenteMedidor) {
				$valorSql = SQL::solverToNumber($componenteMedidor->SQLCOMUMVALOR, $componenteMedidor->SQLORACLEVALOR, $filtroPainel);

				$medidor = (object)[];
				$medidor->elementoDestino = $componente->IDENTIFICADORINTERNO. '_corpo_medidor_'. $componenteMedidor->HANDLE;
				$medidor->exibirescala = $componenteMedidor->EHEXIBIRESCALADEVALOR;
				$medidor->numeroinicial = (float)$componenteMedidor->VALORINICIAL;
				$medidor->numerofinal = (float)$componenteMedidor->VALORFINAL;
				$medidor->posicaoatual = (float)$valorSql;
				$medidor->tipo = 'medidor';
				$medidor->valoratual = number_format($valorSql, $componenteMedidor->FORMATACAO, ',', '.');

				$medidor->grupo = [];

				if (isset($componenteMedidor->MEDIDORGRUPO)) {
					foreach ($componenteMedidor->MEDIDORGRUPO as $componenteMedidorIndice => $componenteMedidorGrupo) {
						$medidor->grupo[] = (object)[
							'cor' => $componenteMedidorGrupo->COR,
							'inicio' => (float)$componenteMedidorGrupo->VALORINICIAL,
							'termino' => (float)$componenteMedidorGrupo->VALORFINAL,
							'titulo' => $componenteMedidorGrupo->TITULO
						];					
					}
				}

				$retorno[] = $medidor;
			}

			return $retorno;
		}		

		public function painelBuscarAlinhamentoComponente($handlePainel) {
			$query = $this->connect->prepare('SELECT ALINHAMENTOCOMPONENTEWEB ALINHAMENTOCOMPONENTEWEB
												FROM BI_PAINEL  
		   									   WHERE HANDLE = :HANDLE');

			$query->bindParam(':HANDLE', $handlePainel, PDO::PARAM_INT);
			$query->execute();

			return json_decode($query->fetch(PDO::FETCH_ASSOC)['ALINHAMENTOCOMPONENTEWEB']);
        }

        public function painelBuscarComponente(&$handlePainel) {
			$componente = [];

			$componenteComplemento['CAMPO'] = $this->painelBuscarComponenteCampo($handlePainel);		
			$componenteComplemento['COR'] = $this->painelBuscarComponenteCor($handlePainel);			
			$componenteComplemento['FILTRO'] = $this->painelBuscarComponenteFiltro($handlePainel);
			$componenteComplemento['INDICADOR'] = $this->painelBuscarComponenteIndicador($handlePainel);
			$componenteComplemento['MEDIDOR'] = $this->painelBuscarComponenteMedidor($handlePainel);

			// busca componente
			$query = $this->connect->prepare('SELECT B.*
												FROM BI_PAINELCOMPONENTE A 
											   INNER JOIN BI_COMPONENTE B ON B.HANDLE = A.COMPONENTE 
											   WHERE A.PAINEL = :PAINEL
												 AND B.STATUS = ' . Constantes::ComponenteStatusAtivo);
	
			$query->bindParam(':PAINEL', $handlePainel, PDO::PARAM_INT);
			$query->execute();

			while ($queryItem = $query->fetch(PDO::FETCH_ASSOC)) {
				$queryItem['SQLCOMUM'] = SQL::parse($queryItem['SQLCOMUM']);
				$queryItem['SQLORACLE'] = SQL::parse($queryItem['SQLORACLE']);

				foreach ($componenteComplemento as $componenteComplementoIndice => $componenteComplementoItem) {
					$componenteComplementoItemIndice = array_keys(array_column($componenteComplementoItem, 'COMPONENTE'), $queryItem['HANDLE']);

					foreach ($componenteComplementoItemIndice as $componenteComplementoItemIndiceItem) {
						$queryItem[$componenteComplementoIndice][] = (object)$componenteComplementoItem[$componenteComplementoItemIndiceItem];
					}					
				}

				$componente[] = $queryItem;
			}

			return $componente;
        }	

		public function painelBuscarComponenteCampo($handlePainel) {
			$componenteCampo = [];
			
			$query = $this->connect->prepare('SELECT A.ORDEM ORDEM,
													 A.REGRA REGRACOMPARACAO,
													 A.SQLCOMUMVALORVARIAVEL SQLCOMUMVALORVARIAVEL,
													 A.SQLORACLEVALORVARIAVEL SQLORACLEVALORVARIAVEL,
													 A.TIPOVALOR TIPOVALOR,
													 A.VALORFIXO VALORFIXO,

													 B.HANDLE COMPONENTECAMPO,
													 B.NOME CAMPODESTINO,

													 C.NOME CAMPOCOMPARACAO,

													 E.VALORRGB CORFONTE,

													 F.VALORRGB CORFUNDO
															
												FROM BI_COMPONENTECAMPOMARCADOR A
													
											   INNER JOIN BI_COMPONENTECAMPO B ON B.HANDLE = A.CAMPODESTINO
											   INNER JOIN BI_COMPONENTECAMPO C ON C.HANDLE = A.CAMPOCOMPARACAO

											   INNER JOIN BI_COMPONENTE D ON D.HANDLE = B.COMPONENTE AND D.HANDLE = C.COMPONENTE

											    LEFT JOIN MS_COR E ON E.HANDLE = A.CORFONTE
												LEFT JOIN MS_COR F ON F.HANDLE = A.CORFUNDO

											   WHERE D.STATUS = ' . Constantes::ComponenteStatusAtivo. '
												 AND EXISTS (SELECT Z.HANDLE FROM BI_PAINELCOMPONENTE Z WHERE Z.PAINEL = :PAINEL AND Z.COMPONENTE = D.HANDLE)

											   ORDER BY ORDEM');

			$query->bindParam(':PAINEL', $handlePainel, PDO::PARAM_INT);	
			$query->execute();	
			
			$componenteCampoMarcador = $query->fetchAll(PDO::FETCH_ASSOC);
			
			$query = $this->connect->prepare('SELECT A.*
												FROM BI_COMPONENTECAMPO A 
											   INNER JOIN BI_COMPONENTE B ON B.HANDLE = A.COMPONENTE 
											   WHERE A.FORMAUTILIZACAO  <> '. Constantes::ComponenteCampoFormaUilizacaoNaoUtilizar. '
												 AND B.STATUS = ' . Constantes::ComponenteStatusAtivo. '
											     AND EXISTS (SELECT Z.HANDLE FROM BI_PAINELCOMPONENTE Z WHERE Z.PAINEL = :PAINEL AND Z.COMPONENTE = B.HANDLE)
											   ORDER BY ORDEM');
	
			$query->bindParam(':PAINEL', $handlePainel, PDO::PARAM_INT);
			$query->execute();

			while ($queryItem = $query->fetch(PDO::FETCH_ASSOC)) {
				$queryItem['FORMATACAO'] = $this->campoGerarFormatacao($queryItem['TIPO'], $queryItem['FORMATACAO']);
				$queryItem['NOME'] = SQL::parse($queryItem['NOME']);

				$componenteCampoMarcadorIndice = array_keys(array_column($componenteCampoMarcador, 'COMPONENTECAMPO'), $queryItem['HANDLE']);

				foreach ($componenteCampoMarcadorIndice as $componenteCampoMarcadorIndiceItem) {
					if ($componenteCampoMarcador[$componenteCampoMarcadorIndiceItem]['TIPOVALOR'] == Constantes::ComponenteMarcadorTipoComparacaoValorVariavel)
					{
						$componenteCampoMarcador[$componenteCampoMarcadorIndiceItem]['VALORCOMPARACAO'] = SQL::solverToNumber($componenteCampoMarcador[$componenteCampoMarcadorIndiceItem]['SQLCOMUMVALORVARIAVEL'], $componenteCampoMarcador[$componenteCampoMarcadorIndiceItem]['SQLORACLEVALORVARIAVEL'], []);
					}
					else
					{
						$componenteCampoMarcador[$componenteCampoMarcadorIndiceItem]['VALORCOMPARACAO'] = $componenteCampoMarcador[$componenteCampoMarcadorIndiceItem]['VALORFIXO'];
					}

					$queryItem['CAMPOMARCADOR'][] = (object)$componenteCampoMarcador[$componenteCampoMarcadorIndiceItem];
				}					

				$componenteCampo[] = $queryItem;
			}

			return $componenteCampo;
        }		

		public function painelBuscarComponenteCor($handlePainel) {
			$query = $this->connect->prepare('SELECT A.ORDEM ORDEM,

													 A.COMPONENTE COMPONENTE, 

													 C.VALORRGB COR
															
												FROM BI_COMPONENTECOR A

											   INNER JOIN BI_COMPONENTE B ON B.HANDLE = A.COMPONENTE

											    LEFT JOIN MS_COR C ON C.HANDLE = A.COR

											   WHERE B.STATUS = ' . Constantes::ComponenteStatusAtivo. '
												 AND EXISTS (SELECT Z.HANDLE FROM BI_PAINELCOMPONENTE Z WHERE Z.PAINEL = :PAINEL AND Z.COMPONENTE = B.HANDLE)

											   ORDER BY ORDEM');

			$query->bindParam(':PAINEL', $handlePainel, PDO::PARAM_INT);	
			$query->execute();				

			return $query->fetchAll(PDO::FETCH_ASSOC);
        }

		public function painelBuscarComponenteFiltro($handlePainel) {
			$query = $this->connect->prepare('SELECT A.*
															
												FROM BI_COMPONENTEFILTRO A
													
											   INNER JOIN BI_COMPONENTE B ON B.HANDLE = A.COMPONENTE

											   WHERE A.STATUS = ' . Constantes::ComponenteStatusAtivo. '
												 AND EXISTS (SELECT Z.HANDLE FROM BI_PAINELCOMPONENTE Z WHERE Z.PAINEL = :PAINEL AND Z.COMPONENTE = B.HANDLE)

											   ORDER BY TITULO');

			$query->bindParam(':PAINEL', $handlePainel, PDO::PARAM_INT);	
			$query->execute();		

			$componenteFiltro = $query->fetchAll(PDO::FETCH_ASSOC);
	
			return $componenteFiltro;
        }			

		public function painelBuscarComponenteIndicador($handlePainel) {
			$componenteIndicador = [];
			
			$query = $this->connect->prepare('SELECT A.IMAGEM IMAGEM,
												     A.ORDEM ORDEM,
													 A.REGRA REGRACOMPARACAO,
													 A.SQLCOMUMVALORVARIAVEL SQLCOMUMVALORVARIAVEL,
													 A.SQLORACLEVALORVARIAVEL SQLORACLEVALORVARIAVEL,
													 A.TIPOVALOR TIPOVALOR,
													 A.VALORFIXODATA VALORFIXODATA,
													 A.VALORFIXONUMERICO VALORFIXONUMERICO,
													 A.VALORFIXOTEXTO VALORFIXOTEXTO,

													 A.COMPONENTEINDICADOR COMPONENTEINDICADOR, 

													 E.VALORRGB CORFONTE,

													 F.VALORRGB CORFUNDO
															
												FROM BI_COMPONENTEINDICADORMARCADOR A

											   INNER JOIN BI_COMPONENTEINDICADOR B ON B.HANDLE = A.COMPONENTEINDICADOR
											   INNER JOIN BI_COMPONENTE D ON D.HANDLE = B.COMPONENTE

											    LEFT JOIN MS_COR E ON E.HANDLE = A.CORFONTE
												LEFT JOIN MS_COR F ON F.HANDLE = A.CORFUNDO

											   WHERE D.STATUS = ' . Constantes::ComponenteStatusAtivo. '
												 AND EXISTS (SELECT Z.HANDLE FROM BI_PAINELCOMPONENTE Z WHERE Z.PAINEL = :PAINEL AND Z.COMPONENTE = D.HANDLE)

											   ORDER BY ORDEM');

			$query->bindParam(':PAINEL', $handlePainel, PDO::PARAM_INT);	
			$query->execute();	
			
			$componenteIndicadorMarcador = $query->fetchAll(PDO::FETCH_ASSOC);
			
			$query = $this->connect->prepare('SELECT A.*
												FROM BI_COMPONENTEINDICADOR A 
											   INNER JOIN BI_COMPONENTE B ON B.HANDLE = A.COMPONENTE 
											   WHERE B.STATUS = ' . Constantes::ComponenteStatusAtivo. '
											     AND EXISTS (SELECT Z.HANDLE FROM BI_PAINELCOMPONENTE Z WHERE Z.PAINEL = :PAINEL AND Z.COMPONENTE = B.HANDLE)
											   ORDER BY ORDEM');
	
			$query->bindParam(':PAINEL', $handlePainel, PDO::PARAM_INT);
			$query->execute();

			while ($queryItem = $query->fetch(PDO::FETCH_ASSOC)) {
				$queryItem['FORMATACAO'] = $this->campoGerarFormatacao($queryItem['TIPOVALOR'], $queryItem['FORMATACAO']);

				$componenteIndicadorMarcadorIndice = array_keys(array_column($componenteIndicadorMarcador, 'COMPONENTEINDICADOR'), $queryItem['HANDLE']);

				foreach ($componenteIndicadorMarcadorIndice as $componenteIndicadorMarcadorIndiceItem) {
					if ($componenteIndicadorMarcador[$componenteIndicadorMarcadorIndiceItem]['TIPOVALOR'] == Constantes::ComponenteMarcadorTipoComparacaoValorVariavel)	{
						$componenteIndicadorMarcador[$componenteIndicadorMarcadorIndiceItem]['VALORCOMPARACAO'] = SQL::solverToNumber($componenteIndicadorMarcador[$componenteIndicadorMarcadorIndiceItem]['SQLCOMUMVALORVARIAVEL'], $componenteIndicadorMarcador[$componenteIndicadorMarcadorIndiceItem]['SQLORACLEVALORVARIAVEL'], []);
					}					
					else {
						switch ($queryItem['TIPOVALOR']) {
							case Constantes::ComponenteTipoCampoInteiro:
							case Constantes::ComponenteTipoCampoNumerico:
								$componenteIndicadorMarcador[$componenteIndicadorMarcadorIndiceItem]['VALORCOMPARACAO'] = $componenteIndicadorMarcador[$componenteIndicadorMarcadorIndiceItem]['VALORFIXONUMERICO'];

								break;
							
							case Constantes::ComponenteTipoCampoData:
								$componenteIndicadorMarcador[$componenteIndicadorMarcadorIndiceItem]['VALORCOMPARACAO'] = $componenteIndicadorMarcador[$componenteIndicadorMarcadorIndiceItem]['VALORFIXODATA'];

								break;
						
							default:
								$componenteIndicadorMarcador[$componenteIndicadorMarcadorIndiceItem]['VALORCOMPARACAO'] = $componenteIndicadorMarcador[$componenteIndicadorMarcadorIndiceItem]['VALORFIXOTEXTO'];

								break;
						}			
					}

					$queryItem['INDICADORMARCADOR'][] = (object)$componenteIndicadorMarcador[$componenteIndicadorMarcadorIndiceItem];
				}					

				$componenteIndicador[] = $queryItem;
			}

			return $componenteIndicador;
        }

		public function painelBuscarComponenteMedidor($handlePainel) {
			$componenteMedidor = [];
			
			$query = $this->connect->prepare('SELECT A.TITULO TITULO,
												     A.VALORINICIAL VALORINICIAL,
													 A.VALORFINAL VALORFINAL,

													 A.COMPONENTEMEDIDOR COMPONENTEMEDIDOR, 

													 E.VALORRGB COR
															
												FROM BI_COMPONENTEMEDIDORGRUPO A

											   INNER JOIN BI_COMPONENTEMEDIDOR B ON B.HANDLE = A.COMPONENTEMEDIDOR
											   INNER JOIN BI_COMPONENTE D ON D.HANDLE = B.COMPONENTE

											    LEFT JOIN MS_COR E ON E.HANDLE = A.COR

											   WHERE D.STATUS = ' . Constantes::ComponenteStatusAtivo. '
												 AND EXISTS (SELECT Z.HANDLE FROM BI_PAINELCOMPONENTE Z WHERE Z.PAINEL = :PAINEL AND Z.COMPONENTE = D.HANDLE)

											   ORDER BY VALORINICIAL');

			$query->bindParam(':PAINEL', $handlePainel, PDO::PARAM_INT);	
			$query->execute();	
			
			$componenteMedidorGrupo = $query->fetchAll(PDO::FETCH_ASSOC);
			
			$query = $this->connect->prepare('SELECT A.*
												FROM BI_COMPONENTEMEDIDOR A 
											   INNER JOIN BI_COMPONENTE B ON B.HANDLE = A.COMPONENTE 
											   WHERE B.STATUS = ' . Constantes::ComponenteStatusAtivo. '
											     AND EXISTS (SELECT Z.HANDLE FROM BI_PAINELCOMPONENTE Z WHERE Z.PAINEL = :PAINEL AND Z.COMPONENTE = B.HANDLE)
											   ORDER BY ORDEM');
	
			$query->bindParam(':PAINEL', $handlePainel, PDO::PARAM_INT);
			$query->execute();

			while ($queryItem = $query->fetch(PDO::FETCH_ASSOC)) {
				$queryItem['FORMATACAO'] = $this->campoGerarFormatacao(Constantes::ComponenteTipoCampoNumerico, $queryItem['FORMATACAO']);

				$componenteMedidorGrupoIndice = array_keys(array_column($componenteMedidorGrupo, 'COMPONENTEMEDIDOR'), $queryItem['HANDLE']);

				foreach ($componenteMedidorGrupoIndice as $componenteMedidorGrupoIndiceItem) {
					$queryItem['MEDIDORGRUPO'][] = (object)$componenteMedidorGrupo[$componenteMedidorGrupoIndiceItem];
				}	

				$componenteMedidor[] = $queryItem;
			}

			return $componenteMedidor;
        }	

		private function painelCalcularTamanhoColuna($item, $itemNivelSuperior, $larguraPainel) {
			if ($larguraPainel <= 600) {
				return 100;
			}
			else {
				$tamanho = 0;		

				if ((isset($item->largura)) && (isset($itemNivelSuperior->largura)) && ($itemNivelSuperior->largura > 0)) {
					$tamanho = (($item->largura / $itemNivelSuperior->largura) * 100);

					if ($tamanho > $itemNivelSuperior->saldoLargura) {
						$tamanho = $itemNivelSuperior->saldoLargura;
					}

					if ((!isset($itemNivelSuperior->orientacao)) || ($itemNivelSuperior->orientacao != Constantes::ComponenteOrientacaoVertical)) {		
						$itemNivelSuperior->saldoLargura -= $tamanho;
					}	
					
					return $tamanho;
				}
			}
		}

		private function painelGerarElementoHtmlComponente($item, $itemNivelSuperior, $larguraPainel, &$componente) {
			$elementoHtml = $this->elementoHtmlNovo(null, 'div');
			$elementoHtml->atributo['style'][] = 'width:'. $this->painelCalcularTamanhoColuna($item, $itemNivelSuperior, $larguraPainel) . '%';			

			if (isset($item->item)) {	
				$item->quantidadeItem = count($item->item);
				$item->saldoLargura = 100;
				
				foreach ($item->item as $itemItem) {	
					$elementoHtml->item[] = $this->painelGerarElementoHtmlComponente($itemItem, $item, $larguraPainel, $componente);
				}
			}
			else if (isset($item->identificador)) {			
				$elementoHtml->atributo['class'][] = 'componente';
				$elementoHtml->atributo['id'] = $item->identificador;				
				
				$componenteIndice = array_keys(array_column($componente, 'IDENTIFICADORINTERNO'), $item->identificador);

				if (count($componenteIndice) > 0) {
					$componente[$componenteIndice[0]]['ALTURA'] = $item->altura;
					$componente[$componenteIndice[0]]['LARGURA'] = $item->largura;
					
					$elementoHtml->item[] = $this->componenteGerarElementoHtml((object)$componente[$componenteIndice[0]]);
				}
			}			

			if (isset($itemNivelSuperior->orientacao)) {
			 	switch($itemNivelSuperior->orientacao) {
					case Constantes::ComponenteOrientacaoVertical:
						$divComplementar = $elementoHtml;

						$elementoHtml = $this->elementoHtmlNovo(null, 'div');
						$elementoHtml->atributo['class'][] = 'componente';
						$elementoHtml->atributo['style'][] = 'width:100%';
						$elementoHtml->item[] = $divComplementar;

						break;
					
					case Constantes::ComponenteOrientacaoHorizontal:
						if ($itemNivelSuperior->quantidadeItem > 1) {
							$elementoHtml->atributo['style'][] = 'display:inline-grid';
						}						
						break;
				}
			}

			return $elementoHtml;
		}	

		private function painelGerarElementoHtmlFiltro($componente) {
			$filtroUtilizado = [];
			
			$elementoHtmlModal = $this->elementoHtmlNovo(null, 'div');
			$elementoHtmlModal->atributo['class'][] = 'modal';
			$elementoHtmlModal->atributo['id'] = 'painel_filtro';
			$elementoHtmlModal->atributo['role'] = 'dialog';
			$elementoHtmlModal->atributo['tabindex'] = '-1';

			$elementoHtmlModalDialog = $this->elementoHtmlNovo($elementoHtmlModal, 'div');
			$elementoHtmlModalDialog->atributo['class'][] = 'modal-dialog';

			$elementoHtmlConteudo = $this->elementoHtmlNovo($elementoHtmlModalDialog, 'div');
			$elementoHtmlConteudo->atributo['class'][] = 'modal-content';

			$elementoHtmlCabecalho = $this->elementoHtmlNovo($elementoHtmlConteudo, 'div');
			$elementoHtmlCabecalho->atributo['class'][] = 'modal-header';

			$elementoHtmlCabecalhoLegenda = $this->elementoHtmlNovo($elementoHtmlCabecalho, 'h5');
			$elementoHtmlCabecalhoLegenda->atributo['class'][] = 'modal-title';
			$elementoHtmlCabecalhoLegenda->conteudo = 'Filtrar';

			$elementoHtmlCorpo = $this->elementoHtmlNovo($elementoHtmlConteudo, 'div');
			$elementoHtmlCorpo->atributo['class'][] = 'modal-body';
			$elementoHtmlCorpo->atributo['style'][] = 'font-size:12px';
			
			$elementoHtmlCorpoLinha = $this->elementoHtmlNovo($elementoHtmlCorpo, 'div');			
			$elementoHtmlCorpoLinha->atributo['class'][] = 'row';

			$elementoHtmlRodape = $this->elementoHtmlNovo($elementoHtmlConteudo, 'div');
			$elementoHtmlRodape->atributo['class'][] = 'modal-footer';

			$elementoHtmlRodapeBotao = $this->elementoHtmlNovo($elementoHtmlRodape, 'div');
			$elementoHtmlRodapeBotao->atributo['class'][] = 'btn';
			$elementoHtmlRodapeBotao->atributo['class'][] = 'btn-default';
			$elementoHtmlRodapeBotao->atributo['onclick'] = 'fecharModalFiltro()';
			$elementoHtmlRodapeBotao->atributo['type'] = 'button';
			$elementoHtmlRodapeBotao->conteudo = 'Ok';

			foreach ($componente as $componenteItem) {
				if (isset($componenteItem['FILTRO'])) {
					foreach ($componenteItem['FILTRO'] as $componenteItemFiltro) {
						if (!in_array($componenteItemFiltro->NOME, $filtroUtilizado)) {
								
							$elementoHtmlAgrupador = $this->elementoHtmlNovo($elementoHtmlCorpoLinha, 'div');
							$elementoHtmlAgrupador->atributo['class'][] = 'col-md-12';
							
							// titulo
							$elementoHtmlTituloLinha = $this->elementoHtmlNovo($elementoHtmlAgrupador, 'div');
							$elementoHtmlTituloLinha->atributo['class'][] = 'col-md-12';
	
							$elementoHtmlTituloLinhaValor = $this->elementoHtmlNovo($elementoHtmlTituloLinha, 'label');
							$elementoHtmlTituloLinhaValor->conteudo = $componenteItemFiltro->TITULO;		
	
							// valor	
							switch ($componenteItemFiltro->TIPO) {
								case Constantes::ComponenteTipoFiltroData:								
									$this->painelGerarElementoHtmlFiltroCampoData($componenteItemFiltro, $elementoHtmlAgrupador);
	
									break;
	
								case Constantes::ComponenteTipoFiltroNumerico:										
									$this->painelGerarElementoHtmlFiltroCampoNumerico($componenteItemFiltro, $elementoHtmlAgrupador);

									break;
	
								case Constantes::ComponenteTipoFiltroLista:
								case Constantes::ComponenteTipoFiltroTabela:
									$this->painelGerarElementoHtmlFiltroCampoTabela($componenteItemFiltro, $elementoHtmlAgrupador);
	
									break;	
								case Constantes::ComponenteTipoFiltroTexto:
									$this->painelGerarElementoHtmlFiltroCampoTexto($componenteItemFiltro, $elementoHtmlAgrupador);
		
									break;							
							}
							
							$filtroUtilizado[] = $componenteItemFiltro->NOME;
						}
					}
				}
			}

			return $elementoHtmlModal;
		}	

		private function painelGerarElementoHtmlFiltroCampoData($componenteItemFiltro, $elementoHtmlNivelSuperior) {
			$formatoData = strtoupper(str_replace('-', '', str_replace('/', '', BancoDados::getMascaraData())));
					
			// monta mascara
			$mascaraSugestaoInput = '';
			$mascaraValorPadrao = '';	
			$mascaraValidacaoInput = '';
	
			if (in_array($componenteItemFiltro->TIPODATA, [Constantes::ComponenteFiltroTipoDataData, Constantes::ComponenteFiltroTipoDataDataHora])) {
				if ($componenteItemFiltro->FORMATODATA == Constantes::ComponenteFiltroFormatoDataDiaMesAno) {
					$mascaraSugestaoInput .= 'DD/MM/AAAA';
					$mascaraValidacaoInput .= '00/00/0000';
					$mascaraValorPadrao .= 'd/m/Y';
				}
				else {
					$mascaraSugestaoInput .= 'MM/AAAA';
					$mascaraValidacaoInput .= '00/0000';
					$mascaraValorPadrao .= 'm/Y';
				}
	
				if ($componenteItemFiltro->TIPODATA == Constantes::ComponenteFiltroTipoDataDataHora) {
					$mascaraSugestaoInput .= ' ';
					$mascaraValidacaoInput .= ' ';
					$mascaraValorPadrao .= ' ';
				}
			}
	
			if (in_array($componenteItemFiltro->TIPODATA, [Constantes::ComponenteFiltroTipoDataDataHora, Constantes::ComponenteFiltroTipoDataHora])) {
				if ($componenteItemFiltro->FORMATOHORA == Constantes::ComponenteFiltroFormatoHoraHoraMinutoSegundo) {
					$mascaraSugestaoInput .= 'hh:mm:ss';
					$mascaraValidacaoInput .= '00:00:00';
					$mascaraValorPadrao .= 'H:i:s';
				}
				else {
					$mascaraSugestaoInput .= 'hh:mm';
					$mascaraValidacaoInput .= '00:00';
					$mascaraValorPadrao .= 'H:i';
				}
			}
			
			
			foreach (['DE', 'ATE'] as $tipoData) {
				
				// monta valor padrao do filtro
				$valorPadraoData = 0;

				switch ($componenteItemFiltro->VALORPADRAODATA) {
					case Constantes::ComponenteFiltroTipoValorPadraoDiaAtual:
						if ($tipoData == 'DE') {
							$valorPadraoData = new datetime(date('Y-m-d'));
						}
						else {
							$valorPadraoData = new datetime(date('Y-m-d 23:59:00'));
						}

						break;
				
					case Constantes::ComponenteFiltroTipoValorPadraoSemanaAtual:
						$valorPadraoData = new DateTime();

						if ($tipoData == 'DE') {
							$valorPadraoData = $valorPadraoData->modify('monday this week 00:00:00');
						}
						else {
							$valorPadraoData = $valorPadraoData->modify('sunday this week 23:59:00');
						}
						
						break;
					
					case Constantes::ComponenteFiltroTipoValorPadraoMesAtual:
						if ($tipoData == 'DE') {
							$valorPadraoData = new datetime(date('Y-m-1'));
						}
						else {
							$valorPadraoData = new datetime(date('Y-m-t 23:59:00'));
						}

						break;
					
					case Constantes::ComponenteFiltroTipoValorPadraoAnoAtual:
						if ($tipoData == 'DE') {
							$valorPadraoData = new datetime(date('Y-1-1'));
						}
						else {
							$valorPadraoData = new datetime(date('Y-12-31 23:59:00'));
						}
						
						break;
					
					default:
						if ($tipoData == 'DE') {
							$valorPadraoData = new datetime(date('1899-12-01 00:00:00'));
						}
						else {
							$valorPadraoData = new datetime(date('1899-12-01 00:00:00'));
						}
					
						break;
				}

				// monta edit
				$elementoHtmlCampoLinha = $this->elementoHtmlNovo($elementoHtmlNivelSuperior, 'div');
				$elementoHtmlCampoLinha->atributo['class'][] = 'col-md-4';
							
				$elementoHtmlCampoLinhaEdit = $this->elementoHtmlNovo($elementoHtmlCampoLinha, 'input');
				$elementoHtmlCampoLinhaEdit->atributo['class'][] = 'form-control';
				$elementoHtmlCampoLinhaEdit->atributo['class'][] = 'campo';
				$elementoHtmlCampoLinhaEdit->atributo['data-mask'] = $mascaraValidacaoInput;
				$elementoHtmlCampoLinhaEdit->atributo['id'] = 'painel_filtro_'. $componenteItemFiltro->NOME. $tipoData;
				$elementoHtmlCampoLinhaEdit->atributo['maxlength'] = strlen($mascaraSugestaoInput);								
				$elementoHtmlCampoLinhaEdit->atributo['onblur'] = 'validarDataModalFiltro(this)';
				$elementoHtmlCampoLinhaEdit->atributo['placeholder'] = $mascaraSugestaoInput;										
				$elementoHtmlCampoLinhaEdit->atributo['type'] = 'text';										
	
				$elementoHtmlCampoLinhaEdit->atributo['formatodata'] = $formatoData;
				$elementoHtmlCampoLinhaEdit->atributo['legenda'] = $componenteItemFiltro->TITULO;
				$elementoHtmlCampoLinhaEdit->atributo['obrigatorio'] = $componenteItemFiltro->EHOBRIGATORIO;
				$elementoHtmlCampoLinhaEdit->atributo['tipo'] = $componenteItemFiltro->TIPO;	
										
				$elementoHtmlCampoLinhaEdit->atributo['value'] = $valorPadraoData->format($mascaraValorPadrao);
				$elementoHtmlCampoLinhaEdit->atributo['valorcomparacao'] = $valorPadraoData->format('Y/m/d H:i:s');
			}
		}
			
		private function painelGerarElementoHtmlFiltroCampoNumerico($componenteItemFiltro, $elementoHtmlNivelSuperior) {
			foreach (['DE', 'ATE'] as $tipoNumero) {
				
				// monta valor padrao do filtro
				if ($tipoNumero == 'DE') {
					$valorPadraoNumerico = $componenteItemFiltro->VALORPADRAONUMERICODE;
				}
				else {
					$valorPadraoNumerico = $componenteItemFiltro->VALORPADRAONUMERICOATE;
				}
	
				if (($valorPadraoNumerico == '0.0000') || ($valorPadraoNumerico == '.0000')) {
					$valorPadraoNumerico = 0;
				}

				// monta edit
				$elementoHtmlCampoLinha = $this->elementoHtmlNovo($elementoHtmlNivelSuperior, 'div');
				$elementoHtmlCampoLinha->atributo['class'][] = 'col-md-4';
							
				$elementoHtmlCampoLinhaEdit = $this->elementoHtmlNovo($elementoHtmlCampoLinha, 'input');
				$elementoHtmlCampoLinhaEdit->atributo['class'][] = 'form-control';
				$elementoHtmlCampoLinhaEdit->atributo['class'][] = 'campo';
				$elementoHtmlCampoLinhaEdit->atributo['id'] = 'painel_filtro_'. $componenteItemFiltro->NOME. $tipoNumero;
				$elementoHtmlCampoLinhaEdit->atributo['onblur'] = 'validarNumericoModalFiltro(this)';
				$elementoHtmlCampoLinhaEdit->atributo['step'] = '0.0001';										
				$elementoHtmlCampoLinhaEdit->atributo['type'] = 'number';
				$elementoHtmlCampoLinhaEdit->atributo['value'] = $valorPadraoNumerico;

				$elementoHtmlCampoLinhaEdit->atributo['legenda'] = $componenteItemFiltro->TITULO;
				$elementoHtmlCampoLinhaEdit->atributo['obrigatorio'] = $componenteItemFiltro->EHOBRIGATORIO;
				$elementoHtmlCampoLinhaEdit->atributo['tipo'] = $componenteItemFiltro->TIPO;
			}
		}		
		
		private function painelGerarElementoHtmlFiltroCampoTabela($componenteItemFiltro, $elementoHtmlNivelSuperior) {
			$parametro = $this->painelGerarElementoHtmlFiltroCampoTabelaParametro($componenteItemFiltro);
									
			$elementoHtmlCampoLinha = $this->elementoHtmlNovo($elementoHtmlNivelSuperior, 'div');
			$elementoHtmlCampoLinha->atributo['class'][] = 'col-md-12';
			$elementoHtmlCampoLinha->atributo['class'][] = 'input-group';
						
			$elementoHtmlCampoLinhaEdit = $this->elementoHtmlNovo($elementoHtmlCampoLinha, 'input');
			$elementoHtmlCampoLinhaEdit->atributo['class'][] = 'form-control';
			$elementoHtmlCampoLinhaEdit->atributo['class'][] = 'campo';
			$elementoHtmlCampoLinhaEdit->atributo['disabled'][] = 'true';
			$elementoHtmlCampoLinhaEdit->atributo['id'] = 'painel_filtro_'. $componenteItemFiltro->NOME;
			$elementoHtmlCampoLinhaEdit->atributo['placeholder'] = 'Buscar '. strtolower($componenteItemFiltro->TITULO);
			$elementoHtmlCampoLinhaEdit->atributo['type'] = 'text';
			$elementoHtmlCampoLinhaEdit->atributo['value'] = $this->painelGerarElementoHtmlFiltroCampoTabelaTraducao($parametro, $componenteItemFiltro->VALORPADRAOTABELA);
			$elementoHtmlCampoLinhaEdit->atributo['valorcomparacao'] = $componenteItemFiltro->VALORPADRAOTABELA;

			$elementoHtmlCampoLinhaEdit->atributo['legenda'] = $componenteItemFiltro->TITULO;
			$elementoHtmlCampoLinhaEdit->atributo['obrigatorio'] = $componenteItemFiltro->EHOBRIGATORIO;
			$elementoHtmlCampoLinhaEdit->atributo['tipo'] = $componenteItemFiltro->TIPO;

			$elementoHtmlCampoLinhaBotao = $this->elementoHtmlNovo($elementoHtmlCampoLinha, 'div');
			$elementoHtmlCampoLinhaBotao->atributo['class'][] = 'input-group-btn';

			$elementoHtmlCampoLinhaBotaoRemover = $this->elementoHtmlNovo($elementoHtmlCampoLinhaBotao, 'button');
			$elementoHtmlCampoLinhaBotaoRemover->atributo['class'][] = 'btn';
			$elementoHtmlCampoLinhaBotaoRemover->atributo['class'][] = 'btn-default';
			$elementoHtmlCampoLinhaBotaoRemover->atributo['id'] = 'painel_filtro_'. $componenteItemFiltro->NOME. '_botao_remover';
			$elementoHtmlCampoLinhaBotaoRemover->atributo['onclick'][] = 'removerSelecaoModalFiltro(this)';
			$elementoHtmlCampoLinhaBotaoRemover->atributo['type'] = 'submit';
									
			if (($componenteItemFiltro->VALORPADRAOTABELA == '') || ($componenteItemFiltro->VALORPADRAOTABELA == '0')) {
				$elementoHtmlCampoLinhaBotaoRemover->atributo['style'][] = 'display:none';
			}

			$elementoHtmlCampoLinhaBotaoRemoverImagem = $this->elementoHtmlNovo($elementoHtmlCampoLinhaBotaoRemover, 'i');
			$elementoHtmlCampoLinhaBotaoRemoverImagem->atributo['class'][] = 'glyphicon';
			$elementoHtmlCampoLinhaBotaoRemoverImagem->atributo['class'][] = 'glyphicon-remove';

			$elementoHtmlCampoLinhaBotaoBuscar = $this->elementoHtmlNovo($elementoHtmlCampoLinhaBotao, 'button');
			$elementoHtmlCampoLinhaBotaoBuscar->atributo['class'][] = 'btn';
			$elementoHtmlCampoLinhaBotaoBuscar->atributo['class'][] = 'btn-default';
			$elementoHtmlCampoLinhaBotaoBuscar->atributo['id'] = 'painel_filtro_'. $componenteItemFiltro->NOME. '_botao_buscar';
			$elementoHtmlCampoLinhaBotaoBuscar->atributo['onclick'][] = 'abrirModalFiltroSelecao(this)';
			$elementoHtmlCampoLinhaBotaoBuscar->atributo['type'] = 'submit';
			$elementoHtmlCampoLinhaBotaoBuscar->atributo['parametro'] = base64_encode(json_encode($parametro));

			$elementoHtmlCampoLinhaBotaoBuscarImagem = $this->elementoHtmlNovo($elementoHtmlCampoLinhaBotaoBuscar, 'i');
			$elementoHtmlCampoLinhaBotaoBuscarImagem->atributo['class'][] = 'glyphicon';
			$elementoHtmlCampoLinhaBotaoBuscarImagem->atributo['class'][] = 'glyphicon-search';
		}

		private function painelGerarElementoHtmlFiltroCampoTabelaParametro($filtro) {
			$parametro = (object)[];
			$parametro->campo = [];			
			
			$tamanho = 0;
			$tamanhoTotal = 0;
			
			$query = $this->connect->prepare('SELECT A.NOME TABELA,

													 B.ORDEM ORDEM, 

													 C.DESCRICAO DESCRICAO,
													 C.NOME NOME,
													 C.TAMANHOSTRING TAMANHOSTRING,
													 C.TIPOCAMPO TIPOCAMPO

												FROM MD_TABELA A 
											    
												LEFT JOIN MD_TABELALOOKUP B ON B.TABELA = A.HANDLE AND B.TRADUCAO IS NULL
											    LEFT JOIN MD_CAMPO C ON C.HANDLE = B.CAMPO

											   WHERE A.HANDLE = :TABELA
											   ORDER BY ORDEM');
	
			$query->bindParam(':TABELA', $filtro->TABELA, PDO::PARAM_INT);
			$query->execute();

			while ($queryItem = $query->fetch(PDO::FETCH_ASSOC)) {			
				switch ($queryItem['TIPOCAMPO']) {
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
						$tamanho = ($queryItem['TAMANHOSTRING']);

						if ($tamanho < 100) {
							$tamanho = 100;
						}

						break;	

					default:
						$tamanho = 150;

						break;
				}

				$parametro->tabela = $queryItem['TABELA'];

				if ($queryItem['NOME'] != '') {				
					$parametro->campo[] = (object)[
						'nome' => $queryItem['NOME'],
						'titulo' => $queryItem['DESCRICAO'],
						'tamanho' => $tamanho
					];

					$tamanhoTotal +=$tamanho;
				}
			}

			if (count($parametro->campo) == 0) {
				$parametro->campo[] = (object)[
					'nome' => 'HANDLE',
					'titulo' => 'Handle',
					'tamanho' => '100'
				];				
			}
			else {
				$tamanhoSaldo = 100;

				foreach($parametro->campo as $campoIndice => $campoItem) {
					if (count($parametro->campo) == ($campoIndice + 1)) {
						$campoItem->tamanho = $tamanhoSaldo;
					}
					else {
						$campoItem->tamanho = floor(($campoItem->tamanho / $tamanhoTotal) * 100);
						$tamanhoSaldo -= $campoItem->tamanho;
					}
				}
			}

			if ($filtro->TIPO == Constantes::ComponenteTipoFiltroLista) {
				$parametro->localwheredefault = ' A.COMPONENTEFILTRO = '. $filtro->HANDLE;
			}
			else {
				$parametro->localwheredefault = '';
			}

			return $parametro;
		}
	
		private function painelGerarElementoHtmlFiltroCampoTabelaTraducao($jsonParametro, $valorPadrao) {
			if (($valorPadrao == '') || ($valorPadrao == '0')) {
				return '';
			}
			else {
				$registro = $this->filtroSelecaoBuscarQuery($jsonParametro->tabela, $jsonParametro->campo, ' A.HANDLE = '. $valorPadrao, '', '', true)->fetchAll(PDO::FETCH_ASSOC);

				if (count($registro) == 0) {
					return '';
				}
				else {
					$valor = '';

					foreach ($jsonParametro->campo as $campoItem) {
						if ($valor != '') {
							$valor .= ' - ';							
						}

						$valor .= $registro[0][$campoItem->nome];
					}

					return $valor;
				}
			}
		}

		private function painelGerarElementoHtmlFiltroCampoTexto($componenteItemFiltro, $elementoHtmlNivelSuperior) {
			$elementoHtmlCampoLinha = $this->elementoHtmlNovo($elementoHtmlNivelSuperior, 'div');
			$elementoHtmlCampoLinha->atributo['class'][] = 'col-md-12';
							
			$elementoHtmlCampoLinhaEdit = $this->elementoHtmlNovo($elementoHtmlCampoLinha, 'input');
			$elementoHtmlCampoLinhaEdit->atributo['class'][] = 'form-control';
			$elementoHtmlCampoLinhaEdit->atributo['class'][] = 'campo';
			$elementoHtmlCampoLinhaEdit->atributo['id'] = 'painel_filtro_'. $componenteItemFiltro->NOME;								
			$elementoHtmlCampoLinhaEdit->atributo['type'] = 'text';
			$elementoHtmlCampoLinhaEdit->atributo['value'] = $componenteItemFiltro->VALORPADRAOTEXTO;
		
			$elementoHtmlCampoLinhaEdit->atributo['legenda'] = $componenteItemFiltro->TITULO;
			$elementoHtmlCampoLinhaEdit->atributo['obrigatorio'] = $componenteItemFiltro->EHOBRIGATORIO;
			$elementoHtmlCampoLinhaEdit->atributo['tipo'] = $componenteItemFiltro->TIPO;	
		}
		
		private function painelGerarElementoHtmlFiltroSelecao() {
			$elementoHtmlModal = $this->elementoHtmlNovo(null, 'div');
			$elementoHtmlModal->atributo['class'][] = 'modal';
			$elementoHtmlModal->atributo['id'] = 'painel_filtro_selecao';
			$elementoHtmlModal->atributo['role'] = 'dialog';
			$elementoHtmlModal->atributo['tabindex'] = '-1';

			$elementoHtmlModalDialog = $this->elementoHtmlNovo($elementoHtmlModal, 'div');
			$elementoHtmlModalDialog->atributo['class'][] = 'modal-dialog';
			$elementoHtmlModalDialog->atributo['class'][] = 'modal-lg';			

			$elementoHtmlConteudo = $this->elementoHtmlNovo($elementoHtmlModalDialog, 'div');
			$elementoHtmlConteudo->atributo['class'][] = 'modal-content';

			$elementoHtmlCabecalho = $this->elementoHtmlNovo($elementoHtmlConteudo, 'div');
			$elementoHtmlCabecalho->atributo['class'][] = 'modal-header';

			$elementoHtmlCabecalhoLegenda = $this->elementoHtmlNovo($elementoHtmlCabecalho, 'h5');
			$elementoHtmlCabecalhoLegenda->atributo['class'][] = 'modal-title';
			$elementoHtmlCabecalhoLegenda->conteudo = 'Selecionar registro';
			
			$elementoHtmlCorpo = $this->elementoHtmlNovo($elementoHtmlConteudo, 'div');
			$elementoHtmlCorpo->atributo['class'][] = 'modal-body';
			$elementoHtmlCorpo->atributo['style'][] = 'font-size:12px';

			$elementoHtmlCorpoLinha = $this->elementoHtmlNovo($elementoHtmlCorpo, 'div');			
			$elementoHtmlCorpoLinha->atributo['class'][] = 'row';

			$elementoHtmlCorpoLinhaBusca = $this->elementoHtmlNovo($elementoHtmlCorpoLinha, 'div');
			$elementoHtmlCorpoLinhaBusca->atributo['class'][] = 'col-md-12';
			$elementoHtmlCorpoLinhaBusca->atributo['class'][] = 'input-group';

			$elementoHtmlCorpoLinhaBuscaEdit = $this->elementoHtmlNovo($elementoHtmlCorpoLinhaBusca, 'input');
			$elementoHtmlCorpoLinhaBuscaEdit->atributo['class'][] = 'form-control';
			$elementoHtmlCorpoLinhaBuscaEdit->atributo['class'][] = 'campo';
			$elementoHtmlCorpoLinhaBuscaEdit->atributo['id'] = 'painel_filtro_selecao_edit';
			$elementoHtmlCorpoLinhaBuscaEdit->atributo['placeholder'] = 'Procurar resgistro';
			$elementoHtmlCorpoLinhaBuscaEdit->atributo['type'] = 'text';
			
			$elementoHtmlCorpoLinhaBuscaBotao = $this->elementoHtmlNovo($elementoHtmlCorpoLinhaBusca, 'div');
			$elementoHtmlCorpoLinhaBuscaBotao->atributo['class'][] = 'input-group-btn';

			$elementoHtmlCorpoLinhaBuscaBotaoBuscar = $this->elementoHtmlNovo($elementoHtmlCorpoLinhaBuscaBotao, 'button');
			$elementoHtmlCorpoLinhaBuscaBotaoBuscar->atributo['class'][] = 'btn';
			$elementoHtmlCorpoLinhaBuscaBotaoBuscar->atributo['class'][] = 'btn-default';
			$elementoHtmlCorpoLinhaBuscaBotaoBuscar->atributo['onclick'][] = 'buscarRegistroModalFiltroSelecao()';
			$elementoHtmlCorpoLinhaBuscaBotaoBuscar->atributo['type'] = 'submit';

			$elementoHtmlCorpoLinhaBuscaBotaoBuscarImagem = $this->elementoHtmlNovo($elementoHtmlCorpoLinhaBuscaBotaoBuscar, 'i');
			$elementoHtmlCorpoLinhaBuscaBotaoBuscarImagem->atributo['class'][] = 'glyphicon';
			$elementoHtmlCorpoLinhaBuscaBotaoBuscarImagem->atributo['class'][] = 'glyphicon-search';

			$elementoHtmlCorpoLinhaTabela = $this->elementoHtmlNovo($elementoHtmlCorpoLinha, 'div');
			$elementoHtmlCorpoLinhaTabela->atributo['id'] = 'painel_filtro_selecao_tabela';

			$elementoHtmlRodape = $this->elementoHtmlNovo($elementoHtmlConteudo, 'div');
			$elementoHtmlRodape->atributo['class'][] = 'modal-footer';

			$elementoHtmlRodapeBotao = $this->elementoHtmlNovo($elementoHtmlRodape, 'div');
			$elementoHtmlRodapeBotao->atributo['class'][] = 'input-group-btn';

			$elementoHtmlRodapeBotaoFechar = $this->elementoHtmlNovo($elementoHtmlRodapeBotao, 'button');
			$elementoHtmlRodapeBotaoFechar->atributo['class'][] = 'btn';
			$elementoHtmlRodapeBotaoFechar->atributo['class'][] = 'btn-default';
			$elementoHtmlRodapeBotaoFechar->atributo['onclick'][] = 'fecharModalFiltroSelecao()';
			$elementoHtmlRodapeBotaoFechar->atributo['type'] = 'submit';
			$elementoHtmlRodapeBotaoFechar->conteudo = 'Fechar';			

			return $elementoHtmlModal;
		}

		private function painelGerarElementoHtmlParametro($componente) {
			$elementoHtml = $this->elementoHtmlNovo(null, 'input');
			$elementoHtml->atributo['id'] = 'painel_parametro';
			$elementoHtml->atributo['type'] = 'hidden';
			$elementoHtml->atributo['value'] = strtr(base64_encode(gzcompress(serialize($componente))), '+/=', '-_,');

			return $elementoHtml;
		}

		private function tabelaAtualizarValor($componente, $alturaPainel, $larguraPainel, $filtroPainel) {			
			$componente->totalizador = [];

			$elementoHtml = $this->elementoHtmlNovo(null, 'div');
			$elementoHtml->atributo['class'][] = 'col-xs-12';
			$elementoHtml->atributo['class'][] = 'col-md-12';
			$elementoHtml->atributo['class'][] = 'table-responsive';

			if (isset($componente->CAMPO)) {
				if ($larguraPainel >= 800) {
					$elementoHtml->atributo['style'][] = 'height:'. floor(($componente->ALTURA / Constantes::AlturaPainel) * $alturaPainel). 'px';
				}

				$elementoHtml->item[] = $this->tabelaGerarElementoHtmlCabecalho($componente);
				$elementoHtml->item[] = $this->tabelaGerarElementoHtmlCorpo($componente, $filtroPainel);
				$elementoHtml->item[] = $this->tabelaGerarElementoHtmlRodape($componente);
			}

			return [
				'elementoDestino' => $componente->IDENTIFICADORINTERNO. '_corpo',
				'tipo' => 'texto',
				'valor' => $this->elementoHtmlGerarTextoHtml($elementoHtml)
			];
		}

		private function tabelaGerarElementoHtmlCabecalho($componente) {
			if ($componente->EHEXIBIRCABECALHOTABELA == 'S') {
				$elementoHtmlTable = $this->tabelaGerarElementoHtmlNovo($componente, 'cabecalho');
				$elementoHtmlThead = $this->elementoHtmlNovo($elementoHtmlTable, 'thead');
				$elementoHtmlTr = $this->elementoHtmlNovo($elementoHtmlThead, 'tr');
				
				if (isset($componente->CAMPO)) {
					foreach ($componente->CAMPO as $componenteIndice => $componenteCampo)
					{
						$elementoHtmlTh = $this->elementoHtmlNovo($elementoHtmlTr, 'th');
						$elementoHtmlTh->conteudo = $componenteCampo->TITULO;
						
						$elementoHtmlTh->atributo['onclick'] = 'ordernarTabela(this)';

						$elementoHtmlTh->atributo['style'][] = 'font-size:'. $componente->FONTECABECALHOTABELA. 'px';
						$elementoHtmlTh->atributo['style'][] = 'width:'. $componenteCampo->TAMANHO. '%';
						$elementoHtmlTh->atributo['data-f-bold'] = 'true';

						switch ($componenteCampo->TIPO) {
							case Constantes::ComponenteTipoCampoInteiro:
							case Constantes::ComponenteTipoCampoNumerico:
								$elementoHtmlTh->atributo['class'][] = 'th-number';
								$elementoHtmlTh->atributo['style'][] = 'text-align:center';	
								$elementoHtmlTh->atributo['data-a-h'] = 'center';
														

								break;

							case Constantes::ComponenteTipoCampoData:
								$elementoHtmlTh->atributo['class'][] = 'th-date';
								$elementoHtmlTh->atributo['style'][] = 'text-align:center';	
								$elementoHtmlTh->atributo['data-a-h'] = 'center';

								break;								
						}
					}
					
					return $elementoHtmlTable;
				}
			}
		}	

		private function convertColorRgbKml($rgb) {
			$array = explode(",", $rgb, 3);
			
			return sprintf("%02x%02x%02x", $array[0], $array[1], $array[2]);
		}

		private function tabelaGerarElementoHtmlCorpo($componente, $filtroPainel) {
			foreach ($componente->CAMPO as $componenteIndice => $componenteCampo) {
				if ($componenteCampo->EHTOTALIZAR == 'S') {
					$componente->totalizador[$componenteIndice] = 0;					
				}
				else {
					$componente->totalizador[$componenteIndice] = 'N';
				}					
			}
			
			$query = SQL::solver($componente->SQLCOMUM, $componente->SQLORACLE, $filtroPainel);

			$elementoHtmlTable = $this->tabelaGerarElementoHtmlNovo($componente, 'corpo');
			$elementoHtmlBody = $this->elementoHtmlNovo($elementoHtmlTable, 'body');

			while ($queryItem = $query->fetch(PDO::FETCH_ASSOC)) {
				$elementoHtmlTr = $this->elementoHtmlNovo($elementoHtmlBody, 'tr');
					
				foreach ($componente->CAMPO as $componenteIndice => $componenteCampo) {
					$elementoHtmlTd = $this->elementoHtmlNovo($elementoHtmlTr, 'td');

					$elementoHtmlTd->atributo['style'][] = 'width:'. $componenteCampo->TAMANHO. '%';
					$elementoHtmlTd->atributo['style'][] = 'font-size:'. $componente->FONTEGRIDTABELA. 'px';

					if (isset($queryItem[$componenteCampo->NOME])) {

						switch ($componenteCampo->TIPO) {
							case Constantes::ComponenteTipoCampoInteiro:
								$elementoHtmlTd->conteudo = $queryItem[$componenteCampo->NOME];
								$elementoHtmlTd->atributo['style'][] = 'text-align:right';
								$elementoHtmlTd->atributo['data-a-h'] = 'right';

								break;
								
							case Constantes::ComponenteTipoCampoNumerico:
								if ($queryItem[$componenteCampo->NOME] != '') {
									$elementoHtmlTd->conteudo = number_format($queryItem[$componenteCampo->NOME], $componenteCampo->FORMATACAO, ',', '.');
								}

								$elementoHtmlTd->atributo['style'][] = 'text-align:right';	
								$elementoHtmlTd->atributo['data-a-h'] = 'right';

								break;

							case Constantes::ComponenteTipoCampoData:								
								$elementoHtmlTd->atributo['style'][] = 'text-align:center';	
								$elementoHtmlTd->atributo['data-a-h'] = 'center';

								if (($queryItem[$componenteCampo->NOME] == '') || ($queryItem[$componenteCampo->NOME] == '0')) {
									$elementoHtmlTd->atributo['value'] = '';
									$elementoHtmlTd->conteudo = '';
								}
								else {
									$elementoHtmlTd->atributo['value'] = (new DateTime($queryItem[$componenteCampo->NOME]))->format('Y/m/d H:i');				
									$elementoHtmlTd->conteudo = (new DateTime($queryItem[$componenteCampo->NOME]))->format($componenteCampo->FORMATACAO);
								}	

								break;
							default:
								$elementoHtmlTd->conteudo = $queryItem[$componenteCampo->NOME];

								break;								
						}
					}

					if (isset($componenteCampo->CAMPOMARCADOR)) {
						$achouMarcador = false;

						foreach ($componenteCampo->CAMPOMARCADOR as $componenteCampoMarcador) {
							switch ($componenteCampoMarcador->REGRACOMPARACAO) {
								case Constantes::ComponenteMarcadorRegraComparacaoValorDiferente:
									$achouMarcador = $componenteCampoMarcador->VALORCOMPARACAO != $queryItem[$componenteCampoMarcador->CAMPOCOMPARACAO];
									break;

								case Constantes::ComponenteMarcadorRegraComparacaoValorIgualA:
									$achouMarcador = $componenteCampoMarcador->VALORCOMPARACAO == $queryItem[$componenteCampoMarcador->CAMPOCOMPARACAO];
									break;

								case Constantes::ComponenteMarcadorRegraComparacaoValorMenorQue:
									$achouMarcador = $componenteCampoMarcador->VALORCOMPARACAO > $queryItem[$componenteCampoMarcador->CAMPOCOMPARACAO];
									break;

								case Constantes::ComponenteMarcadorRegraComparacaoValorMenorOuIgualA:
									$achouMarcador = $componenteCampoMarcador->VALORCOMPARACAO >= $queryItem[$componenteCampoMarcador->CAMPOCOMPARACAO];
									break;

								case Constantes::ComponenteMarcadorRegraComparacaoValorMaiorQue:
									$achouMarcador = $componenteCampoMarcador->VALORCOMPARACAO < $queryItem[$componenteCampoMarcador->CAMPOCOMPARACAO];
									break;
							
								case Constantes::ComponenteMarcadorRegraComparacaoValorMaiorOuIgualA:
									$achouMarcador = $componenteCampoMarcador->VALORCOMPARACAO <= $queryItem[$componenteCampoMarcador->CAMPOCOMPARACAO];
									break;
							}	

							if ($achouMarcador)	{
								if ($componenteCampoMarcador->CORFONTE != '') {
									$elementoHtmlTd->atributo['style'][] = 'color:rgb('. $componenteCampoMarcador->CORFONTE. ')';
									$elementoHtmlTd->atributo['data-f-color'] = $this->convertColorRgbKml($componenteCampoMarcador->CORFONTE);
								}
							
								if ($componenteCampoMarcador->CORFUNDO != '') {
									$elementoHtmlTd->atributo['style'][]= 'background-color:rgb('. $componenteCampoMarcador->CORFUNDO. ')';
									$elementoHtmlTd->atributo['data-fill-color'] = $this->convertColorRgbKml($componenteCampoMarcador->CORFUNDO);
								}

								break;
							}					
						}
					}

					if ($componenteCampo->EHTOTALIZAR == 'S') {
						if ($queryItem[$componenteCampo->NOME] != '') {
							$valor = $queryItem[$componenteCampo->NOME];
						}
						else {
							$valor = 0;
						}

						if (isset($componente->totalizador[$componenteIndice])) {
							$componente->totalizador[$componenteIndice] += $valor;
						} else {
							$componente->totalizador[$componenteIndice] = $valor;
						}
					}
					else {
						$componente->totalizador[$componenteIndice] = 'N';
					}					
				}
			}
				
			return $elementoHtmlTable;
		}

		private function tabelaGerarElementoHtmlNovo($componente, $tipoTabela) {
			$elementoHtml = $this->elementoHtmlNovo(null, 'table');
			$elementoHtml->atributo['id'] = $componente->IDENTIFICADORINTERNO. '_tabela_'. $tipoTabela;
		
			$elementoHtml->atributo['class'][] = 'table';
			$elementoHtml->atributo['class'][] = 'table-hover';

			if (($componente->EHEXIBIRDIVISORLINHATABELA == 'S') && ($componente->EHEXIBIRDIVISORCOLUNATABELA == 'S')) {
				$elementoHtml->atributo['class'][] = 'table-bordered';
			}
			else if ($componente->EHEXIBIRDIVISORLINHATABELA == 'S') {
				$elementoHtml->atributo['class'][] = 'table-bordered-row';
			}
			else if ($componente->EHEXIBIRDIVISORCOLUNATABELA == 'S') {
				$elementoHtml->atributo['class'][] = 'table-bordered-column';
			}
			
			switch ($tipoTabela) {
				case 'cabecalho':
					$elementoHtml->atributo['class'][] = 'table-head';

					if ($componente->EHDESTACARCABECALHOTABELA == 'S') {
						$elementoHtml->atributo['class'][] = 'componente-active';
					}

					break;

				case 'corpo':
					$elementoHtml->atributo['class'][] = 'table-body';

					if ($componente->EHEXIBIRTABELAZEBRADA == 'S') {
						$elementoHtml->atributo['class'][] = 'table-striped';
					}


					break;

				case 'rodape':
					$elementoHtml->atributo['class'][] = 'table-foot';

					break;
			}	

			$tamanhoColunaExportacao = '';

			if (isset($componente->CAMPO)) {
				foreach ($componente->CAMPO as $componenteIndice => $componenteCampo)
				{
					if ($tamanhoColunaExportacao != '') {
						$tamanhoColunaExportacao .= ',';
					}
					
					$tamanhoColunaExportacao .= $componenteCampo->TAMANHO + 5;
				}
			}

			$elementoHtml->atributo['data-cols-width'] = $tamanhoColunaExportacao;

			return $elementoHtml;
		}

		private function tabelaGerarElementoHtmlRodape($componente) {
			if ($componente->EHEXIBIRRODAPETABELA == 'S') {
				$elementoHtmlTable = $this->tabelaGerarElementoHtmlNovo($componente, 'rodape');		
				$elementoHtmlThead = $this->elementoHtmlNovo($elementoHtmlTable, 'thead');
				$elementoHtmlTr = $this->elementoHtmlNovo($elementoHtmlThead , 'tr');
				
				if (isset($componente->CAMPO)) {
					foreach ($componente->CAMPO as $componenteIndice => $componenteCampo)
					{
						if ($componente->totalizador[$componenteIndice] != 'R') {
							$elementoHtmlTh = $this->elementoHtmlNovo($elementoHtmlTr, 'th');
							$elementoHtmlTh->atributo['id'] = $componente->IDENTIFICADORINTERNO. '_tabela_rodape_'. $componenteCampo->HANDLE;

							$elementoHtmlTh->atributo['style'][] = 'font-size:'. $componente->FONTEGRIDTABELA. 'px';												

							if ($componenteCampo->EHTOTALIZAR == 'S'){
								$elementoHtmlTh->atributo['style'][] = 'width:'. $componenteCampo->TAMANHO. '%';

								if ((!isset($componente->totalizador[$componenteIndice])) || ($componente->totalizador[$componenteIndice] == '')) {
									$elementoHtmlTh->conteudo = number_format(0, $componenteCampo->FORMATACAO, ',', '.');
								}
								else {
									$elementoHtmlTh->conteudo = number_format($componente->totalizador[$componenteIndice], $componenteCampo->FORMATACAO, ',', '.');
								}

								$elementoHtmlTh->atributo['style'][] = 'text-align:right';
								$elementoHtmlTh->atributo['data-a-h'] = 'right';
							}
							else if ($componenteIndice == 0) {
								$elementoHtmlTh->conteudo = 'Total';

								if ((count($componente->totalizador) > 1) && ($componente->totalizador[$componenteIndice + 1] == 'N')) {
									$elementoHtmlTh->atributo['colspan'][] = '2';

									$componente->totalizador[$componenteIndice + 1] = 'R';
									$elementoHtmlTh->atributo['style'][] = 'width:'. ($componenteCampo->TAMANHO + $componente->CAMPO[$componenteIndice + 1]->TAMANHO). '%';
								}
								else {
									$elementoHtmlTh->atributo['style'][] = 'width:'. $componenteCampo->TAMANHO. '%';
								}
							}
						}
					}
				}

				return $elementoHtmlTable;
			}	
		}
	}	
		
?>