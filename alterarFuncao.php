<?php
	/*Pagina para escrever noticia*/
	require('./conexao.php');//Pagina de Conexão

	if(is_null($cookie = $_COOKIE['login']))
			header('Location:./index.php');
		else
			$cookie = $_COOKIE['login'];

	if(empty($_POST['titulo']) || empty($_POST['tipo']) || empty($_POST['descricao']))
	{
		echo "<script>alert('Preencha todos os campos para mandar a noticia'); window.location.href = './abrirChamado.php';</script>";
	}
	else
	{
		$id = $_GET['id'];
		$titulo = $_POST['titulo'];
		$tipo = $_POST['tipo'];
		$descricao = $_POST['descricao'];
		$urgente = $_POST['urgente'];

		$bd->query("UPDATE chamado SET id_tipo_chamado = '$tipo', descricao = '$descricao', titulo = '$titulo', urgente = '$urgente' WHERE id_chamado='$id'");

		echo "<script>alert('Chamado alterado com sucesso'); window.location.href = './index.php';</script>";
	}
?>	