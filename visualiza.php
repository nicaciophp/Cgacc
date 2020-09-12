<?php 
include('valida_sessao.php');
require_once('conectar_bd.php');
require_once("php/encripta.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: text/html; charset=ISO-8859-1",true); 

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
?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Registro de ACC</title>

	<!-- Custom fonts for this template-->
	<link href="./vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!--LINK para SELECT search -->
	<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css" />-->
	<link href="./css/bootstrap-select.min.css" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="./css/sb-admin-2.min.css" rel="stylesheet">
	<!-- Custom styles for this page -->
	<link href="./vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

			<!-- Sidebar - Brand -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="home-<?php echo $id_usuario; ?>">
				<div class="sidebar-brand-icon rotate-n-15">
					<i class="fas fa-at"></i>
				</div>
				<div class="sidebar-brand-text mx-3">Registro de ACC</div>
			</a>

			<!-- Divider -->
			<hr class="sidebar-divider my-0">

			<!-- Nav Item - Dashboard -->
			<li class="nav-item">
				<a class="nav-link" href="home">
					<i class="fas fa fa-home"></i>
					<span>Inicio</span></a>
				</li>

				<!-- Nav Item - Curso -->
				<li class="nav-item">
					<a class="nav-link" href="curso">
						<i class="fas fa-atlas"></i>
						<span>Curso</span></a>
					</li>

					<!-- Nav Item - Aluno -->
					<li class="nav-item">
						<a class="nav-link" href="aluno">
							<i class="far fa-angry"></i>
							<span>Aluno</span></a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="categoria">
								<i class="fas fa fa-server"></i>
								<span>Categoria</span></a>
							</li>

							<!-- Nav Item - Atividade -->
							<li class="nav-item">
								<a class="nav-link" href="atividade">
									<i class="fas fa-address-card"></i>
									<span>Atividade</span></a>
								</li>

								<!-- Nav Item - Lançar ACC -->
								<li class="nav-item">
									<a class="nav-link" href="lancar-acc">
										<i class="fas fa-file-alt"></i>
										<span>Lançar ACC</span></a>
									</li>

									<!-- Divider -->
									<hr class="sidebar-divider d-none d-md-block">

									<!-- Sidebar Toggler (Sidebar) -->
									<div class="text-center d-none d-md-inline">
										<button class="rounded-circle border-0" id="sidebarToggle"></button>
									</div>

								</ul>
								<!-- End of Sidebar -->

								<!-- Content Wrapper -->
								<div id="content-wrapper" class="d-flex flex-column">

									<!-- Main Content -->
									<div id="content">

										<!-- Topbar -->
										<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

											<!-- Sidebar Toggle (Topbar) -->
											<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
												<i class="fa fa-bars"></i>
											</button>

											<!-- Topbar Navbar -->
											<ul class="navbar-nav ml-auto">

												<!-- Nav Item - User Information -->
												<li class="nav-item dropdown no-arrow">
													<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nome_usuario; ?></span>
													</a>
													<!-- Dropdown - User Information -->
													<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
														<a class="dropdown-item" href="./alterar_dados">
															<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
															Alterar Dados
														</a>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item" href="sair.php" data-toggle="modal" data-target="#logoutModal">
															<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
															Sair
														</a>
													</div>
												</li>

											</ul>

										</nav>
										<!-- End of Topbar -->

										<!-- Begin Page Content -->
										<div class="container-fluid">

											<?php

											$id_aluno = $_GET['id'];
											echo "<div class=\"row\">
											<div class=\"col-6\">
											<div class=\"card shadow mb-4\">
											<div class=\"card-header py-3\">
											<h6 class=\"m-0 font-weight-bold text-primary\">Dados do Aluno</h6>
											</div>
											<div class=\"card-body\">
											";
											$sql_select = mysqli_query($config, "SELECT id_aluno, aluno.nome AS nome_aluno, email, matricula, turma, curso.nome AS nome_curso FROM aluno, curso WHERE aluno.id_aluno = '$id_aluno' AND aluno.id_curso = curso.id_curso");
											$r = mysqli_fetch_array($sql_select);

											$id = $r['id_aluno'];
											$nome = $r['nome_aluno'];
											$email = $r['email'];
											$matricula = $r['matricula'];
											$turma = $r['turma'];
											$nome_curso = $r['nome_curso'];
											echo "<label><b>Nome:</b> </label> ".utf8_decode($nome)."<br>";
											echo "<label><b>E-Mail:</b> </label> ".$email."<br>";
											echo "<label><b>Matricula:</b> </label> ".$matricula."<br>";
											echo "<label><b>Turma:</b> </label> ".$turma."<br>";
											echo "<label><b>Curso:</b> </label> ".utf8_decode($nome_curso);
											echo "
											</div>
											</div>
											</div>
											<div class=\"col-6\">
											<div class=\"card shadow mb-4\">
											<div class=\"card-header py-3\">
											<h6 class=\"m-0 font-weight-bold text-primary\">Atividades Complementares</h6>
											</div>
											<div class=\"card-body\">
											";

											$sql_categoria = mysqli_query($config,"SELECT
												CAT.TIPO, SUM(ACC.CH_APROVEITADA) AS TOTAL_POR_CAT, CAT.ID_CATEGORIA
												FROM
												categoria CAT, -- ALUNO ALU,
												atividade ATV, acc ACC
												WHERE	
												ACC.ID_ALUNO 	 = $id_aluno AND
												ACC.ID_ATIVIDADE = ATV.ID_ATIVIDADE AND
												ATV.ID_CATEGORIA = CAT.ID_CATEGORIA 
												GROUP BY
												CAT.TIPO");
											echo "<table class=\"table table-sm\">";
											foreach ($sql_categoria as $r_categoria) {
												$id_categoria = $r_categoria['ID_CATEGORIA'];
												$nome_categoria = $r_categoria['TIPO'];
												//$ch_maxima = $r_categoria['ch_maxima'];
												$total_por_cat = $r_categoria['TOTAL_POR_CAT'];

												echo "<tr class=\"table-secondary\"><td><b><h5>".utf8_decode($nome_categoria)."</h5></b></td> <td><h5>".$total_por_cat." horas </h5></td></tr>";


												$sql_atividade = mysqli_query($config, "SELECT
													ATV.NOME_DESC_TITULO, ACC.CH_APROVEITADA
													FROM
													atividade ATV, acc ACC-- , aluno ALU,
													WHERE
													ATV.ID_ATIVIDADE = ACC.ID_ATIVIDADE AND
													ACC.ID_ALUNO = $id_aluno AND 
													ATV.ID_CATEGORIA = $id_categoria");

												foreach ($sql_atividade as $r_atividade){
													$nome_atividade = $r_atividade['NOME_DESC_TITULO'];
													$ch_aproveitada = $r_atividade['CH_APROVEITADA'];

													echo "<tr><td>".utf8_decode($nome_atividade)."</td><td>".$ch_aproveitada." horas</td></tr> ";
												}
											}
											echo "</table>";
											echo"
											</div>
											</div>
											</div>
											</div>
											";
//VISUALIZA ALUNO
/*
require_once("tpl-inicial.php");
// Carrega conteudo da pagina
if($tpl->exists("TPL_CONTAINER")) $tpl->addFile("TPL_CONTAINER", "html/tpl-visualiza.html");
$id_aluno = $_GET['id'];

$sql_select = mysqli_query($config, "SELECT id_aluno, aluno.nome AS nome_aluno, email, matricula, turma, curso.nome AS nome_curso FROM aluno, curso WHERE aluno.id_aluno = '$id_aluno' AND aluno.id_curso = curso.id_curso");
$r = mysqli_fetch_array($sql_select);

$id = $r['id_aluno'];
$nome = $r['nome_aluno'];
$email = $r['email'];
$matricula = $r['matricula'];
$turma = $r['turma'];
$nome_curso = $r['nome_curso'];

if($tpl->exists("ID")) $tpl->ID = $id;
if($tpl->exists("NOME")) $tpl->NOME = $nome;
if($tpl->exists("EMAIL")) $tpl->EMAIL = $email;
if($tpl->exists("MATRICULA")) $tpl->MATRICULA = $matricula;
if($tpl->exists("TURMA")) $tpl->TURMA = $turma;
if($tpl->exists("CURSO")) $tpl->CURSO = $nome_curso;
*/
//$sql_categoria = mysqli_query($config,"SELECT * FROM categoria");


		//if($tpl->exists("CATEGORIA")) $tpl->CATEGORIA = $nome_categoria;
		//if($tpl->exists("CH_MAXIMA")) $tpl->CH_MAXIMA = $ch_maxima;

/*$sql_atividade = mysqli_query($config, "SELECT nome_desc_titulo, ch_aproveitada, id_categoria FROM acc, atividade WHERE acc.id_aluno = $id_aluno AND acc.id_atividade = atividade.id_atividade");
foreach ($sql_atividade as $r_atividade) {
	$nome_atividade = $r_atividade['nome_desc_titulo'];
	$ch_aproveitada = $r_atividade['ch_aproveitada'];
	$id_categoria = $r_atividade['id_categoria'];

	$sql_categoria = mysqli_query($config, "SELECT DISTINCT * FROM categoria WHERE id_categoria = $id_categoria GROUP BY tipo");
	$r_categoria = mysqli_fetch_array($sql_categoria);
	$id_cat = $r_categoria['id_categoria'];
	$nome_categoria = $r_categoria['tipo'];

	if($tpl->exists("ATIVIDADE")) $tpl->ATIVIDADE = $nome_atividade. " - ".$id_categoria;

	//if($tpl->exists("CATEGORIA")) $tpl->CATEGORIA = $nome_categoria;
	//if($tpl->exists("ATIVIDADE")) $tpl->ATIVIDADE = $nome_atividade. " - ".$id_categoria;		

	$tpl->block("BLOCK_ATIVIDADE");
}*/

//$sql_categoria = mysqli_query($config, "SELECT categoria.id_categoria, tipo FROM categoria WHERE ");
/*
$sql_categoria = mysqli_query($config,"SELECT DISTINCT categoria.id_categoria, tipo, ch_maxima, nome_desc_titulo FROM acc, atividade, categoria, cat_curso WHERE acc.id_aluno = $id_aluno AND acc.id_atividade = atividade.id_atividade AND atividade.id_categoria = categoria.id_categoria AND cat_curso.id_categoria = categoria.id_categoria");
foreach ($sql_categoria as $r_categoria) {
	$id_categoria = $r_categoria['id_categoria'];
	$nome_categoria = $r_categoria['tipo'];
	$ch_maxima = $r_categoria['ch_maxima'];
	$nome_atividade = $r_categoria['nome_desc_titulo'];


	if($tpl->exists("CATEGORIA")) $tpl->CATEGORIA = $nome_categoria;
	if($tpl->exists("ATIVIDADE")) $tpl->ATIVIDADE = $nome_atividade;
	$tpl->block("BLOCK_CATEGORIA");
}

require_once("tpl-final.php");
*/
echo file_get_contents("html/tpl-pe.html");
mysqli_close($config);
?>
