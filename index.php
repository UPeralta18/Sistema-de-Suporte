<!DOCTYPE html>
<html>
<head>
	<title>Suporte</title>

	<style type="text/css">
		body{
			text-align: center;
		}
		table{
			border-collapse: collapse;
			margin: 0 auto;
		}
		td{
			padding: 5px;
			border-bottom: 1px solid #000;
		}
		tr:hover {
			background-color: #DDD;
		}
		th{
			color: #FFF;
			background-color: #888;
			padding: 5px;
		}
	</style>
</head>
<body>

	<?php

		require("./conexao.php");

		if(empty($_COOKIE['login']))
		{
			echo 
			'<form method="POST" action="./login.php" name="login">
				<p>Usuario: <input type="text" name="usuario"></p>
				<p>Senha: <input type="password" name="senha"></p>
				<button>Fazer login</button>
			</form>';
		}
		else
		{
			$cookie = $_COOKIE['login'];
			echo '<p>Bem vindo '.$cookie. ' <a href="./sair.php"> Sair</a></p>';

			$query = $bd->query("SELECT administrador FROM usuario WHERE nome = '$cookie'");
			$dados = $query->fetch_array();
			$verificaAdmin = $dados['administrador'];

			if ($verificaAdmin) {
				require('./administrador.php');
			}
			else{
				require('./comum.php');
			}
		}
	?>


</body>
</html>
