<?php 
require_once("tpl-inicial.php");

// Carrega conteudo da pagina
if($tpl->exists("TPL_CONTAINER")) $tpl->addFile("TPL_CONTAINER", "html/tpl-alterar_dados.html");
session_start();

//descriptografa o id do usuario com a função criptografa() do arquivo php/encripta.php
$id_usuario = criptografa(decrip, $_SESSION['id']);

if (isset($_POST['alterar_dados'])) {
	$nome = $_POST['nome'];
	$curso = $_POST['nome_curso'];
	$ch_acc = $_POST['ch_acc'];
	$login = $_POST['login'];
	$senha = $_POST['senha'];
	$conf_senha = $_POST['conf-senha'];
	//$conf_senha = $_POST['conf-senha'];
	$conta_senha = strlen($conf_senha);

	

	$sql_curso = mysqli_query($config, "SELECT curso.id_curso, curso.nome FROM curso, cadastro_usuario WHERE curso.id_curso = cadastro_usuario.id_curso AND cadastro_usuario.id_usuario = $id_usuario");
	$retorna_curso = mysqli_fetch_object($sql_curso);
	$id_curso = $retorna_curso->id_curso;

	$sql_email_existe = mysqli_query($config, "SELECT * FROM cadastro_usuario WHERE '$login'=login");
	$email_existe = mysqli_num_rows($sql_email_existe);

	$sql_curso_existe = mysqli_query($config, "SELECT * FROM curso WHERE '$curso' = nome");
	$curso_existe = mysqli_num_rows($sql_curso_existe);
	if ($curso_existe >= 1) {
		if($tpl->exists("CURSO_EXISTE")) $tpl->CURSO_EXISTE = "<div class=\"border-bottom-danger\">Lamento mas esse curso já existe em nossa base de dados, verifique com o responsável e tente novamente.</div>";
	}elseif (empty($curso)) {
		if($tpl->exists("CURSO_VAZIO")) $tpl->CURSO_VAZIO = "<div class=\"border-bottom-danger\">Este campo é obrigatório.</div>";
	}elseif ($email_existe>=1) {
		if($tpl->exists("EMAIL_EXISTE")) $tpl->EMAIL_EXISTE = "<div class=\"border-bottom-danger\">Lamento mas esse e-mail já existe em nossa base de dados, escolha outro e tente novamente.</div>";
	}elseif (empty($login)) {
		if($tpl->exists("EMAIL_VAZIO")) $tpl->EMAIL_VAZIO = "<div class=\"border-bottom-danger\">Este campo é obrigatório.</div>";
	}elseif (empty($nome)) {
		if($tpl->exists("NOME_VAZIO")) $tpl->NOME_VAZIO = "<div class=\"border-bottom-danger\">Este campo é obrigatório.</div>";
	}elseif ($conta_senha < 8) {
		if($tpl->exists("SENHA_FRACA")) $tpl->SENHA_FRACA = "<div class=\"border-bottom-danger\">A senha escolhida é fraca escolha uma igual ou maior que 8 caracteres.</div>";
	}elseif ($conf_senha <> $senha) {
		if($tpl->exists("ERRO_SENHA")) $tpl->ERRO_SENHA = "<div class=\"border-bottom-danger\">As senha não estão iguais, por favor corrija e tente novamente. </div>";
	}elseif (empty($ch_acc)) {
		if($tpl->exists("CH_VAZIO")) $tpl->CH_VAZIO = "<div class=\"border-bottom-danger\">Este campo é obrigatório.</div>";
	}else{
		mysqli_query($config, "UPDATE curso SET nome = '$curso' WHERE $id_curso=id_curso");
		mysqli_query($config, "UPDATE cadastro_usuario SET login = '$login' WHERE $id_usuario=id_usuario");
		mysqli_query($config, "UPDATE cadastro_usuario SET nome = '$nome' WHERE $id_usuario=id_usuario ");
		$senha_crip = criptografa(crip, $conf_senha);
		mysqli_query($config, "UPDATE cadastro_usuario SET senha = '$senha_crip' WHERE $id_usuario=id_usuario ");
		mysqli_query($config, "UPDATE curso SET ch_acc = '$ch_acc' WHERE $id_curso=id_curso ");

		echo "<script>alert('Dados alterados com sucesso!');</script>";
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=tela_login\">";
	}

}
require_once("tpl-final.php");
?>