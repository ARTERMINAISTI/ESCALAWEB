<?php
include_once('../tecnologia/Sistema.php');
include_once('../../model/tecnologia/Usuario.php');

$entrar = Sistema::getPost('entrar');
    
if (isset($entrar)) {
    $connect = Sistema::getConexao();
    $usuario = strtoupper(Sistema::getPost('usuario'));
    $senhaNaoCriptografada = Sistema::getPost('senha');
    $senha = base64_encode(sha1($senhaNaoCriptografada, true));

    //-- SISTEMA
    $querySistema = $connect->prepare("SELECT A.CLIENTE
                                         FROM MD_SISTEMA A");
    $querySistema->execute();

    $rowSistema = $querySistema->fetch(PDO::FETCH_ASSOC);

    $sistemaCliente = $rowSistema['CLIENTE'];
        
    // Verifica login digitado
    $queryLogin = $connect->prepare("SELECT A.LOGINMAIUSCULO,
									   A.SENHA,
									   A.PESSOA,
									   A.HANDLE,
									   A.PAPEL,
									   B.NOME NOMEPAPEL
				  	   FROM MS_USUARIO A
				  	   INNER JOIN MS_PAPEL B ON B.HANDLE = A.PAPEL
				 				 WHERE A.LOGINMAIUSCULO = :LOGINMAIUSCULO
								 AND A.SENHA = :SENHA
								 AND A.STATUS = 4
								");
    $queryLogin->bindParam(':LOGINMAIUSCULO', $usuario, PDO::PARAM_STR);
    $queryLogin->bindParam(':SENHA', $senha, PDO::PARAM_STR);
    $queryLogin->execute();
    
    $rowLogin = $queryLogin->fetch(PDO::FETCH_ASSOC);
    
    $login = $rowLogin['LOGINMAIUSCULO'];
    $pessoa = $rowLogin['PESSOA'];
    $handleUsuario = $rowLogin['HANDLE'];
    $papel = $rowLogin['PAPEL'];
    $papelNome = $rowLogin['NOMEPAPEL'];        
  
    //seleciona ultima empresa logada pelo usuario no sistema
    $QueryEmpresa = $connect->prepare("SELECT A.VALOR 
										 FROM MD_USUARIOVARIAVEL A
										 WHERE A.USUARIO = '" . $handleUsuario . "'
										  AND A.VARIAVEL = 'ULTIMAEMPRESA'
										");
    $QueryEmpresa->execute();

    $rowEmpresa = $QueryEmpresa->fetch(PDO::FETCH_ASSOC);
    $ValorEmpresa = $rowEmpresa['VALOR'];

    //seleciona ultima filial logada pelo usuario no sistema
    $QueryFilial = $connect->prepare("SELECT A.VALOR 
										FROM MD_USUARIOVARIAVEL A
									   WHERE A.USUARIO = '" . $handleUsuario . "'
										 AND A.VARIAVEL = 'ULTIMAFILIAL'
									  ");
    $QueryFilial->execute();

    $rowFilial = $QueryFilial->fetch(PDO::FETCH_ASSOC);
    $ValorFilial = $rowFilial['VALOR'];
    
    $QueryEmpresaPermissao = $connect->prepare("SELECT A.HANDLE, 
											   (SELECT COUNT(B.HANDLE) FROM MS_FILIAL B WHERE B.EMPRESA = A.HANDLE) TEMFILIAL 
													   FROM MS_EMPRESA A 
									           WHERE (EXISTS(SELECT C.HANDLE FROM MS_USUARIOEMPRESA C WHERE C.EMPRESA = A.HANDLE AND C.USUARIO = ('" . $handleUsuario . "'))
									           OR NOT EXISTS(SELECT D.HANDLE FROM MS_USUARIOEMPRESA D WHERE D.USUARIO = ('" . $handleUsuario . "')))
											  ");
    $QueryEmpresaPermissao->execute();

    $rowEmpresaPermissao = $QueryEmpresaPermissao->fetch(PDO::FETCH_ASSOC);
    $temfilial = $rowEmpresaPermissao['TEMFILIAL'];

    if ($temfilial <= 0 or $temfilial <= '') {
        header('Location: ../../view/estrutura/login.php?permissaoempresa=F');
    } else {
        $ValorEmpresa = $rowEmpresaPermissao['HANDLE'];
    }
 
    $QueryFilialPermissao = $connect->prepare("SELECT A.FILIAL 
												 FROM MS_USUARIOEMPRESAFILIAL A 
												WHERE A.USUARIOEMPRESA = (SELECT HANDLE FROM MS_USUARIOEMPRESA WHERE USUARIO = '" . $handleUsuario . "' AND EMPRESA = '" . $ValorEmpresa . "') 
												");
    $QueryFilialPermissao->execute();

    $rowFilialPermissao = $QueryFilialPermissao->fetch(PDO::FETCH_ASSOC);
    $filial = $rowFilialPermissao['FILIAL'];
    
    if ($filial <= 0 or $filial <= '') {
        header('Location: ../../view/estrutura/login.php?permissaoempresa=F');
    }
    
    if ($empresa <= '' and $filial <= '') {
        header('Location: ../../view/estrutura/login.php?mensagem=O usuário deve obrigatóriamente estar logado em uma filial.');
    }
    
    $_SESSION['complementoTitulo'] = '';

    if ($ValorEmpresa > null) {
        $QueryEmpresaMestre = $connect->prepare("SELECT EMPRESAMESTRE FROM MS_EMPRESA WHERE HANDLE = '".$ValorEmpresa."'");
        $QueryEmpresaMestre->execute();
        $rowEmpresaMestre = $QueryEmpresaMestre->fetch(PDO::FETCH_ASSOC);
        $empresaMestre = $rowEmpresaMestre['EMPRESAMESTRE'];

        $QueryComplementoTitulo = $connect->prepare("SELECT VALOR
		                                               FROM IN_CAMPOCOMPLEMENTAR
													  WHERE CAMPO = 'NOMEEXIBICAOTITULOESCALAWEB'
													    AND HANDLEORIGEM = '".$ValorEmpresa."'
													    AND ORIGEM = 1234");
        $QueryComplementoTitulo->execute();
        $rowComplementoTitulo = $QueryComplementoTitulo->fetch(PDO::FETCH_ASSOC);
        
        if (!empty($rowComplementoTitulo['VALOR'])) {
            $_SESSION['complementoTitulo'] = $rowComplementoTitulo['VALOR'];
        }
    }

    $QueryEmpresa = $connect->prepare("SELECT A.NOMEREDUZIDO,
                                                B.APELIDO
                                            FROM MS_EMPRESA A
                                            LEFT JOIN MS_PESSOA B ON B.HANDLE = A.PESSOA 
                                        WHERE A.HANDLE = '".$ValorEmpresa."'");
    $QueryEmpresa->execute();
        
    $rowEmpresa = $QueryEmpresa->fetch(PDO::FETCH_ASSOC);
    $NomeEmpresa = $rowEmpresa['NOMEREDUZIDO'];
    $ApelidoEmpresa = $rowEmpresa['APELIDO'];
        
        
    $QueryFilial = $connect->prepare("SELECT MS_FILIAL.NOMEREDUZIDO FROM MS_FILIAL WHERE MS_FILIAL.HANDLE = '".$ValorFilial."'");
    $QueryFilial->execute();
        
    $rowFilial = $QueryFilial->fetch(PDO::FETCH_ASSOC);
    $NomeFilial = $rowFilial['NOMEREDUZIDO'];
    
    if ($handleUsuario > 0) {
        $_SESSION['pessoa'] = $pessoa;
        $_SESSION['papel'] = $papel;
        $_SESSION['usuario'] = $usuario;
        $_SESSION['handleUsuario'] = $handleUsuario;
        $_SESSION['senha'] = $senha;
        $_SESSION['senhaNaoCriptografada'] = $senhaNaoCriptografada;
        $_SESSION['empresa'] = $ValorEmpresa;
        $_SESSION['filial'] = $ValorFilial;
        $_SESSION['NomeEmpresa'] = $NomeEmpresa;
	    $_SESSION['ApelidoEmpresa'] = $ApelidoEmpresa;
        $_SESSION['NomeFilial'] = $NomeFilial;
        $_SESSION['empresaMestre'] = $empresaMestre;
        $_SESSION['loginUsuario'] = $login;
        $_SESSION['papelNome'] = $papelNome;
        $_SESSION['sistemaCliente'] = $sistemaCliente;

        $usuario = new Usuario();
        $usuario->gerarAuditoriaAcesso();    	
        
        setcookie("ultimologinWeb", strtolower($usuario), time()+3600*24*30, '/');
        
        header('Location: ../../view/servicedesk/Painel.php'); 
    }//if login e senha existir
    elseif (($handleUsuario == '0') || ($handleUsuario == '')) {
        setcookie("ultimologinWeb", strtolower($usuario), time()+3600*24*30, '/');
            
        header('Location: ../../view/estrutura/login.php?success=F');
    } else {
        unset($_SESSION['pessoa']);
        unset($_SESSION['papel']);
        unset($_SESSION['referenciaPapelUsuario']);
        unset($_SESSION['senhaNaoCriptografada']);
        unset($_SESSION['usuario']);
        unset($_SESSION['senha']);
        unset($_SESSION['empresa']);
        unset($_SESSION['filial']);
		unset($_SESSION['loginUsuario']);
		unset($_SESSION['handleUsuario']);
		unset($_SESSION['auditoriaAcesso']);	
        unset($_SESSION['papelNome']);
        unset($_SESSION['sistemaCliente']);
                
        header('Location: ../../view/estrutura/login.php?success=F');
    }
}//isset entrar
else {
    echo "<script type='application/javascript'> window.location.href='../../view/estrutura/login.php?success=F';</script>";
}
