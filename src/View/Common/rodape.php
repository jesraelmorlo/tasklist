<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
	Para suporte, entre em contato |
	E-mail: jesrael.morlo@gmail.com |
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; <?php echo date('Y'); ?> </strong> All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
	<li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
	<li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
	<!-- Home tab content -->
	<div class="tab-pane active" id="control-sidebar-home-tab">
	    <h3 class="control-sidebar-heading">Recent Activity</h3>
	    <ul class="control-sidebar-menu">
		<li>
		    <a href="javascript::;">
			<i class="menu-icon fa fa-birthday-cake bg-red"></i>

			<div class="menu-info">
			    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

			    <p>Will be 23 on April 24th</p>
			</div>
		    </a>
		</li>
	    </ul>
	    <!-- /.control-sidebar-menu -->

	    <h3 class="control-sidebar-heading">Tasks Progress</h3>
	    <ul class="control-sidebar-menu">
		<li>
		    <a href="javascript::;">
			<h4 class="control-sidebar-subheading">
			    Custom Template Design
			    <span class="label label-danger pull-right">70%</span>
			</h4>

			<div class="progress progress-xxs">
			    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
			</div>
		    </a>
		</li>
	    </ul>
	    <!-- /.control-sidebar-menu -->

	</div>
	<!-- /.tab-pane -->
	<!-- Stats tab content -->
	<div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
	<!-- /.tab-pane -->
	<!-- Settings tab content -->
	<div class="tab-pane" id="control-sidebar-settings-tab">
	    <form method="post">
		<h3 class="control-sidebar-heading">General Settings</h3>

		<div class="form-group">
		    <label class="control-sidebar-subheading">
			Report panel usage
			<input type="checkbox" class="pull-right" checked>
		    </label>

		    <p>
			Some information about this general settings option
		    </p>
		</div>
		<!-- /.form-group -->
	    </form>
	</div>
	<!-- /.tab-pane -->
    </div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="<?php echo URL; ?>vendor/almasaeed2010/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo URL; ?>vendor/almasaeed2010/adminlte/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo URL; ?>vendor/almasaeed2010/adminlte/dist/js/app.min.js"></script>
<script src="<?php echo URL; ?>vendor/almasaeed2010/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo URL; ?>vendor/almasaeed2010/adminlte/plugins/chosen/chosen.jquery.js"></script>
<!-- InputMask -->
<script src="<?php echo URL; ?>vendor/almasaeed2010/adminlte/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo URL; ?>vendor/almasaeed2010/adminlte/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo URL; ?>vendor/almasaeed2010/adminlte/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->

<script src="<?php echo URL; ?>vendor/almasaeed2010/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo URL; ?>vendor/almasaeed2010/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo URL; ?>vendor/almasaeed2010/adminlte/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="<?php echo URL; ?>vendor/almasaeed2010/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?php echo URL; ?>vendor/almasaeed2010/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?php echo URL; ?>vendor/almasaeed2010/adminlte/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="<?php echo URL; ?>vendor/almasaeed2010/adminlte/plugins/fastclick/fastclick.js"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
<script>
    $(function () {
        $('#example1').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": true,
            language: {
                emptyTable: "Nenhum registro encontrado!"
            }
        });
    });

    $(document).ready(function () {
        $("#btnCep").on('click', function () {
            var cep_code = $('#txtCep').val();
            if (cep_code.length <= 0)
                return;

            $.ajax({
                dataType: "json",
                //url: "http://apps.widenet.com.br/busca-cep/api/cep.json",
                //data: {code: cep_code},
                url: "http://cep.republicavirtual.com.br/web_cep.php",
                data: {
		    cep: cep_code,
		    formato: 'json'
		},
                beforeSend: function (xhr) {
                    $('.img-overlay').css('display', 'block');
                },
                success: function (result) {
		    
                    if (result.resultado != 1) {
			$('.help-block').
				    css('display', 'block').
				    css('color', '#dd4b39').
				    css('font-weight', 'bold').
				    text(result.resultado_txt.toString().replace('sucesso - ', '') || "Houve um erro desconhecido").show();
			$('.img-overlay').css('display', 'none');
                        return;
                    }
		    $('.help-block').css('display', 'none');
                    $("input[name=cep]").val(cep_code);
                    var nomeCidade = result.cidade;
                    $.ajax({
                        dataType: "json",
                        type: 'post',
                        url: "<?php echo URL ?>Common/retornarCidade/parametros=" + nomeCidade,
                        success: function (cidadeID) {
                            $("select[name=cidade]").val(cidadeID);
                            $("select[name=cidade]").change();
                            $("select[name=cidade]").trigger("chosen:updated");
                        }
                    });
                    $("input[name=enderecobairro]").val(result.bairro);
                    $("input[name=endereco]").val(result.tipo_logradouro + ' ' + result.logradouro);
                    $('.img-overlay').css('display', 'none');
		    /*
                    if (result.status != 1) {
			$('.help-block').
				    css('display', 'block').
				    css('color', '#dd4b39').
				    css('font-weight', 'bold').
				    text(result.message || "Houve um erro desconhecido").show();
			$('.img-overlay').css('display', 'none');
                        return;
                    }
		    $('.help-block').css('display', 'none');
                    $("input[name=cep]").val(result.code);
                    var nomeCidade = result.city;
                    $.ajax({
                        dataType: "json",
                        type: 'post',
                        url: "<?php echo URL ?>Common/retornarCidade/parametros=" + nomeCidade,
                        success: function (cidadeID) {
                            $("select[name=cidade]").val(cidadeID);
                            $("select[name=cidade]").change();
                            $("select[name=cidade]").trigger("chosen:updated");
                        }
                    });
                    $("input[name=enderecobairro]").val(result.district);
                    $("input[name=endereco]").val(result.address);
                    $('.img-overlay').css('display', 'none');
		    */
                },
                error: function (result) {
                    $('.img-overlay').css('display', 'none');
                }
            });
        });

        $('.btnRemover').click(function () {
            if (window.confirm('Confirma a remoção do registro [' + $(this).attr('data-descricao') + ']?')) {
                var url = "<?php echo URL ?>" + $(this).attr('data-classe') + "/remover/" + $(this).attr('data-id');
                window.location = url;
            }
        });

        $('#cadastrarNovo').on('click', function (e) {
            var href = $(this).attr('data-href');
	    $('.img-overlay').css('display', 'block');
            $.ajax({
                dataType: "html",
                url: href,
		before: function(){
		},
                success: function (conteudo) {
		    $('#Editando').hide().fadeOut(1000);
		    $('#Cadastrando').html('');
		    $('#Cadastrando').html(conteudo);
		    //$('#Cadastrando').css('display', 'block');
		    $('#Cadastrando').show().fadeIn(1000);
		    $('.img-overlay').css('display', 'none');
                },
                error: function (result) {
                    $('.img-overlay').css('display', 'none');
                }
            });
        });

        $('.editandoCadastro').on('click', function (e) {
            var href = $(this).attr('data-href');
	    $('.img-overlay').css('display', 'block');
            $.ajax({
                dataType: "html",
                url: href,
		before: function(){
		},
                success: function (conteudo) {
		    $('#Cadastrando').hide().fadeOut(1000);
		    $('#Editando').html('');
		    $('#Editando').html(conteudo);
		    //$('#Editando').css('display', 'block');
		    $('#Editando').find('.box-header').find('h3').text('Editando cadastro');
		    $('#Editando').show().fadeIn(1000);
		    $('.img-overlay').css('display', 'none');
                },
                error: function (result) {
                    $('.img-overlay').css('display', 'none');
                }
            });
        });

        $('#btnBuscar').click(function () {
            var url = "<?php echo URL . $classe . '/listar/'; ?>/0/buscar=" + $('select[name=coluna]').val() + "|" + $('input[name=buscar]').val();
            window.location = url;
        });

        $('#itensPagina').on('change', function () {
            var url = "<?php echo URL . $classe . '/listar/'; ?>/0/paginacao=page|" + $('select[name=itensPagina]').val();
            window.location = url;
        });

        var i = 0;
        $('#btnIncluirQuadro').click(function () {
            var vars = {};
            $('input.form-control').each(function (index, obj) {
                var valor = $(this).val();
                if (valor != '') {
                    vars[$(this).attr('name')] = $(this).val();
                }
            });
            $('textarea.form-control').each(function (index, obj) {
                var valor = $(this).val();
                if (valor != '') {
                    vars[$(this).attr('name')] = $(this).val();
                }
            });

            var Cd_Prod_Aux = vars['Cd_Prod_Aux'];
            var Qt_Item = vars['Qt_Item'];
            var Md_Largura = vars['Md_Largura'];
            var Md_Altura = vars['Md_Altura'];
            var Vl_Unitario = vars['Vl_Unitario'];
            var Vl_Bruto = vars['Vl_Bruto'];
            var VL_ADICIONAIS = vars['VL_ADICIONAIS'];
            var Ds_Observacao = vars['Ds_Observacao'];

            $('#imagem' + i).html("<td>" + Cd_Prod_Aux + "</td>" + "<td>" + Qt_Item + "</td>" + "<td>" + Md_Largura + "</td>" + "<td>" + Md_Altura + "</td>" + "<td>" + Vl_Unitario + "</td>" + "<td>" + Vl_Bruto + "</td>" + "<td>" + VL_ADICIONAIS + "</td>" + "<td>" + Ds_Observacao + "</td>" + "<td>Editar</td>");

            $('#tabelaImagem').append('<tr id="imagem' + (i + 1) + '"></tr>');

            $('#myModal').modal('hide');

            i++;
        });
        //Initialize Select2 Elements
        $(".chosen-select").chosen();
        $("[data-mask]").inputmask();
    });
</script>     
</body>
</html>
