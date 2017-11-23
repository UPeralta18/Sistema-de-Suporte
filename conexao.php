<?php
	/*Apenas para a conexão do banco de dados*/
	$bd = new mysqli('localhost', 'root', '', 'suporte');

	if($bd->connect_errno)
	{
		throw new Exception('Erro na conexão', $conexao->connect_errno);
	}

	$bd->set_charset("utf-8");
?>