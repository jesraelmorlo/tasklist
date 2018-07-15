<?php

    class bd
    {

	private $pdo = null;
	private $handle;
	private $tabela = null;
	private static $crud = null;

	private function __construct($conexao, $tabela = NULL)
	{
	    if (!empty($conexao))
	    {
		$this->pdo = $conexao;
	    }
	    else
	    {
		echo "<h3>Conexão inexistente!</h3>";
		exit();
	    }

	    if (!empty($tabela))
		$this->tabela = $tabela;
	}

	public static function getInstance($conexao, $tabela = NULL, $forceNewInstance = false)
	{
	    // Verifica se existe uma instância da classe
	    if (!isset(self::$crud) || $forceNewInstance == true)
	    {
		try {
		    self::$crud = new bd($conexao, $tabela);
		}
		catch (Exception $e) {
		    echo "Erro: " . $e->getMessage();
		}
	    }
	    return self::$crud;
	}

	public function setTableName($tabela)
	{
	    if (!empty($tabela))
	    {
		$this->tabela = $tabela;
	    }
	}

	/*
	 * Método privado para construção da instrução SQL de INSERT   
	 * @param $arrayDados = Array de dados contendo colunas e valores   
	 * @return String contendo instrução SQL   
	 */

	private function buildInsert($arrayDados)
	{
	    // Inicializa variáveis
	    $sql = "";
	    $campos = "";
	    $valores = "";
	    //var_dump($this->tabela);exit;
	    // Loop para montar a instrução com os campos e valores
	    foreach ($arrayDados as $chave => $valor):
		$campos .= $chave . ', ';
		$valores .= '?, ';
	    endforeach;
	    // Retira vírgula do final da string
	    $campos = (substr($campos, -2) == ', ') ? trim(substr($campos, 0, (strlen($campos) - 2))) : $campos;

	    // Retira vírgula do final da string
	    $valores = (substr($valores, -2) == ', ') ? trim(substr($valores, 0, (strlen($valores) - 2))) : $valores;

	    // Concatena todas as variáveis e finaliza a instrução
	    $sql .= "INSERT INTO {$this->tabela} (" . $campos . ")VALUES(" . $valores . ")";

	    // Retorna string com instrução SQL
	    return trim($sql);
	}

	/*
	 * Método público para inserir os dados na tabela
	 * @param $arrayDados = Array de dados contendo colunas e valores
	 * @return Retorna resultado booleano da instrução SQL
	 */

	public function insert($arrayDados)
	{
	    try {
		// Atribui a instrução SQL construida no método
		$sql = $this->buildInsert($arrayDados);

		// Passa a instrução para o PDO
		$stm = $this->pdo->prepare($sql);

		// Loop para passar os dados como parâmetro
		$cont = 1;
		foreach ($arrayDados as $valor):
		    $stm->bindValue($cont, $valor);
		    $cont++;
		endforeach;
		// Executa a instrução SQL e captura o retorno
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$retorno = $stm->execute();

		if (!$retorno)
		{
		    echo "<p>" . $sql . "</p>";
		    exit;
		}

		$id = $this->pdo->lastInsertId();

		return $id;
	    }
	    catch (PDOException $e) {
		return $this->translateMessageError($e, $sql);
	    }
	}

	/*
	 * Método privado para construção da instrução SQL de UPDATE   
	 * @param $arrayDados = Array de dados contendo colunas, operadores e valores   
	 * @param $arrayCondicao = Array de dados contendo colunas e valores para condição WHERE   
	 * @return String contendo instrução SQL   
	 */

	private function buildUpdate($arrayDados, $arrayCondicao)
	{

	    // Inicializa variáveis
	    $sql = "";
	    $valCampos = "";
	    $valCondicao = "";

	    // Loop para montar a instrução com os campos e valores
	    foreach ($arrayDados as $chave => $valor):
		$valCampos .= $chave . '=?, ';
	    endforeach;

	    // Loop para montar a condição WHERE
	    foreach ($arrayCondicao as $chave => $valor):
		$valCondicao .= $chave . '? AND ';
	    endforeach;

	    // Retira vírgula do final da string
	    $valCampos = (substr($valCampos, -2) == ', ') ? trim(substr($valCampos, 0, (strlen($valCampos) - 2))) : $valCampos;

	    // Retira vírgula do final da string
	    $valCondicao = (substr($valCondicao, -4) == 'AND ') ? trim(substr($valCondicao, 0, (strlen($valCondicao) - 4))) : $valCondicao;

	    // Concatena todas as variáveis e finaliza a instrução
	    $sql .= "UPDATE {$this->tabela} SET " . $valCampos . " WHERE " . $valCondicao;

	    // Retorna string com instrução SQL
	    return trim($sql);
	}

	/*
	 * Método público para atualizar os dados na tabela   
	 * @param $arrayDados = Array de dados contendo colunas e valores   
	 * @param $arrayCondicao = Array de dados contendo colunas e valores para condição WHERE - Exemplo array('$id='=>1)   
	 * @return Retorna resultado booleano da instrução SQL   
	 */

	public function update($arrayDados, $arrayCondicao)
	{
	    try {

		// Atribui a instrução SQL construida no método
		$sql = $this->buildUpdate($arrayDados, $arrayCondicao);

		// Passa a instrução para o PDO
		$stm = $this->pdo->prepare($sql);

		// Loop para passar os dados como parâmetro
		$cont = 1;
		foreach ($arrayDados as $valor):
		    $stm->bindValue($cont, $valor);
		    $cont++;
		endforeach;

		// Loop para passar os dados como parâmetro cláusula WHERE
		foreach ($arrayCondicao as $valor):
		    $stm->bindValue($cont, $valor);
		    $cont++;
		endforeach;

		// Executa a instrução SQL e captura o retorno
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$retorno = $stm->execute();

		if (!$retorno)
		{
		    echo "<p>" . $sql . "</p>";
		    exit;
		}

		return $retorno;
	    }
	    catch (PDOException $e) {
		return $this->translateMessageError($e, $sql);
	    }
	}

	/*
	 * Método privado para construção da instrução SQL de DELETE
	 * @param $id = Id do registro para condição WHERE - Exemplo array('$id='=>1)
	 * @return String contendo instrução SQL
	 */

	private function buildDelete($id)
	{
	    // Inicializa variáveis
	    $sql = "";
	    // Concatena todas as variáveis e finaliza a instrução
	    $sql .= "DELETE FROM {$this->tabela}  WHERE id = " . $id;
	    // Retorna string com instrução SQL
	    return trim($sql);
	}

	/*
	 * Método público para remover registro da tabela
	 * @param $id = Id do registro para condição WHERE - Exemplo array('$id='=>1)
	 * @return Retorna resultado booleano da instrução SQL
	 */

	public function delete($id)
	{
	    try {

		// Atribui a instrução SQL construida no método
		$sql = $this->buildDelete($id);

		// Passa a instrução para o PDO
		$stm = $this->pdo->prepare($sql);

		// Loop para passar os dados como parâmetro
		$cont = 1;
		$stm->bindValue($id, $valor);

		// Executa a instrução SQL e captura o retorno
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$retorno = $stm->execute();

		if (!$retorno)
		{
		    echo "<p>" . $sql . "</p>";
		    exit;
		}

		return $retorno;
	    }
	    catch (PDOException $e) {
		return $this->translateMessageError($e, $sql);
	    }
	}

	/*
	 * Método genérico para executar instruções de consulta independente do nome da tabela passada no _construct
	 * @param $sql = Instrução SQL inteira contendo, nome das tabelas envolvidas, JOINS, WHERE, ORDER BY, GROUP BY e LIMIT
	 * @param $arrayParam = Array contendo somente os parâmetros necessários para clásusla WHERE
	 * @param $fetchAll  = Valor booleano com valor default TRUE indicando que serão retornadas várias linhas, FALSE retorna apenas a primeira linha
	 * @return Retorna array de dados da consulta em forma de objetos
	 */

	public function getSQLGeneric($sql, $arrayParams = null, $fetchAll = TRUE)
	{
	    try {

		// Passa a instrução para o PDO
		$stm = $this->pdo->prepare($sql);

		// Verifica se existem condições para carregar os parâmetros
		if (!empty($arrayParams)):
		    // Loop para passar os dados como parâmetro cláusula WHERE
		    $cont = 1;
		    foreach ($arrayParams as $valor):
			$stm->bindValue($cont, $valor);
			$cont++;
		    endforeach;

		endif;

		// Executa a instrução SQL
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stm->execute();

		// $stm->debugDumpParams();
		// Verifica se é necessário retornar várias linhas
		if ($fetchAll):
		    $dados = $stm->fetchAll(PDO::FETCH_OBJ);
		else:
		    $dados = $stm->fetch(PDO::FETCH_OBJ);
		endif;

		return $dados;
	    }
	    catch (PDOException $e) {
		return array("erro" => $e->getMessage(), "sql" => $sql);
	    }
	}

	private function translateMessageError($error, $sql)
	{
	    $nomeTabela = '';

	    switch ($this->tabela) {
		case 'crm_alunos': $nomeTabela = 'Alunos';
		    break;
		case 'crm_chamadaalunos': $nomeTabela = 'Chamada de alunos';
		    break;
		case 'crm_chamadas': $nomeTabela = 'Chamadas';
		    break;
		case 'crm_cursos': $nomeTabela = 'Cursos';
		    break;
		case 'crm_empresacontatos': $nomeTabela = 'Contatos da empresa';
		    break;
		case 'crm_empresas': $nomeTabela = 'Empresas';
		    break;
		case 'crm_followups': $nomeTabela = 'Followups';
		    break;
		case 'crm_instrutores': $nomeTabela = 'Instrutores';
		    break;
		case 'crm_turmaalunos': $nomeTabela = 'Turma de alunos';
		    break;
		case 'crm_turmainstrutores': $nomeTabela = 'Turma de instrutores';
		    break;
		case 'crm_turmas': $nomeTabela = 'Turmas';
		    break;
		case 'est_categoriasestoque': $nomeTabela = 'Categorias de estoque';
		    break;
		case 'est_estoque': $nomeTabela = 'Estoques';
		    break;
		case 'sis_estados': $nomeTabela = 'Estados';
		    break;
		case 'sis_grupos': $nomeTabela = 'Grupos';
		    break;
		case 'sis_grupousuarios': $nomeTabela = 'Grupos de usuários';
		    break;
		case 'sis_municipios': $nomeTabela = 'Municipios';
		    break;
		case 'sis_regioes': $nomeTabela = 'Regiões';
		    break;
		case 'sis_subregioes': $nomeTabela = 'Sub-regiões';
		    break;
		case 'sis_templatesemail': $nomeTabela = 'Template de e-mails';
		    break;
		case 'sis_usuarios': $nomeTabela = 'Usuários';
		    break;
		default: $nomeTabela = 'Tabela não definida';
		    break;
	    }

	    $errorInfo = array('code' => $error->getCode(), 'erro' => '<!--<pre>' . $sql . '</pre>-->', 'table' => $nomeTabela, 'sql' => '<!--<pre>' . $sql . '</pre>-->');
	    $erroCode = '';
	    switch ($error->getCode()) {
		case '23000':
		    $erroCode = substr($error->getMessage(), strpos($error->getMessage(), 'Integrity constraint violation:') + 31, 6);
		    $erroCode = str_replace(' ', '', $erroCode);
		    $errorInfo['code'] = $erroCode;
		    switch ($erroCode) {
			case '1451':
			case '1217':
			    $errorInfo['erro'] = 'Existem registros que dependem da tabela de ' . $errorInfo['table'] . ', exclusão não autorizada.<br><br>' .
				    '[Erro código: ' . $errorInfo['code'] . ']: ' . $error->getMessage() .
				    $errorInfo['sql'];
			    break;
			case '1452':
			    $errorInfo['erro'] = 'Existem campos que não foram preenchidos na tabela de ' . $errorInfo['table'] . ', verifique.<br><br>' .
				    '[Erro código: ' . $errorInfo['code'] . ']: ' . $error->getMessage() .
				    $errorInfo['sql'];
			    break;
			case '1062':
			    $errorInfo['erro'] = 'Registro já existente na tabela de ' . $errorInfo['table'] . ', verfique os campos.<br><br>' .
				    '[Erro código: ' . $errorInfo['code'] . ']: ' . $error->getMessage() .
				    $errorInfo['sql'];
			    break;
		    }

		    break;
	    }
	    return $errorInfo;
	}

    }

?>
