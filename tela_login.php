<?php
//PAGINA DE LOGIN
require_once('php/conectar_bd.php');
require_once("lib/raelgc/view/Template.php");
require_once('php/encripta.php');

use raelgc\view\Template;

$tpl = new Template("html/tela_login.html");

//CRIA UMA SESSÃO
session_start();
if (isset($_POST['entrar'])) {

$id = $_GET['id'];
$username = $_POST["login"];
$senha = $_POST["senha"];
$verificaSenha = criptografa(crip, $senha);//sha1($senha);

$sql = "SELECT * FROM cadastro_usuario WHERE login = '$username'";
$resultado = mysqli_query($config, $sql) or die ("PROBLEMAS COM A CONSULTA; ".mysqli_error());
$linhas = mysqli_num_rows($resultado);
$linhas1 = mysqli_fetch_object($resultado);
$senhaBD = $linhas1->senha;
$id_usuario = $linhas1->id_usuario;

//CRIPTOGRAFA O ID DO USUÁRIO E DEPOIS PASSA VIA GET PARA A URL
$id_criptografa = criptografa(crip, $id_usuario);

if (!empty($_POST) AND (empty($_POST['login']) OR empty($_POST['senha']))) {
	$_SESSION['loginErro'] = "<div class=\"border-bottom-danger\">Insira algo e tente novamente!</div>";
	header("Location: tela_login");
	exit;
}else{
	if ($linhas <=0) {
	$_SESSION['loginErro'] = "<div class=\"border-bottom-danger\">Login ou Senha inválidos!</div>";
	header("Location: tela_login");
	exit;
	}elseif ($verificaSenha <> $senhaBD) {
		$_SESSION['loginErro'] = "<div class=\"border-bottom-danger\">Login ou Senha inválidos!</div>";
		header("Location: tela_login");
		exit;
	}else{
		$_SESSION['nome_usuario'] = $username;
		$_SESSION['senha_usuario'] = $verificaSenha;
		$_SESSION['id'] = $id_criptografa;
		$_SESSION['nivel'] = $linhas1->nivel;
		//header ("Location: home?id=$id_usuario");
		//direciona para o arquivo home com o id criptografado.
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=home-$id_criptografa\">";
	}
  }
}
if (isset($_SESSION['loginErro'])) {
	if($tpl->exists("ERRO")) $tpl->ERRO =  $_SESSION['loginErro'];
    unset($_SESSION['loginErro']);
}
$tpl->show();
mysqli_close($config);
?>
