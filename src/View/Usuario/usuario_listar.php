<?php

    include_once(DOCUMENT_ROOT . 'src/View/Common/cabecalho.php');
    global $msg_erro;
    global $msg_sucesso;
?>
<!-- Main content -->
<section class="content">
    <div class="row">
	<div class="col-md-12">
	    <div class="box">
		<div class="box-header">
		    <h3 class="box-title">Usuário</h3>
		</div>
		<?php

		    if (!empty($msg_sucesso))
		    {
			?>
			<div class="callout callout-success">
			    <h4>Sucesso!</h4>
			    <p><?php echo $msg_sucesso; ?></p>
			</div>
		    <?php

		    }
		    if (!empty($msg_erro))
		    {
			?>
			<div class="callout callout-danger">
			    <h4>Erro!</h4>
			    <p><?php echo $msg_erro; ?></p>
			</div>
    <?php } ?>
		<div class="box-body">
		    <div id="componentes-cadastrados" class="dataTables_wrapper form-inline dt-bootstrap">
			<div class="row">
			    <div class="col-sm-6">
				<a class="btn btn-primary" href="<?php echo URL . $classe . '/cadastrar/'; ?>">Cadastrar Novo</a>
			    </div>
			    <div class="col-sm-6">
				<div id="example1_filter" class="dataTables_filter">
				    <label>
					Buscar:
					<select name="coluna" class="form-control">
					    <?php

						foreach ($arrCamposBusca as $value => $descricao) {
						    $selected = '';
						    if ($value == $coluna)
						    {
							$selected = 'selected';
						    }
						    ?>
						    <option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $descricao; ?></option>
    <?php } ?>
					</select>
					<input class="form-control input-sm" type="search" placeholder="" value="<?php echo $buscar; ?>" name="buscar" aria-controls="example1">
					<input type="button" class="btn btn-primary" id="btnBuscar" value="Buscar" />
				    </label>
				</div>
			    </div>
			</div>
			<div class="row">
			    <div class="col-sm-12">
				<table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
				    <thead>
					<tr role="row">
					    <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: auto;" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Nome</th>
					    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: auto;" aria-label="Browser: activate to sort column ascending">E-mail</th>
					    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: auto;" aria-label="Browser: activate to sort column ascending">&nbsp;</th>
					</tr>
				    </thead>
				    <tbody>
					<?php

					    $aux = 0;
					    foreach ($usuarios as $usuario) {
						    ?>
						    <td class="sorting_1"><?php echo $usuario->nome; ?></td>
						    <td class="sorting_1"><?php echo $usuario->email; ?></td>
						    <td>
							<a class="" href="<?php echo URL . 'Usuario/editar/' . $usuario->id; ?>"><i class="fa fa-edit"></i>Editar</a>
							<?php if ($usuario->podeRemover){ ?>
								<a style="float:right;" class="btnRemover" data-descricao="<?php echo $usuario->nome; ?>" href="javascript: void(0);" data-classe="Usuario"  data-id="<?php echo $usuario->id ?>"><i class="fa fa-remove"></i>Remover</a>
							<?php } else{ ?>
								<span style="float:right;"><i class="fa fa-remove"></i>Remover</span>
							<?php } ?>
						    </td>
						</tr>
    <?php } ?>
				    </tbody>
				</table>
			    </div>
			</div>
		    </div>
		</div>
		<div class="box-footer clearfix">
		    <ul class="pagination pagination-sm no-margin pull-right">

			<li><a class='box-navegacao <?= $exibir_botao_inicio ?>' href="index.php?class=<?php echo $classe; ?>&acao=listar&page=<?= $primeira_pagina ?>" title="Primeira Página">Primeira</a></li>
			<li><a class='box-navegacao <?= $exibir_botao_inicio ?>' href="index.php?class=<?php echo $classe; ?>&acao=listar&page=<?= $pagina_anterior ?>" title="Página Anterior">Anterior</a></li>

			    <?php

				/* Loop para montar a páginação central com os números */
				for ($i = $range_inicial; $i <= $range_final; $i++) {
				    $destaque = ($i == $pagina_atual) ? 'active' : '';
				    ?>
				<li class='box-numero <?= $destaque ?>'><a href="index.php?class=<?php echo $classe; ?>&acao=listar&page=<?= $i ?>"><?= $i ?></a></li>
    <?php } ?>
			<li><a href="index.php?class=<?php echo $classe; ?>&acao=listar&page=<?= $proxima_pagina ?>" title="Próxima Página">Próxima</a></li>
			<li><a href="index.php?class=<?php echo $classe; ?>&acao=listar&page=<?= $ultima_pagina ?>" title="Última Página">Último</a></li>
		    </ul>
		</div>
	    </div>
	</div>
    </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include_once(DOCUMENT_ROOT . 'src/View/Common/rodape.php'); ?>