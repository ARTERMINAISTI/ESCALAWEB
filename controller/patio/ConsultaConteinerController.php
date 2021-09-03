<?php
include_once('../../model/patio/ConsultaConteinerModel.php');

class ConsultaConteinerController extends ConsultaConteinerModel
{

    private $conexao;

    function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    private function loadByQuery($query)
    {
        $this->setHandle($query['HANDLE']);
        $this->setStatus($query['STATUS']);
        $this->setStatusNome($query['STATUSNOME']);
        $this->setstatusImagem($query['STATUS'],$query['STATUSNOME']);    
        $this->setConteiner($query['CONTEINER']);
        $this->setFilial($query['FILIAL']);
        $this->setTipoConteiner($query['TIPOCONTEINER']);
        $this->setClassificacaoISO($query['CLASSIFICACAOISO']);   
        $this->setCliente($query['CLIENTE']);
        $this->setLocalizacao($query['LOCALIZACAO']);
        if (!is_null($query['ENTRADA'])){
            $this->setEntrada(date('d/m/Y', strtotime($query['ENTRADA'])));
        } else {
            $this->setEntrada($query['ENTRADA']);
        }
        if (!is_null($query['SAIDA'])){
            $this->setSaida(date('d/m/Y', strtotime($query['SAIDA'])));
        } else {
            $this->setSaida($query['SAIDA']);    
        }
        $this->setDias($query['DIAS']);
        $this->setTipoOperacao($query['TIPOOPERACAO']);
        $this->setFinalidade($query['FINALIDADE']);
        if (!is_null($query['DEMURRAGE'])){
            $this->setDemurrage(date('d/m/Y', strtotime($query['DEMURRAGE'])));
        } else {
            $this->setDemurrage($query['DEMURRAGE']);    
        };
    }

    private function getTableRow()
    {
        return "<tr>
                    <td hidden='true'>{$this->getHandle()}</td>
                    <td width='1%'>{$this->getStatusImagem()}</td> 
                    <td>{$this->getConteiner()}</td>
                    <td>{$this->getFilial()}</td>
                    <td>{$this->getTipoConteiner()}</td>
                    <td>{$this->getClassificacaoISO()}</td>    
                    <td>{$this->getCliente()}</td>  
                    <td>{$this->getLocalizacao()}</td>                    
                    <td>{$this->getEntrada()}</td>    
                    <td>{$this->getSaida()}</td>    
                    <td>{$this->getDias()}</td>    
                    <td>{$this->getTipoOperacao()}</td>    
                    <td>{$this->getFinalidade()}</td>    
                    <td>{$this->getDemurrage()}</td>    
                </tr>";
    }

    public function getRegistro($filtro = '')
    {
        $result = Array('ERRO' => false,
            'DADOS' => null);
        try {
            $query = $this->conexao->prepare($this->getQuery($filtro));
            $query->execute();

            $result['DADOS'] = $this->processaRegistro($query);
        } catch (Exception $e) {
            $result['ERRO'] = true;
            $result['DADOS'] = Array("<div class=\"alert alert-warning\">{$e->getMessage()}</div>");
        }

        return $result;
    }

    private function processaRegistro($query)
    {
        $result = Array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $this->loadByQuery($row);

            $result[] = $this->getTableRow();
        }
        return $result;
    }

    public function montaFiltro()
    {
		$this->montaFiltroFilial();
        $this->montaFiltroCliente();
        $this->montaFiltroSituacao();
        $this->montaFiltroTipoOperacao();
        $this->montaFiltroConteiner();
        $this->montaFiltroTipoConteiner();
        $this->montaFiltroLocalizacao();
        $this->montaFiltroClassificacaoISO();
        $this->montaFiltroFinalidade();
    }

	private function montaFiltroFilial()
    {
        $this->filtro['FILIAL'] = Array();
        $query = $this->conexao->prepare($this->getQueryFiltroFilial());
        $query->execute();
        if ($query) {
            $this->filtro['FILIAL'] = $query->fetchAll();
        }
    }

    private function montaFiltroCliente()
    {
        $this->filtro['CLIENTE'] = Array();
        $query = $this->conexao->prepare($this->getQueryFiltroCliente());
        $query->execute();
        if ($query) {
            $this->filtro['CLIENTE'] = $query->fetchAll();;
        }
    }

    private function montaFiltroSituacao()
    {
        $this->filtro['SITUACAO'] = Array();
        $query = $this->conexao->prepare($this->getQueryFiltroSituacao());
        $query->execute();
        if ($query) {
            $this->filtro['SITUACAO'] = $query->fetchAll();;
        }
    }

    private function montaFiltroTipoOperacao()
    {
        $this->filtro['TIPOOPERACAO'] = Array();
        $query = $this->conexao->prepare($this->getQueryFiltroTipoOperacao());
        $query->execute();
        if ($query) {
            $this->filtro['TIPOOPERACAO'] = $query->fetchAll();;
        }
    }

    private function montaFiltroConteiner()
    {
        $this->filtro['CONTEINER'] = Array();
        $query = $this->conexao->prepare($this->getQueryFiltroConteiner());
        $query->execute();
        if ($query) {
            $this->filtro['CONTEINER'] = $query->fetchAll();;
        }
    }

    private function montaFiltroTipoConteiner()
    {
        $this->filtro['TIPOCONTEINER'] = Array();
        $query = $this->conexao->prepare($this->getQueryFiltroTipoConteiner());
        $query->execute();
        if ($query) {
            $this->filtro['TIPOCONTEINER'] = $query->fetchAll();;
        }
    }

    private function montaFiltroLocalizacao()
    {
        $this->filtro['LOCALIZACAO'] = Array();
        $query = $this->conexao->prepare($this->getQueryFiltroLocalizacao());
        $query->execute();
        if ($query) {
            $this->filtro['LOCALIZACAO'] = $query->fetchAll();;
        }
    }

    private function montaFiltroClassificacaoISO()
    {
        $this->filtro['CLASSIFICACAOISO'] = Array();
        $query = $this->conexao->prepare($this->getQueryFiltroClassificacaoISO());
        $query->execute();
        if ($query) {
            $this->filtro['CLASSIFICACAOISO'] = $query->fetchAll();;
        }
    }

    private function montaFiltroFinalidade()
    {
        $this->filtro['FINALIDADE'] = Array();
        $query = $this->conexao->prepare($this->getQueryFiltroFinalidade());
        $query->execute();
        if ($query) {
            $this->filtro['FINALIDADE'] = $query->fetchAll();;
        }
    }

}