<?php

session_start();
require_once './src/Model/Usuario.php';
require_once './src/Model/Task.php';
require_once './src/Controller/CommonController.php';
require_once './src/Controller/TaskController.php';
require_once './src/Controller/UsuarioController.php';

class UsuarioController extends CommonController{

	private $modulos = array();
	private $classe = 'Usuario';
	private $breadcrumb = array();
	private $titulo_principal = '';

	public function __construct(){
	    $usuario = new Usuario();
	    $usuario->common = new CommonController();
	    $modulos = $usuario->common->getModulos();
	    $this->modulos = $modulos;

	    $modulo_posicao = array_search($this->classe, array_column($modulos, 'modulo'));
	    $this->titulo_principal = $modulos[$modulo_posicao];
	    $this->breadcrumb = array('TaskList' => URL . 'usuario/listar/', $this->titulo_principal['descricao'] => URL . $this->classe . '/listar/');
	}

	public function login($msg = ''){
	    if (!empty($msg)){
			$msg_error = $msg;
	    }
	    $token = md5(uniqid(rand(), true));
	    require './src/View/Usuario/usuario_login.php';
	}

	public function logoff(){
	    $this->clearLoginInfo();
	    require './src/View/Usuario/usuario_login.php';
	}

	public function index(){
	    $usuario = new Usuario();
	    $task = new TaskController();
	    if (isset($_SESSION['_loginInfo']) && !empty($_SESSION['_loginInfo'])){
			$modulos = $this->modulos;
			$classe = $this->classe;
			$task->listar();
			return;
	    }
	    $usuarios = $usuario->logar($_POST);

	    $codigo_usuario = $usuarios->id;

	    if (isset($codigo_usuario) && !empty($codigo_usuario) && $codigo_usuario > 0){
			$_SESSION['_loginInfo'] = $usuarios;
			$modulos = $this->modulos;
			$classe = $this->classe;
			$task->listar();
	    }
	    else{
			$this->login('Usuário ou senha inválido!');
	    }
	}

	public function listar(){
	    $usuario = new Usuario();
	    $usuario->common = new CommonController();

	    $coluna = '';
	    $buscar = '';
	    $pagina_atual = 1;
	    if ($this->validateGet('parametros'))
		{
			$re = "/^[a-z]+=/";
			preg_match($re, $this->validateGet('parametros'), $matches);
			$acao = str_replace('=', '', $matches[0]);

			$re = "/=([a-zA-Z].*)\|([A-Za-z0-9].*)$/";
			preg_match($re, $this->validateGet('parametros'), $matches);

			switch ($acao) {
				case 'buscar':
					if (isset($matches[1])){
						$coluna = str_replace('=', '', $matches[1]);
					}
					if (isset($matches[2])){
						$buscar = str_replace('=', '', $matches[2]);
					}
				
				case 'listar':
					$pagina_atual = str_replace('=', '', $matches[2]);
				break;					
			}
	    }

	    $linha_inicial = ($pagina_atual - 1) * QTDE_REGISTROS;
	    $num_registros = $usuario->listarTodosTotal();

	    /* Idêntifica a primeira página */
	    $primeira_pagina = 1;
	    /* Cálcula qual será a última página */
	    $ultima_pagina = ceil($num_registros / QTDE_REGISTROS);
	    /* Cálcula qual será a página anterior em relação a página atual em exibição */
	    $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual - 1 : 0;
	    /* Cálcula qual será a proxima página em relação a página atual em exibição */
	    $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual + 1 : 0;
	    /* Cálcula qual será a página inicial do nosso range */
	    $range_inicial = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1;
	    /* Cálcula qual será a página final do nosso range */
	    $range_final = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina ) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina;
	    /* Verifica se vai exibir o botão "Primeiro" e "Proximo" */
	    $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';
	    /* Verifica se vai exibir o botão "Anterior" e "Último" */
	    $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';
	    $arrCamposBusca = array('nome' => 'Nome');
	    $usuarios = $usuario->listarTodos($pagina_atual, $linha_inicial, $coluna, $buscar);
		$task = new Task();
		foreach($usuarios as $usuario){
			$tasksDoUsuario = $task->listarTasksDoUsuario($usuario->id);
			count($tasksDoUsuario);
			$usuario->podeRemover = (count($tasksDoUsuario) == 0);
		}
		
	    $titulo_principal = $this->titulo_principal;
	    $breadcrumb = $this->breadcrumb;
	    $modulos = $this->modulos;
	    $classe = $this->classe;
	    require './src/View/Usuario/usuario_listar.php';
	}

	public function listarUsuario($idUsuario = 0){
	    $usuario = new Usuario();
	    if ($idUsuario > 0) {
			$usuarios = $usuario->listarUsuario($idUsuario);
	    }
	    return $usuarios;
	}

	public function editarUsuario($infoUsuario){
	    $usuario = new Usuario();
	    if (isset($infoUsuario) && !empty($infoUsuario)){
			$retorno = $usuario->editarUsuario($infoUsuario);
			if (is_array($retorno)){
				$msg_erro = $retorno['erro'];
				$GLOBALS['msg_erro'] = $msg_erro;
			}
			else{
				$msg_sucesso = 'Usuário cadastrado com sucesso.';
				$GLOBALS['msg_sucesso'] = $msg_sucesso;
			}
			$usuarios = $usuario->listarUsuario($retorno);
	    }
	    return $usuarios;
	}

	public function editar($handle){
	    $msg_sucesso = '';
	    $metodo = 'editar';
	    $usuario = new Usuario();
	    $usuario->common = new CommonController();
	    if (isset($_POST) && !empty($_POST)){
			$retorno = $usuario->editarUsuario($_POST);
			if (is_array($retorno)){
				$msg_erro = $retorno['erro'];
				$GLOBALS['msg_erro'] = $msg_erro;
			}
			else{
				$msg_sucesso = $this->classe . ' alterado com sucesso.';
				$GLOBALS['msg_sucesso'] = $msg_sucesso;
			}
	    }
	    $usuarios = new Usuario();
	    $usuarios = $usuario->listarUsuario($handle);

	    $titulo_principal = $this->titulo_principal;
	    $breadcrumb = $this->breadcrumb;
	    $modulos = $this->modulos;
	    $classe = $this->classe;
	    require './src/View/Usuario/usuario_form.php';
	}

	public function cadastrarNovoUsuario(){
		$infoUsuario = $_POST;
	    $usuario = new Usuario();
	    if (isset($infoUsuario) && !empty($infoUsuario)) {
			$retorno = $usuario->cadastrarUsuario($infoUsuario);
			if (is_array($retorno)) {
				$msg_erro = $retorno['erro'];
				$GLOBALS['msg_erro'] = $msg_erro;
				require './src/View/Usuario/usuario_formNovo.php';
			}
			else {
				$msg_sucesso = 'Cadastrado efetuado com sucesso.';
				$GLOBALS['msg_sucesso'] = $msg_sucesso;
				require './src/View/Usuario/usuario_login.php';
			}
	    }
		else{
			require './src/View/Usuario/usuario_formNovo.php';
		}
	}	
	
	public function cadastrarUsuario($infoUsuario){
	    $usuario = new Usuario();
	    if (isset($infoUsuario) && !empty($infoUsuario)) {
			$retorno = $usuario->cadastrarUsuario($infoUsuario);
			if (is_array($retorno)){
				$msg_erro = $retorno['erro'];
				$GLOBALS['msg_erro'] = $msg_erro;
			}
			else{
				$msg_sucesso = 'Usuário cadastrado com sucesso.';
				$GLOBALS['msg_sucesso'] = $msg_sucesso;
			}
			$usuarios = $usuario->listarUsuario($retorno);
	    }
	    return $usuarios;
	}

	public function cadastrar(){
	    $msg_sucesso = '';
	    $usuarios = '';
	    $metodo = 'cadastrar';

	    $usuario = new Usuario();
	    if (isset($_POST) && !empty($_POST)){
			$retorno = $usuario->cadastrarUsuario($_POST);
			if (is_array($retorno)){
				$msg_erro = $retorno['erro'];
				$GLOBALS['msg_erro'] = $msg_erro;
			}
			else{
				$msg_sucesso = 'Usuário cadastrado com sucesso.';
				$GLOBALS['msg_sucesso'] = $msg_sucesso;
			}
			$usuarios = $usuario->listarUsuario($retorno);
		}
	    else {
			$usuarios = array($usuario);
	    }

	    $titulo_principal = $this->titulo_principal;
	    $breadcrumb = $this->breadcrumb;
	    $modulos = $this->modulos;
	    $classe = $this->classe;
	    require './src/View/Usuario/usuario_form.php';
	}

	public function removerUsuario($handle){
	    $usuario = new Usuario();
	    if ($handle > 0){
			$retorno = $usuario->removerUsuario($handle);
			if (is_array($retorno))	{
				$msg_erro = $retorno['erro'];
				$GLOBALS['msg_erro'] = $msg_erro;
			}
			else{
				$msg_sucesso = $this->classe . ' removido com sucesso.';
				$GLOBALS['msg_sucesso'] = $msg_sucesso;
			}
	    }
	}

	public function remover(){
	    $metodo = 'remover';
	    $usuario = new Usuario();
	    $usuario->common = new CommonController();
	    if (isset($_GET['handle']) && !empty($_GET['handle'])){
			$retorno = $usuario->removerUsuario($_GET['handle']);
			if (is_array($retorno))	{
				$msg_erro = $retorno['erro'];
				$GLOBALS['msg_erro'] = $msg_erro;
			}
			else{
				$msg_sucesso = $this->classe . ' removido com sucesso.';
				$GLOBALS['msg_sucesso'] = $msg_sucesso;
			}
	    }
	    $titulo_principal = $this->titulo_principal;
	    $breadcrumb = $this->breadcrumb;
	    $modulos = $this->modulos;
	    $classe = $this->classe;
	    $this->listar();
	}

}

?>
