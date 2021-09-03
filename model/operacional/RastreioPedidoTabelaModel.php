<?php
include_once('../../controller/tecnologia/Sistema.php');

$connect = Sistema::getConexao();
$pendente = Sistema::getPost('pendente');
$usuario = $_SESSION['handleUsuario'];

$pessoaUsuarioFiltro = Sistema::getPessoaUsuarioToStr($connect);

if ($pessoaUsuarioFiltro == '') {

    $vFromPessoaUsuario = " ";
    $vfiltroPessoaUsuario = " ";
} else {
	$vFromPessoaUsuario = " LEFT JOIN MS_PESSOA O (NOLOCK) ON O.HANDLE IN ($pessoaUsuarioFiltro) ";
    $vfiltroPessoaUsuario = " AND CASE WHEN O.CNPJCPF = A.CNPJCPFDESTINATARIO THEN 'S' 
	                                  WHEN O.CNPJCPF = A.CNPJCPFREMETENTE THEN 'S' 
									  WHEN O.CNPJCPF = G.CNPJCPF THEN 'S' 
							     ELSE 'N' END  = 'S' ";
}
$vFiltro = "";
$bFiltro = false;

if ((Sistema::getFiltroPostLookupArray("filtroCliente", "A.CLIENTE") != '') and (Sistema::getFiltroPostLookupArray("filtroUnidadenegocio", "A.UNIDADENEGOCIOCLIENTE") == '')) {
    $vFiltroUnidadeNegocio = " AND (A.UNIDADENEGOCIOCLIENTE IN (SELECT X.UNIDADENEGOCIOCLIENTE
                                                                  FROM MS_PESSOACLIENTEUNIDADE X (NOLOCK) 
                                                                 INNER JOIN MS_PESSOACLIENTE Y  (NOLOCK)  ON Y.HANDLE = X.CLIENTE
                                                                 WHERE Y.PESSOA = A.CLIENTE) or A.UNIDADENEGOCIOCLIENTE IS NULL)";
    $bFiltro = true;
} else {
    $vFiltroUnidadeNegocio = Sistema::getFiltroPostLookupArray("unidadenegocio", "A.UNIDADENEGOCIOCLIENTE");
}

if (Sistema::getFiltroPostTexto("filtroDocumento", "Y.NUMERO") == '') {
    $vFitroDocumento = "";
} 
else {
    $vFitroDocumento = " AND EXISTS (SELECT 1 
                                       FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK) 
                                      INNER JOIN GD_ORIGINARIO Y  (NOLOCK)  ON Y.HANDLE = X.HANDLEORIGEM
                                      WHERE X.PEDIDO = A.HANDLE 
                                        AND X.ORIGEM = 1890
                                     " . Sistema::getFiltroPostTexto("filtroDocumento", "Y.NUMERO") ."
                                     
                                     UNION ALL

                                     SELECT 1 
                                       FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK) 
                                      INNER JOIN GD_DOCUMENTO Y  (NOLOCK)  ON Y.DOCUMENTOTRANSPORTE = X.HANDLEORIGEM
                                      INNER JOIN GD_DOCUMENTOORIGINARIO Y1 (NOLOCK)  ON Y1.DOCUMENTO = Y.HANDLE
                                      INNER JOIN GD_ORIGINARIO Y2 (NOLOCK)  ON Y2.HANDLE = Y1.ORIGINARIO
                                      WHERE X.PEDIDO = A.HANDLE 
                                        AND X.ORIGEM = 2042 " . Sistema::getFiltroPostTexto("filtroDocumento", "Y2.NUMERO") . ")";                                     
    $bFiltro = true;
}

if (Sistema::getFiltroPostTexto("filtroCte", "Y.NUMERO") == '') {
    $vFiltroCte = "";
} else {
    $vFiltroCte = " AND EXISTS (SELECT 1 
                                  FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK) 
                                 INNER JOIN GD_DOCUMENTO Y (NOLOCK)  ON Y.DOCUMENTOTRANSPORTE = X.HANDLEORIGEM
                                 WHERE X.PEDIDO = A.HANDLE 
                                   AND X.ORIGEM = 2042
                               " . Sistema::getFiltroPostTexto("filtroCte", "Y.NUMERO") . ")";
    $bFiltro = true;                                     
}

if ($_POST["filtroObservacao"] == '') {
    $vFiltroDocumentoObservacao = "";
} else {
    $vFiltroDocumentoObservacao = " 
                                    AND EXISTS (SELECT 1 
                                                  FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK) 
                                                 INNER JOIN GD_ORIGINARIO Y (NOLOCK)  ON Y.HANDLE = X.HANDLEORIGEM
                                                 WHERE X.PEDIDO = A.HANDLE 
                                                   AND X.ORIGEM = 1890
                                               " . Sistema::getFiltroPostLike("filtroObservacao", "Y.OBSERVACAO") . ")";
    $bFiltro = true;                                     
}

if (Sistema::getPost('filtroTransporteProprio') <> 'S') {
    $vFiltroTransporteProprio = '';
} else { $vFiltroTransporteProprio = "AND A.TRANSPORTADORA IN (SELECT X.PESSOA
                                                                 FROM MS_FILIAL X (NOLOCK) 
                                                                WHERE X.EMPRESA = A.EMPRESA
                                                                  AND X.STATUS = 4)"; 
    $bFiltro = true;
}       

if ((sistema::getFiltroPostTexto("filtroTransportadora", "A.TRANSPORTADORA") == '') || (Sistema::getPost('filtroTransporteProprio') == 'S')) {
    $vFiltroTransportadora = "";
} else {
    # Só irá retornar registro se a Transportadora estiver ativa ou se o Transporte próprio não estiver marcado.
   $vFiltroTransportadora = " AND A.TRANSPORTADORA IN (SELECT X.HANDLE
                                                         FROM MS_PESSOA X (NOLOCK) 
                                                        WHERE X.STATUS = 4
                                                        " . Sistema::getFiltroPostLike("filtroTransportadora", "X.APELIDO") .")";
}

if (Sistema::getPost('filtroEmTransporte') <> 'S') {
    $vFiltroEmTransporte = "";
} else {
    $vFiltroEmTransporte = "AND M.DATAEMISSAO <> 0";
}

foreach($_POST as $key => $value) {
    if (($value <> "") && ($key <> "pendente") && ($key <> "ehpendente")) {
        $bFiltro = true;
        break;
    }
}

if (Sistema::getPost('filtroPendente') == '') {
    $vFiltroPendente = '';

} else {
    $vFiltroPendente = $_POST["filtroPendente"];
}

if ($_POST['filtroDocumento'] == '') {
    $vFiltroDocumento = "";
} else {
    $vFiltroDocumento = " AND EXISTS (SELECT 1 
                                        FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK) 
                                       INNER JOIN GD_ORIGINARIO Y (NOLOCK) ON Y.HANDLE = X.HANDLEORIGEM
                                       WHERE X.PEDIDO = A.HANDLE 
                                         AND X.ORIGEM = 1890
                                     " . Sistema::getFiltroPostTexto("filtroDocumento", "Y.NUMERO") ."
                                     
                                     UNION ALL

                                     SELECT 1 
                                        FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK) 
                                       INNER JOIN GD_DOCUMENTO Y (NOLOCK) ON Y.DOCUMENTOTRANSPORTE = X.HANDLEORIGEM
                                       INNER JOIN GD_DOCUMENTOORIGINARIO Y1 (NOLOCK) ON Y1.DOCUMENTO = Y.HANDLE
                                       INNER JOIN GD_ORIGINARIO Y2 (NOLOCK) ON Y2.HANDLE = Y1.ORIGINARIO
                                       WHERE X.PEDIDO = A.HANDLE 
                                         AND X.ORIGEM = 2042 " . Sistema::getFiltroPostTexto("filtroDocumento", "Y2.NUMERO") . ")";                                     
    $bFiltro = true;    
    
    //error_log($vFiltroDocumento);
} 

if (Sistema::getPost('filtroCliente') == '') {
    $vFiltroCliente = '';

} else {
    $vFiltroCliente = Sistema::getFiltroPostLookupArray('filtroCliente', 'A.CLIENTE');
}; 

$queryCampos = "A.HANDLE HANDLE,
                A.RASTREAMENTO RASTREAMENTO,
                A.DATA DATA,
                A.STATUS STATUS,
                E.NOME STATUSNOME,
                F.RESOURCENAME RESOURCENAME,
                J.NOME TIPO,
                A.NUMEROPEDIDO NUMEROPEDIDO,
                A.NUMEROCONTROLE NUMEROCONTROLE,
                A.DOCUMENTOORIGINARIO NUMERONOTAFISCAL,                
                CASE WHEN A.VALORMERCADORIA > 0 THEN A.VALORMERCADORIA ELSE L.VALORMERCADORIA END VALORMERCADORIA,
                M.NUMERO DOCUMENTOTRANSPORTE,
                CONVERT(VARCHAR(10), M.DATAEMISSAO, 103) EMISSAODOCUMENTO,
                L.PESO PESOREALDOCUMENTO,
                L.PESOCUBADO PESOCUBADODOCUMENTO,
                COALESCE(L.QUANTIDADEVOLUME, 0) QTDVOLUMEDOCUMENTO,
                CONVERT(VARCHAR(10), A.DATAENTREGA, 103) DATAENTREGA,
                M.VALORBRUTO VALORFRETE,
                CONVERT(VARCHAR(10), L.PREVISAOENTREGA, 103) PREVISAOENTREGADOCUMENTO,
                A.NOMEREMETENTE REMETENTE,
                A.MUNICIPIOLOCALCOLETA MUNICIPIOCOLETA,
                A.UFLOCALCOLETA ESTADOCOLETA,                
                A.NOMEDESTINATARIO DESTINATARIO,               
                A.MUNICIPIOLOCALENTREGA MUNICIPIOENTREGA,
                A.UFLOCALENTREGA ESTADOENTREGA,                
                N.TITULO ETAPAATUAL,
                H.TITULO ETAPAEXECUCAO,
                H.DATA ETAPADATA,   
                G.APELIDO CLIENTE
                ";

$queryFrom = "
              FROM MD_SISTEMA ZZZZZ (NOLOCK)
			  INNER JOIN RA_PEDIDO A (NOLOCK) ON A.EMPRESA = $empresa 
              LEFT JOIN MS_USUARIO D (NOLOCK) ON A.LOGUSUARIOCADASTRO = D.HANDLE
              LEFT JOIN RA_STATUSPEDIDO E (NOLOCK) ON E.HANDLE = A.STATUS
              LEFT JOIN MD_IMAGEM F (NOLOCK) ON F.HANDLE = E.IMAGEM
              LEFT JOIN MS_PESSOA G (NOLOCK) ON G.HANDLE = A.CLIENTE                           
              LEFT JOIN RA_PEDIDOETAPA H (NOLOCK) ON H.HANDLE = A.ETAPAATUAL
              LEFT JOIN RA_TIPOETAPA I (NOLOCK) ON I.HANDLE = H.ETAPA
              INNER JOIN RA_TIPOPEDIDO J (NOLOCK) ON J.HANDLE = A.TIPO
              LEFT JOIN RA_PEDIDOMOVIMENTACAO K (NOLOCK) ON K.HANDLE = (SELECT MAX(X.HANDLE)
                                                                          FROM RA_PEDIDOMOVIMENTACAO X (NOLOCK)                                                                             
                                                                         WHERE X.PEDIDO = A.HANDLE
                                                                           AND X.ORIGEM = 2042)                                                                                                                                                           
              LEFT JOIN GD_DOCUMENTOTRANSPORTE L (NOLOCK) ON L.HANDLE = K.HANDLEORIGEM
              LEFT JOIN GD_DOCUMENTO M (NOLOCK) ON M.HANDLE = L.DOCUMENTO
              AND M.EHCANCELADO <> 'S'
              AND M.EHCOMPLEMENTAR <> 'S' ";
			  
$etapaAtualFrom = " LEFT JOIN RA_PEDIDOETAPA N (NOLOCK)  ON N.PEDIDO = A.HANDLE AND N.STATUS = 9 AND NOT EXISTS(SELECT Y.HANDLE 
                                                                                 FROM RA_PEDIDOETAPA Y (NOLOCK) 
                                                                                WHERE Y.HANDLE > N.HANDLE
                                                                                  AND Y.PEDIDO = A.HANDLE
                                                                                  AND Y.STATUS = 9)  
                    LEFT JOIN RA_TIPOETAPA O (NOLOCK) ON O.HANDLE = N.ETAPA ";

$queryOrderBy = "ORDER BY M.DATAEMISSAO DESC";

//Start Filtros:
$start = $_POST["start"];
$length = $_POST["length"] + $start;
//End filtros.

$queryPedido = "WITH ORDENS AS
          ( SELECT ROW_NUMBER() OVER ($queryOrderBy) ROW_NUMBER, "
                   . $queryCampos
                   . $queryFrom 
				   . $etapaAtualFrom
				   . $vFromPessoaUsuario
				   
				   . " WHERE 1 = 1  "
				   
                   . $vfiltroPessoaUsuario
                   . Sistema::getFiltroPostTexto("filtroNumeroPedido", "A.NUMEROPEDIDO ")  
                   . Sistema::getFiltroPostTexto("filtroRastreamento", "A.RASTREAMENTO ")  
                   . Sistema::getFiltroPostEntreData("filtroDataInicio", "filtroDataFinal", "A.DATA ")  
                   . Sistema::getFiltroPostLookupArray("filtroFilial", "A.FILIAL ") 
                   . Sistema::getFiltroPostLookupArray("filtroTipoPedido", "A.TIPO ") 
                   . Sistema::getFiltroPostLookupArray("filtroSituacao", "O.HANDLE ")  
                   . Sistema::getFiltroPostTexto("filtroRemetente", "A.NOMEREMETENTE ")  
                   . Sistema::getFiltroPostTexto("filtroDestinatario", "A.NOMEDESTINATARIO ") 
                   . Sistema::getFiltroPostTexto("filtroNumeroControle", "A.NUMEROCONTROLE ")  
                   . Sistema::getFiltroPostLookupArray("filtroCliente", "A.CLIENTE ")  
                   . $vFiltroUnidadeNegocio
                   . $vFiltroPendente
                   . $vFiltroDocumento 
                   . $vFiltroDocumentoObservacao
                   . $vFiltroTransportadora 
                   . $vFiltroTransporteProprio 
                   . $vFiltroEmTransporte 
                   . $vFiltroCte   .")
                   SELECT * FROM ORDENS A WHERE row_number BETWEEN $start AND $length ";

//error_log($queryPedido);

$queryOrder = $connect->prepare($queryPedido);
$queryOrder -> execute(); //var_dump($queryOrder);

$dadosPedido = [];

while($dados = $queryOrder->fetch(PDO::FETCH_ASSOC)){
    $dados["STATUS"]                   = Sistema::getImagem($dados["RESOURCENAME"],$dados["STATUSNOME"]);
    $dados["RASTREAMENTO"]             = Sistema::formataTexto($dados["RASTREAMENTO"]);
    $dados["DATA"]                     = Sistema::formataDataHora($dados["DATA"]);
    $dados["TIPO"]                     = Sistema::formataTexto($dados["TIPO"]);    
    $dados["NUMEROPEDIDO"]             = Sistema::formataTexto($dados["NUMEROPEDIDO"]);
    $dados["NUMEROCONTROLE"]           = Sistema::formataTexto($dados["NUMEROCONTROLE"]);    
    $dados["NUMERONOTAFISCAL"]         = Sistema::formataTexto($dados["NUMERONOTAFISCAL"]);
    $dados["VALORMERCADORIA"]          = Sistema::formataValor($dados["VALORMERCADORIA"]);
    $dados["DOCUMENTOTRANSPORTE"]      = Sistema::formataTexto($dados["DOCUMENTOTRANSPORTE"]);
    $dados["EMISSAODOCUMENTO"]         = $dados["EMISSAODOCUMENTO"];
    $dados["PESOREALDOCUMENTO"]        = Sistema::formataValor($dados["PESOREALDOCUMENTO"]);
    $dados["PESOCUBADODOCUMENTO"]      = Sistema::formataValor($dados["PESOCUBADODOCUMENTO"]);
    $dados["QTDVOLUMEDOCUMENTO"]       = $dados["QTDVOLUMEDOCUMENTO"];
    $dados["VALORFRETE"]               = Sistema::formataValor($dados["VALORFRETE"]);
    $dados["PREVISAOENTREGADOCUMENTO"] = $dados["PREVISAOENTREGADOCUMENTO"];
    $dados["REMETENTE"]                = $dados["REMETENTE"];
    $dados["MUNICIPIOCOLETA"]          = $dados["MUNICIPIOCOLETA"];
    $dados["ESTADOCOLETA"]             = $dados["ESTADOCOLETA"];
    $dados["DESTINATARIO"]             = $dados["DESTINATARIO"];
    $dados["MUNICIPIOENTREGA"]         = $dados["MUNICIPIOENTREGA"];
    $dados["ESTADOENTREGA"]            = $dados["ESTADOENTREGA"];
    $dados["ETAPAATUAL"]               = $dados["ETAPAATUAL"];
    $dados["ETAPAEXECUCAO"]            = $dados["ETAPAEXECUCAO"];
    $dados["ETAPADATA"]                = $dados["ETAPADATA"];
    $dados["CLIENTE"]                  = $dados["CLIENTE"];

    $dadosPedido[] = $dados;
};

$sqlTotalRastreioPedidoFiltred = "SELECT COUNT(A.HANDLE) TOTAL "
                                . $queryFrom
                                . $vFromPessoaUsuario
                                
                                . " WHERE 1 = 1 " 			   
                                
                                . $vfiltroPessoaUsuario
                                
                                . Sistema::getFiltroPostTexto("filtroNumeroPedido", "A.NUMEROPEDIDO ")  
                                . Sistema::getFiltroPostTexto("filtroRastreamento", "A.RASTREAMENTO ")  
                                . Sistema::getFiltroPostEntreData("dataInicio", "dataFinal", "A.DATA ")  
                                . Sistema::getFiltroPostLookupArray("filtroFilial", "A.FILIAL ") 
                                . Sistema::getFiltroPostLookupArray("filtroTipoPedido", "A.TIPO ") 
                                . Sistema::getFiltroPostLookupArray("filtroSituacao", "I.HANDLE ")  
                                . Sistema::getFiltroPostTexto("filtroRemetente", "A.NOMEREMETENTE ")  
                                . Sistema::getFiltroPostTexto("filtroDestinatario", "A.NOMEDESTINATARIO ") 
                                . Sistema::getFiltroPostTexto("filtroNumeroControle", "A.NUMEROCONTROLE ")  
                                . Sistema::getFiltroPostLookupArray("filtroCliente", "A.CLIENTE ")  

                                . $vFiltroUnidadeNegocio
                                . $vFiltroPendente
                                . $vFiltroDocumento
                                . $vFiltroDocumentoObservacao
                                . $vFiltroTransportadora
                                . $vFiltroTransporteProprio 
                                . $vFiltroEmTransporte 
                                . $vFiltroCte;

$totalRastreioPedidoFiltred = $connect->prepare($sqlTotalRastreioPedidoFiltred);
$totalRastreioPedidoFiltred -> execute();
$totalRegistroRastreioFiltred = $totalRastreioPedidoFiltred->fetch(PDO::FETCH_ASSOC);

//error_log($sqlTotalRastreioPedidoFiltred);

echo json_encode([
    "draw"            => $_POST['draw'],
    "data"            => $dadosPedido,
    "recordsTotal"    => $totalRegistroRastreioFiltred['TOTAL'],
    "recordsFiltered" => $totalRegistroRastreioFiltred['TOTAL']    
]);