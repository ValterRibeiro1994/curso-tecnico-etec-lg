<?php

require_once('../template/templateResultado.php');

session_start();

$template = new TemplateResultado();
echo($template->criarTemplateResultado($_SESSION));

// limpa os dados da sessão apos finalizar processo
// $_SESSION = [];
