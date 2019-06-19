<?php include_once(DOCUMENT_ROOT . 'src/View/Common/cabecalho.php'); ?>

<!-- Main content -->
<section class="content">
    <div class="row">
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	    <div class="box box-default box-solid">
		<div class="box-header box-collapse with-border">
		    <h3 class="box-title">Cadastro</h3>
		</div>
		<div class="box-body">
		    <form role="form" data-toggle="validator" method="POST" action="<?php echo URL; ?>index.php?class=<?php echo $classe; ?>&acao=<?php echo $metodo; ?>">
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
			    <label>Nome</label>
			    <div class="input-group col-lg-12">
				<input class="form-control" type="text" value="<?php echo $usuarios[0]->nome; ?>" name="nome" required />
			    </div>

			    <label>E-mail</label>
			    <div class="input-group col-lg-12">
				<div class='input-group-addon'><i class='fa fa-mail-forward'></i></div>
				<input class="form-control" type="email" name="email" value="<?php echo $usuarios[0]->email; ?>" required />
			    </div>

			    <div class="form-group">
				<label for="senha" class="control-label">Senha</label>
				<div class="form-inline row">
				    <div class="form-group col-sm-6">
					<input type="password" data-minlength="0" class="form-control" name="senha" id="senha" placeholder="Senha" required />
					<div class="help-block">Minimo 4 caracteres</div>
				    </div>
				</div>
			    </div>

			</div>

			<div class="box-footer">
			    <input type="hidden" name="handle" value="<?php echo $usuarios[0]->id; ?>">
			    <button class="btn btn-primary" type="submit">Salvar</button>
			    <a class="btn btn-primary" href="<?php echo URL . $classe; ?>/listar/">Voltar</a>
			</div>
		    </form>
		</div>
	    </div>
	</div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include_once(DOCUMENT_ROOT . 'src/View/Common/rodape.php'); ?>