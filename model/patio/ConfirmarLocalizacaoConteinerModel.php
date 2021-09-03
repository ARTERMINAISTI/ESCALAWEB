<?php

class ConfirmarLocalizacaoConteinerModel {
    
    protected $handle;
    protected $status;
    protected $statusNome;
    protected $statusImagem;
    protected $numero;
    protected $data;
    protected $filial;
    protected $cliente; 
    protected $situacao;
    protected $tipooperacao;
    protected $conteiner;
    protected $tipoconteiner;
    protected $localizacao;
    protected $handleLocalizacao;
    protected $classificacaoiso;
    protected $finalidade;
    
    protected $filtro = Array("FILIAL" => Array(), 
                              "CLIENTE" => Array(), 
                              "CONTEINER" => Array(), 
                              "LOCALIZACAO" => Array(),
                              "DATA" => Array()
                             );
    
    protected $filtroSelecionado = Array("FILIAL" => Array(), 
                                         "CLIENTE" => Array(), 
                                         "CONTEINER" => Array(), 
                                         "LOCALIZACAO" => Array(),
                                         "DATA" => Array()
                                        );
       
    public function __construct() {
                                                
    }
    
    public function getQuery($filtro = '') {
        return "SELECT A.HANDLE HANDLE, 
                       A.NUMERO, 
                       B.NOME FILIAL, 
                       A.DATA DATA, 
                       C.NOME CLIENTE, 
                       D.CODIGO CONTEINER, 
                       E.HANDLE HANDLELOCALIZACAO,
                       E.POSICAO LOCALIZACAO
                  FROM PA_ORDEM A
                 INNER JOIN MS_FILIAL B ON B.HANDLE = A.FILIAL
                 INNER JOIN MS_PESSOA C ON C.HANDLE = A.CLIENTE
                  LEFT JOIN PA_CONTEINER D ON D.HANDLE = A.CONTEINER
                 INNER JOIN PA_TERMINALLOCALIZACAO E ON E.HANDLE = A.LOCALIZACAO
                 WHERE A.STATUS = 21
                   AND A.EMPRESA = {$_SESSION['empresa']}

                 $filtro 

                 ORDER BY A.NUMERO DESC";
    }        

    public function getHandle() {
        return $this->handle;
    }
    
    public function getNumero() {
        return $this->numero;
    }

    public function getFilial() {
        return $this->filial;
    }

    public function getData() {
        return $this->data;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function getConteiner() {
        return $this->conteiner;
    }

    public function getLocalizacao() {
        return $this->localizacao;
    }

    public function getHandleLocalizacao() {
        return $this->handleLocalizacao;
    }

    public function getFiltro($filtro) {
        return $this->filtro[$filtro];
    }

    protected function setHandle($handle) {
        $this->handle = $handle;
    }

    protected function setNumero($numero) {
        $this->numero = $numero;
    }

    protected function setFilial($filial) {
        $this->filial = $filial;
    }

    protected function setData($data) {
        $this->data = $data;
    }

    protected function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    protected function setConteiner($conteiner) {
        $this->conteiner = $conteiner;
    }

    protected function setLocalizacao($localizacao) {
        $this->localizacao = $localizacao;
    }

    protected function setHandleLocalizacao($handleLocalizacao) {
        $this->handleLocalizacao = $handleLocalizacao;
    }

    protected function getQueryFiltroFilial() {
        return "SELECT A.HANDLE, 
                       A.NOME C1, 
                       A.SIGLA C2
                  FROM MS_FILIAL A
                 WHERE A.STATUS = 4 
                 ORDER BY C1";
    }
    
    protected function getQueryFiltroCliente() {
        return "SELECT TOP 1000 
                       A.HANDLE, 
                       A.APELIDO C1, 
                       A.CNPJCPF C2
                  FROM MS_PESSOA A (NOLOCK)  
                 WHERE A.STATUS = 4
                   AND A.EHCLIENTE = 'S'
                   ORDER BY C1 ";
	}

    protected function getQueryFiltroConteiner() {
        return "SELECT TOP 1000 
                       A.HANDLE, 
                       A.CODIGO C1
                  FROM PA_CONTEINER A
                 WHERE A.STATUS = 4
                 ORDER BY C1 ";
	}

    protected function getQueryFiltroLocalizacao() {        
        return "SELECT TOP 1000
                           A.HANDLE, 
                           A.POSICAO C1
                    
                  FROM PA_TERMINALLOCALIZACAO A 
                        
                 WHERE 1 = 1  
                   AND EXISTS (SELECT Z1.HANDLE                
                                 FROM PA_TERMINAL Z1              
                                WHERE Z1.HANDLE = A.TERMINAL 
                                  AND Z1.EMPRESA = {$_SESSION['empresa']}
                                  AND Z1.FILIAL = {$_SESSION['filial']})
                        
                   AND HANDLE IN ( SELECT A.HANDLE HANDLE   
                                     FROM PA_TERMINALLOCALIZACAO A  
                                    WHERE A.STATUS = 3 
                                      AND NOT EXISTS (SELECT Z.HANDLE                    
                                                        FROM PA_TERMINALCLIENTE Z                   
                                                       WHERE Z.TERMINALLOCALIZACAO = A.HANDLE)  
                                      AND NOT EXISTS (SELECT Z.HANDLE                    
                                                        FROM PA_TERMINALNATUREZAMERCADORIA Z                   
                                                       WHERE Z.TERMINALLOCALIZACAO = A.HANDLE)  
                                      AND NOT EXISTS (SELECT Z.HANDLE                    
                                                        FROM PA_TERMINALNATUREZAOPERACAO Z                   
                                                       WHERE Z.TERMINALLOCALIZACAO = A.HANDLE)  
                                      AND (EXISTS (SELECT X.HANDLE                 
                                                     FROM PA_TERMINAL X                
                                                    WHERE X.HANDLE = A.TERMINAL                  
                                                      AND X.FILIAL = {$_SESSION['filial']}                  
                                                      AND X.STATUS = 3             )     )                                  

                   AND ((A.CAPACIDADEBOOKING = 0) OR       ((A.CAPACIDADEBOOKING) > COALESCE((SELECT COUNT(1)                                   
                                                                                                FROM PA_CONTEINERENTRADA Z                                     
                                                                                               WHERE Z.LOCALIZACAO = A.HANDLE                                     
                                                                                                 AND Z.SAIDA IS NULL                                  
                                                                                               GROUP BY Z.BOOKING), 0)      )     ) 
                   AND ((A.CAPACIDADEPROCESSO = 0) OR       ((A.CAPACIDADEPROCESSO) > COALESCE((SELECT COUNT(1)                                   
                                                                                                  FROM PA_CONTEINERENTRADA Z                                     
                                                                                                 WHERE Z.LOCALIZACAO = A.HANDLE                                     
                                                                                                   AND Z.SAIDA IS NULL                                  
                                                                                                 GROUP BY Z.PROCESSO), 0)      )     ) 
                   AND (NOT EXISTS (SELECT Z.HANDLE                     
                                      FROM PA_CONTEINERMOVIMENTACAO Z                    
                                     WHERE Z.LOCALIZACAO = A.HANDLE                      
                                       AND Z.FILIAL = {$_SESSION['filial']}                     
                                       AND Z.DATA = (SELECT MAX(XX.DATA) 
                                                       FROM PA_CONTEINERMOVIMENTACAO XX 
                                                      WHERE XX.LOCALIZACAO = Z.LOCALIZACAO)                      
                                       AND Z.ORDEM = (SELECT MAX(XX.ORDEM) 
                                                        FROM PA_CONTEINERMOVIMENTACAO XX 
                                                       WHERE XX.LOCALIZACAO = Z.LOCALIZACAO 
                                                         AND XX.DATA = Z.DATA)                      
                                       AND Z.TIPOOPERACAO <> 2                      
                                       AND (NOT EXISTS (SELECT X.HANDLE                                         
                                                          FROM PA_CONTEINERMOVIMENTACAO X                                        
                                                         WHERE X.CONTEINER = Z.CONTEINER                                          
                                                           AND X.TIPOOPERACAO = 4                                          
                                                           AND X.FILIAL = Z.FILIAL                                          
                                                           AND X.DATA > Z.DATA)  )  )       
                                       OR A.EHPERMITIRMULTIPLOCONTEINER = 'S' )  )
                                
                   
                   AND (EXISTS(SELECT X.HANDLE           
                                 FROM PA_TERMINALLOCALIZACAOSITUACAO X          
                                INNER JOIN PA_TERMINALLOCALIZACAO Y ON Y.HANDLE = X.TERMINALLOCALIZACAO AND Y.HANDLE = A.HANDLE          
                                INNER JOIN PA_TERMINAL Z ON Z.HANDLE = Y.TERMINAL          
                                WHERE Z.FILIAL = {$_SESSION['filial']}        
                                  AND X.STATUSCONTEINER = 4)     
                        OR NOT EXISTS(SELECT X.HANDLE                     
                                        FROM PA_TERMINALLOCALIZACAOSITUACAO X                    
                                       INNER JOIN PA_TERMINALLOCALIZACAO Y ON Y.HANDLE = X.TERMINALLOCALIZACAO                    
                                       INNER JOIN PA_TERMINAL Z ON Z.HANDLE = Y.TERMINAL                    
                                       WHERE X.STATUSCONTEINER = 4                      
                                         AND Z.FILIAL = {$_SESSION['filial']}))

                   AND ( A.STATUS = 3)
                 ORDER BY C1 ASC ";
    }
    
}
