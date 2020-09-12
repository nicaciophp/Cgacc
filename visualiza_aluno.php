<?php
require_once("tpl-inicial.php");
// Carrega conteudo da pagina
if($tpl->exists("TPL_CONTAINER")) $tpl->addFile("TPL_CONTAINER", "html/tpl-visualiza-aluno.html");
require_once("tpl-final.php");
?>