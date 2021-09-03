<?php

class ConsultaConteinerModel {
    
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
    protected $classificacaoiso;
    protected $finalidade;
    
    protected $filtro = Array("FILIAL" => Array(), 
                              "CLIENTE" => Array(), 
                              "STATUS" => Array(), 
                              "TIPOOPERACAO" => Array(), 
                              "CONTEINER" => Array(), 
                              "TIPOCONTEINER" => Array(), 
                              "LOCALIZACAO" => Array(), 
                              "CLASSIFICACAOISO" => Array(),     
                              "FINALIDADE" => Array()
                             );
    
    protected $filtroSelecionado = Array("FILIAL" => Array(), 
                                         "CLIENTE" => Array(), 
                                         "STATUS" => Array(), 
                                         "TIPOOPERACAO" => Array(), 
                                         "CONTEINER" => Array(), 
                                         "TIPOCONTEINER" => Array(), 
                                         "LOCALIZACAO" => Array(), 
                                         "CLASSIFICACAOISO" => Array(),     
                                         "FINALIDADE" => Array()
                                         );
       
    public function __construct() {
        
    }
    
    public function getQuery($filtro = '') {
        return "SELECT TOP 1000 A.HANDLE HANDLE,
                       A.STATUS STATUS, 
                       B.NOME STATUSNOME, 
                       A.CODIGO CONTEINER, 
                       C.NOME TIPOCONTEINER, 
                       D.NOME CLASSIFICACAOISO, 
                       F.NOME CLIENTE, 
                       J.NOME FILIAL, 
                       G.POSICAO LOCALIZACAO, 
                       E.ENTRADA ENTRADA, 
                       E.SAIDA SAIDA, 
                       E.DIAS DIAS, 
                       K.NOME TIPOOPERACAO, 
                       I.NOME FINALIDADE, 
                       E.DEMURRAGE DEMURRAGE
                         
                  FROM PA_CONTEINER A (NOLOCK)
                  LEFT JOIN PA_STATUSCONTEINER B (NOLOCK) ON B.HANDLE = A.STATUS
                  LEFT JOIN PA_TIPOEQUIPAMENTO C (NOLOCK) ON C.HANDLE = A.TIPOEQUIPAMENTO
                  LEFT JOIN PA_CLASSIFICACAOISO D (NOLOCK) ON D.HANDLE = A.CLASSIFICACAOISO
                  LEFT JOIN PA_CONTEINERENTRADA E (NOLOCK) ON E.HANDLE = A.CONTEINERENTRADA
                  LEFT JOIN MS_PESSOA F (NOLOCK) ON F.HANDLE = E.CLIENTE
                  LEFT JOIN PA_TERMINALLOCALIZACAO G (NOLOCK) ON G.HANDLE = E.LOCALIZACAO
                  LEFT JOIN PA_TIPOMOVIMENTACAO H (NOLOCK) ON H.HANDLE = E.TIPOMOVIMENTACAO
                  LEFT JOIN PA_FINALIDADEMOVIMENTACAO I (NOLOCK) ON I.HANDLE = E.FINALIDADE
                  LEFT JOIN MS_FILIAL J (NOLOCK) ON J.HANDLE = E.FILIAL
                  LEFT JOIN PA_TIPOOPERACAO K (NOLOCK) ON K.HANDLE = H.TIPOOPERACAO
                 WHERE A.STATUS <> 3 --CANCELADO
                     
                  $filtro 

                 ORDER BY E.ENTRADA, A.LOGDATACADASTRO DESC";
    }       

    public function getHandle() {
        return $this->handle;
    }
    
    public function getStatus() {
        return $this->status;
    }

    public function getStatusNome() {
        return $this->statusNome;
    }
    
    public function getStatusImagem() {
        return $this->statusImagem;
    }

    public function getConteiner() {
        return $this->conteiner;
    }
    
    public function getFilial() {
        return $this->filial;
    }

    public function getTipoConteiner() {
        return $this->tipoconteiner;
    }

    public function getClassificacaoISO() {
        return $this->classificacaoiso;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function getLocalizacao() {
        return $this->localizacao;
    }

    public function getEntrada() {
        return $this->entrada;
    }

    public function getSaida() {
        return $this->saida;
    }

    public function getDias() {
        return $this->dias;
    }

    public function getTipoOperacao() {
        return $this->tipooperacao;
    }

    public function getFinalidade() {
        return $this->finalidade;
    }

    public function getDemurrage() {
        return $this->demurrage;
    }
    
    public function getFiltro($filtro) {
        return $this->filtro[$filtro];
    }

    protected function setHandle($handle) {
        $this->handle = $handle;
    }

    protected function setConteiner($conteiner) {
        $this->conteiner = $conteiner;
    }

    protected function setFilial($filial) {
        $this->filial = $filial;
    }
    
    protected function setTipoConteiner($tipoconteiner) {
        $this->tipoconteiner = $tipoconteiner;
    }
    
    protected function setClassificacaoISO($classificacaoiso) {
        $this->classificacaoiso = $classificacaoiso;
    }
    
    protected function setCliente($cliente) {
        $this->cliente = $cliente;
    }
    
    protected function setLocalizacao($localizacao) {
        $this->localizacao = $localizacao;
    }
    
    protected function setEntrada($entrada) {
        $this->entrada = $entrada;
    }
    
    protected function setSaida($saida) {
        $this->saida = $saida;
    }
    
    protected function setDias($dias) {
        $this->dias = $dias;
    }
    
    protected function setTipoOperacao($tipooperacao) {
        $this->tipooperacao = $tipooperacao;
    }
    
    protected function setFinalidade($finalidade) {
        $this->finalidade = $finalidade;
    }
    
    protected function setDemurrage($demurrage) {
        $this->demurrage = $demurrage;
    }
    
    protected function setFiltro($filtro, $value) {
        $this->filtro[$filtro] = $value;
    } 

    protected function setStatus($status) {
        $this->status = $status;
    }

    protected function setStatusNome($statusNome) {
        $this->statusNome = $statusNome;
    }

    protected function setstatusImagem($ProgramacaoStatus, $ProgramacaoStatusNome ) {
        
        if ($ProgramacaoStatus == '1') {
            $this->statusImagem = "<img src='../../view/tecnologia/img/status/cinza/vazio.png' width='13px' height='auto' title='" . $ProgramacaoStatusNome . "' alt='" . $ProgramacaoStatusNome . "'>";
        }
        if ($ProgramacaoStatus == '2') {
            $this->statusImagem = "<img src='../../view/tecnologia/img/status/amarelo/exclamacao.png' width='13px' height='auto' title='" . $ProgramacaoStatusNome . "' alt='" . $ProgramacaoStatusNome . "'>";
        }
        if ($ProgramacaoStatus == '3') {
            $this->statusImagem = "<img src='../../view/tecnologia/img/status/vermelho/x.png' width='13px' height='auto' title='" . $ProgramacaoStatusNome . "' alt='" . $ProgramacaoStatusNome . "'>";
        }
        if ($ProgramacaoStatus == '4') {
            $this->statusImagem = "<img src='../../view/tecnologia/img/status/verde/ok.png' width='13px' height='auto' title='" . $ProgramacaoStatusNome . "' alt='" . $ProgramacaoStatusNome . "'>";
        }
        if ($ProgramacaoStatus == '5') {
            $this->statusImagem = "<img src='../../view/tecnologia/img/status/azul/mais.png' width='13px' height='auto' title='" . $ProgramacaoStatusNome . "' alt='" . $ProgramacaoStatusNome . "'>";
        }
        if ($ProgramacaoStatus == '6') {
            $this->statusImagem = "<img src='../../view/tecnologia/img/status/azul/menos.png' width='13px' height='auto' title='" . $ProgramacaoStatusNome . "' alt='" . $ProgramacaoStatusNome . "'>";
        }
        if ($ProgramacaoStatus == '7') {
            $this->statusImagem = "<img src='../../view/tecnologia/img/status/azul/vazio.png' width='13px' height='auto' title='" . $ProgramacaoStatusNome . "' alt='" . $ProgramacaoStatusNome . "'>";
        }
        if ($ProgramacaoStatus == '8') {
            $this->statusImagem = "<img src='../../view/tecnologia/img/status/amarelo/vazio.png' width='13px' height='auto' title='" . $ProgramacaoStatusNome . "' alt='" . $ProgramacaoStatusNome . "'>";
        }
        if ($ProgramacaoStatus == '9') {
            $this->statusImagem = "<img src='../../view/tecnologia/img/status/azul/sustenido.png' width='13px' height='auto' title='" . $ProgramacaoStatusNome . "' alt='" . $ProgramacaoStatusNome . "'>";
        }
        if ($ProgramacaoStatus == '10') {
            $this->statusImagem = "<img src='../../view/tecnologia/img/status/verde/vazio.png' width='13px' height='auto' title='" . $ProgramacaoStatusNome . "' alt='" . $ProgramacaoStatusNome . "'>";
        }
        if ($ProgramacaoStatus == '11') {
            $this->statusImagem = "<img src='../../view/tecnologia/img/status/azul/seta_esquerda.png' width='13px' height='auto' title='" . $ProgramacaoStatusNome . "' alt='" . $ProgramacaoStatusNome . "'>";
        }
        if ($ProgramacaoStatus == '12') {
            $this->statusImagem = "<img src='../../view/tecnologia/img/status/azul/seta_direita.png' width='13px' height='auto' title='" . $ProgramacaoStatusNome . "' alt='" . $ProgramacaoStatusNome . "'>";
        }
        if ($ProgramacaoStatus == '13') {
            $this->statusImagem = "<img src='../../view/tecnologia/img/status/vermelho/vazio.png' width='13px' height='auto' title='" . $ProgramacaoStatusNome . "' alt='" . $ProgramacaoStatusNome . "'>";
        }
        if ($ProgramacaoStatus == '14') {
            $this->statusImagem = "<img src='../../view/tecnologia/img/status/cinza/vazio.png' width='13px' height='auto' title='" . $ProgramacaoStatusNome . "' alt='" . $ProgramacaoStatusNome . "'>";
        }
        if ($ProgramacaoStatus == '15') {
            $this->statusImagem = "<img src='../../view/tecnologia/img/status/azul/interrogacao.png' width='13px' height='auto' title='" . $ProgramacaoStatusNome . "' alt='" . $ProgramacaoStatusNome . "'>";
        }
        
    }

    protected function getQueryFiltroFilial() {
        return "SELECT A.HANDLE, 
                       A.NOME C1, 
                       A.SIGLA C2
                  FROM MS_FILIAL A (NOLOCK)
                 WHERE A.STATUS = 4 
                 ORDER BY C1";
    }
    
    protected function getQueryFiltroCliente() {
        return "SELECT A.HANDLE, 
                       A.APELIDO C1, 
                       A.CNPJCPF C2
                  FROM MS_PESSOA A (NOLOCK)  
                 WHERE A.STATUS = 4
                   AND A.EHCLIENTE = 'S'
                   ORDER BY C1 ";
  }

    protected function getQueryFiltroSituacao() {
        return "SELECT A.HANDLE, 
                       A.NOME C1
                  FROM PA_STATUSCONTEINER A (NOLOCK)  
                 ORDER BY C1";
    }

    protected function getQueryFiltroTipoOperacao() {
        return "SELECT A.HANDLE, 
                       A.NOME C1
                  FROM PA_TIPOOPERACAO A (NOLOCK)  
                ORDER BY C1";
    }

    protected function getQueryFiltroConteiner() {
        return "SELECT TOP 1 A.HANDLE, 
                       A.CODIGO C1
                  FROM PA_CONTEINER A (NOLOCK)  
                 WHERE A.STATUS <> 3";
    }

    protected function getQueryFiltroTipoConteiner() {
        return "SELECT A.HANDLE, 
                       A.NOME C1,
                       A.SIGLA C2
                  FROM PA_TIPOEQUIPAMENTO A (NOLOCK)  
                 WHERE A.STATUS = 4
                 ORDER BY C1";
    }

    protected function getQueryFiltroLocalizacao() {
        return "SELECT A.HANDLE, 
                       A.POSICAO C1
                  FROM PA_TERMINALLOCALIZACAO A (NOLOCK)  
                 WHERE A.STATUS = 3
                 ORDER BY C1";
    }

    protected function getQueryFiltroClassificacaoISO() {
        return "SELECT A.HANDLE, 
                       A.NOME C1, 
                       A.SIGLA C2
                  FROM PA_TIPOORDEM A (NOLOCK)  
                 WHERE A.STATUS = 4 
                 ORDER BY C1";
    }

    protected function getQueryFiltroFinalidade() {
        return "SELECT A.HANDLE, 
                       A.NOME C1
                  FROM PA_FINALIDADEMOVIMENTACAO A (NOLOCK)  
                 WHERE A.STATUS = 4
                 ORDER BY C1";
    }
    
}
