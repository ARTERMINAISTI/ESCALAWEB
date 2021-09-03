<?php
    include_once('../../model/painelindicador/painelindicador.php');
	
	$acao = '';
	
	$alturaPainel = 0;	
	$handlePainel = 0;
	$filtroPainel = '';	
	$larguraPainel = 0;
	$parametroPainel = '';	

	if (isset($_POST['ACAO']))	{
		$acao = $_POST['ACAO'];
	}
	
	if (isset($_POST['ALTURA'])) {
		$alturaPainel = $_POST['ALTURA'];
	}

	if (isset($_POST['FILTRO'])) {
		$filtroPainel = $_POST['FILTRO'];
	}
	
	if (isset($_POST['LARGURA'])) {
		$larguraPainel = $_POST['LARGURA'];
	}

	if (isset($_POST['PAINELPARAMETRO'])) {
		$parametroPainel = $_POST['PAINELPARAMETRO'];
	}
	
	if (isset($_POST['PAINEL'])) {
		$handlePainel = $_POST['PAINEL'];
	}
	
	switch ($acao) {
        case "ATUALIZARPAINEL":

			$painelIndicador = new PainelIndicador();
            $painelIndicador->atualizarPainel($parametroPainel, $alturaPainel, $larguraPainel, $filtroPainel);

			break;

		case "FILTROBUSCARREGISTRO":

			$painelIndicador = new PainelIndicador();
            $painelIndicador->filtroSelecaoBuscarRegistro($filtroPainel);

			
			break;
		
        case "CARREGARPAINEL":

			$painelIndicador = new PainelIndicador();
            $painelIndicador->carregarPainel($handlePainel, $larguraPainel);

			break;
		
		default: 
            throw new Exception("Não foi encontrado nenhuma operação para a ação informada. Ação: ".$acao);
	}
?>