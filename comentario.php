<!DOCTYPE html>
<html>
<head>
	<script>
		
		function fechar() {
			alert("Comentário enviado com sucesso");
			window.opener = window;
			window.close("#");
		}

	</script>
	<title></title>
</head>
<body>

	<?php
		require('./conexao.php');

		if(is_null($cookie = $_COOKIE['login']))
			header('Location:./index.php');
		else
			$cookie = $_COOKIE['login'];
		
		$id = $_GET['id'];
		$comentario =  mysqli_fetch_array($bd->query("SELECT comentario FROM chamado WHERE id_chamado = '$id'"));

		echo'
			<form method="POST">
				<p>Escreva o comentário: <br/> <textarea name="novoComentario" rows="10" cols="50"></textarea></p>
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
		}
	?>

</body>
</html>