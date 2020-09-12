<?php
require_once("tpl-inicial.php");
// Carrega conteudo da pagina
if($tpl->exists("TPL_CONTAINER")) $tpl->addFile("TPL_CONTAINER", "html/curso.html");

session_start();
if (isset($_SESSION["nome_usuario"]))
  $id_usuario = $_SESSION["id"];
$id_decript = criptografa(decrip, $id_usuario);

$sql_usuario = mysqli_query($config, "SELECT * FROM cadastro_usuario WHERE id_usuario = $id_decript");
$retorna_usuario = mysqli_fetch_object($sql_usuario);
$id_curso = $retorna_usuario->id_curso;

$sql_sel_curso = mysqli_query($config, "SELECT * FROM curso WHERE id_curso=$id_curso");

foreach ($sql_sel_curso as $r) :
	$id = $r['id_curso'];
	$nome = $r['nome'];
	$ch_acc = $r['ch_acc'];
	if($tpl->exists("ID")) $tpl->ID = $r['id_curso'];
	if($tpl->exists("NOME")) $tpl->NOME = $r['nome'];
	if($tpl->exists("CH_ACC")) $tpl->CH_ACC = $r['ch_acc'];

	if($tpl->exists("EDITAR")) $tpl->EDITAR = "<button class=\"btn btn-info btn-sm\" data-toggle=\"modal\" data-target=\"#editar_cursos_modal\" data-whatevernome = \"$nome\" data-whateverchacc=\"$ch_acc\" data-whatever=\"$id\">Editar</button>";

	if($tpl->exists("EXCLUIR")) $tpl->EXCLUIR = "<button class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#excluir_curso_modal\" data-whatever=\"$id\">Excluir</button>";

	$tpl->block("BLOCK_CURSO");
endforeach;
require_once("tpl-final.php");
?>
