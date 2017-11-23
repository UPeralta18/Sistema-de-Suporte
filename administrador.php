<!DOCTYPE html>
<html>
<head>
	<script>
	function resolver(id) {
		if (confirm("Deseja adicionar um comentário?")) {
			var janela = window.open ('./comentario.php?id='+id, 'janela', 'width=500px, height=300px, scrollbars=no, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
		}
		if(confirm("Deseja confirmar a resolução do chamado?")) 
			window.location.href = './resolver.php?id='+id+'&status=2';
		else
			window.location.href = './index.php';
	}

	function mudar(id) {
		if (confirm("Deseja adicionar um comentário?")) {
			var janela = window.open ('./comentario.php?id='+id, 'janela', 'width=500px, height=300px, scrollbars=no, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
		}
		var status = document.getElementById("status").value;
		if(status>0) {
			if(confirm("Deseja mudar o chamado?"))
				window.location.href = './resolver.php?id='+id+'&status='+status;
			else
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

	<?php
		require('./conexao.php');
		
		if(is_null($cookie = $_COOKIE['login']))
			header('Location:./index.php');
		else
			$cookie = $_COOKIE['login'];

		$resultados0 = $bd->query("SELECT * FROM chamado WHERE status = '0'");
		$resultados1 = $bd->query("SELECT * FROM chamado WHERE status = '0' AND urgente = '1'");
		$resultados2 = $bd->query("SELECT * FROM chamado WHERE status = '0' AND urgente = '0'");

		if ($resultados0->num_rows > 0) {
			echo '<h2>Chamados pendentes</h2>';

			if($resultados1->num_rows > 0) {
				echo'<h3>Urgentes</h3>
					<table>
						<tr>
							<th>ID</th>
							<th>Tipo</th>
							<th>Data abertura</th>
							<th>Titulo</th>
							<th>Descrição</th>
							<th>Solicitante</th>
							<th>Setor</th>
							<th>Telefone</th>
							<th></th>
							<th>Mudar Status</th>
						</tr>';

				while ($chamado = mysqli_fetch_array($resultados1)) {
					$idTipoChamado = $chamado['id_tipo_chamado'];
					$tipoChamado =  mysqli_fetch_array($bd->query("SELECT nome FROM tipo_chamado WHERE id_tipo_chamado = '$idTipoChamado'"));

					$idSolicitante = $chamado['id_solicitante'];
					$solicitante = mysqli_fetch_array($bd->query("SELECT * FROM usuario WHERE id_usuario = '$idSolicitante'"));

					$idSetorSolicitante = $solicitante['setor'];
					$setor = mysqli_fetch_array($bd->query("SELECT * FROM setor WHERE id_setor = '$idSetorSolicitante'"));

					$dataAbertura = date("d/m/Y", strtotime($chamado['data_abertura']));

					echo '<tr>
							<td><b>'.$chamado['id_chamado'].'</b></td>
							<td><b>'.$tipoChamado['nome'].'</b></td>
							<td><b>'.$dataAbertura.'</b></td>
							<td><b>'.$chamado['titulo'].'</b></td>
							<td><b>'.$chamado['descricao'].'</b></td>
							<td><b>'.$solicitante['nome'].'</b></td>
							<td><b>'.$setor['nome'].'</b></td>
							<td><b>'.$setor['telefone'].'</b></td>
							<td><button onclick="comentario('.$chamado['id_chamado'].')"><b>Comentários</b></button></td>
							<td>
								<select id="status">
									<option value="0">Pendente</option>
									<option value="1">Em Execução</option>
									<option value="2">Resolvido</option>
									<option value="3">Cancelado</option>
								</select>
								<button onclick="mudar('.$chamado['id_chamado'].')"><b>Mudar</b></button>
							</td>
						</tr>';
				}
				echo '</table>';
			}

			if ($resultados2->num_rows > 0) {
				echo'<h3>Não urgentes</h3>
					<table>
						<tr>
							<th>ID</th>
							<th>Tipo</th>
							<th>Data abertura</th>
							<th>Titulo</th>
							<th>Descrição</th>
							<th>Solicitante</th>
							<th>Setor</th>
							<th>Telefone</th>
							<th></th>
							<th>Mudar Status</th>
						</tr>';

				while ($chamado = mysqli_fetch_array($resultados2)) {
					$idTipoChamado = $chamado['id_tipo_chamado'];
					$tipoChamado =  mysqli_fetch_array($bd->query("SELECT nome FROM tipo_chamado WHERE id_tipo_chamado = '$idTipoChamado'"));

					$idSolicitante = $chamado['id_solicitante'];
					$solicitante = mysqli_fetch_array($bd->query("SELECT * FROM usuario WHERE id_usuario = '$idSolicitante'"));

					$idSetorSolicitante = $solicitante['setor'];
					$setor = mysqli_fetch_array($bd->query("SELECT * FROM setor WHERE id_setor = '$idSetorSolicitante'"));

					$dataAbertura = date("d/m/Y", strtotime($chamado['data_abertura']));

					echo '<tr>
							<td>'.$chamado['id_chamado'].'</td>
							<td>'.$tipoChamado['nome'].'</td>
							<td><b>'.$dataAbertura.'</b></td>
							<td>'.$chamado['titulo'].'</td>
							<td>'.$chamado['descricao'].'</td>
							<td>'.$solicitante['nome'].'</td>
							<td>'.$setor['nome'].'</td>
							<td>'.$setor['telefone'].'</td>
							<td><button onclick="comentario('.$chamado['id_chamado'].')">Comentários</button></td>
							<td>
								<select id="status">
									<option value="0">Pendente</option>
									<option value="1">Em Execução</option>
									<option value="2">Resolvido</option>
									<option value="3">Cancelado</option>
								</select>
								<button onclick="mudar('.$chamado['id_chamado'].')"><b>Mudar</b></button>
							</td>
						</tr>';
				}
				echo '</table>';
			}
		}

		$resultados0 = $bd->query("SELECT * FROM chamado WHERE status = '1'");
		$resultados1 = $bd->query("SELECT * FROM chamado WHERE status = '1' AND urgente = '1'");
		$resultados2 = $bd->query("SELECT * FROM chamado WHERE status = '1' AND urgente = '0'");

		if ($resultados0->num_rows > 0) {
			echo '<h2>Chamados em execução</h2>';

			if($resultados1->num_rows > 0) {
				echo'<h3>Urgentes</h3>
					<table>
						<tr>
							<th>ID</th>
							<th>Tipo</th>
							<th>Data abertura</th>
							<th>Data de início de execução</th>
							<th>Titulo</th>
							<th>Descrição</th>
							<th>Solicitante</th>
							<th>Setor</th>
							<th>Telefone</th>
							<th></th>
							<th></th>
						</tr>';

				while ($chamado = mysqli_fetch_array($resultados1)) {
					$idTipoChamado = $chamado['id_tipo_chamado'];
					$tipoChamado =  mysqli_fetch_array($bd->query("SELECT nome FROM tipo_chamado WHERE id_tipo_chamado = '$idTipoChamado'"));

					$idSolicitante = $chamado['id_solicitante'];
					$solicitante = mysqli_fetch_array($bd->query("SELECT * FROM usuario WHERE id_usuario = '$idSolicitante'"));

					$idSetorSolicitante = $solicitante['setor'];
					$setor = mysqli_fetch_array($bd->query("SELECT * FROM setor WHERE id_setor = '$idSetorSolicitante'"));

					$dataAbertura = date("d/m/Y", strtotime($chamado['data_abertura']));
					$dataInicioExecucao = date("d/m/Y", strtotime($chamado['data_inicio_execucao']));

					echo '<tr>
							<td><b>'.$chamado['id_chamado'].'</b></td>
							<td><b>'.$tipoChamado['nome'].'</b></td>
							<td><b>'.$dataAbertura.'</b></td>
							<td><b>'.$dataInicioExecucao.'</b></td>
							<td><b>'.$chamado['titulo'].'</b></td>
							<td><b>'.$chamado['descricao'].'</b></td>
							<td><b>'.$solicitante['nome'].'</b></td>
							<td><b>'.$setor['nome'].'</b></td>
							<td><b>'.$setor['telefone'].'</b></td>
							<td><button onclick="comentario('.$chamado['id_chamado'].')"><b>Comentários</b></button></td>
							<td><button onclick="resolver('.$chamado['id_chamado'].')"><b>Resolver</b></button></td>
						</tr>';
				}
				echo '</table>';
			}

			if ($resultados2->num_rows > 0) {
				echo'<h3>Não urgentes</h3>
					<table>
						<tr>
							<th>ID</th>
							<th>Tipo</th>
							<th>Data abertura</th>
							<th>Data de início de execução</th>
							<th>Titulo</th>
							<th>Descrição</th>
							<th>Solicitante</th>
							<th>Setor</th>
							<th>Telefone</th>
							<th></th>
						</tr>';

				while ($chamado = mysqli_fetch_array($resultados2)) {
					$idTipoChamado = $chamado['id_tipo_chamado'];
					$tipoChamado =  mysqli_fetch_array($bd->query("SELECT nome FROM tipo_chamado WHERE id_tipo_chamado = '$idTipoChamado'"));

					$idSolicitante = $chamado['id_solicitante'];
					$solicitante = mysqli_fetch_array($bd->query("SELECT * FROM usuario WHERE id_usuario = '$idSolicitante'"));

					$idSetorSolicitante = $solicitante['setor'];
					$setor = mysqli_fetch_array($bd->query("SELECT * FROM setor WHERE id_setor = '$idSetorSolicitante'"));

					$dataAbertura = date("d/m/Y", strtotime($chamado['data_abertura']));
					$dataInicioExecucao = date("d/m/Y", strtotime($chamado['data_inicio_execucao']));

					echo '<tr>
							<td>'.$chamado['id_chamado'].'</td>
							<td>'.$tipoChamado['nome'].'</td>
							<td><b>'.$dataAbertura.'</b></td>
							<td><b>'.$dataInicioExecucao.'</b></td>
							<td>'.$chamado['titulo'].'</td>
							<td>'.$chamado['descricao'].'</td>
							<td>'.$solicitante['nome'].'</td>
							<td>'.$setor['nome'].'</td>
							<td>'.$setor['telefone'].'</td>
							<td><button onclick="comentario('.$chamado['id_chamado'].')">Comentários</button></td>
							<td> <button onclick="resolver('.$chamado['id_chamado'].')">Resolver</button> </td>
						</tr>';
				}
				echo '</table>';
			}
		}

		$resultados = $bd->query("SELECT * FROM chamado WHERE status = '2'");
		if ($resultados->num_rows > 0) {
			echo'<h2>Chamados resolvidos</h2>
				<table>
					<tr>
						<th>ID</th>
						<th>Tipo</th>
						<th>Data abertura</th>
						<th>Data de início de execução</th>
						<th>Data de finalização</th>
						<th>Titulo</th>
						<th>Descrição</th>
						<th>Solicitante</th>
						<th>Setor</th>
						<th>Telefone</th>
						<th></th>
					</tr>';

			while ($chamado = mysqli_fetch_array($resultados)) {
				$idTipoChamado = $chamado['id_tipo_chamado'];
				$tipoChamado =  mysqli_fetch_array($bd->query("SELECT nome FROM tipo_chamado WHERE id_tipo_chamado = '$idTipoChamado'"));

				$idSolicitante = $chamado['id_solicitante'];
				$solicitante = mysqli_fetch_array($bd->query("SELECT * FROM usuario WHERE id_usuario = '$idSolicitante'"));

				$idSetorSolicitante = $solicitante['setor'];
				$setor = mysqli_fetch_array($bd->query("SELECT * FROM setor WHERE id_setor = '$idSetorSolicitante'"));

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
						<td>'.$solicitante['nome'].'</td>
						<td>'.$setor['nome'].'</td>
						<td>'.$setor['telefone'].'</td>
						<td><button onclick="comentario('.$chamado['id_chamado'].')">Comentários</button></td>
					</tr>';
			}
			echo '</table>';
		}

		$resultados = $bd->query("SELECT * FROM chamado WHERE status = '3'");
		if ($resultados->num_rows > 0) {
			echo'<h2>Chamados cancelados</h2>
				<table>
					<tr>
						<th>ID</th>
						<th>Tipo</th>
						<th>Data abertura</th>
						<th>Data de cancelamento</th>
						<th>Titulo</th>
						<th>Descrição</th>
						<th>Solicitante</th>
						<th>Setor</th>
						<th>Telefone</th>
						<th></th>
					</tr>';

			while ($chamado = mysqli_fetch_array($resultados)) {
				$idTipoChamado = $chamado['id_tipo_chamado'];
				$sqlTipoChamado =  mysqli_fetch_array($bd->query("SELECT nome FROM tipo_chamado WHERE id_tipo_chamado = '$idTipoChamado'"));
				$tipoChamado = $sqlTipoChamado['nome'];

				$idSolicitante = $chamado['id_solicitante'];
				$solicitante = mysqli_fetch_array($bd->query("SELECT * FROM usuario WHERE id_usuario = '$idSolicitante'"));

				$idSetorSolicitante = $solicitante['setor'];
				$setor = mysqli_fetch_array($bd->query("SELECT * FROM setor WHERE id_setor = '$idSetorSolicitante'"));


				$dataAbertura = date("d/m/Y", strtotime($chamado['data_abertura']));
				$dataFinalizacao = date("d/m/Y", strtotime($chamado['data_finalizacao']));

				echo '<tr>
						<td>'.$chamado['id_chamado'].'</td>
						<td>'.$tipoChamado.'</td>
						<td>'.$dataAbertura.'</td>
						<td>'.$dataFinalizacao.'</td>
						<td>'.$chamado['titulo'].'</td>
						<td>'.$chamado['descricao'].'</td>
						<td>'.$solicitante['nome'].'</td>
						<td>'.$setor['nome'].'</td>
						<td>'.$setor['telefone'].'</td>
						<td><button onclick="comentario('.$chamado['id_chamado'].')">Comentários</button></td>
					</tr>';
			}
			echo '</table>';
		}
	?>
</body>
</html>
