<!DOCTYPE html>
<html>
	<head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <title><?php echo TITULO;?></title>
	  <!-- Tell the browser to be responsive to screen width -->
	  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  <!-- Bootstrap 3.3.5 -->
	  <link rel="stylesheet" href="<?php echo URL;?>vendor/almasaeed2010/adminlte/bootstrap/css/bootstrap.min.css">
	  <!-- Font Awesome -->
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	  <!-- Ionicons -->
	  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  
	  <!-- Theme style -->
	  <link rel="stylesheet" href="<?php echo URL;?>vendor/almasaeed2010/adminlte/dist/css/AdminLTE.min.css">
	  <!-- iCheck -->
	  <link rel="stylesheet" href="<?php echo URL;?>vendor/almasaeed2010/adminlte/plugins/iCheck/square/blue.css">

	  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	  <!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	  <![endif]-->
	</head>
	<body class="hold-transition login-page">
		<!-- Main content -->
		<div class="row">
			<form role="form" data-toggle="validator" method="POST" action="<?php echo URL; ?>index.php?class=usuario&acao=cadastrarNovoUsuario">
				<section class="content">
					<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12"></div>
					<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
						<div class="box box-default box-solid">
						<div class="box-header box-collapse with-border">
							<h3 class="box-title">Cadastrar-me</h3>
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
								<a class="btn btn-primary" href="<?php echo URL ; ?>">Voltar</a>
							</div>
							</form>
						</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12"></div>
				</section>
			</form>
		</div>
		<!-- /.content -->
	<!-- /.content-wrapper -->
	<!-- /.login-box -->

	<!-- jQuery 2.1.4 -->

	<script src="<?php echo URL;?>vendor/almasaeed2010/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="<?php echo URL;?>vendor/almasaeed2010/adminlte/plugins/jQueryUI/jquery-ui.min.js"></script>
	<!-- Bootstrap 3.3.5 -->
	<script src="<?php echo URL;?>vendor/almasaeed2010/adminlte/bootstrap/js/bootstrap.min.js"></script>
	<!-- iCheck -->
	<script src="<?php echo URL;?>vendor/almasaeed2010/adminlte/plugins/iCheck/icheck.min.js"></script>
	</script>
	</body>
</html>