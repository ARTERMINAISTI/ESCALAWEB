<?php

Sistema::iniciaCarregando();

$queryEtapaPedido = "SELECT TOP 1000
                            A.HANDLE HANDLE,
                            A.STATUS STATUS,
                            A.SEQUENCIAL SEQUENCIAL,
                            A.DATA DATA,
                            A.OBSERVACAO OBSERVACAO,
                            A.TITULO ETAPA,
                            B.MUNICIPIODESTINATARIO DESTINO,
                            B.MUNICIPIOREMETENTE ORIGEM,
                            B.NOMEDESTINATARIO DESTINATARIO,
                            B.NOMEREMETENTE REMETENTE,
                            B.NUMEROPEDIDO NUMEROPEDIDO,
                            B.RASTREAMENTO RASTREAMENTO,
                            C.NOME STATUSNOME,
                            D.RESOURCENAME RESOURCENAME,
                            E.APELIDO CLIENTE
                       FROM RA_PEDIDOETAPA A
                      INNER JOIN RA_PEDIDO B ON B.HANDLE = A.PEDIDO
                       LEFT JOIN MS_STATUS C ON C.HANDLE = A.STATUS
                       LEFT JOIN MD_IMAGEM D ON D.HANDLE = C.IMAGEM
                       LEFT JOIN MS_PESSOA E ON E.HANDLE = B.CLIENTE
                      WHERE B.EMPRESA = " . $empresa . "
                          
                        AND EXISTS(SELECT X.HANDLE
                                     FROM MS_USUARIO X
                                    WHERE X.HANDLE = " . $handleUsuario . "
                                      AND X.PESSOA = A.RESPONSAVEL)

					              AND A.HANDLE = CASE WHEN ((SELECT MAX(X.HANDLE) 
					                                           FROM RA_PEDIDOETAPA X 
										                                WHERE X.PEDIDO = A.PEDIDO
										                                  AND X.STATUS = 9) <> 0)
                                            THEN (SELECT MAX(X.HANDLE) 
                                                    FROM RA_PEDIDOETAPA X 
                                                   WHERE X.PEDIDO = A.PEDIDO
                                                     AND X.STATUS = 9)
                                            ELSE (SELECT MIN(X.HANDLE) 
                                                    FROM RA_PEDIDOETAPA X 
                                                   WHERE X.PEDIDO = A.PEDIDO
                                                     AND X.STATUS = 11) END
                                      
                            " . Sistema::getFiltroPostTexto("numeroPedido", "B.NUMEROPEDIDO") . "
                            " . Sistema::getFiltroPostTexto("rastreamento", "B.RASTREAMENTO") . "
                            " . Sistema::getFiltroPostEntreDataMinuto("dataDe", "dataAte", "A.DATA") . "
                            " . Sistema::getFiltroPostTexto("cliente", "E.APELIDO") . "
                            " . Sistema::getFiltroPostTexto("origem", "B.MUNICIPIOREMETENTE") . "
                            " . Sistema::getFiltroPostTexto("destino", "B.MUNICIPIODESTINATARIO") . "
                            " . Sistema::getFiltroPostTexto("remetente", "B.NOMEREMETENTE") . "
                            " . Sistema::getFiltroPostTexto("destinatario", "B.NOMEDESTINATARIO") . "
                                
                      ORDER BY NUMEROPEDIDO DESC";

try {
    $queryEtapaPedidoPrepare = $connect->prepare($queryEtapaPedido);
    $queryEtapaPedidoPrepare->execute();

    $rowEtapaPedido = $queryEtapaPedidoPrepare->fetch(PDO::FETCH_ASSOC);

    if (!empty($rowEtapaPedido)) {
        do {
            $etapaPedidoHandle = $rowEtapaPedido['HANDLE'];
            $etapaPedidoStatus = $rowEtapaPedido['STATUS'];

            $etapaPedidoStatusIcone = Sistema::getImagem($rowEtapaPedido['RESOURCENAME'], $rowEtapaPedido['STATUSNOME']);
            $etapaPedidoNumeroPedido = $rowEtapaPedido['NUMEROPEDIDO'];
            $etapaPedidoSequencial = $rowEtapaPedido['SEQUENCIAL'];
            $etapaPedidoEtapa = $rowEtapaPedido['ETAPA'];
            $etapaPedidoData = Sistema::formataDataHora($rowEtapaPedido['DATA']);
            $etapaPedidoObservacao = Sistema::formataTexto($rowEtapaPedido['OBSERVACAO']);
            $etapaPedidoCliente = $rowEtapaPedido['CLIENTE'];
            $etapaPedidoRastreamento = $rowEtapaPedido['RASTREAMENTO'];
            $etapaPedidoRemetente = $rowEtapaPedido['REMETENTE'];
            $etapaPedidoOrigem = $rowEtapaPedido['ORIGEM'];
            $etapaPedidoDestinatario = $rowEtapaPedido['DESTINATARIO'];
            $etapaPedidoDestino = $rowEtapaPedido['DESTINO'];

            echo "  <tr>
                        <td hidden='true'><input type='radio' name='check[]' class='check' hidden='true' id='check' data-ref='$etapaPedidoStatus' value='$etapaPedidoHandle'></td>
                        <td>$etapaPedidoStatusIcone</td>
                        <td class=\"text-right\">$etapaPedidoNumeroPedido</td>
                        <td class=\"text-right\">$etapaPedidoSequencial</td>
                        <td>$etapaPedidoEtapa</td>
                        <td class=\"text-center\">$etapaPedidoData</td>
                        <td>$etapaPedidoObservacao</td>
                        <td>$etapaPedidoCliente</td>
                        <td>$etapaPedidoRastreamento</td>
                        <td>$etapaPedidoRemetente</td>
                        <td>$etapaPedidoOrigem</td>
                        <td>$etapaPedidoDestinatario</td>
                        <td>$etapaPedidoDestino</td>
                    </tr>";
        } while ($rowEtapaPedido = $queryEtapaPedidoPrepare->fetch(PDO::FETCH_ASSOC));
    } else {
        Sistema::getNaoEncontrado();
    }
} catch (Exception $e) {
    Sistema::tratarErro($e);
}