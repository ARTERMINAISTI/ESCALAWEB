<?php
include_once('../tecnologia/Sistema.php');
include_once('ConfirmarLocalizacaoConteinerController.php');

$conexao = Sistema::getConexao();

$ConfirmarConteiner = new ConfirmarLocalizacaoConteinerController($conexao);

switch($_POST['REQUEST']) {
    
    case 'getRegistro':
        $dadosFiltro = json_decode(json_encode($_POST["FILTRO"]));
        
        $filtro = "";
        if(is_array($dadosFiltro->FILIAL)) {
            $filtro = " AND B.HANDLE IN (" . implode(',', $dadosFiltro->FILIAL) . ") ";
        }
        
        if($dadosFiltro->DATA) {
            $filtro = " AND DATEDIFF(minute, CONVERT(VARCHAR, A.DATA, 20), (SELECT CONVERT(VARCHAR, REPLACE('$dadosFiltro->DATA', 'T', ' '), 20))) = 0 ";
        }

        if(is_array($dadosFiltro->CLIENTE)) {
            $filtro = " AND C.HANDLE IN (" . implode(',', $dadosFiltro->CLIENTE) . ") ";
        }

        if(is_array($dadosFiltro->CONTEINER)) {
            $filtro = " AND D.HANDLE IN (" . implode(',', $dadosFiltro->CONTEINER) . ") ";
        }

        if(is_array($dadosFiltro->LOCALIZACAO)) {
            $filtro = " AND E.HANDLE IN (" . implode(',', $dadosFiltro->LOCALIZACAO) . ") ";
        }
       
        $rows = $ConfirmarConteiner->getRegistro($filtro);
        
        echo json_encode($rows);
    break;    
    
    case 'getFiltroFilial':
        $ConfirmarConteiner->montaFiltro();
        
        echo json_encode($ConfirmarConteiner->getFiltro('FILIAL'));
    break;    

    case 'getFiltroData':
        $ConfirmarConteiner->montaFiltro();
        
        echo json_encode($ConfirmarConteiner->getFiltro('DATA'));
    break;
    
    case 'getFiltroCliente':
        $ConfirmarConteiner->montaFiltro();
        
        echo json_encode($ConfirmarConteiner->getFiltro('CLIENTE'));
    break;    

    case 'getFiltroConteiner':
        $ConfirmarConteiner->montaFiltro();
        
        echo json_encode($ConfirmarConteiner->getFiltro('CONTEINER'));
    break; 

    case 'getFiltroLocalizacao':
        $ConfirmarConteiner->montaFiltro();
        
        echo json_encode($ConfirmarConteiner->getFiltro('LOCALIZACAO'));
    break; 

}