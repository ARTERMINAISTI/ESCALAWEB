<?php
$pessoaUsuarioFiltro = Sistema::getPessoaUsuarioToStr($connect);

if (!empty($pessoaUsuarioFiltro)) {
    $filtroPessoaUsuario = " AND A.CLIENTE IN ($pessoaUsuarioFiltro)";
} else {
    $filtroPessoaUsuario = " AND 1 = 0 ";
}

$handle = null;
$status = null;
$statusIcone = null;
$statusNome = null;
$numeroLote = null;
$data = null;
$dataInicial = null;
$dataFinal =null;
$quantidadeDoc = null;
$tipoExtracao = null;
$cliente = null;

$queryLote = $connect->prepare(
"SELECT A.HANDLE HANDLE,
        A.NUMERO NUMEROLOTE,
        B.HANDLE STATUS,
        B.NOME STATUSNOME,
        E.RESOURCENAME RESOURCENAME,
        A.DATA DATA,
        A.DATAINICIAL,
        A.DATAFINAL,
        A.QUANTIDADE QUANTIDADEDOCUMENTO,
        C.NOME TIPOEXTRACAO,
        D.NOME CLIENTE
   FROM GD_LOTEDISTRIBUICAO A
  INNER JOIN MS_STATUS B ON B.HANDLE = A.STATUS
  INNER JOIN GD_TIPOEXTRACAO C ON C.HANDLE = A.TIPOEXTRACAO
  INNER JOIN MS_PESSOA D ON D.HANDLE = A.CLIENTE
  INNER JOIN MD_IMAGEM E ON E.HANDLE = B.IMAGEM
  WHERE A.HANDLE IS NOT NULL
   " . $filtroPessoaUsuario . "
  ORDER BY A.NUMERO DESC");

$queryLote->execute();

while ($row = $queryLote->fetch(PDO::FETCH_ASSOC)) {
    $handle = $row['HANDLE'];
    $status = $row['STATUS'];
    $statusIcone = Sistema::getImagem($row['RESOURCENAME'], $row['STATUSNOME']);
    $statusNome = $row['STATUSNOME'];
    $numeroLote = $row['NUMEROLOTE'];
    $cliente = $row['CLIENTE'];
    $tipoExtracao = $row['TIPOEXTRACAO'];
    $quantidadeDoc = $row['QUANTIDADEDOCUMENTO'];
    $data = Sistema::formataData($row['DATA']);
    $dataInicial = Sistema::formataData($row['DATAINICIAL']);
    $dataFinal = Sistema::formataData($row['DATAFINAL']);
    ?>
    <tr onclick="trOnClick(<?php echo $handle; ?>)">
        <td hidden="true"><input type="radio" name="check[]" hidden="true" id="check" data-ref="<?php echo $status ?>" value="<?php echo $handle ?>"></td>
        <td widtd="1%" style="font-size:14px;"><?php echo $statusIcone; ?></td>
        <td><?php echo $statusNome ?></td>
        <td style="text-align:right"><?php echo $numeroLote ?></td>
        <td><?php echo $cliente ?></td>
        <td><?php echo $tipoExtracao ?></td>
        <td style="text-align:right"><?php echo $quantidadeDoc ?></td>
        <td><?php echo $data ?></td>
        <td><?php echo $dataInicial ?></td>
        <td><?php echo $dataFinal ?></td>
    </tr>
<?php
}
?>