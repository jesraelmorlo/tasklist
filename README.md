Implementar uma tasklist com a stack PHP/MySQL.

# Acessar a aplicação:
<p>1: Usar a funcionalidade <b>Cadastrar-me</b> para criar seu usuário de operação.</p>
<p>2: Após usuário criado, efetuar login com as credenciais utilizadas no cadastro.</p>
<p>3: Ao efetura login, será redirecionado para o menu de tarefas, onde, poderá cadastrar, editare remover as mesmas.</p>
<p>4: Ao <b>cadastrar</b> uma tarefa, somente poderá ser informado titulo, status e descrição da mesma, demais campos, o sistema fará a manutenção automaticamente.</p>
<p>5: Ao <b>editar</b> uma tarefa, somente poderá ser modificado titulo, status e descrição da mesma, campo de data de alteração o sistema fará a manutenção automaticamente.</p>
<p>6: Tarefas com status <b>finalizado</b>, não será permitido editar e nem remover.</p>
<p>5: No menu de usuários, poderá cadastrar, editar e remover os mesmos, desde que não tenham tarefas criadas.</p>


# Arquivos:
<p>./images/ - contém as imagens da aplicação.</p>
<p>./sql/ - contém dump da base de dados para operar na aplicação.</p>

<p>./src/Model/conexao.php - Instancia que cria a conexão com o banco de dado através de PDO basendo-se nas configurações nele contido.</p>
<p>./src/Model/bd.php - Classe que monta o CRUD para os models fazerm uso.</p>
<p>./src/Model/Task.php - Model que interage com a tabela de tarefas (sis_tasks).</p>
<p>./src/Model/Usuario.php - Model que interage com a tabela de usuários (sis_usuarios).</p>

<p>./src/View/View.php - Classe que renderizará o conteúdo da cada respectiva view.</p>
<p>./src/View/Common/ - Contém aquivos cabeçalho, menu lateral e rodapé da aplicação.</p>
<p>./src/View/Task/ - Contém arquivos de lista e formulário de cadastro/edição de tarefas.</p>
<p>./src/View/Usuario/ - Contém arquivos de lista e formulário de cadastro/edição de usuários.</p>

<p>./src/Controller/CommonController.php - Arquivo implementa a classe genérica de controllers, com seus respectivos métodos.</p>
<p>./src/Controller/TaskController.php - Arquivo implementa as ações de negócio quanto a tarefas (tasks), com seus respectivos métodos como listar, cadastrar, editar e remover.</p>
<p>./src/Controller/UsuarioController.php - Arquivo implementa as ações de negócio quanto a usuários, com seus respectivos métodos como listar, cadastrar, editar e remover.</p>

<p>./vendor/ - Admin panel da aplicação.</p>
<p>./config.php - contém configurações da aplicação.</p>
<p>./index.php - onde a aplicação fará a instancia da classe ou controller a ser consumido.</p>

