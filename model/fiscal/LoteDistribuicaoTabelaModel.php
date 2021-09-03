<?php
Sistema::iniciaCarregando();

$pessoaUsuarioFiltro = Sistema::getPessoaUsuarioToStr($connect);

if (!empty($pessoaUsuarioFiltro)) {
    $filtroPessoaUsuario = " AND A.PESSOA IN ($pessoaUsuarioFiltro)";
} else {
    $filtroPessoaUsuario = " AND 1 = 0 ";
}

$filtroDataEmissao = (!empty($_GET['dataInicial'])) ? Sistema::getFiltroGetEntreData("dataInicial", "dataFinal", "A.DATAEMISSAO") : ' AND 1 = 0 ' ;

$handleDocumento = null;
$numeroDocumento = null;
$tipoDocumento = null;
$dataEmissao = null;
$valorBruto = null;
$remetenteDocumento = null;
$destinatario = null;
$tomadorDocumento = null;
$filialDocumento = null;
$filialOrigemDocumento = null;
$filialDestinoDocumento = null;
$atualDocumento = null;
$UFAtualDocumento = null;
$origemDocumento = null;
$UFOrigemDocumento = null;
$destinoDocumento = null;
$UFDestinoDocumento = null;

$queryDocumento = $connect->prepare(
"SELECT A.HANDLE,
        Q.RESOURCENAME RESOURCENAMEDOCUMENTO,
        B.NOME STATUSDOCUMENTO,
        S.RESOURCENAME RESOURCENAMEDOCUMENTOTRANSPORTE,
        R.NOME STATUSDOCUMENTOTRANSPORTE,
        A.NUMERODOCUMENTO,
        G.SIGLA TIPODOCUMENTO,
        A.DATAEMISSAO EMISSAODOCUMENTO,
        A.VALORBRUTO VALORBRUTODOCUMENTO,
        H.NOME REMETENTEDOCUMENTO,
        I.NOME DESTINATARIODOCUMENTO,
        J.NOME TOMADORDOCUMENTO,
        J.HANDLE TOMADORHANDLE,
        D.SIGLA FILIALDOCUMENTO,
        E.SIGLA FILIALORIGEMDOCUMENTO,
        F.SIGLA FILIALDESTINODOCUMENTO,
        K.NOME ATUALDOCUMENTO,
        L.SIGLA UFATUALDOCUMENTO,
        M.NOME ORIGEMDOCUMENTO,
        N.SIGLA UFORIGEMDOCUMENTO,
        O.NOME DESTINODOCUMENTO,
        P.SIGLA UFDESTINODOCUMENTO

   FROM GD_DOCUMENTO                      A
   LEFT JOIN GD_STATUSDOCUMENTO           B ON B.HANDLE = A.STATUS 
   LEFT JOIN GD_DOCUMENTOTRANSPORTE       C ON C.HANDLE = A.DOCUMENTOTRANSPORTE
   LEFT JOIN MS_FILIAL                    D ON D.HANDLE = A.FILIAL
   LEFT JOIN MS_FILIAL                    E ON E.HANDLE = C.FILIALTRANSPORTE
   LEFT JOIN MS_FILIAL                    F ON F.HANDLE = C.FILIALDESTINO
   LEFT JOIN TR_TIPODOCUMENTO             G ON G.HANDLE = A.TIPODOCUMENTOFISCAL
   LEFT JOIN MS_PESSOA                    H ON H.HANDLE = C.REMETENTE
   LEFT JOIN MS_PESSOA                    I ON I.HANDLE = C.DESTINATARIO
   LEFT JOIN MS_PESSOA                    J ON j.HANDLE = A.PESSOA
   LEFT JOIN MS_MUNICIPIO                 K ON K.HANDLE = C.MUNICIPIOATUAL
   LEFT JOIN MS_ESTADO                    L ON L.HANDLE = K.ESTADO
   LEFT JOIN MS_MUNICIPIO                 M ON M.HANDLE = C.MUNICIPIOORIGEM
   LEFT JOIN MS_ESTADO                    N ON N.HANDLE = M.ESTADO
   LEFT JOIN MS_MUNICIPIO                 O ON O.HANDLE = C.MUNICIPIODESTINO
   LEFT JOIN MS_ESTADO                    P ON P.HANDLE = O.ESTADO
   LEFT JOIN MD_IMAGEM                    Q ON Q.HANDLE = B.IMAGEM
   LEFT JOIN GD_STATUSDOCUMENTOTRANSPORTE R ON R.HANDLE = C.STATUS
   LEFT JOIN MD_IMAGEM                    S ON S.HANDLE = R.IMAGEM
   LEFT JOIN TR_MODELODOCUMENTO           T ON T.HANDLE = A.MODELO

  WHERE T.CODIGO LIKE '57'
   " . $filtroPessoaUsuario . "
   " . $filtroDataEmissao . "
  ORDER BY A.DATAEMISSAO DESC");

$queryDocumento->execute();

while ($rowDocumento = $queryDocumento->fetch(PDO::FETCH_ASSOC)) {
    $handleDocumento = $rowDocumento['HANDLE'];
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
        <td width="1%">
            <input type="checkbox" name="check" id="check" handle="<?php echo $handleDocumento; ?>" cliente="<?php echo $rowDocumento['TOMADORHANDLE']; ?>">
        </td>
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