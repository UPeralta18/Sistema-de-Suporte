<?php

	require('./conexao.php');

	$usuario = ucfirst(strtolower(($_POST['usuario'])));
	$senha = $_POST['senha'];

	$verifica = $bd->query("SELECT * FROM usuario WHERE nome = '$usuario' && senha = '$senha'");
	
	$dados = $verifica->fetch_array();
	$id = $dados['id_usuario'];

	$logado = $bd->query("SELECT * FROM logado WHERE id_usuario = '$id'");

	if(empty($_POST['usuario']) || empty($_POST['senha']))
	{
		echo '<script>alert("Preencha todos os campos para logar"); window.location.href = "./index.php";</script>';
	}
	elseif(mysqli_num_rows($verifica)<=0)
	{
		echo '<script> alert("O usuario ou senha está errado"); window.location.href = "./index.php";</script>';
	}
	elseif (mysqli_num_rows($logado)>0)
	{
		echo '<script> alert("Este usuario já está logado"); window.location.href = "./index.php";</script>';
	}
	else
	{
		$bd->query("INSERT INTO logado (id_usuario, logado) VALUES ('$id', '1');");
		setcookie("login",$usuario);
		header('Location:./index.php');
	}

?>