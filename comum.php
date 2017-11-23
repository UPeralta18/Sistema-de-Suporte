<!DOCTYPE html>
<html>
<head>
	<script>
		function cancelar(id) {
			if (confirm("Deseja adicionar um comentário?")) {
				var janela = window.open ('./comentario.php?id='+id, 'janela', 'width=500px, height=300px, scrollbars=no, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
			}
		   	if(confirm("Deseja realmente cancelar o chamado?") == true) {
		   		window.location.href = './resolver.php?id='+id+'&status=3';
		    } else {
		    	window.location.href = './index.php';
		    }
		}

		function alterar(id) {
		   if(confirm("Deseja realmente alterar o chamado?") == true) {
		   		window.location.href = './alterar.php?id='+id;
		    } else {
		    	window.location.href = './index.php';
		    }
		}

		function comentario(id) {
			window.open('./verComentario.php?id='+id, '_blank');
		}
	</script>
	<title>Sistema de Chamados</title>
</head>
<body>

	<a href="abrirChamado.php">Abrir Chamado</a>
	
	<h2>Seus chamados</h2>

	<?php
		require('./conexao.php');
		
		if(is_null($cookie = $_COOKIE['login']))
			header('Location:./index.php');
		else
			$cookie = $_COOKIE['login'];

		$acharID = mysqli_fetch_array($bd->query("SELECT id_usuario FROM usuario WHERE nome = '$cookie'"));
		$id = $acharID['id_usuario'];

		$resultados = $bd->query("SELECT * FROM chamado WHERE id_solicitante = '$id' AND status = '0'");
		$resultados1 = $bd->query("SELECT * FROM chamado WHERE id_solicitante = '$id' AND status = '1'");
		$resultados2 = $bd->query("SELECT * FROM chamado WHERE id_solicitante = '$id' AND status = '2'");
		$resultados3 = $bd->query("SELECT * FROM chamado WHERE id_solicitante = '$id' AND status = '3'");

		if ($resultados->num_rows > 0) {
			echo'<h3>Chamados não solucionados</h3>
				<table>
					<tr>
						<th>ID</th>
						<th>Tipo</th>
						<th>Data de abertura</th>
						<th>Titulo</th>
						<th>Descrição</th>
						<th>Urgente?</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>';
			
			$urgentes = $bd->query("SELECT * FROM chamado WHERE id_solicitante = '$id' AND status = '0' AND urgente = '1' ORDER BY DATE_FORMAT(data_abertura, '%d/%c/%Y')");
			$naoUrgentes = $bd->query("SELECT * FROM chamado WHERE id_solicitante = '$id' AND status = '0' AND urgente = '0' ORDER BY DATE_FORMAT(data_abertura, '%d/%c/%Y')");

			while ($chamado = mysqli_fetch_array($urgentes)) {
				$idTipoChamado = $chamado['id_tipo_chamado'];
				$tipoChamado =  mysqli_fetch_array($bd->query("SELECT nome FROM tipo_chamado WHERE id_tipo_chamado = '$idTipoChamado'"));
				$data = date("d/m/Y", strtotime($chamado['data_abertura']));

				echo '<tr>
						<td><b>'.$chamado['id_chamado'].'</b></td>
						<td><b>'.$tipoChamado['nome'].'</b></td>
						<td><b>'.$data.'</b></td>
						<td><b>'.$chamado['titulo'].'</b></td>
						<td><b>'.$chamado['descricao'].'</b></td>
						<td> <b>Sim</b> </td>
						<td><button onclick="comentario('.$chamado['id_chamado'].')"><b>Comentários</b></button></td>
						<td><button onclick="alterar('.$chamado['id_chamado'].')"><b>Alterar</b></button></td>
						<td><button onclick="cancelar('.$chamado['id_chamado'].')"><b>Cancelar</b></button></td>
					</tr>';
			}

			while ($chamado = mysqli_fetch_array($naoUrgentes)) {
				$idTipoChamado = $chamado['id_tipo_chamado'];
				$tipoChamado =  mysqli_fetch_array($bd->query("SELECT nome FROM tipo_chamado WHERE id_tipo_chamado = '$idTipoChamado'"));
				$data = date("d/m/Y", strtotime($chamado['data_abertura']));

				echo '<tr>
						<td>'.$chamado['id_chamado'].'</td>
						<td>'.$tipoChamado['nome'].'</td>
						<td>'.$data.'</td>
						<td>'.$chamado['titulo'].'</td>
						<td>'.$chamado['descricao'].'</td>
						<td> Não </td>
						<td><button onclick="comentario('.$chamado['id_chamado'].')">Comentários</button></td>
						<td><button onclick="alterar('.$chamado['id_chamado'].')">Alterar</button></td>
						<td><button onclick="cancelar('.$chamado['id_chamado'].')">Cancelar</button></td>
					</tr>';
			}

			echo '</table><br>';
		}
		if ($resultados1->num_rows > 0) {
			echo'<h3>Chamados em execução</h3>
				<table>
					<tr>
						<th>ID</th>
						<th>Tipo</th>
						<th>Data de abertura</th>
						<th>Data de início de execução</th>
						<th>Titulo</th>
						<th>Descrição</th>
						<th>Urgente?</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>';
			
			$urgentes = $bd->query("SELECT * FROM chamado WHERE id_solicitante = '$id' AND status = '1' AND urgente = '1'");
			$naoUrgentes = $bd->query("SELECT * FROM chamado WHERE id_solicitante = '$id' AND status = '1' AND urgente = '0'");

			while ($chamado = mysqli_fetch_array($resultados1)) {
				$idTipoChamado = $chamado['id_tipo_chamado'];
				$tipoChamado =  mysqli_fetch_array($bd->query("SELECT nome FROM tipo_chamado WHERE id_tipo_chamado = '$idTipoChamado'"));
				$dataAbertura = date("d/m/Y", strtotime($chamado['data_abertura']));
				$dataInicioExecucao = date("d/m/Y", strtotime($chamado['data_inicio_execucao']));

				echo '<tr>
						<td><b>'.$chamado['id_chamado'].'</b></td>
						<td><b>'.$tipoChamado['nome'].'</b></td>
						<td><b>'.$dataAbertura.'</b></td>
						<td><b>'.$dataInicioExecucao.'</b></td>
						<td><b>'.$chamado['titulo'].'</b></td>
						<td><b>'.$chamado['descricao'].'</b></td>
						<td> <b>Sim</b> </td>
						<td><button onclick="comentario('.$chamado['id_chamado'].')"><b>Comentários</b></button></td>
						<td><button onclick="alterar('.$chamado['id_chamado'].')"><b>Alterar</b></button></td>
						<td><button onclick="cancelar('.$chamado['id_chamado'].')"><b>Cancelar</b></button></td>
					</tr>';
			}

			while ($chamado = mysqli_fetch_array($resultados1)) {
				$idTipoChamado = $chamado['id_tipo_chamado'];
				$tipoChamado =  mysqli_fetch_array($bd->query("SELECT nome FROM tipo_chamado WHERE id_tipo_chamado = '$idTipoChamado'"));
				$dataAbertura = date("d/m/Y", strtotime($chamado['data_abertura']));
				$dataInicioExecucao = date("d/m/Y", strtotime($chamado['data_inicio_execucao']));

				echo '<tr>
						<td>'.$chamado['id_chamado'].'</td>
						<td>'.$tipoChamado['nome'].'</td>
						<td>'.$dataAbertura.'</td>
						<td>'.$dataInicioExecucao.'</td>
						<td>'.$chamado['titulo'].'</td>
						<td>'.$chamado['descricao'].'</td>
						<td> Não </td>
						<td><button onclick="comentario('.$chamado['id_chamado'].')">Comentários</button></td>
						<td><button onclick="alterar('.$chamado['id_chamado'].')">Alterar</button></td>
						<td><button onclick="cancelar('.$chamado['id_chamado'].')">Cancelar</button></td>
					</tr>';
			}

			echo '</table><br>';
		}
		if($resultados2->num_rows > 0) {
			echo'<h3>Chamados solucionados</h3>
				<table>
					<tr>
						<th>ID</th>
						<th>Tipo</th>
						<th>Data de abertura</th>
						<th>Data de início de execução</th>
						<th>Data de finalização</th>
						<th>Titulo</th>
						<th>Descrição</th>
						<th></th>
					</tr>';

			while ($chamado = mysqli_fetch_array($resultados2)) {
				$idTipoChamado = $chamado['id_tipo_chamado'];
				$tipoChamado =  mysqli_fetch_array($bd->query("SELECT nome FROM tipo_chamado WHERE id_tipo_chamado = '$idTipoChamado'"));
				$dataAbertura = date("d/m/Y", strtotime($chamado['data_abertura']));
				$dataInicioExecucao = date("d/m/Y", strtotime($chamado['data_inicio_execucao']));
				$dataFinalizacao = date("d/m/Y", strtotime($chamado['data_finalizacao']));

				echo '<tr>
						<td>'.$chamado['id_chamado'].'</td>
						<td>'.$tipoChamado['nome'].'</td>
						<td>'.$dataAbertura.'</td>
						<td>'.$dataInicioExecucao.'</td>
						<td>'.$dataFinalizacao.'</td>
						<td>'.$chamado['titulo'].'</td>
						<td>'.$chamado['descricao'].'</td>
						<td><button onclick="comentario('.$chamado['id_chamado'].')">Comentários</button></td>						
					</tr>';
			}

		echo '</table><br>';
		}
		if($resultados3->num_rows > 0) {
			echo'<h3>Chamados cancelados</h3>
				<table>
					<tr>
						<th>ID</th>
						<th>Tipo</th>
						<th>Data de abertura</th>
						<th>Data de cancelamento</th>
						<th>Titulo</th>
						<th>Descrição</th>
						<th></th>
					</tr>';

			while ($chamado = mysqli_fetch_array($resultados3)) {
				$idTipoChamado = $chamado['id_tipo_chamado'];
				$tipoChamado =  mysqli_fetch_array($bd->query("SELECT nome FROM tipo_chamado WHERE id_tipo_chamado = '$idTipoChamado'"));
				$dataAbertura = date("d/m/Y", strtotime($chamado['data_abertura']));
				$dataFinalizacao = date("d/m/Y", strtotime($chamado['data_finalizacao']));

				echo '<tr>
						<td>'.$chamado['id_chamado'].'</td>
						<td>'.$tipoChamado['nome'].'</td>
						<td>'.$dataAbertura.'</td>
						<td>'.$dataFinalizacao.'</td>
						<td>'.$chamado['titulo'].'</td>
						<td>'.$chamado['descricao'].'</td>
						<td><button onclick="comentario('.$chamado['id_chamado'].')">Comentários</button></td>
					</tr>';
			}

		echo '</table><br>';
		}
	?>

</body>
</html>
