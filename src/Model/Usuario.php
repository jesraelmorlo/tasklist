<?php

    require_once('conexao.php');
    require_once('bd.php');

    class Usuario
    {

	public $id;
	public $nome;
	public $email;
	public $senha;
	public $nom_tabela = 'sis_usuarios';
	private $order_by_default = ' nome ';

	public function __construct()
	{
	    $this->id = "";
	    $this->nome = "";
	    $this->email = "";
	    $this->senha = "";
	}

	public function listarTodos($pagina_atual = 0, $linha_inicial = 0, $coluna = '', $buscar = '')
	{
	    $pdo = Conexao::getInstance();

	    $crud = bd::getInstance($pdo, $this->nom_tabela);

	    $where = '';
	    if ($coluna != '' && $buscar != '')
	    {
		$where = sprintf(' WHERE %s LIKE UPPER("%%%s%%") ', $coluna, strtoupper($buscar));
	    }

	    $paginacao = 'LIMIT ' . QTDE_REGISTROS;
	    if ($pagina_atual > 0 && $linha_inicial > 0)
	    {
		$paginacao = " LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
	    }

	    $sql = "SELECT e.* FROM " . $this->nom_tabela . " e " .
		    $where . " ORDER BY " . $this->order_by_default . $paginacao;
	    $dados = $crud->getSQLGeneric($sql);

	    return $dados;
	}

	public function listarTodosTotal()
	{
	    $pdo = Conexao::getInstance();

	    $crud = bd::getInstance($pdo, $this->nom_tabela);

	    $sql = "SELECT count(*) as total_registros FROM " . $this->nom_tabela;

	    $dados = $crud->getSQLGeneric($sql, null, FALSE);

	    return $dados->total_registros;
	}

	public function listarUsuario($handle)
	{
	    $pdo = Conexao::getInstance();

	    $crud = bd::getInstance($pdo, $this->nom_tabela);

	    $sql = "SELECT e.* FROM " . $this->nom_tabela . " e " .
		    " WHERE e.id = ?";
	    $arrayParam = array($handle);

	    $dados = $crud->getSQLGeneric($sql, $arrayParam, TRUE);

	    return $dados;
	}

	public function removerUsuario($id)
	{
	    $pdo = Conexao::getInstance();
	    if ($id > 0)
	    {
		$crud = bd::getInstance($pdo, $this->nom_tabela, true);
		$retorno = $crud->delete($id);
	    }

	    return $retorno;
	}

	public function editarUsuario($post)
	{
	    $pdo = Conexao::getInstance();

	    $arrayUsuario = array();
	    foreach ($post as $key => $value) {
		if ($key != 'handle' && $key != 'id')
		{
		    $arrayUsuario[$key] = $value;
		    // Se for o campo senha mas o usuário não informou a senha, então, não vai alterá-la
		    if ($key == 'senha' && $value != '')
			$arrayUsuario[$key] = md5($value);
		    else if ($key == 'senha' && $value == '')
			unset($arrayUsuario[$key]);
		}
	    }

	    $crud = bd::getInstance($pdo, $this->nom_tabela, TRUE);

	    $arrayCond = array('id=' => $post['handle']);
	    $retorno = $crud->update($arrayUsuario, $arrayCond);

	    return $retorno;
	}

	public function cadastrarUsuario($post)
	{
	    $pdo = Conexao::getInstance();

	    $arrayUsuario = array();

	    foreach ($post as $key => $value) {
		if ($key != 'handle' && $key != 'id')
		{
		    $arrayUsuario[$key] = $value;
		    // Se for o campo senha e o usuário informou a senha, então, converte para md5
		    if ($key == 'senha' && $value != '')
			$arrayUsuario[$key] = md5($value);
		}
	    }

	    $crud = bd::getInstance($pdo, $this->nom_tabela, true);

	    $retorno = $crud->insert($arrayUsuario);

	    return $retorno;
	    exit;
	}

	public function logar($post)
	{
	    $pdo = Conexao::getInstance();

	    $crud = bd::getInstance($pdo, $this->nom_tabela);

	    $sql = "SELECT id, nome, email FROM " . $this->nom_tabela . " WHERE email = ? AND senha = ?";

	    $arrayCond = array($post['usuario'], md5($post['senha']));

	    $dados = $crud->getSQLGeneric($sql, $arrayCond, FALSE);

	    return $dados;
	}

    }

?>
