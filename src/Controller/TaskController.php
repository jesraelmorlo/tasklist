<?php

    require_once './src/Model/Task.php';
    require_once './src/Controller/CommonController.php';

    class TaskController extends CommonController
    {

	private $modulos = array();
	private $status = array();
	private $classe = 'Task';
	private $breadcrumb = array();
	private $titulo_principal = '';

	public function __construct()
	{
	    $this->validarSessao();
	    $task = new Task();
	    $task->common = new CommonController();
	    $modulos = $task->common->getModulos();
	    $this->modulos = $modulos;
	    $status = $task->common->getTaskStatus();
	    $this->status = $status;		

	    $modulo_posicao = array_search($this->classe, array_column($modulos, 'modulo'));
	    $this->titulo_principal = $modulos[$modulo_posicao];
	    $this->breadcrumb = array('TaskList' => URL . 'dashboard/index/', $this->titulo_principal['descricao'] => URL . $this->classe . '/listar/');
	}

	public function listar()
	{
	    $task = new Task();
	    $task->common = new CommonController();

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
			if (isset($matches[1]))
			{
			    $coluna = str_replace('=', '', $matches[1]);
			}
			if (isset($matches[2]))
			{
			    $buscar = str_replace('=', '', $matches[2]);
			}
			break;

		    case 'listar':
			$pagina_atual = str_replace('=', '', $matches[2]);
		}
	    }

	    $linha_inicial = ($pagina_atual - 1) * QTDE_REGISTROS;

	    $num_registros = $task->listarTodosTotal();

	    /* Idêntifica a primeira página */
	    $primeira_pagina = 1;

	    /* Cálcula qual será a última página */
	    $ultima_pagina = ceil($num_registros / QTDE_REGISTROS);

	    /* Cálcula qual será a página anterior em relação a página atual em exibição */
	    $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual - 1 : 0;

	    /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */
	    $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual + 1 : 0;

	    /* Cálcula qual será a página inicial do nosso range */
	    $range_inicial = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1;

	    /* Cálcula qual será a página final do nosso range */
	    $range_final = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina ) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina;

	    /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */
	    $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';

	    /* Verifica se vai exibir o botão "Anterior" e "Último" */
	    $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';

	    $arrCamposBusca = array('titulo' => 'Titulo');

	    $tasks = $task->listarTodos($pagina_atual, $linha_inicial, $coluna, $buscar);
	    $titulo_principal = $this->titulo_principal;
	    $breadcrumb = $this->breadcrumb;
	    $modulos = $this->modulos;
	    $classe = $this->classe;
	    require './src/View/Task/task_listar.php';
	}

	public function listarTodasTasks()
	{
	    $task = new Task();
	    $tasks = $task->listarTodos($pagina_atual, $linha_inicial, $coluna, $buscar);
	    return $tasks;
	}

	public function editar($handle)
	{
	    $msg_sucesso = '';
	    $metodo = 'editar';
	    $task = new Task();
	    $task->common = new CommonController();
	    if (isset($_POST) && !empty($_POST)) {
			// Carregando a atual tarefa para setar a data de criação.
			$currentTask = $task->listarTask($_POST['handle']);
			$_POST['dataAlteracao'] = date('Y-m-d H:i:s');
			$_POST['dataCriacao'] = $currentTask[0]->dataCriacao;
			$_POST['usuario'] = $_SESSION['_loginInfo']->id;
			$retorno = $task->editarTask($_POST);
			if (is_array($retorno)){
				$msg_erro = $retorno['erro'];
				$GLOBALS['msg_erro'] = $msg_erro;
				require './src/View/Task/task_form.php';
			}
			else{
				$msg_sucesso = $this->classe . ' alterado com sucesso.';
				$GLOBALS['msg_sucesso'] = $msg_sucesso;
				$this->listar();
				return true;
			}
	    }
		$tasks = new Task();
		$tasks = $task->listarTask($handle);

		$titulo_principal = $this->titulo_principal;
		$breadcrumb = $this->breadcrumb;
		$modulos = $this->modulos;
		$classe = $this->classe;
		require './src/View/Task/task_form.php';
	}

	public function cadastrar(){
	    $msg_sucesso = '';
	    $tasks = '';
	    $metodo = 'cadastrar';

	    $task = new Task();
	    if (isset($_POST) && !empty($_POST)){
			$_POST['dataCriacao'] = date('Y-m-d H:i:s');
			$_POST['usuario'] = $_SESSION['_loginInfo']->id;
			$_POST['dataAlteracao'] = date('Y-m-d H:i:s');
			$retorno = $task->cadastrarTask($_POST);
			if (is_array($retorno)){
				$msg_erro = $retorno['erro'];
				$GLOBALS['msg_erro'] = $msg_erro;
			}
			else{
				$msg_sucesso = 'Task cadastrada com sucesso.';
				$GLOBALS['msg_sucesso'] = $msg_sucesso;
				$this->listar();
				return true;
			}
			$tasks = $task->listarTask($retorno);
	    }
	    else{
			$tasks = array($task);
	    }

	    $titulo_principal = $this->titulo_principal;
	    $breadcrumb = $this->breadcrumb;
	    $modulos = $this->modulos;
	    $classe = $this->classe;
	    require './src/View/Task/task_form.php';
	}

	public function remover()
	{
	    $metodo = 'remover';
	    $task = new Task();
	    $task->common = new CommonController();
	    if (isset($_GET['handle']) && !empty($_GET['handle']))
	    {
		$retorno = $task->removerTask($_GET['handle']);
		if (is_array($retorno))
		{
		    $msg_erro = $retorno['erro'];
		    $GLOBALS['msg_erro'] = $msg_erro;
		}
		else
		{
		    $msg_sucesso = $this->classe . ' removido com sucesso.';
		    $GLOBALS['msg_sucesso'] = $msg_sucesso;
		}
	    }
	    $titulo_principal = $this->titulo_principal;
	    $breadcrumb = $this->breadcrumb;
	    $modulos = $this->modulos;
	    $classe = $this->classe;
	    $this->listar();
	    //echo '<script>document.location = "' . URL . 'Task/listar/";</script>';
	}

    }

?>
