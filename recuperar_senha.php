<?php 
require_once("lib/raelgc/view/Template.php");
require_once("conectar_bd.php");


use raelgc\view\Template;

$tpl = new Template("html/tpl-recuperar_senha.html");

require_once("conectar_bd.php");


	if (isset($_POST['enviar_email'])) {
		$email = $_POST['email'];
		$data_envio = date('d/m/Y');
		$hora_envio = date('H:i:s');

		$sql_email = mysqli_query($config,"SELECT * FROM cadastro_usuario WHERE '$email' = login");
		$email_dados = mysqli_fetch_object($sql_email);
		$id_email = $email_dados->id_usuario;
		$email_result = mysqli_num_rows($sql_email);
		// 0 = não usado -- 1 = usado
		$usado = 0;

		if ($email_result==1) {
			$cod_criptografado = md5(time());

			//$id_email = 21;
			//$data = 30-09-2019;
			//$hora = 14:26:21;
			//$cod_criptografado = KASDJ123123;

			$insert = mysqli_query($config, "INSERT INTO recupera_senha (cod_criptografado, id_usuario, usado) VALUES ('$cod_criptografado', '$id_email', '$usado')");
		// Compo E-mail
			$arquivo = "
			<html lang=\"pt-br\">
			<meta charset=\"utf-8\">
			<h4>Ola guerreiro sabemos o quanto e ruim esquecer de uma senha, mas nao se preocupe que vamos redefenir ela para voce, para isto basta clicar no link a baixo que sera redirecionado para uma pagina de troca de senha, ate mais abracos!</h4>
			<a href=\"http://nickweb.com.br/sistema_tcc1/nova_senha?token=$cod_criptografado\">Clique aqui para redefinir a senha.</a>
			
			</html>
			";

//enviar

// emails para quem será enviado o formulário
			$emailenviar = $email;
			$destino = $emailenviar;
			$assunto = "Recuperacao de Senha.";

// É necessário indicar que o formato do e-mail é html
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= '<'.$email.'>';
//$headers .= "Bcc: $EmailPadrao\r\n";

			$enviaremail = mail($destino, $assunto, $arquivo, $headers);

							//$erro = mysqli_error($config);
			echo "<script>alert('Um e-mail de recuperação de senha foi enviado para sua caixa de entrada, verifique-a!');</script>";
				//echo " <meta http-equiv='refresh' content='0;URL= recuperar_senha'>";
			
		}else{
			echo "<script>alert('O e-mail informado está incorreto parça, verifique-o e tente novamente!');</script>";
		}
	}
mysqli_close($config);
$tpl->show();
?>