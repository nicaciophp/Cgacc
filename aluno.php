<?php
require_once("tpl-inicial.php");
// Carrega conteudo da pagina
if($tpl->exists("TPL_CONTAINER")) $tpl->addFile("TPL_CONTAINER", "html/tpl-aluno.html");

session_start();
if (isset($_SESSION["nome_usuario"]))
  $id_usuario = $_SESSION["id"];
$id_decript = criptografa(decrip, $id_usuario);

$sql_usuario = mysqli_query($config, "SELECT * FROM cadastro_usuario WHERE id_usuario = $id_decript");
$retorna_usuario = mysqli_fetch_object($sql_usuario);
$id_curso = $retorna_usuario->id_curso;

$sql_curso = mysqli_query($config, "SELECT * FROM curso WHERE id_curso=$id_curso");

foreach ($sql_curso as $r) :
  $id = $r['id_curso'];
  $nome = $r['nome'];
  if($tpl->exists("NOME_CURSO")) $tpl->NOME_CURSO = "<option value=\"$id\">$nome</option>";

  $tpl->block("BLOCK_CURSO");
endforeach;

if (isset($_POST['enviar_aluno'])) {
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $matricula = $_POST['matricula'];
  $turma = $_POST['turma'];
  $curso = $_POST['curso'];

  $sql_insert_aluno = mysqli_query($config, "INSERT INTO aluno (matricula, nome, email, turma, id_curso) VALUES ('$matricula', '$nome', '$email', '$turma','$curso')");

  echo "<script>alert('Dados enviados com sucesso!');</script>";
  echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=aluno'>";
}
$sql_sel_aluno = mysqli_query($config, "SELECT * FROM aluno WHERE id_curso=$id_curso");

foreach ($sql_sel_aluno as $r) :
	$id = $r['id_aluno'];
	$nome = $r['nome'];
	$email = $r['email'];
	$matricula = $r['matricula'];
  $turma = $r['turma'];
	if($tpl->exists("ID")) $tpl->ID = $id;
	if($tpl->exists("NOME")) $tpl->NOME = $nome;
	if($tpl->exists("EMAIL")) $tpl->EMAIL = $email;
  if($tpl->exists("MATRICULA")) $tpl->MATRICULA = $matricula;
  if($tpl->exists("TURMA")) $tpl->TURMA = $turma;

	if($tpl->exists("EDITAR")) $tpl->EDITAR = "<button class=\"btn btn-info btn-sm\" data-toggle=\"modal\" data-target=\"#editar_aluno_modal\" data-whatevernome = \"$nome\" data-whateveremail=\"$email\" data-whatevermatricula=\"$matricula\" data-whateverturma=\"$turma\" data-whatever=\"$id\">Editar</button>";

	if($tpl->exists("EXCLUIR")) $tpl->EXCLUIR = "<button class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#excluir_aluno_modal\" data-whatever=\"$id\">Excluir</button>";

  if($tpl->exists("VISUALIZAR")) $tpl->VISUALIZAR = "<a href=\"visualiza?id=$id\" class=\"btn btn-primary btn-sm\">Visualizar</a>";

	$tpl->block("BLOCK_ALUNO");
endforeach;
require_once("tpl-final.php");
?>
