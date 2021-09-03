<?php
$dataMovimentacaoConteiner = null;
$filialMovimentacaoConteiner = null;
$tipoOperacaoMovimentacaoConteiner = null;
$finalidadeMovimentacaoConteiner = null;
$localizacaoMovimentacaoConteiner = null;
$handleMovimentacaoConteiner = null;

$queryMovimentacaoConteiner->execute();
while ($rowMovimentacaoConteiner = $queryMovimentacaoConteiner->fetch(PDO::FETCH_ASSOC)) {

    $handleMovimentacaoConteiner = $rowMovimentacaoConteiner['HANDLE'];
    $dataMovimentacaoConteiner = Sistema::formataDataHora($rowMovimentacaoConteiner['DATA']);
    $filialMovimentacaoConteiner = $rowMovimentacaoConteiner['FILIAL'];
    $tipoOperacaoMovimentacaoConteiner = $rowMovimentacaoConteiner['TIPOOPERACAO'];
    $finalidadeMovimentacaoConteiner = $rowMovimentacaoConteiner['FINALIDADEMOVIMENTACAO'];
    $localizacaoMovimentacaoConteiner = $rowMovimentacaoConteiner['LOCALIZACAO'];

    ?>
    <tr>
        <td hidden="true"><input type="radio" name="movimentacaoConteiner[]" value="<?php echo $handleMovimentacaoConteiner ?>"></td>
        <td class = 'text-center'><?php echo $dataMovimentacaoConteiner; ?></td>
        <td><?php echo $filialMovimentacaoConteiner; ?></td>
        <td><?php echo $tipoOperacaoMovimentacaoConteiner; ?></td>
        <td><?php echo $finalidadeMovimentacaoConteiner; ?></td>
        <td><?php echo $localizacaoMovimentacaoConteiner; ?></td>
    </tr>
    <?php
}