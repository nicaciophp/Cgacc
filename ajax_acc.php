<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json; charset=utf-8');
require_once('conectar_bd.php');
if(isset($_POST["atividade"])){
	$id_aluno = $_POST['atividade'];
	$sql_atividade = mysqli_query($config, "SELECT
		ATV.ID_ATIVIDADE, ATV.NOME_DESC_TITULO, CAT.TIPO, ATV.CH
		FROM
		atividade ATV, categoria CAT, cat_curso CTC,
		aluno ALU, curso CU
		WHERE	
		ATV.ID_CATEGORIA = CAT.ID_CATEGORIA AND
		CAT.ID_CATEGORIA = CTC.ID_CATEGORIA AND
		CTC.ID_CURSO = ALU.ID_CURSO 		AND
		ALU.ID_CURSO = CU.ID_CURSO 			AND
		ALU.ID_ALUNO = $id_aluno");
		//$r_atividade = mysqli_fetch_object($sql_atividade);
		$teste = array();
	foreach ($sql_atividade as $r_atividade) {
		//$id_atividade = "1";
		$id_atividade = $r_atividade["ID_ATIVIDADE"];
		$nome_atividade = $r_atividade['NOME_DESC_TITULO'];
		$nome_categoria = $r_atividade['TIPO'];
		$ch = $r_atividade['CH'];

		//echo json_encode(array("id_atividade"=>$id_atividade));
		array_push($teste, array("nome_atividade"=>$nome_atividade, "nome_categoria"=>$nome_categoria, "ch"=>$ch, "id_atividade"=>$id_atividade));
			
		//echo "<br>";
		//echo $id_atividade;
	}
	$json_str = json_encode($teste, true);
	echo $json_str;

}
mysqli_close($config);
?>