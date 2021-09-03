<?php
/**
 * Description of efetuarChecklist
 * este tem comentario teste
 * @author luiz.imhof
 */
class efetuarChecklistModel {
    
    protected $handle;
	protected $checkList;
	protected $nomeValor;
	protected $handleValor;


    
    public function __construct() {
        
    }
    
    public function getQuery($filtro = '') {
		
		$checkList = Sistema::getGet('checkList');
		return "SELECT DISTINCT B.HANDLE HANDLECHECKLIST,
							    B.FILIAL, 
		 						C.NOME NOMEITEMANALISE
 
	 					FROM AM_CHECKLISTVALOR A
	 					INNER JOIN AM_CHECKLIST B ON B.HANDLE = A.CHECKLIST
	 					INNER JOIN AM_ITEMANALISE C ON C.HANDLE = B.ITEMANALISE
 
 						WHERE B.HANDLEORIGEM = (SELECT X.HANDLEORIGEM FROM AM_CHECKLIST X WHERE X.HANDLE = $checkList)
	 						AND B.ORIGEM = (SELECT X.ORIGEM FROM AM_CHECKLIST X WHERE X.HANDLE = $checkList)";
        
    }     
	
	public function getQueryValores($checklist){
		return "SELECT A.HANDLE HANDLECHECKLISTVALOR,
					   D.NOME NOMEVALOR
					FROM AM_CHECKLISTVALOR A
 					INNER JOIN AM_CHECKLIST B ON B.HANDLE = A.CHECKLIST
					INNER JOIN AM_VALORCHECKLIST D ON D.HANDLE = A.VALOR
				WHERE B.HANDLE = $checklist";
	}

    public function getHandle() {
        return $this->handle;
    }

    public function getHandleChecklist() {
        return $this->handleChecklist;
    }

    public function getNomeItemAnalise() {
        return $this->nomeItemAnalise;
    }
	public function getNomeValor() {
        return $this->nomeValor;
    }    

	public function getHandleValor() {
        return $this->handleValor;
    }

    protected function setHandle($handle) {
        $this->handle = $handle;
    }

    protected function setHandleChecklist($handleChecklist) {
        $this->handleChecklist = $handleChecklist;
    }

    protected function setNomeItemAnalise($nomeItemAnalise) {
        $this->nomeItemAnalise = $nomeItemAnalise;
    }

	protected function setNomeValor($nomeValor) {
        $this->nomeValor = $nomeValor;
    }
    
	protected function setHandleValor($handleValor) {
        $this->handleValor = $handleValor;
    }
}
