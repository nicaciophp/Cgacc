<?php
function mysqli_result($res,$row=0,$col=0){
    $numrows = mysqli_num_rows($res);
    if ($numrows && $row <= ($numrows-1) && $row >=0){
        mysqli_data_seek($res,$row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])){
            return $resrow[$col];
        }
    }
    return false;
}
session_start();
if (isset($_SESSION["nome_usuario"]))
	$nome_usuario = $_SESSION["nome_usuario"];
if (isset($_SESSION["senha_usuario"]))
	$senha_usuario = $_SESSION["senha_usuario"];
if (!(empty($nome_usuario)OR empty($senha_usuario))) {
	include('conectar_bd.php');
	$resultado = mysqli_query($config, "SELECT * FROM cadastro_usuario WHERE login = '$nome_usuario'");
	$lista = mysqli_fetch_object($resultado);
	$id_bd = $lista->id_usuario;
	//$status = $lista->status;
	/*if($status == "1"){
		header("Location: tela_login");
		exit;
	}*/
		if (mysqli_num_rows($resultado) == 1) {
			if ($senha_usuario != mysqli_result($resultado, 0, "senha")) {
				unset($_SESSION['nome_usuario']);
				unset($_SESSION['senha_usuario']);
				header("Location: tela_login");
				exit;
				}
			}else{
				unset($_SESSION['nome_usuario']);
				unset($_SESSION['senha_usuario']);
				header("Location: tela_login");
				exit;
			}
		}else{
			header("Location: tela_login");
			exit;
		}
//mysqli_close($config);
?>
