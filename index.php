<?php
mb_internal_encoding("UTF-8");

$controllerName = !empty($_GET['controller']) ? $_GET['controller'] : 'site';
$actionName = !empty($_GET['id']) ? 'view' : 'index';

require_once("views/$controllerName/$actionName.php");