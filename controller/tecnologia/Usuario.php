<?php

include_once('../../controller/tecnologia/WS.php');

class UsuarioController {

    public function atualizarAuditoriaAcesso() {

        if (!empty($_SESSION['auditoriaAcesso'])) {
            WebService::setupCURL("accesslog", [
                "AUDITORIA" => $_SESSION['auditoriaAcesso']
            ]);

            WebService::execute();
        }
    }    

    public function finalizarAuditoriaAcesso() {

        if (!empty($_SESSION['auditoriaAcesso'])) {
            WebService::setupCURL("endaccesslog", [
                "AUDITORIA" => $_SESSION['auditoriaAcesso']
            ]);

            WebService::execute();
        }
    } 
    
    public function gerarAuditoriaAcesso() {

        if (!empty($_SESSION['handleUsuario'])) {
        
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            
            WebService::setupCURL("accesslog", [
                "USUARIO" => $_SESSION['handleUsuario'],
                "IP" => $ip,
                "SESSAO" => session_id()
            ]);

            WebService::execute();

            if (WebService::getHttpCode() === 200) {
                $_SESSION['auditoriaAcesso'] = WebService::getBody();
            }            
        }
    }
}	
		
?>