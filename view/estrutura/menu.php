
<div class="topoMenu">
	<div class="row">
		<div class="col-xs-12">                
			<h4 class="titleMenu"> Painel de navegação</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-3">
			<?php
				if (isset($_SESSION['usuarioImagem'])) {
					echo '<div class="imgMenu"><img src="data:image/png;base64,' . $_SESSION['usuarioImagem'] . '" class="img-responsive" style="border-radius:25px"></div>';
				}
				else {
					echo '<div class="imgMenu"><img src="../tecnologia/img/usermenu.png" class="img-responsive" style="border-radius: 25px"></div>';
				}
			?> 
		</div>
		<div class="col-xs-9">
			<p class="infoMenu"><?php echo $loginUsuario.'<br>'.$papelNome; ?></p>
		</div>
	</div>
</div> 
<div>
	<ul class="nav" id="side-menu">
		<li>
			<?php
				if (isset($_SESSION['paginaPrincial'])) {
					echo '<a href="' . $_SESSION['paginaPrincial'] . '">Principal</a>';
				}
				else {
					echo '<a href="../../view/estrutura/index.php">Principal</a>';
				}
			?>
		</li>
		<?php
			$queryMenu = $connect->prepare("SELECT NOME NOME, HANDLE HANDLE 
												FROM (
												
												SELECT DISTINCT B.NOME , B.HANDLE
													FROM MD_ICONE A
													INNER JOIN MD_PAINELNAVEGACAO B ON B.HANDLE = A.PAINELNAVEGACAO
													WHERE A.MODULO = 37
													AND (A.CLIENTE IS NULL OR A.CLIENTE = 0 OR A.CLIENTE = " . $_SESSION['sistemaCliente'] . ")
													AND EXISTS (SELECT 1
																	FROM MS_USUARIO X
																	INNER JOIN MS_USUARIOPAPEL X1 ON X1.USUARIO = X.HANDLE AND X1.STATUS = 4
																	INNER JOIN MS_PAPELICONEPAINELNAVEGACAO X2 ON X2.PAPEL = X1.PAPEL				 
																	WHERE X2.DEFINICAOACESSO = 2 
																	AND X.HANDLE = '".$handleUsuario."'
																	AND X2.PAINELNAVEGACAO = A.HANDLE)
													UNION ALL
													SELECT 'Painel de indicador' NOME, -1 HANDLE
													FROM MD_SISTEMA
													WHERE EXISTS (SELECT A.HANDLE
																	
																	FROM BI_PAINEL A
																	
																	WHERE A.STATUS = 4
																	AND EXISTS (SELECT Z0.HANDLE
																					FROM MS_USUARIOPAPEL Z0
																				INNER JOIN MS_PAPELPAINELINDICADOR Z1 ON Z1.PAPEL = Z0.PAPEL
																				INNER JOIN MS_PAPEL Z2 ON Z2.HANDLE = Z0.PAPEL
																				WHERE Z0.USUARIO = '".$handleUsuario."'
																					AND Z0.STATUS = 4
																					AND Z1.PAINELINDICADOR = A.HANDLE
																					AND Z2.STATUS = 4
																				
																				UNION ALL
																				SELECT Z0.HANDLE
																					FROM MS_USUARIOPAINELINDICADOR Z0
																				WHERE Z0.USUARIO = '".$handleUsuario."'
																					AND Z0.PAINELINDICADOR = A.HANDLE))) XXX
														ORDER BY NOME");
																
			$queryMenu->execute();

			while ($rowMenu = $queryMenu->fetch(PDO::FETCH_ASSOC)) {
				$agrupadorMenu = $rowMenu['NOME'];
				$agrupadorMenuHandle = $rowMenu['HANDLE']; 
		?>
		<li>
			<a href="#"><?php echo $agrupadorMenu; ?> <span class="fa arrow"></span></a>
			<ul class="nav nav-second-level collapse">
				<?php
					if ($agrupadorMenuHandle == -1)
					{
						$queryMenu_filho = $connect->prepare("SELECT A.TITULO TITULO, A.HANDLE HANDLE
																FROM BI_PAINEL A
															WHERE A.STATUS = 4
																AND EXISTS (SELECT Z0.HANDLE
																			FROM MS_USUARIOPAPEL Z0
																			INNER JOIN MS_PAPELPAINELINDICADOR Z1 ON Z1.PAPEL = Z0.PAPEL
																			INNER JOIN MS_PAPEL Z2 ON Z2.HANDLE = Z0.PAPEL
																			WHERE Z0.USUARIO = '".$handleUsuario."'
																				AND Z0.STATUS = 4
																				AND Z1.PAINELINDICADOR = A.HANDLE
																				AND Z2.STATUS = 4
																		
																			UNION ALL

																			SELECT Z0.HANDLE
																			FROM MS_USUARIOPAINELINDICADOR Z0
																			WHERE Z0.USUARIO = '".$handleUsuario."'
																				AND Z0.PAINELINDICADOR = A.HANDLE)
															ORDER BY TITULO");
																
						$queryMenu_filho->execute();

						while ($rowMenuFilho = $queryMenu_filho->fetch(PDO::FETCH_ASSOC)) {	
							
							echo '<li><a href="../../view/inteligencianegocio/visualizarpainel.php?'. $rowMenuFilho['HANDLE']. '">'. $rowMenuFilho['TITULO']. '</a></li>';
						}			
					}	
					else {
						$queryMenu_filho = $connect->prepare("SELECT A.TITULO, A.COMANDO
																FROM MD_ICONE A
															INNER JOIN MD_PAINELNAVEGACAO B ON B.HANDLE = A.PAINELNAVEGACAO
															WHERE A.MODULO = 37
																AND B.HANDLE = '".$agrupadorMenuHandle."'
																AND ((A.CLIENTE IS NULL OR A.CLIENTE = 0) OR A.CLIENTE = " . $_SESSION['sistemaCliente'] . ")
																AND EXISTS (SELECT 1
																			FROM MS_USUARIO X
																			INNER JOIN MS_USUARIOPAPEL X1 ON X1.USUARIO = X.HANDLE
																			INNER JOIN MS_PAPELICONEPAINELNAVEGACAO X2 ON X2.PAPEL = X1.PAPEL				 
																			WHERE X2.DEFINICAOACESSO = 2
																				AND X.HANDLE = '".$handleUsuario."'
																				AND X2.PAINELNAVEGACAO = A.HANDLE)
																ORDER BY TITULO");
																					
						$queryMenu_filho->execute();
						
						while ($rowMenuFilho = $queryMenu_filho->fetch(PDO::FETCH_ASSOC)) {
							$filhoMenu = $rowMenuFilho['TITULO'];
							$comandoMenu = $rowMenuFilho['COMANDO'];
							
							echo '<li><a href="'. $comandoMenu. '">'.$filhoMenu.'</a></li>';
						}
					} 
				?>
			</ul>
		</li>	
		<?php
			}	
		?>
		<li><a href="../../controller/estrutura/logout.php" id="sair">Sair</a></li>
	</ul>
</div>
<script>
$("#sair").on('click', function() {
	var userAg = navigator.userAgent;		
	if(userAg.indexOf('Android') > -1) {
		Android.limpaUsuario();
	}
});
</script>
<?php

include_once('../../model/tecnologia/Usuario.php'); 

$usuario = new Usuario(); 
$usuario->atualizarAuditoriaAcesso(); 

?>