<?php

    session_start();
    require_once 'config.php';

    if (!isset($_GET['class'])) {
		require_once './src/Controller/UsuarioController.php';
		$obj = new UsuarioController();
		$obj->login();
		die();
    }

    $classe = ucwords($_GET['class']);

    $metodo = 'listar';
    if (isset($_GET['acao'])) {
		$metodo = $_GET['acao'];
    }

    $handle = '';
    if (isset($_GET['handle'])) {
		$handle = $_GET['handle'];
    }
    elseif (isset($_POST['handle'])){
		$handle = $_POST['handle'];
    }

    $classe .= 'Controller';
    require_once './src/Controller/' . $classe . '.php';

    $obj = new $classe();
    if (!empty($handle)) {
		$obj->$metodo($handle);
    }
    else {
		$obj->$metodo();
    }
?>
