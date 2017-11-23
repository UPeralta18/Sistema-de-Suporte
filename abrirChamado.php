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
		{
			header('Location:./index.php');
		}
		else
		{
			$query = $bd->query("SELECT id_usuario FROM usuario WHERE nome = '$cookie'");
			$dados = $query->fetch_array();
			$id = $dados['id_usuario'];
			$data = date("Y-m-d");
		}
	?>

	<form method="post" action="./abrirChamadoFuncao.php">
		<fieldset>
			<legend><h2>Abrir Chamado</h2></legend>
			<p>Título: <input type="text" name="titulo" /></p>

			<div id="tipoChamado">
				<p> Categoria do Chamado: </p>
				<?php

					$resultados = $bd->query("SELECT * FROM tipo_chamado");

					if($resultados ->num_rows > 0)
						while ($tipoChamado = $resultados->fetch_object())
						{
							echo '<ul> <input type="radio" name="tipo" value="'.$tipoChamado->id_tipo_chamado.'"> '.$tipoChamado->nome.
							' <span>'.$tipoChamado->descricao.'</span></ul>';
						}
				?>
			</div>

			<p>Descrição do problema: <br/> <textarea name="descricao" rows="10" cols="100"></textarea></p>

			<p>Urgente: <input type="radio" name="urgente" value="0">Não
						<input type="radio" name="urgente" value="1">Sim</p>

			<button>Enviar chamado</button>

		</fieldset>
	</form>

</body>
</html>