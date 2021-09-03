<?php
$queryDocumento->execute();

while ($rowDocumento = $queryDocumento->fetch(PDO::FETCH_ASSOC)) {
    $statusDocumento = Sistema::getImagem($rowDocumento['RESOURCENAMEDOCUMENTO'], $rowDocumento['STATUSDOCUMENTO']);
    $statusDocumentoTrasporte = Sistema::getImagem($rowDocumento['RESOURCENAMEDOCUMENTOTRANSPORTE'], $rowDocumento['STATUSDOCUMENTOTRANSPORTE']);
    $numeroDocumento = $rowDocumento['NUMERODOCUMENTO'];
    $tipoDocumento = $rowDocumento['TIPODOCUMENTO'];
    $dataEmissaoDocumento = Sistema::formataData($rowDocumento['EMISSAODOCUMENTO']);
    $valorBrutoDocumento = Sistema::formataValor($rowDocumento['VALORBRUTODOCUMENTO']);
    $remetenteDocumento = $rowDocumento['REMETENTEDOCUMENTO'];
    $destinatarioDocumento = $rowDocumento['DESTINATARIODOCUMENTO'];
    $tomadorDocumento = $rowDocumento['TOMADORDOCUMENTO'];
    $filialDocumento = $rowDocumento['FILIALDOCUMENTO'];
    $filialOrigemDocumento = $rowDocumento['FILIALORIGEMDOCUMENTO'];
    $filialDestinoDocumento = $rowDocumento['FILIALDESTINODOCUMENTO'];
    $atualDocumento = $rowDocumento['ATUALDOCUMENTO'];
    $UFAtualDocumento = $rowDocumento['UFATUALDOCUMENTO'];
    $origemDocumento = $rowDocumento['ORIGEMDOCUMENTO'];
    $UFOrigemDocumento = $rowDocumento['UFORIGEMDOCUMENTO'];
    $destinoDocumento = $rowDocumento['DESTINODOCUMENTO'];
    $UFDestinoDocumento = $rowDocumento['UFDESTINODOCUMENTO'];
?>
    <tr>
        <td width="1%"><?php echo $statusDocumento; ?></td>
        <td width="1%"><?php echo $statusDocumentoTrasporte; ?></td>
        <td class="text-right"><?php echo $numeroDocumento; ?></td>
        <td><?php echo $tipoDocumento; ?></td>
        <td><?php echo $dataEmissaoDocumento; ?></td>
        <td class="text-right"><?php echo $valorBrutoDocumento; ?></td>
        <td><?php echo $remetenteDocumento; ?></td>
        <td><?php echo $destinatarioDocumento; ?></td>
        <td><?php echo $tomadorDocumento; ?></td>
        <td><?php echo $filialDocumento; ?></td>
        <td><?php echo $filialOrigemDocumento; ?></td>
        <td><?php echo $filialDestinoDocumento; ?></td>
        <td><?php echo $UFAtualDocumento.' - '.$atualDocumento; ?></td>
        <td><?php echo $UFOrigemDocumento.' - '.$origemDocumento; ?></td>
        <td><?php echo $UFDestinoDocumento.' - '.$destinoDocumento; ?></td>
    </tr>
<?php
}
?>