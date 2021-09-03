<?php
include_once('../tecnologia/Sistema.php');
    $entrar = Sistema::getPost('entrar');

if (isset($entrar)) {
    $connect                = Sistema::getConexao();
    $usuario                = strtoupper(Sistema::getPost('usuario'));
    $senhaNaoCriptografada  = Sistema::getPost('senha');
    $senha                  = base64_encode(sha1($senhaNaoCriptografada, true));
        
    // Verifica login digitado
    $queryLogin = $connect->prepare("SELECT A.CPF,
									   A.NOME,
									   A.SENHAWEB,
									   A.HANDLE
				  	                FROM 
                                        RC_CURRICULO A
				 				    WHERE A.CPF = :CPF
                                    AND A.SENHAWEB = :SENHAWEB
                                    ");
    $queryLogin->bindParam(':CPF', $usuario, PDO::PARAM_STR);
    $queryLogin->bindParam(':SENHAWEB', $senha, PDO::PARAM_STR);
    $queryLogin->execute();
    
    $rowLogin = $queryLogin->fetch(PDO::FETCH_ASSOC);
    
    $login          = $rowLogin['CPF'];
    $nome           = $rowLogin['NOME'];
    $senha          = $rowLogin['SENHAWEB'];
    $handle         = $rowLogin['HANDLE'];
       
    //if login e senha existir
    if ($handle > 0) {
        $_SESSION['CPF']        = $login;
        $_SESSION['SENHAWEB']   = $senha;
        $_SESSION['NOME']       = $nome;
        $_SESSION['HANDLE']     = $handle;
        
        setcookie("ultimologinWeb", $login, time()+3600*24*30, '/');
        
        header('Location: ../../view/recrutamento/CurriculoListar.php');
    }
    elseif (($handle == '0') || ($handle == '')) {
        setcookie("ultimologinWeb", $login, time()+3600*24*30, '/');
            
        header('Location: ../../view/estrutura/acesso.php?success=F');
    } else {
        unset($_SESSION['CPF']);
        unset($_SESSION['NOME']);
        //unset($_SESSION['HANDLE']);
        unset($_SESSION['SENHAWEB']); 

        header('Location: ../../view/estrutura/acesso.php?success=F');
    }
}//isset entrar
else {
    echo "<script type='application/javascript'> window.location.href='../../view/estrutura/acesso.php?success=F';</script>";
}
