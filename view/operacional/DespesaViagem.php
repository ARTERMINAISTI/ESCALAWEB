<?php
include_once('../../controller/tecnologia/Sistema.php');
		if(!isset($_SESSION['usuario']) and !isset($_SESSION['senha'])){
			header('Location: ../../view/estrutura/login.php?success=F');
		}// not isset sessions of login
		else{
		$connect = Sistema::getConexao();
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Escalasoft</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" type="image/png" href="../tecnologia/img/favicon.png" />
<!-- Bootstrap Core CSS -->
<link href="../tecnologia/css/bootstrap.php" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="../tecnologia/css/style.php" rel='stylesheet' type='text/css' />
<!-- font CSS -->
<!-- font-awesome icons -->
<link href="../tecnologia/css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<!-- material icons -->
<link href="../../view/tecnologia/css/material-icons.css" rel="stylesheet"> 
<!-- //material icons -->
 <!-- js-->
<script src="../tecnologia/js/jquery-1.11.1.min.js"></script>
<script src="../tecnologia/js/modernizr.custom.js"></script>
<!--animate-->
<link href="../tecnologia/css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="../tecnologia/js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!-- chart -->
<script src="../tecnologia/js/Chart.js"></script>
<!-- //chart -->
<!--Calendario-->
<link rel="stylesheet" href="../tecnologia/css/clndr.css" type="text/css" />
<script src="../tecnologia/js/underscore-min.js" type="text/javascript"></script>
<script src= "../tecnologia/js/moment-2.2.1.js" type="text/javascript"></script>
<script src="../tecnologia/js/clndr.js" type="text/javascript"></script>
<script src="../tecnologia/js/site.js" type="text/javascript"></script>
<!--End Calendario-->
<!-- Menu Lateral -->
<script src="../tecnologia/js/metisMenu.min.js"></script>
<script src="../tecnologia/js/custom.js"></script>
<link href="../tecnologia/css/custom.php" rel="stylesheet">
<!--//Menu Lateral-->
<!-- Custom -->
<script type="text/javascript" src="../tecnologia/js/jquery-ui.js"></script>
<script type="text/javascript" src="../tecnologia/js/scriptDespesaViagem.js"></script>
<script type="text/javascript" src="../tecnologia/js/bootbox.js"></script>
<link type="text/css" href="../tecnologia/css/jquery-ui.css" rel="stylesheet"/>
<link type="text/css" href="../tecnologia/css/styleCustom.php" rel="stylesheet"/>
<link type="text/css" href="../../view/tecnologia/css/jquery.multiselect.css" rel="stylesheet"/>
<script type="text/javascript" src="../../view/tecnologia/js/jquery.multiselect.js"></script>
<script type="text/javascript" src="../../view/tecnologia/js/blockUI.js"></script>
<script type="text/javascript" src="../../view/tecnologia/js/scriptFiltro.js"></script>
<!--// End Custom -->
<!-- shortTable -->
<link href="../../view/tecnologia/css/theme.bootstrap_3.min.css" rel="stylesheet">
<script src="../../view/tecnologia/js/jquery.tablesorter.js"></script>
<script src="../../view/tecnologia/js/jquery.tablesorter.widgets.js"></script>
<script>
	$(function(){
		$('table').tablesorter({
			widgets        : ['zebra', 'columns'],
			usNumberFormat : false,
			sortReset      : true,
			sortRestart    : true,
			dateFormat: 'pt'
		});
	});
	</script>
<!--// End shortTable -->
<style>
body{
	overflow: hidden;	
}
@media screen and (max-width: 768px) {
body{
	overflow: auto;	
}
}
</style>
</head> 
<body class="cbp-spmenu-push" id="bodyFullScreen">
<div id="loader"></div>
	<div class="main-content">
		<!--left-fixed -navigation-->
		<div class=" sidebar" role="navigation">
            <div class="navbar-collapse">
				<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
					<?php
						include('../../view/estrutura/menu.php');
					?>
				</nav>
			</div>
		</div>
        
		<!--left-fixed -navigation-->
		<!-- header-starts -->
			<div class="sticky-header header-section ">
            
				<!--toggle button start-->
				<button id="showLeftPush"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
                
			<div class="topBar">Despesa de viagem</div>
            
            <div class="topBarRight">
            	<button type="button" class="btn botaoTop dropdown-toggle desktopHide" role="button" aria-expanded="false" data-toggle="dropdown"><i class="material-icons">&#xE5D4;</i></button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                    <li><button name="inserirDespesaMobile" class="btn botaoMobile" type="button" id="inserirDespesaMobile">Inserir</button></li>
                    <li><button name="visualizarDespesaMobile" class="btn botaoMobile display" type="button" onClick="VisualizarDespesaViagem()" id="visualizarDespesaMobile">Visualizar</button></li>
                    <li><button type="button" class="btn botaoMobile display" id="cancelarDespesaMobile" data-toggle="modal"  data-target="#CancelarDespesaModal"  name="cancelarDespesaMobile">Cancelar</button></li>
                    <li><button type="button" class="btn botaoMobile display" id="excluirDespesaMobile"  name="excluirDespesaMobile" data-toggle="modal"  data-target="#ExcluirDespesaModal">Excluir</button></li>
                    <li><button type="button" class="btn botaoMobile display" id="liberarDespesaMobile" data-toggle="modal"  data-target="#LiberarDespesaModal" name="liberarDespesaMobile">Liberar</button></li>
                    <li><button type="button" class="btn botaoMobile display" id="voltarDespesaMobile" data-toggle="modal"  data-target="#VoltarDespesaModal" name="voltarDespesaMobile">Voltar</button></li>
                </ul>
				<button data-toggle="modal" class="botaoTop"  onClick="multiselection();" data-target="#FiltroModal"><i class="glyphicon glyphicon-search"></i></button>
            </div>
            
        </div>
            
			<div class="clearfix"> </div>	
		</div>
		<!-- //header-ends -->

		<!-- main content start-->   
        <div class="pageContent"> 
<?php
	include_once('../../model/operacional/retornoLiberarDespesaViagem.php');
	include('../../model/operacional/ModalDespesaViagem.php');
?>
            <form method="post" action="../../controller/operacional/viagemController.php">
            <div class="table-responsive mobileHide">
            <div class="larguraInteira">
                <table class="table table-striped table-bordered " id="reqtablenew" border="0">
                	<thead>
                    	<tr class="Noactivetr">
                    	<th hidden="true">#</th>
                    	<th>&nbsp;</th>      
                        <th>Despesa</th>
                        <th>Viagem</th>
                        <th>Placa</th>
                        <th>Rota</th>
                        <th>Origem</th>
                        <th>Destino</th>
                        <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        	include_once('../../model/operacional/DespesaViagemTabelaModel.php');
                        ?>
                    </tbody>
                </table>
             </div>
             </div>
             
             <div class="desktopHide">
                <table class="table table-striped table-bordered bottomPull" id="reqtablenewMobile" border="0">
                    <tbody>
                        <?php
                        	include_once('../../model/operacional/DespesaViagemTabelaModelMobile.php');
                        ?>
                    </tbody>
                </table>
             </div>     
             
                <div class="footerFixed mobileHide">
                	<div class="col-xs-1">
                            <button type="button" class="span">&nbsp;</button>
                     </div>
                    <div class="col-xs-11">
                        <div class="right">
                        
  
                        <a href="InserirDespesaViagem.php?referencia=DespesaViagem">
                            <button type="button" class="botao" id="inserirDespesa" name="inserirDespesa">Inserir</button>
                        </a>
                        	<button type="button" class="botao display" id="visualizarDespesa" name="visualizarDespesa" onClick="VisualizarDespesaViagem()">Visualizar</button>
                            <button type="button" class="botao display" id="cancelarDespesa" data-toggle="modal"  data-target="#CancelarDespesaModal"  name="cancelarDespesa">Cancelar</button>
                            <button type="button" class="botao display" id="excluirDespesa"  name="excluirDespesa" data-toggle="modal"  data-target="#ExcluirDespesaModal">Excluir</button>
                            <button type="button" class="botao display" id="liberarDespesa" data-toggle="modal"  data-target="#LiberarDespesaModal" name="liberarDespesa">Liberar</button>
                            <button type="button" class="botao display" id="voltarDespesa" data-toggle="modal"  data-target="#VoltarDespesaModal" name="voltarDespesa">Voltar</button>
                        </div>
                    </div>
                </div><!-- end footer -->
            </form>
        </div><!-- end pageContent -->
            
				<div class="clearfix"> </div>
		</div>
		<!--footer
		<div class="footer">
		   <p>&copy; 2016 Escalasoft Tecnologia Todos os direitos reservados| Simples, r??pido e completo.</p>
		</div>
        <!--//footer-->
	</div>
	<!-- Classie -->
		<script src="../tecnologia/js/classie.js"></script>
	<!--scrolling js-->
	<script src="../tecnologia/js/jquery.nicescroll.js"></script>
	<script src="../tecnologia/js/script.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
   <script src="../tecnologia/js/bootstrap.js"> </script>
</body>
</html>

<?php
		}
?>