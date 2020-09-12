<?php
require_once("conectar_bd.php");
require_once("php/encripta.php");
require_once("lib/raelgc/view/Template.php");
use raelgc\view\Template;

$tpl = new Template("html/tpl-cadastro-usuario.html");


if (isset($_POST['cadastrar'])) {
  $nome = $_POST['nome'];
  $login = $_POST['login'];
  $senha = $_POST['senha'];
  $conf_senha = $_POST['conf-senha'];
  $curso = $_POST['nome_curso'];
  $ch_acc = $_POST['ch_acc'];

  $conta_senha = strlen($senha);

  //seleciona a tablea cadastro_usuario onde a coluna é igual ao valor de $login
  $sql_select = mysqli_query($config, "SELECT * FROM cadastro_usuario WHERE login LIKE '%".$login."%'");
  $sql_nro_linhas = mysqli_num_rows($sql_select);

  //verifica se a senha é menor que 8 caracteres.
  if ($conta_senha < 8) {
    if($tpl->exists("SENHA_PEQUENA")) $tpl->SENHA_PEQUENA = "<div class=\"border-bottom-danger\">A senha escolhida é pequena escolha uma igual ou maior que 8 caracteres.</div>";
  //verifica se o número de linhas de login for maior ou igual a 1 e mostra msg de erro.
  }elseif ($sql_nro_linhas >= 1) {
    if($tpl->exists("LOGIN_DUPLICADO")) $tpl->LOGIN_DUPLICADO = "<div class=\"border-bottom-danger\">O login escolhido já existe, por favor escolha outro e tente novamente.</div>";
    //header("Location: cadastro-usuario");
    //verifica se senha é diferente e conf senha.
  }elseif ($senha <> $conf_senha) {
    if($tpl->exists("ERRO_SENHA")) $tpl->ERRO_SENHA = "<div class=\"border-bottom-danger\">As senha não estão iguais, por favor corrija e tente novamente. </div>";
  }elseif (empty($nome)) {
   if($tpl->exists("NOME_VAZIO")) $tpl->NOME_VAZIO = "<div class=\"border-bottom-danger\">Este campo é obrigatório.</div>";
  }elseif (empty($login)) {
    if($tpl->exists("LOGIN_VAZIO")) $tpl->LOGIN_VAZIO = "<div class=\"border-bottom-danger\">Este campo é obrigatório.</div>";
  }elseif (empty($curso)) {
    if($tpl->exists("CURSO_VAZIO")) $tpl->CURSO_VAZIO = "<div class=\"border-bottom-danger\">Este campo é obrigatório.</div>";
  }elseif (empty($ch_acc)) {
    if($tpl->exists("CH_VAZIO")) $tpl->CH_VAZIO = "<div class=\"border-bottom-danger\">Este campo é obrigatório.</div>";
  }else {
    $codifica_senha = criptografa(crip, $conf_senha);
    $sql_curso = mysqli_query($config, "INSERT INTO curso (nome, ch_acc) VALUES ('$curso', '$ch_acc')");
    //Retorna o ULTIMO id cadastrado para ser listado no arquivo abrecliente.php
    $sql = "SELECT LAST_INSERT_ID()"; // consulta
    $con = mysqli_query($config,$sql) or die ("PROBLEMAS COM A CONSULTA; ".mysqli_error()); // enviamos a consulta ao SGBD
    $res = mysqli_fetch_row($con); // recuperamos o que for retornado em um array - $res
    $curso_id=$res[0];


    $sql_insert = mysqli_query($config, "INSERT INTO cadastro_usuario (nome, login, senha, id_curso) VALUES ('$nome', '$login', '$codifica_senha','$curso_id')");

    echo "<script>alert('Usuario cadastrado com sucesso!');</script>";
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=tela_login\">";

    //exibe a mensgame de dados enviados.
    if ($sql_insert) {
      if($tpl->exists("DADOS_SUCESSO")) $tpl->DADOS_SUCESSO = "<br><div class=\"border-bottom-success\">Dados enviados com sucesso.</div>";
    }
  }
}
mysqli_close($config);
$tpl->show();
?>
