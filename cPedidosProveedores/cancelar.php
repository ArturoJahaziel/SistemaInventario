<?php
	//se manda llamar la conexion
	include("../sesiones/verificar_sesion.php");
	$id_usuario =  $_SESSION["idUsuario"];
	$ide       = $_POST["idd"];
	$fecha=date("Y-m-d"); 
	$hora=date ("H:i:s");

	mysql_query("SET NAMES utf8");

	$consulta3=mysql_query("DELETE FROM detalle_pedido
WHERE id_pedido = '$ide';",$conexion) or die (mysql_error());
	
	$insertar = mysql_query("UPDATE pedidos_proveedores
								SET
								status='En proceso '
							WHERE id_pedido_proveedor='$ide'",$conexion)or die(mysql_error());
		echo "ok";
?>