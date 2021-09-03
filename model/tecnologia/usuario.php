<?php

include_once("../../controller/tecnologia/Sistema.php");
include_once("../../controller/tecnologia/WS.php");

class Usuario {

    public function atualizarAuditoriaAcesso() {

        if (!empty($_SESSION["auditoriaAcesso"])) {
            WebService::setupCURL("accesslog", [
                "AUDITORIA" => $_SESSION["auditoriaAcesso"]
            ]);

            WebService::execute();
        }
    }    

    public function finalizarAuditoriaAcesso() {

        if (!empty($_SESSION["auditoriaAcesso"])) {
            WebService::setupCURL("endaccesslog", [
                "AUDITORIA" => $_SESSION["auditoriaAcesso"]
            ]);

            WebService::execute();
        }
    } 
    
    public function gerarAuditoriaAcesso() {

        if (!empty($_SESSION["handleUsuario"])) {
        
            if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }
            
            WebService::setupCURL("accesslog", [
                "USUARIO" => $_SESSION["handleUsuario"],
                "IP" => $ip,
                "SESSAO" => session_id()
            ]);

            WebService::execute();

            if (WebService::getHttpCode() === 200) {
                $_SESSION["auditoriaAcesso"] = WebService::getBody();
            }            
        }
    }
    
    public function gerarImagem() {
        $connect = Sistema::getConexao(false);

        $query = $connect->prepare("SELECT MAX(C.HANDLE) HANDLE
                                      FROM MS_USUARIO A
                                     INNER JOIN MS_PESSOA B ON B.HANDLE = A.PESSOA
                                     INNER JOIN MS_PESSOAANEXO C ON C.PESSOA = A.PESSOA
                                     WHERE A.HANDLE = :USUARIO
                                       AND C.ANEXO IS NOT NULL
                                       AND CASE WHEN B.TIPO IN (2,4) THEN 2 ELSE 1 END = C.TIPO");

        $query->bindParam(":USUARIO", $_SESSION["handleUsuario"], PDO::PARAM_INT);	
        $query->execute();	 
                
        $row = $query->fetch(PDO::FETCH_COLUMN, 0);

        if (count($row) > 0) {
            WebService::setupCURL("attachedimage", [
                "HANDLE" => $row,
                "TABELA" => "MS_PESSOAANEXO",
                "CAMPO" => "ANEXO"
            ]);

            WebService::execute();

            if (WebService::getHttpCode() === 200) {
                $_SESSION["usuarioImagem"] = WebService::getBody();
            }  
        }        
    }
    
    public function getPainelIndicadorTelaInicial() {
        $connect = Sistema::getConexao(false);

        $query = $connect->prepare("SELECT A.PAINELINDICADOR PAINELINDICADOR
                                                
                                      FROM MS_USUARIOPAINELINDICADOR A
                                     INNER JOIN BI_PAINEL B ON B.HANDLE = A.PAINELINDICADOR
                                        
                                     WHERE A.USUARIO = :USUARIO
                                       AND A.EHVISUALIZARPAGINAINICIALWEB = 'S'
                                       
                                       AND B.STATUS = 4");

        $query->bindParam(":USUARIO", $_SESSION["handleUsuario"], PDO::PARAM_INT);	
        $query->execute();	 
                
        $row = $query->fetch(PDO::FETCH_COLUMN, 0);
				
        if (count($row) > 0) {
            return intval($row);
        }
        else {
            return 0;
        }        
    }
}	
		
?>