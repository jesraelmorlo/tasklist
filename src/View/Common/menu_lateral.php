
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

	<!-- Sidebar user panel (optional) -->
	<?php /*
	      <div class="user-panel">
	      <div class="pull-left image">
	      <img src="<?php echo $url;?>images/nz.jpg" class="img-circle" alt="User Image">
	      </div>
	      <div class="pull-left info">
	      <p>Natal Zoboli</p>
	      <!-- Status -->
	      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
	      </div>
	      </div>
	     */ ?>
	<!-- search form (Optional) -->
	<?php /*
	      <form action="#" method="get" class="sidebar-form">
	      <div class="input-group">
	      <input type="text" name="q" class="form-control" placeholder="Search...">
	      <span class="input-group-btn">
	      <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
	      </button>
	      </span>
	      </div>
	      </form>
	     */ ?>
	<!-- /.search form -->

	<!-- Sidebar Menu -->
	<ul class="sidebar-menu">
	    <li class="header">Menu</li>
	    <!--
	    <li class="treeview">
			    <a href=""><i class="fa fa-plus-circle"></i> Pedidos </a>
			    <ul class="treeview-menu">
				    <li class="treeview">
					    <li><a href="<?php echo URL; ?>Orcamento/listar/">Listar</a></li>
				    </li>
			    </ul>
	    </li>
	    -->
	    <!-- Optionally, you can add icons to the links -->
	    <li class="treeview">
		    <!--<a href=""><i class="fa fa-cog"></i> Administração </a>-->
		<!--<ul class="treeview-menu">-->
		<?php

		    foreach ($modulos as $class) {
			    ?>
	    	    <li class="treeview">
	    		<a href="<?php echo URL . $class['modulo'] . '/listar/'; ?>">
	    			<i class="fa <?php echo $class['icone']; ?>"></i> <span><?php echo $class['descricao']; ?></span> <!--<i class="fa fa-angle-left pull-right"></i>--></a>
	    		<!--			<ul class="treeview-menu">
			    <?php if ($class['modulo'] != 'ComposicaoPreco')
			    { ?>
									<li><a href="<?php echo URL; ?>index.php?class=<?php echo $class['modulo']; ?>&acao=listar">Listar</a></li>
									<li><a href="<?php echo URL; ?>index.php?class=<?php echo $class['modulo']; ?>&acao=cadastrar">Cadastrar novo</a></li>
			<?php }
			else
			{ ?>
									<li><a href="<?php echo URL; ?>index.php?class=<?php echo $class['modulo']; ?>&acao=editar&&handle=1">Listar</a></li>
	    <?php } ?>
	    					</ul>-->
	    	    </li>
	<?php
    } ?>
	    <!--</ul>-->
	    </li>
	</ul>
	<!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
