<?php

	require('./conexao.php');
	$login = $_COOKIE['login'];//Recebe o valor atual de cookie

	$verifica = $bd->query("SELECT id_usuario from usuario WHERE nome = '$login'");
	$dados = $verifica->fetch_array();
	$id = $dados['id_usuario']; 
	$bd->query("DELETE FROM logado WHERE id_usuario = '$id'"); 

    setcookie('login', '');//Apaga o valor de cookie

	header("Location: ./index.php"); //Retorna para a página inicial
?>