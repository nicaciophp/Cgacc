<?php
require_once('php/conectar_bd.php');
require_once("lib/raelgc/view/Template.php");
use raelgc\view\Template;
$tpl = new Template("html/tela_login.html");


//$entrar = $_POST['entrar'];
//$verificaSenha = $senha;//sha1($senha);

$username = $_POST["login"];
$senha = $_POST["senha"];
$verifica = mysqli_query($config, "SELECT * FROM cadastro_usuario WHERE login = '$username' AND senha = '$senha'") or die("erro ao selecionar");
if (mysqli_num_rows($verifica)<=0){
	echo $tpl->ERRO = "Login ou Senha incorretos!";
  echo"<script language='javascript' type='text/javascript'>window.location.href='tela_login.php';</script>";
  die();
}else {
	setcookie("login",$username);
	header("Location:index.php");
}

mysqli_close($config);
?>
