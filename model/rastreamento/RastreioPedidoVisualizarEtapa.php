<?php

$queryRastreamentoEtapa->execute();

while($rowRastreamentoEtapa = $queryRastreamentoEtapa->fetch(PDO::FETCH_ASSOC)){
$handleRastreamentoEtapa = $rowRastreamentoEtapa['HANDLE'];
$etapaRastreamentoEtapa = $rowRastreamentoEtapa['ETAPA'];
//$dataRastreamentoEtapa = date('d/m/Y H:i:s', strtotime($rowRastreamentoEtapa['DATA']));
$observacaoRastreamentoEtapa = $rowRastreamentoEtapa['OBSERVACAO'];
$etapaimagemstatus = "<img src='../tecnologia/img/status/{$rowRastreamentoEtapa['ETAPAIMAGEMSTATUS']}.png' width='15px' height='15px'>";
	
$ts = strtotime($rowRastreamentoEtapa['DATA']);

if ($ts === false)
{
	$dataRastreamentoEtapa = NULL;
}
else
{
	$dataRastreamentoEtapa = date('d/m/Y H:i:s', strtotime($rowRastreamentoEtapa['DATA']));
}
?>
<tr>
<td style="border: 0;" align="center"><?php echo $etapaimagemstatus; ?></td>
<td style="border: 0; width: 13%"><?php echo $dataRastreamentoEtapa; ?></td>
<td style="border: 0;"><?php echo $etapaRastreamentoEtapa; ?></td>
<td style="border: 0;"><?php echo $observacaoRastreamentoEtapa; ?></td>
</tr>
<?php
}