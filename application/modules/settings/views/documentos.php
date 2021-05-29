<script>
$(function(){ 
	$(".btn-info").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + '/settings/cargarModalProcesos',
                data: {'idProcesoInfo': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});	
});
</script>

<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<a class="btn btn-primary btn-xs" href=" <?php echo base_url('settings/procesos'); ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a>
					<i class="fa fa-file-o"></i><strong> LISTA DE DOCUMENTOS</strong> - <?php echo $infoProcesos[0]['title']; ?>
				</div>
				<div class="panel-body">

<?php
	$retornoExito = $this->session->flashdata('retornoExito');
	if ($retornoExito) {
?>
		<div class="alert alert-success ">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			<?php echo $retornoExito ?>		
		</div>
<?php
	}
	$retornoError = $this->session->flashdata('retornoError');
	if ($retornoError) {
?>
		<div class="alert alert-danger ">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<?php echo $retornoError ?>
		</div>
<?php
	}
?> 


<!--INICIO LISTADO -->
<?php 
	if($listaTemas){
		$ci = &get_instance();
		$ci->load->model("general_model");

		foreach ($listaTemas as $lista):
			$arrParam = array(
				'idProcesoInfo' => $infoProcesos[0]['id_proceso_informacion'],
				'idTema' => $lista['id_tema'],
				'estado' => 1
			);
			$documentoProcesos = $this->general_model->get_documentos_procesos($arrParam);	
?>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-info">
				<div class="panel-heading">
					<i class="fa fa-tag"></i> <strong><?php echo $lista['tema']; ?></strong>
				</div>
				<div class="panel-body">
					<ul class="nav nav-pills">
						<li class='active'>
							<?php 
								$idProcesoInfo =  $infoProcesos[0]['id_proceso_informacion']; 
								$idTema = $lista['id_tema'];
								$codigoProceso = $infoProcesos[0]['codigo'];
							?>
							<a href="<?php echo base_url('settings/documents_form/' . $idProcesoInfo . '/' . $idTema); ?>">Adicionar Documento</a>
						</li>
					</ul>

				<?php 
					if($documentoProcesos){
				?>				
					<table class="table table-hover">
						<thead>
							<tr>
                                <th>Código</th>
                                <th>URL</th>
                                <th>Nombre</th>
                                <th class='text-center'>Orden</th>
                                <th class='text-center'>Editar</th>
							</tr>
						</thead>
						<?php
							foreach ($documentoProcesos as $item):
								echo '<tr>';
                                echo "<td>" . $item['cod'] . "</td>";
								echo "<td>";
						?>
<a href='<?php echo base_url('files/' . $codigoProceso . '/' . $item['url'] ); ?>' target="_blank"><?php echo $item['url']; ?></a>
						<?php
								echo "</td>";
								echo "<td>" . $item['shortName'] . "</td>";
								echo "<td class='text-center'>" . $item['orden'] . "</td>";
								echo "<td class='text-center'>";
						?>
								<a class="btn btn-info btn-xs" href="<?php echo base_url('settings/documents_form/' . $idProcesoInfo . '/' . $idTema . '/' . $item['id_procesos_documento']); ?>">Editar <span class="glyphicon glyphicon-edit" aria-hidden="true">
								</a>
								<br><br>

	                            <form  name="formHistorial" id="formHistorial" method="post" action="<?php echo base_url("settings/historial_documentos"); ?>">
	                                <input type="hidden" class="form-control" id="hddidDocumento" name="hddidDocumento" value="<?php echo $item['id_procesos_documento']; ?>" />
	                                
	                                <button type="submit" class="btn btn-default btn-xs" id="btnSubmit2" name="btnSubmit2">
	                                    Ver Cambios <span class="fa fa-th-list" aria-hidden="true" />
	                                </button>
	         
	                            </form>

						<?php
								echo "</td>";
                                echo '</tr>';
							endforeach;
						?>
					</table>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>


<?php 
		endforeach;
} 
?>
<!--FIN LISTADO -->


				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->
				
<!--INICIO Modal para adicionar PROCESOS -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal para adicionar PROCESOS -->

<!-- Tables -->
<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: true,
		"pageLength": 25,
		 "ordering": false,
		 paging: false
	});
});
</script>