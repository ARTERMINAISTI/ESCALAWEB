<?php
	include_once('../../controller/tecnologia/BancoDados.php');	
    include_once('../../controller/tecnologia/Sistema.php');
        
	include_once('../../model/inteligencianegocio/constantes.php');
	include_once('../../model/inteligencianegocio/filtro.php');
   
	date_default_timezone_set('America/Sao_Paulo');	

    class Painel {

        protected $connect;

		function __construct() {
            $this->connect = Sistema::getConexao(false);
        }

		private function getAcesso($handle) {
			$usuario = $_SESSION["handleUsuario"];

			$query = $this->connect->prepare("SELECT COUNT(A.HANDLE) QUANRIDADE
												FROM BI_PAINEL A 
											   
											   INNER JOIN MS_USUARIO B ON B.HANDLE = :USUARIO
											   INNER JOIN MS_STATUS C ON C.HANDLE = ". Constantes::StatusAtivo ."
											   
											   WHERE A.HANDLE = :PAINEL
											     AND A.EHWEB = 'S' 
											  	 AND A.STATUS = C.HANDLE
												 
												 AND B.STATUS = C.HANDLE

												 AND EXISTS (SELECT Z0.HANDLE 
															   FROM MS_USUARIOPAPEL Z0
															  INNER JOIN MS_PAPELPAINELINDICADOR Z1 ON Z1.PAPEL = Z0.PAPEL AND Z1.PAINELINDICADOR = A.HANDLE 
															  INNER JOIN MS_PAPEL Z2 ON Z2.HANDLE = Z0.PAPEL AND Z2.STATUS = C.HANDLE
															  WHERE Z0.USUARIO = B.HANDLE
															    AND Z0.STATUS = C.HANDLE

															  UNION ALL

															 SELECT Z0.HANDLE 
															   FROM MS_USUARIOPAINELINDICADOR Z0
															  WHERE Z0.PAINELINDICADOR = A.HANDLE
															    AND Z0.USUARIO = B.HANDLE)");
			
			$query->bindParam(":PAINEL", $handle, PDO::PARAM_INT);
			$query->bindParam(":USUARIO", $usuario, PDO::PARAM_INT);

			$query->execute();
			
			$row = $query->fetch(PDO::FETCH_OBJ);
				
			if (isset($row)) {
				return $row->QUANRIDADE > 0;
			}

			return false;
		}

		public function getEstrutura($parametro) {
			if (!$this->getAcesso($parametro->handle)) {
				return array(
					"errors" => array(
						"status" => 403,
						"detail" => "O painel não está disponível neste momento para o seu usuário!"
					)
				);
			}
			
			$query = $this->connect->prepare('SELECT ALINHAMENTOCOMPONENTEWEB ALINHAMENTOCOMPONENTEWEB,
													 TITULO TITULO
												FROM BI_PAINEL  
		   									   WHERE HANDLE = :HANDLE');

			$query->bindParam(':HANDLE', $parametro->handle, PDO::PARAM_INT);
			$query->execute();

			$row = $query->fetch(PDO::FETCH_ASSOC);

			$filtro = new Filtro();

			return array(
				"componente" => json_decode($row["ALINHAMENTOCOMPONENTEWEB"]),
				"filtro" => $filtro->getEstrutura($parametro->handle),
				"titulo" => $row["TITULO"]
			);
		}
	}
?>