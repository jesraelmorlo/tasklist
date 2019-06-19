<?php

require_once('conexao.php');
require_once('bd.php');

class Task{

	public $id;
	public $titulo;
	public $status;
	public $descricao;
	public $dataCriacao;
	public $dataAlteracao;
	public $usuario;
	public $nom_tabela = 'sis_tasks';
	private $order_by_default = ' id desc, status ';

	public function __construct(){
	    $this->id = "";
	    $this->titulo = "";
	    $this->status = "A";
	    $this->descricao = "";
	    $this->dataCriacao = "";
	    $this->dataAlteracao = "";
	    $this->usuario = "";
	}

	public function listarTodos($pagina_atual = 0, $linha_inicial = 0, $coluna = '', $buscar = ''){
	    $pdo = Conexao::getInstance();
	    $crud = bd::getInstance($pdo, $this->nom_tabela);
	    $where = '';
	    if ($coluna != '' && $buscar != ''){
			$where = sprintf(' WHERE %s LIKE UPPER("%%%s%%") ', $coluna, strtoupper($buscar));
	    }

	    $paginacao = 'LIMIT ' . QTDE_REGISTROS;
	    if ($pagina_atual > 0 && $linha_inicial > 0)	    {
			$paginacao = " LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
	    }

	    $sql = "SELECT t.*, case t.status when 'A' then 'Aberto' when 'E' then 'Em andamento' when 'F' then 'Finalizado' end as statusDesc, u.nome as nomeUsuario, u.email as emailUsuario FROM " . $this->nom_tabela . " t " .
		    "LEFT JOIN sis_usuarios u on u.id = t.usuario " .
		$where . " ORDER BY " . $this->order_by_default . $paginacao;
	    $dados = $crud->getSQLGeneric($sql);
	    return $dados;
	}

	public function listarTodosTotal(){
	    $pdo = Conexao::getInstance();
	    $crud = bd::getInstance($pdo, $this->nom_tabela);
	    $sql = "SELECT count(*) as total_registros FROM " . $this->nom_tabela;
	    $dados = $crud->getSQLGeneric($sql, null, FALSE);
	    return $dados->total_registros;
	}

	public function listarTask($handle){
	    $pdo = Conexao::getInstance();
	    $crud = bd::getInstance($pdo, $this->nom_tabela);
	    $sql = "SELECT t.*, case t.status when 'A' then 'Aberto' when 'E' then 'Em andamento' when 'F' then 'Finalizado' end as statusDesc, u.nome as nomeUsuario, u.email as emailUsuario FROM " . $this->nom_tabela . " t " .
				"LEFT JOIN sis_usuarios u on u.id = t.usuario " .
		    " WHERE t.id = ?";
	    $arrayParam = array($handle);
	    $dados = $crud->getSQLGeneric($sql, $arrayParam, TRUE);
	    return $dados;
	}

	public function removerTask($id){
	    $pdo = Conexao::getInstance();
	    if ($id > 0) {
			$crud = bd::getInstance($pdo, $this->nom_tabela);
			$retorno = $crud->delete($id);
	    }
	    return $retorno;
	}

	public function editarTask($post){
	    $pdo = Conexao::getInstance();
	    $arrayTask = array();
	    foreach ($post as $key => $value) {
		if ($key != 'handle' && $key != 'id')
		    $arrayTask[$key] = $value;
	    }
	    $crud = bd::getInstance($pdo, $this->nom_tabela);
	    $arrayCond = array('id=' => $post['handle']);
	    $retorno = $crud->update($arrayTask, $arrayCond);
	    return $retorno;
	}

	public function cadastrarTask($post){
	    $pdo = Conexao::getInstance();
	    $arrayTask= array();
	    foreach ($post as $key => $value) {
		if ($key != 'handle' && $key != 'id')
		    $arrayTask[$key] = $value;
	    }
	    $crud = bd::getInstance($pdo, $this->nom_tabela);
	    $retorno = $crud->insert($arrayTask);
	    return $retorno;
	    exit;
	}
	
	public function listarTasksDoUsuario($idUsuario){
	    $pdo = Conexao::getInstance();
	    $crud = bd::getInstance($pdo, $this->nom_tabela);
	    $where = '';
	    if ($idUsuario > 0){
			$where = ' WHERE usuario = '. $idUsuario;
	    }

	    $sql = "SELECT t.*, case t.status when 'A' then 'Aberto' when 'E' then 'Em andamento' when 'F' then 'Finalizado' end as statusDesc, u.nome as nomeUsuario, u.email as emailUsuario FROM " . $this->nom_tabela . " t " .
		    "LEFT JOIN sis_usuarios u on u.id = t.usuario " .
		$where . " ORDER BY " . $this->order_by_default;
	    $dados = $crud->getSQLGeneric($sql);
	    return $dados;
	}	

}

?>
