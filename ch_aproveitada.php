<?php
require_once('conectar_bd.php');

//$id_atividade = $_POST['atividade'];
$carga_horaria = $_POST['carga_horaria'];
$atividade = $_POST['atividade'];

$sql = mysqli_query($config, "SELECT * FROM atividade WHERE $atividade = id_atividade");
$retorna = mysqli_fetch_object($sql);

$ch_real = $retorna->ch;
$id_categoria = $retorna->id_categoria;

//$sql_categoria = mysqli_query($config, "SELECT * FROM ch_maxima WHERE $id_categoria = id_categoria");

if ($atividade == "") {
  echo "Por favor selecione a atividade!";
}elseif ($carga_horaria > $ch_real) {
  echo $ch_real;
}else{
  echo $carga_horaria;
}
mysqli_close($config);
 ?>
