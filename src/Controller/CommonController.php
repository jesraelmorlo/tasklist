<?php

    class CommonController
    {

	protected function validarSessao()
	{
	    session_start();
	    if ($_SESSION['_loginInfo'] == null)
	    {
		echo '<script>document.location = "' . URL . '";</script>';
	    }
	}

	public function clearLoginInfo()
	{
	    unset($_SESSION['_loginInfo']);
	    unset($_SESSION['token']);
	}

	public function getModulos()
	{
	    $modulos[] = array('modulo' => 'Task', 'descricao' => 'Task', 'icone' => 'fa-tasks');
	    $modulos[] = array('modulo' => 'Usuario', 'descricao' => 'Usuário', 'icone' => 'fa-users');
	    return $modulos;
	}

	public function getSituacoes()
	{
	    $situacoes = array('A' => 'Ativo', 'I' => 'Inativo');
	    return $situacoes;
	}

	public function getTaskStatus()
	{
	    $status = array('A' => 'Aberto', 'E' => 'Em ndamento', 'F' => 'Finalizado');
	    return $status;
	}	
	
	public function validatePost($post)
	{
	    if (isset($_POST[$post]) && !empty($_POST[$post]))
	    {
		return $_POST[$post];
	    }
	    else
	    {
		return false;
	    }
	}

	public function validateGet($get)
	{
	    if (isset($_GET[$get]) && !empty($_GET[$get]))
	    {
		return $_GET[$get];
	    }
	    else
	    {
		return false;
	    }
	}

    }

?>