<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="<?php echo URL;?>imagens/favicon.ico">
  <title><?php echo TITULO;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="<?php echo URL;?>vendor/almasaeed2010/adminlte/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo URL;?>vendor/almasaeed2010/adminlte/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo URL;?>vendor/almasaeed2010/adminlte/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo URL;?>vendor/almasaeed2010/adminlte/plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="<?php echo URL;?>vendor/almasaeed2010/adminlte/plugins/iCheck/all.css">
  <link rel="stylesheet" href="<?php echo URL;?>vendor/almasaeed2010/adminlte/plugins/timepicker/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="<?php echo URL;?>vendor/almasaeed2010/adminlte/plugins/chosen/chosen.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="<?php echo URL;?>vendor/almasaeed2010/adminlte/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo URL;?>vendor/almasaeed2010/adminlte/plugins/datatables/dataTables.bootstrap.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
      .logo-mini2 img{
	  width: 50px !important;
	  height: 50px !important;
      }
      .logo-miniUser img{
	  padding-top: 0;
	  width: 37px !important;
	  height: 37px !important;
      }

    .img-overlay {
	max-width: 10px;
	border: 0;
	float: right;
	height: 20px;
	margin: 0;
	padding: 0;
	width: 10px;
    }

  </style>
</head>
<body class="hold-transition skin-red-light sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="<?php echo URL;?>task/listar/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?php echo URL;?>images/cornice-menor.jpg" /></span>
      <!-- logo for regular state and mobile devices -->
      <!--<span class="logo-lg"><b>Corni</b>CE</span>-->
      <span class="logo-mini2"><img src="<?php echo URL;?>images/cornice-menor.jpg" /></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <span class="logo-miniUser"><img src="<?php echo URL;?>images/logo_cliente.jpg" class="user-image" alt="User Image"></span>
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo $_SESSION['_loginInfo']->nome ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="<?php echo URL;?>images/logo_cliente.jpg" class="img-circle" alt="User Image">
                <p>
                 <?php echo $_SESSION['_loginInfo']->nome;?>
                  <small>Descrição</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo URL . 'Usuario/editar/'.$_SESSION['_loginInfo']->id;?>" class="btn btn-default btn-flat">Meu Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo URL;?>usuario/logoff/" class="btn btn-default btn-flat">Sair</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  
  <?php include_once(DOCUMENT_ROOT.'src/View/Common/menu_lateral.php'); ?>  
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <small><i class="fa <?php echo $titulo_principal['icone']; ?>"></i></small>
        <a style="text-decoration:none;" href="<?php echo URL.$classe;?>/listar/"><?php echo $titulo_principal['descricao']; ?></a>
      </h1>
      <ol class="breadcrumb">
		<?php foreach ($breadcrumb as $titulo => $link) { ?>
				<li class="active"><a href="<?php echo $link;?>"><?php echo $titulo;?></a></li>
		<?php } ?>
      </ol>
    </section>  