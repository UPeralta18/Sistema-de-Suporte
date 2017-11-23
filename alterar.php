<!DOCTYPE html>
<html>
<head>
	<title>Abrir Chamado</title>

	<style type="text/css">
		/* Efeitos do texto */
		ul span{
		padding:5px;
		border:1px solid #000;
		position:absolute;
		-webkit-border-radius:5px;
		-moz-border-radius:5px;
		border-radius:5px;
		opacity:0;
		-moz-opacity:0;
		filter:alpha(opacity=0);
		margin-left: 5px;
		background: #FFF;
		}

		/* Efeitos do texto quando o mouse estive em cima da Imagem */ 
		ul:hover span{
		opacity:1;
		-moz-opacity:1;
		filter:alpha(opacity=100);
		}
	</style>
</head>
<body>

	<?php
		require('./conexao.php');

		if(is_null($cookie = $_COOKIE['login']))
			header('Location:./index.php');
		else
			$cookie = $_COOKIE['login'];

		$id = $_GET['id'];
		$chamado = mysqli_fetch_array($bd->query("SELECT * FROM chamado WHERE id_chamado = '$id'"));
	
		echo'
		<form method="post" action="./alterarFuncao.php?id='.$id.'">
			<fieldset>
				<legend>Abrir Chamado</legend>
				<p>Título: <input type="text" name="titulo" value="'.$chamado['titulo'].'" /></p>

				<div id="tipoChamado">
					<p> Categoria do Chamado: </p>';
					

		$resultados = $bd->query("SELECT * FROM tipo_chamado");

		while ($tipoChamado = mysqli_fetch_array($resultados))
		{	
			if($tipoChamado['id_tipo_chamado'] == $chamado['id_tipo_chamado'])
				echo '<ul> <input type="radio" name="tipo" value="'.$tipoChamado['id_tipo_chamado'].'" checked> '.$tipoChamado['nome'].
			' <span>'.$tipoChamado['descricao'].'</span></ul>';
			else
				echo '<ul> <input type="radio" name="tipo" value="'.$tipoChamado['id_tipo_chamado'].'"> '.$tipoChamado['nome'].
			' <span>'.$tipoChamado['descricao'].'</span></ul>';
		}
					
		echo'
				</div>

				<p>Descrição do problema: <br/> <textarea name="descricao" rows="10" cols="100">'.$chamado['descricao'].'</textarea></p>';

		if($chamado['urgente'])
			echo '<p>Urgente: <input type="radio" name="urgente" value="0">Não
					<input type="radio" name="urgente" value="1" checked>Sim</p>';
		else
			echo '<p>Urgente: <input type="radio" name="urgente" value="0" checked>Não
					<input type="radio" name="urgente" value="1">Sim</p>';

		echo '
				<button>Alterar chamado</button>

			</fieldset>
		</form>';

	?>

</body>
</html>