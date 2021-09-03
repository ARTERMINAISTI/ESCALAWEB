<?php
include_once('../../model/armazenagem/efetuarChecklistModel.php');

/**
 * Description of efetuarChecklist
 *
 * @author luiz.imhof
 */
class efetuarChecklistController extends efetuarChecklistModel
{

    private $conexao;

    function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    private function loadByQuery($query)
    {
        $this->setHandle($query['HANDLECHECKLIST']);
        $this->setNomeItemAnalise($query['NOMEITEMANALISE']);
        
           
    }
    private function loadByQueryValores($queryValores)
    {

        $this->setNomeValor($queryValores['NOMEVALOR']);
           
    }

    private function getTableRow()
    {

        $queryValores = $this->conexao->prepare("SELECT A.HANDLE HANDLECHECKLISTVALOR,
                                                        A.EHMARCADO EHMARCADO,
                                                        A.OBSERVACAO OBSERVACAO,
					                                    D.NOME NOMEVALOR
					                               FROM AM_CHECKLISTVALOR A
 					                              INNER JOIN AM_CHECKLIST B ON B.HANDLE = A.CHECKLIST
					                              INNER JOIN AM_VALORCHECKLIST D ON D.HANDLE = A.VALOR
				                                  WHERE B.HANDLE = '" . $this->getHandle() . "' 
                                                  ORDER BY D.NOME");
            
        $queryValores->execute();
        
        $valores = array();
        while ($row = $queryValores->fetch(PDO::FETCH_ASSOC)) {
            $this->setNomeValor($row['NOMEVALOR']);
            $this->setHandleChecklist($row['HANDLECHECKLISTVALOR']);;

            if ($row['EHMARCADO'] == 'S') {
                $checked = 'checked';   
            } else {
                $checked = '';
            }

            if ($row['OBSERVACAO'] != '' && $row['EHMARCADO'] == 'S') {
                $observacao = 'value= ' . $row['OBSERVACAO'];   
            } else {
                $observacao = '';
            }

            $valores[] = "<input type='radio' data-handle='{$this->getHandleChecklist()}' name='{$this->getNomeItemAnalise()}' class='check' {$checked} id='{$this->getNomeValor()}' value='{$this->getNomeValor()}' > {$this->getNomeValor()}";
            
            $observacoes[] = $observacao; 
            
        }
        $valoresString = implode(' ', $valores);
        $observacoesString = implode(' ', $observacoes);

        return "
                    <tr>
                        <td hidden='true'><input type='radio' name='check[]' class='check' hidden='true' id='check'  value='{$this->getHandle()}'>
                        <td>{$this->getNomeItemAnalise()}</td>
                        <td>{$valoresString}</td>
                        <td><input type='text' class='form-control' placeholder='Observação' name='observacao' {$observacoesString}></textarea></td>
                        <td><button type='button' class='btn' id='anexoChecklist' data-toggle='modal' data-target='#AnexoChecklistModal' name='anexoChecklist'><i class='bi bi-paperclip'></i></button></textarea></td>
                    </tr>
                    
               ";
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
    public function getRegistroValores($checklist)
    {
        $result = Array('ERRO' => false,
            'DADOS' => null);
        try {

            $queryValores = $this->conexao->prepare($this->getQueryValores($checklist));
            $queryValores->execute();

            $result['DADOS'] = $this->processaRegistroValores($queryValores);
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

    private function processaRegistroValores($queryValores)
    {
        $result = Array();
        while ($row = $queryValores->fetch(PDO::FETCH_ASSOC)) {
            $this->loadByQueryValores($row);

            $result[] = $this->getTableRow();
        }
        return $result;
    }
    
}