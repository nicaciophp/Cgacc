<?php 
$token = $_GET['token'];

require_once("lib/raelgc/view/Template.php");
require_once("conectar_bd.php");
require_once("php/encripta.php");

use raelgc\view\Template;
$tpl = new Template("html/tpl-nova_senha.html");

$sql_hash = mysqli_query($config, "SELECT * FROM recupera_senha WHERE '$token' = cod_criptografado");
$retorna_hash = mysqli_fetch_object($sql_hash);
$usado = $retorna_hash->usado;


if($tpl->exists("TOKEN")) $tpl->TOKEN = $token;

if ($usado == 0) {
	$limite = strtotime($data_hora_recupera.' +24 hours');
	if($limite > time()){
		if (isset($_POST['enviar_senha'])) {
			$senha_nova = $_POST['senha'];
			$codifica_senha = criptografa(crip, $senha_nova);
			$hash = $_POST['token'];

			$sql_hash_2 = mysqli_query($config, "SELECT * FROM recupera_senha WHERE '$hash' = cod_criptografado");
			$retorna_hash_2 = mysqli_fetch_object($sql_hash_2);
			$num_linhas = mysqli_num_rows($sql_hash_2);
			$id_usuario = $retorna_hash_2->id_usuario;

			if ($num_linhas >=1) {
				mysqli_query($config, "UPDATE cadastro_usuario SET senha = '$codifica_senha' WHERE $id_usuario=id_usuario ");
				mysqli_query($config, "UPDATE recupera_senha SET usado = 1 WHERE $id_usuario=id_usuario ");

				echo "<script>alert('Senha alterada com sucesso!');</script>";

				echo " <meta http-equiv='refresh' content='0;URL= tela_login'>";
			}else{
				echo "<script>alert('O token está incorreto clique no link e tente novamente!');</script>";
				echo " <meta http-equiv='refresh' content='0;URL= recuperar_senha'>";
			}
			
		}
	}else{
		echo "<script>alert('O tempo limite de 24 horas já foi excedido, por favor faça uma nova requisição de recuperação de senha!');</script>";
	}
}else{
	echo "<script>alert('Esse código de recuperação de senha já foi utilizado, faça uma nova requisição e tente novamente');</script>";
	echo " <meta http-equiv='refresh' content='0;URL= recuperar_senha'>";
}

$tpl->show();
mysqli_close($config);
exit();
?>