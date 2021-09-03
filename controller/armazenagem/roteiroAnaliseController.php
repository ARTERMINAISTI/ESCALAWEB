<?php
include_once('../../model/armazenagem/roteiroAnaliseModel.php');

/**
 * Description of roteiroAnalise
 *
 * @author luiz.imhof
 */
class roteiroAnaliseController extends roteiroAnaliseModel
{

    private $conexao;

    function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    private function loadByQuery($query)
    {
        $this->setHandle($query['HANDLE']);
        $this->setOrigem($query['ORIGEM']);
        $this->setCliente($query['CLIENTE']);
        $this->setFilial($query['FILIAL']);
        $this->setTipo($query['TIPO']);
        $this->setVeiculo($query['VEICULO']);
        $this->setMotorista($query['MOTORISTA']);
        $this->setConteiner($query['CONTEINER']);
        $this->setData(date('d/m/Y', strtotime($query['DATA'])));
        $this->setNumero($query['NUMERO']);
        
    }

    private function getTableRow()
    {
        return "<tr>
                    <td hidden='true'><input type='radio' name='check[]' class='check' hidden='true' id='check'  value='{$this->getHandle()}'>
                    <td>{$this->getFilial()}</td>   
                    <td>{$this->getCliente()}</td>  
                    <td>{$this->getTipo()}</td>   
                    <td>{$this->getOrigem()}</td>   
                    <td>{$this->getVeiculo()}</td>   
                    <td>{$this->getMotorista()}</td>   
                    <td>{$this->getConteiner()}</td>   
                    <td>{$this->getdata()}</td>   
                    <td>{$this->getNumero()}</td>  
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
    
}