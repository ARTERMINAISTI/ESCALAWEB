<?php
include_once('../tecnologia/Sistema.php');
include_once('ConsultaConteinerController.php');

$conexao = Sistema::getConexao();

$ConsultaConteiner = new ConsultaConteinerController($conexao);

switch($_POST['REQUEST']) {
    
    case 'getRegistro':
        $dadosFiltro = json_decode(json_encode($_POST["FILTRO"]));
        
        $filtro = "";
        if(is_array($dadosFiltro->FILIAL)) {
            $filtro = " AND J.HANDLE IN (" . implode(',', $dadosFiltro->FILIAL) . ") ";
        }   
        
        if(is_array($dadosFiltro->CLIENTE)) {
            $filtro = " AND F.HANDLE IN (" . implode(',', $dadosFiltro->CLIENTE) . ") ";
        } 

        if(is_array($dadosFiltro->SITUACAO)) {
            $filtro = " AND A.STATUS IN (" . implode(',', $dadosFiltro->SITUACAO) . ") ";
        } 

        if(is_array($dadosFiltro->TIPOOPERACAO)) {
            $filtro = " AND K.HANDLE IN (" . implode(',', $dadosFiltro->TIPOOPERACAO) . ") ";
        } 
        
        if($dadosFiltro->CONTEINER) {
            $filtro = " AND A.CODIGO = '$dadosFiltro->CONTEINER' ";
        } 

        if(is_array($dadosFiltro->TIPOCONTEINER)) {
            $filtro = " AND C.HANDLE IN (" . implode(',', $dadosFiltro->TIPOCONTEINER) . ") ";
        } 

        if(is_array($dadosFiltro->LOCALIZACAO)) {
            $filtro = " AND G.HANDLE IN (" . implode(',', $dadosFiltro->LOCALIZACAO) . ") ";
        } 

        if(is_array($dadosFiltro->CLASSIFICACAOISO)) {
            $filtro = " AND D.HANDLE IN (" . implode(',', $dadosFiltro->CLASSIFICACAOISO) . ") ";
        } 

        if($dadosFiltro->DATAENTRADA) {
            $filtro = " AND DATEDIFF(day, CONVERT(VARCHAR, E.ENTRADA, 20), (SELECT CONVERT(VARCHAR, REPLACE('$dadosFiltro->DATAENTRADA', 'T', ' '), 20))) = 0 ";
        } 

        if($dadosFiltro->DATASAIDA) { 
            $filtro = " AND DATEDIFF(day, CONVERT(VARCHAR, E.SAIDA, 20), (SELECT CONVERT(VARCHAR, REPLACE('$dadosFiltro->DATASAIDA', 'T', ' '), 20))) = 0 ";
        }
        if($dadosFiltro->DATADEMURRAGE) {
            $filtro = " AND DATEDIFF(day, CONVERT(VARCHAR, E.DEMURRAGE, 20), (SELECT CONVERT(VARCHAR, REPLACE('$dadosFiltro->DATADEMURRAGE', 'T', ' '), 20))) = 0 ";
        } 
        
        $rows = $ConsultaConteiner->getRegistro($filtro);
        
        echo json_encode($rows);
    break;    
    
    case 'getFiltroFilial':
        $ConsultaConteiner->montaFiltro();
        
        echo json_encode($ConsultaConteiner->getFiltro('FILIAL'));
    break;    

    case 'getFiltroCliente':
        $ConsultaConteiner->montaFiltro();
        
        echo json_encode($ConsultaConteiner->getFiltro('CLIENTE'));
    break;
    
    case 'getFiltroSituacao':
        $ConsultaConteiner->montaFiltro();
        
        echo json_encode($ConsultaConteiner->getFiltro('SITUACAO'));
    break;    

    case 'getFiltroTipoOperacao':
        $ConsultaConteiner->montaFiltro();
        
        echo json_encode($ConsultaConteiner->getFiltro('TIPOOPERACAO'));
    break; 

    case 'getFiltroConteiner':
        $ConsultaConteiner->montaFiltro();
        
        echo json_encode($ConsultaConteiner->getFiltro('CONTEINER'));
    break; 

    case 'getFiltroTipoConteiner':
        $ConsultaConteiner->montaFiltro();
        
        echo json_encode($ConsultaConteiner->getFiltro('TIPOCONTEINER'));
    break; 

    case 'getFiltroLocalizacao':
        $ConsultaConteiner->montaFiltro();
        
        echo json_encode($ConsultaConteiner->getFiltro('LOCALIZACAO'));
    break; 

    case 'getFiltroClassificacaoIso':
        $ConsultaConteiner->montaFiltro();
        
        echo json_encode($ConsultaConteiner->getFiltro('CLASSIFICACAOISO'));
    break; 

}