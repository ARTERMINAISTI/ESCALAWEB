<?php
    include_once('../../controller/tecnologia/Sistema.php');
    date_default_timezone_set('America/Sao_Paulo');
    include_once('../../controller/tecnologia/WS.php');

    class LoteDistribuicao{
        private $connect;
        
        function LoteDistribuicao() {
            $this->connect = Sistema::getConexao();
        }

        public function gerarLoteDistribuicao($dados) {
            WebService::setupCURL("/fiscal/gerarLote", json_decode($dados));

            WebService::execute();

            $body = WebService::getBody();

            $dados = json_decode($body);

            if (isset($dados->HANDLE)) {
                echo $dados->HANDLE;
            } else {
                echo Sistema::retornoJson(500, $body);
            }
        }

        public function DownloadLoteDistribuicao($dados) {
            WebService::setupCURL("/fiscal/downloadLote", json_decode($dados));

            WebService::execute();

            $body = WebService::getBody();

            $dados = json_decode($body);

            if (isset($dados->HANDLE)) {
                echo $body;
            } else {
                echo Sistema::retornoJson(500, $body);
            }
        }
    }
    
?>