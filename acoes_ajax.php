<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: text/html; charset=ISO-8859-1",true); 
require_once('conectar_bd.php');
//header("Content-Type: text/html; charset=ISO-8859-1",true);
//ação do arquivo curso.php e curso.html
//exclui curso
ini_set('default_charset','UTF-8');
if(isset($_POST["excluir_curso"])){

	$id_curso = $_POST['id_excluir_curso'];
	mysqli_query($config, "DELETE FROM curso WHERE id_curso LIKE '$id_curso'");
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=curso\">";
}
//exclui aluno arquivo tpl-aluno.html e aluno.php
if(isset($_POST["excluir_aluno"])){

	$id_aluno = $_POST['id_excluir_aluno'];
	mysqli_query($config, "DELETE FROM aluno WHERE id_aluno LIKE '$id_aluno'");
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=aluno?id=$id_aluno\">";
}
//ação do arquivo curso.php
//edita curso
if (isset($_POST['enviar_curso'])) {
	$altera_nome = $_POST['nome'];
	$altera_ch_acc = $_POST['ch_acc'];
	$id = $_POST['id_curso'];

	mysqli_query($config, "UPDATE curso SET nome = '$altera_nome' WHERE id_curso = $id");
	mysqli_query($config,"UPDATE curso SET ch_acc = '$altera_ch_acc' WHERE id_curso =$id");

	echo "<script>alert('Dados alterado com sucesso!');</script>";
	echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=curso'>";
}
//edita aluno arquivo tpl-aluno.html aluno.php
if (isset($_POST['enviar_aluno'])) {
	$altera_nome = $_POST['nome'];
	$altera_email = $_POST['email'];
	$altera_matricula = $_POST['matricula'];
	$altera_turma = $_POST['turma'];
	$id = $_POST['id_aluno'];

	mysqli_query($config,"UPDATE aluno SET matricula = '$altera_matricula' WHERE id_aluno =$id");
	mysqli_query($config,"UPDATE aluno SET nome = '$altera_nome' WHERE id_aluno = $id");
	mysqli_query($config,"UPDATE aluno SET email = '$altera_email' WHERE id_aluno =$id");
	mysqli_query($config,"UPDATE aluno SET turma = '$altera_turma' WHERE id_aluno =$id");

	echo "<script>alert('Dados alterados com sucesso!');</script>";
	echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=aluno?id=$id'>";
}

//mostra dados do aluno na tela de lançar acc
if(isset($_POST["aluno"])){
	$id_aluno = $_POST['aluno'];

	$sql_select = mysqli_query($config, "SELECT * FROM aluno WHERE $id_aluno = id_aluno");
	$retorna_dados = mysqli_fetch_array($sql_select);
	$nome_aluno = $retorna_dados['nome'];
	$email_aluno = $retorna_dados['email'];
	$turma_aluno = $retorna_dados['turma'];
	$matricula_aluno = $retorna_dados['matricula'];
	$ch_aprovada = $retorna_dados['ch_aprovada'];
	$id_curso = $retorna_dados['id_curso'];

	$sql_curso = mysqli_query($config, "SELECT * FROM curso WHERE $id_curso = id_curso");
	$retorna_dados_curso = mysqli_fetch_array($sql_curso);
	$nome_curso = $retorna_dados_curso['nome'];
	$ch_acc_curso = $retorna_dados_curso['ch_acc'];

	$faltam_ch = $ch_acc_curso - $ch_aprovada;

	echo "<div class=\"row\">";
	echo "<div class=\"col\">";

	echo "<b>Nome:</b> ".utf8_decode($nome_aluno)."<br>";
	echo "<b>E-Mail:</b> ".$email_aluno."<br>";
	echo "<b>Turma:</b> ".$turma_aluno."<br>";
	echo utf8_decode("<b>Matrícula:</b> ").$matricula_aluno."<br>";
	echo "<b>Curso:</b> ".utf8_decode($nome_curso)."<br>";
	echo utf8_decode("<b>Carga Horária Aprovada:</b> ").$ch_aprovada."<br>";

	if($ch_acc_curso >= $ch_aprovada){
		echo "<b>Faltam:</b> ".$faltam_ch." horas <br>";
	}else{
		echo "<b>Faltam:</b> 0 horas <br>";
	}

	if ($ch_acc_curso >= $ch_aprovada) {
		echo "Faltam ".$faltam_ch." de ".$ch_acc_curso.utf8_decode(" horas para completar a carga horária. <br>");
	}else {
		echo "Este aluno completou a carga horária de ACC'S de ".$ch_acc_curso." horas, ele esta com o total de ".$ch_aprovada." horas. <br>";
	}
	echo "</div>";

	echo "<div class=\"col\">";
	$sql_categoria = mysqli_query($config,"SELECT
		CAT.TIPO, SUM(ACC.CH_APROVEITADA) AS TOTAL_POR_CAT, CAT.ID_CATEGORIA
		FROM
		categoria CAT, -- ALUNO ALU,
		atividade ATV, acc ACC
		WHERE	
		ACC.ID_ALUNO 	 = $id_aluno AND
		ACC.ID_ATIVIDADE = ATV.ID_ATIVIDADE AND
		ATV.ID_CATEGORIA = CAT.ID_CATEGORIA 
		GROUP BY
		CAT.TIPO");
	echo "<table class=\"table table-sm\">";
	while ($r_categoria = mysqli_fetch_array($sql_categoria)) {
		$id_categoria = $r_categoria['ID_CATEGORIA'];
		$nome_categoria = utf8_decode($r_categoria['TIPO']);
		//$ch_maxima = $r_categoria['ch_maxima'];
		$total_por_cat = $r_categoria['TOTAL_POR_CAT'];

		echo "<tr class=\"table-secondary\"><td><b><h5>".$nome_categoria."</h5></b></td> <td><h5>".$total_por_cat." horas </h5></td></tr>";


		$sql_atividade = mysqli_query($config, "SELECT
			ATV.NOME_DESC_TITULO, ACC.CH_APROVEITADA
			FROM
			atividade ATV, acc ACC-- , aluno ALU,
			WHERE
			ATV.ID_ATIVIDADE = ACC.ID_ATIVIDADE AND
			ACC.ID_ALUNO = $id_aluno AND 
			ATV.ID_CATEGORIA = $id_categoria");

		while ($r_atividade = mysqli_fetch_array($sql_atividade)){
			$nome_atividade = utf8_decode($r_atividade['NOME_DESC_TITULO']);
			$ch_aproveitada = $r_atividade['CH_APROVEITADA'];

			echo "<tr><td>".$nome_atividade."</td><td>".$ch_aproveitada." horas</td></tr> ";
		}
	}
	echo "</table>";
	
	echo "</div>";
	echo "</div>";
	//echo "<meta http-equiv=\"refresh\" content=\"0;URL=aluno?id=$id_aluno\">";
}
mysqli_close($config);
?>