<?php

$usuario = $_SESSION['handleUsuario'];

//$sqlPessoasUsuario = "SELECT C.HANDLE, C.APELIDO NOME FROM MS_USUARIO A
//INNER JOIN MS_USUARIOPESSOA B ON B.USUARIO = A.HANDLE
//INNER JOIN MS_PESSOA C ON B.PESSOA = C.HANDLE
//WHERE A.HANDLE = $usuario";

$sqlPessoasUsuario = "SELECT C.HANDLE, C.APELIDO NOME FROM MS_USUARIO A
INNER JOIN MS_TRANSFERENCIAAGENTE B ON B.AGENTEVENDAS = A.PESSOA
INNER JOIN MS_PESSOA C ON C.HANDLE = B.PESSOA
WHERE B.STATUS = 6 AND A.HANDLE = $usuario";

//$sqlPessoasUsuario = " SELECT A.HANDLE, 
//                             A.APELIDO NOME 
//                         FROM MS_PESSOA A
//                        WHERE A.STATUS = 4 
//                          AND A.EHCLIENTE = 'S' ";


$queryPessoasUsuario = $connect->prepare($sqlPessoasUsuario);
$queryPessoasUsuario->execute();

$clientes = [];

while($dados = $queryPessoasUsuario->fetch(PDO::FETCH_ASSOC)){
    $clientes[] = $dados;
}