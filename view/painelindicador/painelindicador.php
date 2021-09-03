<?php
	include_once('../../controller/tecnologia/Sistema.php');

	if (!isset($_SESSION['usuario']) and ! isset($_SESSION['senha'])) 
	{
		header('Location: ../../view/estrutura/login.php?success=F');
	}
	else 
	{
		$connect = Sistema::getConexao(false);
?>

		<!DOCTYPE HTML>
		<html>
			<head>
				<title>Escalasoft</title><meta name="viewport" content="width=device-width, initial-scale=1.0">

				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					
				<link rel="icon" type="image/png" href="../tecnologia/img/favicon.png" />
				
				<!-- Bootstrap Core CSS -->
				<link href="../tecnologia/css/bootstrap.php" rel='stylesheet' type='text/css' />
				<link href="../tecnologia/css/painelindicador.css" rel='stylesheet' type='text/css' />
				<!-- Custom CSS -->
				<link href="../tecnologia/css/style.php" rel='stylesheet' type='text/css' />
				<!-- font CSS -->
				<!-- font-awesome icons -->
				<link href="../tecnologia/css/font-awesome.css" rel="stylesheet">
				<!-- //font-awesome icons -->
				<!-- js-->
				<script src="../tecnologia/js/jquery-1.11.1.min.js"></script>
				<script src="../tecnologia/js/modernizr.custom.js"></script>
				<!-- //js-->
				<!-- Menu Lateral -->
				<script src="../tecnologia/js/metisMenu.min.js"></script>
				<script src="../tecnologia/js/custom.js"></script>
				<link href="../tecnologia/css/custom.php" rel="stylesheet">
				<!--//Menu Lateral-->
				<!-- Custom -->
				<script type="text/javascript" src="../tecnologia/js/jquery-ui.js"></script>
				<script src= "../../view/tecnologia/js/moment-2.2.1.js" type="text/javascript"></script>
				<link type="text/css" href="../tecnologia/css/jquery-ui.css" rel="stylesheet"/>
				<link type="text/css" href="../tecnologia/css/styleCustom.php" rel="stylesheet"/>
				<script type="text/javascript" src="../../view/tecnologia/js/blockUI.js"></script>
				<!--//End Custom -->				
				<!-- AmCharts -->
				<script src="../tecnologia/amcharts/core.js"></script>
				<script src="../tecnologia/amcharts/charts.js"></script>
				<script src="../tecnologia/amcharts/animated.js"></script>				
				<!-- fullcalendar -->				
				<link type="text/css" href='../../view/tecnologia/fullcalendar/core/main.css' rel='stylesheet' />
				<link type="text/css" href='../../view/tecnologia/fullcalendar/daygrid/main.css' rel='stylesheet' />
				<script type="text/javascript" src='../../view/tecnologia/fullcalendar/core/main.js'></script>
				<script type="text/javascript" src='../../view/tecnologia/fullcalendar/daygrid/main.js'></script>
				<script type="text/javascript" src='../../view/tecnologia/fullcalendar/core/locales-all.js'></script>
			</head>
			<body>
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
						<div class="topBar" id="painel_identificacao"></div>            
					</div>            
					<div class="clearfix"> </div>	
				</div>
				
				<!-- main content start-->
                <div class="pageContent">					

					<div class="container-fluid">	
						
						<div id="painel_botao"></div>
							<div class="btn-group btn-group-sm" role="group" aria-label="...">
								<button type="button" class="btn btn-default" onclick="atualizarPainel()">Atualizar</button>
								<button type="button" class="btn btn-default" onclick="abrirModalFiltro()">Filtrar</button>
							</div>
						</div>
						
						<div id="painel_conteudo"></div>
					</div>
					
					<script type="text/javascript" src="../tecnologia/js/painelindicador/painelindicador.js"></script>					
					<script type="text/javascript" src="../tecnologia/js/painelindicador/painelindicadorfiltro.js"></script>					
					<script type="text/javascript" src="../tecnologia/js/painelindicador/painelindicadorfiltroselecao.js"></script>					

					<!-- Classie -->
					<script src="../tecnologia/js/classie.js"></script>
					<!-- Bootstrap Core JavaScript -->
					<script src="../tecnologia/js/bootstrap.js"></script>	
					<!-- Mask -->
					<script src="../tecnologia/js/jquery.mask.js"></script>				
					<!--scrolling js-->
					<script src="../tecnologia/js/jquery.nicescroll.js"></script>
					<script src="../tecnologia/js/script.js"></script>			
					<!-- SweetAlert -->
					<script type="text/javascript" src="../tecnologia/js/sweetalert/sweetalert.min.js"></script>					
				</div>
			</body>
		</html>
<?php
	}
?>