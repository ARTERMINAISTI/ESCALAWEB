<?php
	
	$sqlTipoMovimentacao = "SELECT A.HANDLE HANDLE,
							       A.NOME NOME,
							       A.FINALIDADE HANDLEFINALIDADE,
								   A.TIPOOPERACAO TIPOOPERACAO
					    
					    	  FROM PA_TIPOMOVIMENTACAOMANUAL A 
							 WHERE A.STATUS = 3
							 ORDER BY A.NOME";

	$query = $connect->prepare($sqlTipoMovimentacao);
	$query->execute();

	$tiposMovimentacao = [];

		while($rowQuery = $query->fetch(PDO::FETCH_ASSOC)){
			$tiposMovimentacao[] = $rowQuery;
		}

	$sqlFilial = "SELECT A.HANDLE HANDLE,
			          	 A.NOME NOME
	
					FROM MS_FILIAL A 
				   WHERE A.STATUS = 4
				   ORDER BY A.NOME";

	$query = $connect->prepare($sqlFilial);
	$query->execute();

	$listaFiliais = [];

		while($rowQuery = $query->fetch(PDO::FETCH_ASSOC)){
			$listaFiliais[] = $rowQuery;
		}

	$sqlTiposFinalidade = "SELECT A.HANDLE HANDLE,
								  A.NOME NOME

							 FROM PA_FINALIDADEMOVIMENTACAO A
							WHERE A.STATUS = 4
							ORDER BY A.NOME";

	$query = $connect->prepare($sqlTiposFinalidade);
	$query->execute();

	$tiposFinalidade = [];

		while($rowQuery = $query->fetch(PDO::FETCH_ASSOC)){
			$tiposFinalidade[] = $rowQuery;
		}

?>