<?php
	/*Pagina para escrever noticia*/
	require('./conexao.php');//Pagina de Conexão

	if(is_null($cookie = $_COOKIE['login']))
			header('Location:./index.php');
		else
			$cookie = $_COOKIE['login'];

	if(empty($_POST['titulo']) || empty($_POST['tipo']) || empty($_POST['descricao']))
	{
		echo "<script>alert('Preencha todos os campos para abrir o chamado'); window.location.href = './abrirChamado.php';</script>";
	}
	else
	{
		$titulo = $_POST['titulo'];
		$tipo = $_POST['tipo'];
		$descricao = $_POST['descricao'];
		$urgente = $_POST['urgente'];

		//Gera a data dinamicamente
		$data = date("Y-m-d");

		$acharID = mysqli_fetch_array($bd->query("SELECT id_usuario FROM usuario WHERE nome = '$cookie'"));
		$id = $acharID['id_usuario']; 

		$bd->query("INSERT INTO chamado (id_solicitante, status, id_tipo_chamado, data_abertura, descricao, titulo, urgente) VALUES ('$id', '0', '$tipo', '$data', '$descricao', '$titulo', '$urgente')");

		echo "<script>alert('Chamado criado com sucesso'); window.location.href = './index.php';</script>";
	}
?>	