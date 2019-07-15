<?php 
	// Conexion a la base de datos
	include'../conexion/conexion.php';

	// Codificacion de lenguaje
	mysql_query("SET NAMES utf8");

	// Consulta a la base de datos
	$consulta=mysql_query("SELECT id_usuario,
								(	SELECT CONCAT(personas.ap_paterno,' ',personas.ap_materno,' ', personas.nombre)
									FROM personas
									WHERE personas.id_persona = usuarios.id_persona
								) AS NPersona,
								usuario,
								fecha_registro,
								activo,
								contra,
								id_persona
								FROM usuarios",$conexion) or die (mysql_error());
	// $row=mysql_fetch_row($consulta)
?>
<div class="table-responsive">
	<table id="example1" class="table table-responsive table-condensed table-bordered table-striped">
		<thead align="center">
			<tr class="info" >
				<th>#</th>
				<th>Nombre</th>
				<th>Usuario</th>
				<th>Registro</th>
				<th>Restaurar</th>
				<th>Editar</th>
				<th>Estatus</th>
			</tr>
		</thead>
		<tbody align="center">
			<?php 
				$n=1;
				while ($row=mysql_fetch_row($consulta)) {
					$idUsuario   = $row[0];
					$nomPersona  = $row[1];
					$nomUsuario  = $row[2];
					$contra      = $row[5];	
					$id_persona  = $row[6];
					$fecRegistro = $row[3];	
					$activo      = $row[4];						
					$checado=($activo==1)?'checked':'';		
					$desabilitar=($activo==0)?'disabled':'';
					$claseDesabilita=($activo==0)?'desabilita':'';
			?>
			<tr>
				<td >
					<p id="<?php echo "tConsecutivo".$n; ?>" class="<?php echo $claseDesabilita; ?>">
						<?php echo "$n"; ?>
					</p>
				</td>
				<td>
					<p id="<?php echo "tNombrePersona".$n; ?>" class="<?php echo $claseDesabilita; ?>">
						<?php echo $nomPersona; ?>
					</p>
				</td>
				<td>
					<p id="<?php echo "tUsuario".$n; ?>" class="<?php echo $claseDesabilita; ?>">
						<?php echo $nomUsuario; ?>
					</p>
				</td>
				<td>
					<p id="<?php echo "tFecha".$n; ?>"  class="<?php echo $claseDesabilita; ?>">
						<?php echo $fecRegistro; ?>
					</p>
				</td>
				<td>
					<button id="<?php echo "tRestaurar".$n; ?>" <?php echo $desabilitar ?>  type="button" class="btn btn-login btn-sm" onclick="restaurar_contra('<?php echo $idUsuario ?>');">
						<i class="fa fa-undo"></i>
					</button>
				</td>
				<td>
					<button id="<?php echo "boton".$n; ?>" <?php echo $desabilitar ?>  type="button" class="btn btn-login btn-sm" 
						onclick="abrirModalEditar(
												'<?php echo $id_persona ?>',
												'<?php echo $nomUsuario ?>',
												'<?php echo $idUsuario ?>'
												);">
						<i class="far fa-edit"></i>
					</button>
				</td>
				<td>
					<input  data-size="small" data-style="android" value="<?php echo "$valor"; ?>" type="checkbox" <?php echo "$checado"; ?>  id="<?php echo "interruptor".$n; ?>"  data-toggle="toggle" data-on="Desactivar" data-off="Activar" data-onstyle="danger" data-offstyle="success" class="interruptor" data-width="100" onchange="status(<?php echo $n; ?>,<?php echo $idUsuario; ?>);">
				</td>
			</tr>
		<?php
			$n++;
			}
		?>
		</tbody>
		<tfoot align="center">
			<tr class="info">
				<th>#</th>
				<th>Nombre</th>
				<th>Usuario</th>
				<th>Registro</th>
				<th>Restaurar</th>
				<th>Editar</th>
				<th>Estatus</th>
			</tr>
		</tfoot>
	</table>
</div>
			
<script type="text/javascript">
	$(document).ready(function() {
		$('#example1').DataTable( {
			"language": {
				"url": "../plugins/datatables/langauge/Spanish.json"
			},
			"order": [[ 0, "asc" ]],
			"paging":   true,
			"ordering": true,
			"info":     true,
			"responsive": true,
			"searching": true,
			stateSave: false,
			dom: 'Bfrtip',
			lengthMenu: [
				[ 10, 25, 50, -1 ],
				[ '10 Registros', '25 Registros', '50 Registros', 'Todos' ],
			],
			columnDefs: [ {
				// targets: 0,
				// visible: false
			}],
			buttons: [
				{
					extend: 'pageLength',
					text: 'Registros',
					className: 'btn btn-default'
				},
				{
					extend: 'excel',
					text: 'Exportar a Excel',
					className: 'btn btn-default',
					title:'Bajas-Estaditicas',
					exportOptions: {
						columns: ':visible'
					}
				},
				{
					text: 'Nuevo Usuario',
					action: function (  ) {
						ver_alta();
						llenar_persona();
					},
					counter: 1
				},
			]
		});
	});
</script>
<script>
	$(".interruptor").bootstrapToggle('destroy');
	$(".interruptor").bootstrapToggle();
</script>
    
    
