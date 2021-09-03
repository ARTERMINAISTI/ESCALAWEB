<?php
$EtapaHandle = null;
$Etapa = null;
$dataEtapa = null;
$statusEtapa = null;

$queryEtapa->execute();
while ($rowEtapa = $queryEtapa->fetch(PDO::FETCH_ASSOC)) {
    $EtapaHandle = $rowEtapa['HANDLE'];
    $Etapa = $rowEtapa['ETAPA'];
    $statusEtapa = $rowEtapa['STATUS'];
    $codigoEtapa = $rowEtapa['CODIGO'];
    $sequencialEtapa = $rowEtapa['SEQUENCIAL'];
    $observacaoEtapa = $rowEtapa['OBSERVACAO'];
    $dataEtapa = Sistema::formataDataHora($rowEtapa['DATA']);
    $statusEtapaIcone = Sistema::getImagem($rowEtapa['RESOURCENAME']);
    ?>
    <tr>
        <td hidden="true"><input type="radio" name="check[]" hidden="true" class="check" id="check" value="<?php echo $statusEtapa . '-' . $etapaHandle; ?>"></td>
        <td width="1%"><?php echo $statusEtapaIcone; ?></td>        
        <td><?php echo $Etapa; ?></td>
        <td class="text-center"><?php echo $dataEtapa; ?></td>
        <td><?php echo $observacaoEtapa; ?></td>
    </tr>

    <?php
}