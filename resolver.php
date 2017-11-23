<?php

	require('./conexao.php');

	if(is_null($cookie = $_COOKIE['login']))
		header('Location:./index.php');
	else
		$cookie = $_COOKIE['login'];

	$chamado = $_GET['id'];
	$status = $_GET['status'];
	$data = date("Y-m-d");

	$atendente =  mysqli_fetch_array($bd->query("SELECT * FROM usuario WHERE nome = '$cookie'"));
	if($atendente['administrador'])
	{
		$idAtendente = $atendente['id_usuario'];

		if($status==1){
			$bd->query("UPDATE chamado SET id_atendente='$idAtendente', status='$status', data_inicio_execucao='$data' WHERE id_chamado='$chamado'");
			echo "<script type='javascript'>alert('Status alterado para Em Execução');</script>";
		}
		elseif($status==2){
			$bd->query("UPDATE chamado SET status='$status', data_finalizacao='$data' WHERE id_chamado='$chamado'");
			echo "<script type='javascript'>alert('Status alterado para Resolvido');</script>";
		}
		else{
			$bd->query("UPDATE chamado SET status='$status', data_finalizacao='$data' WHERE id_chamado='$chamado'");
			echo "<script type='javascript'>alert('Status alterado para Cancelado');</script>";
		}
	}
	else
	{	
		$bd->query("UPDATE chamado SET status='$status', data_finalizacao='$data' WHERE id_chamado='$chamado'");
		echo "<script type='javascript'>alert('Status alterado para Cancelado');</script>";
	}
	
	header('Location:./index.php');