<?php
include_once('../../model/patio/ConfirmarLocalizacaoConteinerModel.php');

class ConfirmarLocalizacaoConteinerController extends ConfirmarLocalizacaoConteinerModel
{

    private $conexao;

    function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    private function loadByQuery($query)
    {
        $this->setHandle($query['HANDLE']);
        $this->setNumero($query['NUMERO']);
        $this->setFilial($query['FILIAL']); 
        $this->setCliente($query['CLIENTE']);
        $this->setConteiner($query['CONTEINER']);
        $this->setLocalizacao($query['LOCALIZACAO']);
        $this->setHandleLocalizacao($query['HANDLELOCALIZACAO']);
        if (!is_null($query['DATA'])){
            $this->setData(date('d/m/Y H:i', strtotime($query['DATA'])));
        } else {
            $this->setData($query['DATA']);
        }
    }

    private function getTableRow()
    {
        return "<tr>
                    <td hidden='true'><input type='radio' name='check[]' class='check' hidden='true' id='check'  value='{$this->getHandle()}'>                    
                    <td>{$this->getNumero()}</td>
                    <td>{$this->getFilial()}</td>
                    <td>{$this->getData()}</td>
                    <td>{$this->getCliente()}</td>  
                    <td>{$this->getConteiner()}</td>   
                    <td>{$this->getLocalizacao()}</td>       
                    <td hidden>{$this->getHandle()}</td>     
					<td hidden>{$this->getHandleLocalizacao()}</td> 					
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
        $this->montaFiltroConteiner();
        $this->montaFiltroLocalizacao();
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

    private function montaFiltroConteiner()
    {
        $this->filtro['CONTEINER'] = Array();
        $query = $this->conexao->prepare($this->getQueryFiltroConteiner());
        $query->execute();
        if ($query) {
            $this->filtro['CONTEINER'] = $query->fetchAll();;
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

}