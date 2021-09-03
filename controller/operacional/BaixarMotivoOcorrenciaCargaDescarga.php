<?php

include_once('../tecnologia/Sistema.php');

$connect = Sistema::getConexao();

$carregamento = Sistema::getPost('handle');

$queryTipo = "SELECT A.HANDLE id,
                     A.NOME value
                  FROM AM_MOTIVOOCORRENCIACARGA A
                WHERE A.STATUS = 4 
                  AND A.EHPERMITIRWEB = 'S' ";
$queryTipoPrepare = $connect->prepare($queryTipo);
$queryTipoPrepare->execute();

echo json_encode($queryTipoPrepare->fetchAll(PDO::FETCH_ASSOC));
