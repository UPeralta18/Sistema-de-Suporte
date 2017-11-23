<!DOCTYPE html>
<html>
<head>
	<style type="text/css">

	</style>
	<title></title>
</head>
<body>
	<fieldset>
		<legend><h2>Comentários</h2></legend>

		<?php
			require('./conexao.php');

			if(is_null($cookie = $_COOKIE['login']))
				header('Location:./index.php');
			else
				$cookie = $_COOKIE['login'];
			
			$id = $_GET['id'];
			$comentario = mysqli_fetch_array($bd->query("SELECT comentario FROM chamado WHERE id_chamado = '$id'"));

			$separar = explode("  -  ", $comentario['comentario']);

			foreach ($separar as $valor) {
				echo $valor.'<br />';
			}

			echo'<h4>Escrever Comentario:</h4>
				<form method="POST">
					<p><textarea name="novoComentario" rows="10" cols="50"></textarea></p>
					<button onclick="fechar()">Enviar</button>
				</form>';

			if(isset($_POST['novoComentario']))
			{
				$data = date("d/m/Y");
				if(is_null($comentario['comentario']))
					$novoComentario = $cookie.' ('.$data.'): '.$_POST['novoComentario'];
				else
					$novoComentario = $comentario['comentario'].'  -  '.$cookie.' ('.$data.'): '.$_POST['novoComentario'];

				$bd->query("UPDATE chamado SET comentario='$novoComentario' WHERE id_chamado='$id'");
				header('Location:./verComentario.php?id='.$id);
			}
		?>
	</fieldset>

</body>
</html>