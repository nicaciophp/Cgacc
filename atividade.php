<?php
require_once("tpl-inicial.php");
// Carrega conteudo da pagina
if($tpl->exists("TPL_CONTAINER")) $tpl->addFile("TPL_CONTAINER", "html/tpl-atividade.html");

session_start();
if (isset($_SESSION["nome_usuario"]))
  $id_usuario = $_SESSION["id"];
$id_decript = criptografa(decrip, $id_usuario);

$sql_usuario = mysqli_query($config, "SELECT * FROM cadastro_usuario WHERE id_usuario = $id_decript");
$retorna_usuario = mysqli_fetch_object($sql_usuario);
$id_curso_2 = $retorna_usuario->id_curso;

$sql_atividade = mysqli_query($config, "SELECT nome_desc_titulo, data_inicio, data_final, instituicao_local, ch, tipo FROM atividade, categoria, cat_curso WHERE atividade.id_categoria=categoria.id_categoria AND cat_curso.id_categoria=categoria.id_categoria AND cat_curso.id_curso=$id_curso_2");
foreach ($sql_atividade as $r) {
	$atividade = $r['nome_desc_titulo'];
	$data_inicio = $r['data_inicio'];
	$data_final = $r['data_final'];
	$instituicao = $r['instituicao_local'];
	$ch = $r['ch'];
	$categoria = $r['tipo'];

	if($tpl->exists("ATIVIDADE")) $tpl->ATIVIDADE = "$atividade";
	if($tpl->exists("DATA")) $tpl->DATA = "$data_inicio - $data_final";
	if($tpl->exists("INSTITUICAO")) $tpl->INSTITUICAO = "$instituicao";
	if($tpl->exists("CH")) $tpl->CH = "$ch";
	if($tpl->exists("CATEGORIA")) $tpl->CATEGORIA = "$categoria";

	$tpl->block("BLOCK_ATIVIDADE");
}

$sql_categoria = mysqli_query($config, "SELECT * FROM categoria, cat_curso WHERE categoria.id_categoria=cat_curso.id_categoria AND cat_curso.id_curso=$id_curso_2");
foreach ($sql_categoria as $r) {
	$id = $r['id_categoria'];
	$nome = $r['tipo'];

	//MUDADO CH_MAXIMA PARA CAT_CURSO
	$sql_ch_max = mysqli_query($config, "SELECT * FROM cat_curso WHERE $id = id_categoria");
	$retorna_max = mysqli_fetch_object($sql_ch_max);
	$ch_max = $retorna_max->ch_maxima;
	$id_curso = $retorna_max->id_curso;

	$sql_curso = mysqli_query($config,"SELECT * FROM curso WHERE $id_curso = id_curso");
	$retorna_curso = mysqli_fetch_object($sql_curso);
	$curso = $retorna_curso->nome;

	if($tpl->exists("NOME_CATEGORIA")) $tpl->NOME_CATEGORIA = "<option value=\"$id\">$nome - $curso, $ch_max horas</option>";

	$tpl->block("BLOCK_CATEGORIA");
}

if ($_POST['enviar_atividade']) {
	$nome = $_POST['nome'];
	$instituicao = $_POST['instituicao'];
	$data_inicio = $_POST['data_inicio'];
	$data_fim = $_POST['data_fim'];
	$ch = $_POST['ch'];
	$id_categoria = $_POST['id_categoria'];

	$sql_insert = mysqli_query($config, "INSERT INTO atividade (nome_desc_titulo, data_inicio, data_final, instituicao_local, ch, id_categoria) VALUES ('$nome', '$data_inicio', '$data_fim', '$instituicao', '$ch', '$id_categoria')");
	
	echo "<script>alert('Dados enviados com sucesso!')</script>";
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=atividade\">";
}
if ($_POST['cadastrar_atividade']) {
	$nome = $_POST['nome'];
	$instituicao = $_POST['instituicao'];
	$data_inicio = $_POST['data_inicio'];
	$data_fim = $_POST['data_fim'];
	$ch = $_POST['ch'];
	$id_categoria = $_POST['id_categoria'];

	$sql_insert = mysqli_query($config, "INSERT INTO atividade (nome_desc_titulo, data_inicio, data_final, instituicao_local, ch, id_categoria) VALUES ('$nome', '$data_inicio', '$data_fim', '$instituicao', '$ch', '$id_categoria')");
	
	echo "<script>alert('Dados enviados com sucesso!')</script>";
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=lancar-acc\">";
}
require_once("tpl-final.php");
?>
