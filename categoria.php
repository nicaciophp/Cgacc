<?php
require_once("tpl-inicial.php");
// Carrega CURSOS e exibe no select da tela do arquivo tpl-categoria
if($tpl->exists("TPL_CONTAINER")) $tpl->addFile("TPL_CONTAINER", "html/tpl-categoria.html");

session_start();
if (isset($_SESSION["nome_usuario"]))
  $id_usuario = $_SESSION["id"];
$id_decript = criptografa(decrip, $id_usuario);

$sql_usuario = mysqli_query($config, "SELECT * FROM cadastro_usuario WHERE id_usuario = $id_decript");
$retorna_usuario = mysqli_fetch_object($sql_usuario);
$id_curso = $retorna_usuario->id_curso;

$sql_categoria = mysqli_query($config,"SELECT tipo, nome, ch_maxima FROM categoria, cat_curso, curso WHERE cat_curso.id_curso = curso.id_curso AND cat_curso.id_categoria = categoria.id_categoria AND cat_curso.id_curso=$id_curso");
foreach ($sql_categoria as $r) {
	$categoria = $r['tipo'];
	$curso = $r['nome'];
	$ch_maxima = $r['ch_maxima'];
	if($tpl->exists("CATEGORIA")) $tpl->CATEGORIA = "$categoria";
	if($tpl->exists("CURSO")) $tpl->CURSO = "$curso";
	if($tpl->exists("CH_MAXIMA")) $tpl->CH_MAXIMA = "$ch_maxima";

	$tpl->block("BLOCK_CATEGORIA");
}


$sql_sel_curso = mysqli_query($config, "SELECT * FROM curso WHERE id_curso=$id_curso");

foreach ($sql_sel_curso as $r) {
	$id = $r['id_curso'];
	$nome = $r['nome'];
	if($tpl->exists("NOME_CURSO")) $tpl->NOME_CURSO = "<option value=\"$id\">$nome</option>";

	$tpl->block("BLOCK_CURSO");
}
if (isset($_POST['enviar_categoria'])) {
	$categoria = $_POST['categoria'];
	$id_curso =  $_POST['curso'];
	$ch_maxima = $_POST['ch_maxima'];

	//pega o nome do curso e concatena com o nome da categoria para depois inserir na tabela categoria
	$sql_curso = mysqli_query($config, "SELECT * FROM curso WHERE $id_curso = id_curso");
	$retorna_dados = mysqli_fetch_object($sql_curso);
	$nome_curso = $retorna_dados->nome;
	

	$sql_insert = mysqli_query($config, "INSERT INTO categoria (tipo) VALUES ('$categoria')");

	//Retorna o ULTIMO id cadastrado na tebale categoria
	$sql = "SELECT LAST_INSERT_ID()"; // consulta
	$con = mysqli_query($config,$sql) or die ("PROBLEMAS COM A CONSULTA; ".mysqli_error()); // enviamos a consulta ao SGBD
	$res = mysqli_fetch_row($con); // recuperamos o que for retornado em um array - $res
	$id_categoria = $res[0];

	//MUDADO CH_MAXIMA PARA CAT_CURSO
	$sql_insert_ch_max = mysqli_query($config, "INSERT INTO cat_curso (id_curso, id_categoria, ch_maxima) VALUES ('$id_curso', '$id_categoria', '$ch_maxima')");

	echo "<script>alert('Dados enviados com sucesso!')</script>";
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=categoria\">";	
	}
	require_once("tpl-final.php");
	?>
