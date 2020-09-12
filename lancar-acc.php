<?php
require_once("tpl-inicial.php");

if($tpl->exists("TPL_CONTAINER")) $tpl->addFile("TPL_CONTAINER", "html/tpl-lancar-acc.html");

//SELECIONA O ALUNO RELACIONADO AO CURSO DO USUARIO LOGADO NO SISTEMA
session_start();
if (isset($_SESSION["nome_usuario"]))
	$id_usuario = $_SESSION["id"];
$id_decript = criptografa(decrip, $id_usuario);

$sql_usuario = mysqli_query($config, "SELECT * FROM cadastro_usuario WHERE id_usuario = $id_decript");
$retorna_usuario = mysqli_fetch_object($sql_usuario);
$id_curso = $retorna_usuario->id_curso;

$sql_aluno = mysqli_query($config, "SELECT * FROM aluno WHERE id_curso = $id_curso");
//$sql_atividade = mysqli_query($config, "SELECT * FROM atividade");
$sql_categoria = mysqli_query($config, "SELECT * FROM categoria");

while($r = mysqli_fetch_array($sql_aluno)) {
	$id_aluno = $r['id_aluno'];
	$nome_aluno = $r['nome'];
	if($tpl->exists("NOME_ALUNO")) $tpl->NOME_ALUNO = "<option value=\"$id_aluno\">$nome_aluno</option>";

	$tpl->block("BLOCK_ALUNO");
}


while($r_cat = mysqli_fetch_array($sql_categoria)) {
	$id_categoria = $r_cat['id_categoria'];
	$nome_categoria = $r_cat['tipo'];
	if($tpl->exists("NOME_CATEGORIA")) $tpl->NOME_CATEGORIA = "<option value=\"$id_categoria\">$nome_categoria</option>";

	$tpl->block("BLOCK_CATEGORIA");
}

if (isset($_POST['enviar'])) {
	$aluno = $_POST['id_aluno'];
	$id_atividade = $_POST['id_atividade'];
	$ch_aproveitada = $_POST['ch_aproveitada'];

	$sql_ch_atual = mysqli_query($config, "SELECT * FROM aluno WHERE $aluno = id_aluno");
	$retorna_dados = mysqli_fetch_array($sql_ch_atual);
	$ch_atual = $retorna_dados['ch_aprovada'];
	//$ch_soma = $ch_aproveitada + $ch_atual;

	mysqli_query($config,"UPDATE aluno SET ch_aprovada = '$ch_soma' WHERE id_aluno = $aluno");

	//MUDADO CH_APROVEITADA PARA ACC
	mysqli_query($config, "INSERT INTO acc (id_aluno, id_atividade, ch_aproveitada) VALUES ('$aluno', '$id_atividade', '$ch_aproveitada')");
	echo "<script>alert('Dados enviados com sucesso!')</script>";
}
require_once("tpl-final.php");
?>
