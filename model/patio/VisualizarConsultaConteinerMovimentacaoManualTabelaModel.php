<?php
$handleMovimentacaoManual = null;
$dataMovimentacaoManual = null;
$statusMovimentacaoManualIcone = null;

$queryMovimentacaoManual->execute();
while ($rowMovimentacaoManual = $queryMovimentacaoManual->fetch(PDO::FETCH_ASSOC)) {
    
    $handleMovimentacaoManual = $rowMovimentacaoManual['HANDLE'];
    $numeroMovimentacalManual = $rowMovimentacaoManual['NUMERO'];
    $statusMovimentacaoManual = $rowMovimentacaoManual['STATUS'];
    $dataMovimentacaoManual = Sistema::formataDataHora($rowMovimentacaoManual['DATA']);
    $filialMovimentacaoManual = $rowMovimentacaoManual['FILIAL'];
    $tipooperacaoMovimentacaoManual = $rowMovimentacaoManual['TIPOOPERACAO'];
    $finalidadeMovimentacaoManual = $rowMovimentacaoManual['FINALIDADE'];
    $localizacaoMovimentacaoManual = $rowMovimentacaoManual['LOCALIZACAO'];
    $statusMovimentacaoManualIcone = Sistema::getImagem($rowMovimentacaoManual['RESOURCENAME']);
    ?>
    <tr>
        <td hidden="true"><input type="radio" name="checked[]" hidden="true" id="check" value="<?php echo $handleMovimentacaoManual ?>"></td>
        <td width="1%"><?php echo $statusMovimentacaoManualIcone; ?></td>
        <td class="text-center"><?php echo $dataMovimentacaoManual; ?></td>
        <td hidden><?php echo $handleMovimentacaoManual; ?></td>
        <td hidden><?php echo $statusMovimentacaoManual; ?></td>
		<td><?php echo $filialMovimentacaoManual; ?></td>
        <td><?php echo $tipooperacaoMovimentacaoManual; ?></td>
        <td><?php echo $finalidadeMovimentacaoManual; ?></td>
        <td><?php echo $localizacaoMovimentacaoManual; ?></td>
    </tr>

    <?php
}