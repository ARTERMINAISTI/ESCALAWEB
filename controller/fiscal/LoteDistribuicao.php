<?php
    include_once('../../controller/tecnologia/Sistema.php');
    include_once('../../model/fiscal/ModelLoteDistribuicao.php');

    if (!isset($_POST['ACAO'])) {
        throw new Exception('Ação inválida. Nenhuma ação informada.');
    }

    $acao = $_POST['ACAO'];
    $loteDistribuicao = new LoteDistribuicao();
    
    if ($acao == "gerarLoteDistribuicao") {
        $dados = $_POST['DADOS'];
        $loteDistribuicao->gerarLoteDistribuicao($dados);
    }
    
    if ($acao == "downloadLote") {
        $dados = $_POST["DADOS"];
        $loteDistribuicao->DownloadLoteDistribuicao($dados);
    }
?>