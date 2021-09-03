<?php
//-- CAMPOS DO FORM
$numeroLote = null;
$situacao = null;
$situacaoHandle = null;
$data = null;
$dataInicial = null;
$dataFinal =null;
$quantidadeDoc = null;
$tipoExtracao = null;
$cliente = null;

//-- CAMPOS DA TABELA DE DOCUMENTOS
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

$loteHandle = Sistema::getGet('lote');
$query = $connect->prepare(
"SELECT A.NUMERO NUMEROLOTE,
        A.STATUS SITUACAOHANDLE,
        B.NOME SITUACAO,
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

  WHERE A.HANDLE = {$loteHandle}");
$query->execute();

$row = $query->fetch(PDO::FETCH_ASSOC);

$numeroLote = $row["NUMEROLOTE"];
$situacao = $row["SITUACAO"];
$situacaoHandle = $row["SITUACAOHANDLE"];
$data = Sistema::formataDataHora($row["DATA"]);
$dataInicial = Sistema::formataDataHora($row["DATAINICIAL"]);
$dataFinal = Sistema::formataDataHora($row["DATAFINAL"]);
$quantidadeDoc = $row["QUANTIDADEDOCUMENTO"];
$tipoExtracao = $row["TIPOEXTRACAO"];
$cliente = $row["CLIENTE"];

$queryDocumento = $connect->prepare(
"SELECT S.RESOURCENAME RESOURCENAMEDOCUMENTO,
        C.NOME STATUSDOCUMENTO,
        U.RESOURCENAME RESOURCENAMEDOCUMENTOTRANSPORTE,
        T.NOME STATUSDOCUMENTOTRANSPORTE,
        B.NUMERODOCUMENTO,
        I.SIGLA TIPODOCUMENTO,
        B.DATAEMISSAO EMISSAODOCUMENTO,
        B.VALORBRUTO VALORBRUTODOCUMENTO,
        J.NOME REMETENTEDOCUMENTO,
        K.NOME DESTINATARIODOCUMENTO,
        L.NOME TOMADORDOCUMENTO,
        E.SIGLA FILIALDOCUMENTO,
        G.SIGLA FILIALORIGEMDOCUMENTO,
        H.SIGLA FILIALDESTINODOCUMENTO,
        M.NOME ATUALDOCUMENTO,
        N.SIGLA UFATUALDOCUMENTO,
        O.NOME ORIGEMDOCUMENTO,
        P.SIGLA UFORIGEMDOCUMENTO,
        Q.NOME DESTINODOCUMENTO,
        R.SIGLA UFDESTINODOCUMENTO

   FROM GD_LOTEDISTRIBUICAODOCUMENTO      A
   LEFT JOIN GD_DOCUMENTO                 B ON B.HANDLE = A.DOCUMENTO 
   LEFT JOIN GD_STATUSDOCUMENTO           C ON C.HANDLE = B.STATUS 
   LEFT JOIN GD_DOCUMENTOTRANSPORTE       D ON D.HANDLE = B.DOCUMENTOTRANSPORTE
   LEFT JOIN MS_FILIAL                    E ON E.HANDLE = B.FILIAL
   LEFT JOIN MS_PESSOA                    F ON F.HANDLE = B.PESSOA
   LEFT JOIN MS_FILIAL                    G ON G.HANDLE = D.FILIALTRANSPORTE
   LEFT JOIN MS_FILIAL                    H ON H.HANDLE = D.FILIALDESTINO
   LEFT JOIN TR_TIPODOCUMENTO             I ON I.HANDLE = B.TIPODOCUMENTOFISCAL
   LEFT JOIN MS_PESSOA                    J ON J.HANDLE = D.REMETENTE
   LEFT JOIN MS_PESSOA                    K ON K.HANDLE = D.DESTINATARIO
   LEFT JOIN MS_PESSOA                    L ON L.HANDLE = B.PESSOA
   LEFT JOIN MS_MUNICIPIO                 M ON M.HANDLE = D.MUNICIPIOATUAL
   LEFT JOIN MS_ESTADO                    N ON N.HANDLE = M.ESTADO
   LEFT JOIN MS_MUNICIPIO                 O ON O.HANDLE = D.MUNICIPIOORIGEM
   LEFT JOIN MS_ESTADO                    P ON P.HANDLE = O.ESTADO
   LEFT JOIN MS_MUNICIPIO                 Q ON Q.HANDLE = D.MUNICIPIODESTINO
   LEFT JOIN MS_ESTADO                    R ON R.HANDLE = Q.ESTADO
   LEFT JOIN MD_IMAGEM                    S ON S.HANDLE = C.IMAGEM
   LEFT JOIN GD_STATUSDOCUMENTOTRANSPORTE T ON T.HANDLE = D.STATUS
   LEFT JOIN MD_IMAGEM                    U ON U.HANDLE = T.IMAGEM

  WHERE A.LOTEDISTRIBUICAO = {$loteHandle}
  ORDER BY B.NUMERODOCUMENTO DESC");
?>