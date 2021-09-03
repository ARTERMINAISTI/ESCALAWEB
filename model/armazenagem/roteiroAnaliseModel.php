<?php
/**
 * Description of roteiroAnalise
 *
 * @author luiz.imhof
 */
class roteiroAnaliseModel {
    
    protected $handle;
    protected $origem;
    protected $cliente;
    protected $filial;
    protected $tipo;
    protected $data;
    protected $numero;

    
    public function __construct() {
        
    }
    
    public function getQuery($filtro = '') {
        return "SELECT DISTINCT MIN(A.HANDLE) HANDLE,
                            COALESCE(D.NUMERO, E.NUMERO, F.NUMERO) NUMERO,
                            CASE WHEN D.CLIENTE IS NOT NULL THEN D1.NOME
                                 WHEN E.CLIENTE IS NOT NULL THEN E1.NOME
                                 WHEN F.CLIENTE IS NOT NULL THEN F1.NOME
                            END CLIENTE,
                            G.SIGLA FILIAL,
                            MIN(A.LOGDATAALTERACAO) DATA,           
                            K.NOME TIPO,
                            I.NOME ORIGEM,
                            COALESCE(D.NUMERO, E.NUMERO, F.NUMERO) NUMERO,
                            COALESCE(D.PLACA, E.PLACA, F.PLACA) VEICULO,
                            COALESCE(D.MOTORISTA, E.MOTORISTA, F.MOTORISTA) MOTORISTA,
                            J.CODIGO CONTEINER					  
                  FROM AM_CHECKLIST A
                 INNER JOIN AM_CHECKLISTVALOR B ON B.CHECKLIST = A.HANDLE
                  LEFT JOIN AM_CARREGAMENTO D ON D.HANDLE = A.HANDLEORIGEM AND A.ORIGEM = 2880
                  LEFT JOIN MS_PESSOA D1 ON D1.HANDLE = D.CLIENTE
                  LEFT JOIN AM_ORDEM E ON E.HANDLE = A.HANDLEORIGEM AND A.ORIGEM = 1963
                  LEFT JOIN MS_PESSOA E1 ON E1.HANDLE = E.CLIENTE
                  LEFT JOIN PA_ORDEM F ON F.HANDLE = A.HANDLEORIGEM AND A.ORIGEM = 2523
                  LEFT JOIN MS_PESSOA F1 ON F1.HANDLE = F.CLIENTE
                 INNER JOIN MS_FILIAL G ON G.HANDLE = A.FILIAL
                 INNER JOIN AM_ABRANGENCIACHECKLIST I ON I.HANDLE = A.ABRANGENCIA
                  LEFT JOIN PA_CONTEINER J ON J.HANDLE = COALESCE(D.CONTEINER, E.CONTEINER, F.CONTEINER)
                  LEFT JOIN AM_ROTEIRO K ON K.HANDLE = A.ROTEIRO

                 WHERE NOT EXISTS (SELECT HANDLE FROM AM_CHECKLISTVALOR C WHERE C.CHECKLIST = A.HANDLE AND C.EHMARCADO = 'S') 
                 AND (D.STATUS NOT IN (4, 5) OR E.STATUS NOT IN (5, 6) OR F.STATUS NOT IN (4, 5))
                 
                 GROUP BY COALESCE(D.NUMERO, E.NUMERO, F.NUMERO), 
                          CASE WHEN D.CLIENTE IS NOT NULL THEN D1.NOME
                               WHEN E.CLIENTE IS NOT NULL THEN E1.NOME
                               WHEN F.CLIENTE IS NOT NULL THEN F1.NOME
                          END, 
                          COALESCE(D.PLACA, E.PLACA, F.PLACA), 
                          COALESCE(D.MOTORISTA, E.MOTORISTA, F.MOTORISTA), J.CODIGO,
                          G.SIGLA,  
                          I.NOME, 
                          K.NOME
                 ORDER BY COALESCE(D.NUMERO, E.NUMERO, F.NUMERO) DESC";
    }      

    public function getHandle() {
        return $this->handle;
    }

    public function getOrigem() {
        return $this->origem;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function getFilial() {
        return $this->filial;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getdata() {
        return $this->data;
    }

    public function getNumero() {
        return $this->numero;
    }
    
    public function getVeiculo() {
        return $this->veiculo;
    }

    public function getMotorista() {
        return $this->motorista;
    }

    public function getConteiner() {
        return $this->conteiner;
    }

    protected function setHandle($handle) {
        $this->handle = $handle;
    }

    protected function setOrigem($origem) {
        $this->origem = $origem;
    }

    protected function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    protected function setFilial($filial) {
        $this->filial = $filial;
    }

    protected function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    protected function setData($data) {
        $this->data = $data;
    }

    protected function setNumero($numero) {
        $this->numero = $numero;
    }

    protected function setVeiculo($veiculo) {
        $this->veiculo = $veiculo;
    }

    protected function setMotorista($motorista) {
        $this->motorista = $motorista;
    }

    protected function setConteiner($conteiner) {
        $this->conteiner = $conteiner;
    }
   
}