<?php
include('valida_sessao.php');
require_once("lib/raelgc/view/Template.php");
require_once("php/conectar_bd.php");
require_once("php/encripta.php");

use raelgc\view\Template;

//cria a variavel de template
$tpl = new Template("html/index.html");

if($tpl->exists("TPL_CAB")) $tpl->addFile("TPL_CAB", "html/tpl-cab.html");
//abre sessão e pega ID do usuario logado, onde será usado em algumas situações.
session_start();
if (isset($_SESSION["nome_usuario"]))
	$id_usuario = $_SESSION["id"];
//$teste = "teste";

//função que decripta o id com o arquivo php/encripta.php
$id_decript = criptografa(decrip, $id_usuario);

//pega o id do banco e retorna o nome de usuario para exibier no home.
$sql_select = mysqli_query($config, "SELECT * FROM cadastro_usuario WHERE id_usuario = '$id_decript'");
$retorna_dados = mysqli_fetch_object($sql_select);
$nome_usuario = $retorna_dados->nome;

if($tpl->exists("ID_USUARIO")) $tpl->ID_USUARIO =  $id_usuario;
if($tpl->exists("NOME_USUARIO")) $tpl->NOME_USUARIO =  $nome_usuario;

if($tpl->exists("TPL_PE")) $tpl->addFile("TPL_PE", "html/tpl-pe.html");
?>
