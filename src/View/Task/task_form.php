<?php 
include_once(DOCUMENT_ROOT . 'src/View/Common/cabecalho.php'); 

$isReadOnly = ($tasks[0]->status === 'F');

$attrIsReadOnly = '';
if ($isReadOnly){
	$attrIsReadOnly = ' readonly disabled ';
}

?>

<!-- Main content -->
<section class="content">
    <div class="row">
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	    <div class="box box-default box-solid">
		<div class="box-header box-collapse with-border">
		    <h3 class="box-title">Cadastro</h3>
		</div>
		<div class="box-body">
		    <form role="form" method="POST" action="<?php echo URL; ?>index.php?class=<?php echo $classe; ?>&acao=<?php echo $metodo; ?>">
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
			    <label>Titulo</label>
			    <div class="input-group col-lg-12">
					<input class="form-control" <?= $attrIsReadOnly ?> type="text" value="<?php echo $tasks[0]->titulo; ?>" name="titulo" required />
			    </div>

			    <div class="input-group col-lg-12">
				<label>Status</label>
				<select name="status" class="form-control" <?= $attrIsReadOnly ?>>
				    <option value="">Selecione</option>
				    <?php

					foreach ($this->status as $statusId => $status) {
					    $selected = "";
					    if ($statusId == $tasks[0]->status)
					    {
						$selected = ' selected="selected"';
					    }
					    ?>
					    <option value="<?php echo $statusId; ?>" <?php echo $selected; ?>><?php echo $status; ?></option>
    <?php } ?>
				</select>
			    </div>

				<div class="input-group col-lg-6">

					<label>Data criação</label>
					<div class="input-group">
						<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
						</div>
						<input type="text" readonly name="dataCriacao" data-mask="" data-inputmask="'alias': 'dd/mm/yyyy h:i:s'" class="form-control" value="<?php echo (($tasks[0]->dataCriacao) ? date('d/m/Y H:i:s', strtotime($tasks[0]->dataCriacao)) : date('d/m/Y H:i:s'));?>">
						</div>
					<label>Data alteração</label>
					<div class="input-group">
						<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
						</div>						
						<input type="text" readonly name="dataAlteracao" data-mask="" data-inputmask="'alias': 'dd/mm/yyyy h:i:s'" class="form-control" value="<?php echo (($tasks[0]->dataAlteracao) ? date('d/m/Y H:i:s', strtotime($tasks[0]->dataAlteracao)) : date('d/m/Y H:i:s'));?>">
					</div>
				</div>				

			    <label>Descrição</label>
			    <div class="input-group col-lg-6">
				<textarea class="form-control" <?= $attrIsReadOnly ?> type="text" rows="5" name="descricao"><?php echo $tasks[0]->descricao; ?></textarea>
			    </div>				
				
				<?php if ($tasks[0]->id > 0) { ?>
			    <label>Usuário</label>
			    <div class="input-group col-lg-12">
				<input class="form-control"readonly type="email" value="<?php echo $tasks[0]->nomeUsuario; ?>">
				<input class="form-control" type="hidden" name="usuario" value="<?php echo $tasks[0]->usuario; ?>">
			    </div>

			    <label>E-mail</label>
			    <div class="input-group col-lg-12">
				<input class="form-control" readonly type="text" value="<?php echo $tasks[0]->emailUsuario; ?>">				
			    </div>
				<?php } ?>				
			</div>

			<div class="box-footer">
			    <input type="hidden" name="handle" value="<?php echo $tasks[0]->id; ?>">
			    <button <?= $attrIsReadOnly ?> class="btn btn-primary" type="submit">Salvar</button>
			    <a class="btn btn-primary" href="<?php echo URL . $classe; ?>/listar/">Voltar</a>
			</div>
		    </form>
		</div>
	    </div>
	</div>


	<div id="Cadastrando" class="col-md-6 col-lg-6 col-sm-12 col-xs-12 pull-right" style="display: none">
	    <div class="box box-default box-solid">
		<div class="box-header box-collapse with-border">
		    <h3 class="box-title">Cadastrando</h3>
		</div>

		<div class="box-body">
		</div>
	    </div>
	</div>

	<div id="Editando" class="col-md-6 col-lg-6 col-sm-12 col-xs-12 pull-right" style="display: none">
	    <div class="box box-default box-solid">
		<div class="box-header box-collapse with-border">
		    <h3 class="box-title">Editando</h3>
		</div>

		<div class="box-body">
		</div>
	    </div>
	</div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once(DOCUMENT_ROOT . 'src/View/Common/rodape.php'); ?>