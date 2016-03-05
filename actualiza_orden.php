<?php
include('db.php');

/* 

if($registro['status']=='20') $chek='Anulada';
if($registro['status']=='1') $chek='Nueva Orden'; 
if($registro['status']=='2') $chek='Asignada Delivery';
if($registro['status']=='3') $chek='Entregada Delivery';
if($registro['status']=='4') $chek='En Tienda';
if($registro['status']=='5') $chek='Asignada Operador';
if($registro['status']=='6') $chek='Planchada';
if($registro['status']=='7') $chek='Pendiente Pago';
if($registro['status']=='8') $chek='Cancelada';
if($registro['status']=='9') $chek='Enviada';
if($registro['status']=='10') $chek='Entregada Cliente';
if($registro['status']=='11') $chek='>Observación';
 */
if(isset($_REQUEST['id_orden']) && !empty($_REQUEST['id_orden']))
{
	$usu = $_REQUEST['id_orden'];
	if(isset($_REQUEST['cedula'])){
		$ced = $_REQUEST['cedula'];
	}else{
		$ced =0;
	}	
	$resultados = array();
	$resultados["hora"] = date("F j, Y, g:i a"); 
	$resultados["generador"] = "Enviado desde Solo Plancho" ;
	$query="select o.status,id_orden,cedula from orden_servicios o,clientes where reg_id=id_cliente  
		and id_orden='$usu' and cedula='$ced' limit 1";
	$res = mysql_query($query);
	$date=date("Y-m-d");
	if($res){
		$row=mysql_fetch_array($res);
	}else{
		$row=array();
	}
    if(count($row)){
	if($row['status']=='2'){
		$q="update orden_servicios set status='3' where id_orden='$usu'";
        	$result = mysql_query($q);
	
		if( $result){
			$resultados["mensaje"] = "Orden # $usu Recibida por Delivery";
		$up2="update usuario_ordenes set status='3',fecha_cumple='$date' where id_orden='$usu' and status='1'";
        	$resulta = mysql_query($up2);
			$resultados["error"] = "1";
		}else{
			$resultados["mensaje"] = "Error actualizando orden";
			$resultados["error"] = "2";
		}
	}else
	if($row['status']=='9'){
		$q="update orden_servicios set status='10',fecha_entrega='$date' where id_orden='$usu'";
	        $result = mysql_query($q);
		if( $result){
		$up2="update usuario_ordenes set status='5',fecha_cumple='$date' where id_orden='$usu' and status='4'";
        	$resulta = mysql_query($up2);
			$resultados["mensaje"] = "Orden # $usu Entregada Al cliente";
			$resultados["error"] = "1";
		}else{
			$resultados["mensaje"] = "Error actualizando orden";
			$resultados["error"] = "2";
		}
	}
	else{
		$resultados["mensaje"] = "Orden no esta en satus Asignada Delivery o Enviada al Cliente";
		$resultados["error"] = "4";
	}
    }else{
	$resultados["mensaje"] = "Error faltan datos";
	$resultados["error"] = "3";
	}
}else{
	$resultados["mensaje"] = "Error actualizando orden faltan datos";
	$resultados["error"] = "3";
}
/*convierte los resultados a formato json*/
echo json_encode($resultados);
?>
