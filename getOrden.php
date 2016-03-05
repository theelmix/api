<?php 
require_once 'dbc.php'; // The mysql database connection script

/* Extrae los valores enviados desde la aplicacion movil */
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

$id_orden = mysql_escape_string($_GET['id_orden']);

<<<<<<< HEAD
$query="select id_orden, precio_orden, peso_libras, cantidad_piezas, id_cliente, status from orden_servicios where id_orden = '$id_orden'";
=======
$query="SELECT id_orden, precio_orden, peso_libras, cantidad_piezas, id_cliente, status, forma_entrega, observacion, precio_orden from orden_servicios where id_orden = '$id_orden'";
>>>>>>> 77cd5ef4d6d1db01d1621b69d26a08f58fc8338e
$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

$arr = array();
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
        /*defino el mensaje de status*/
        switch ($row['status']) {
            case '1':
                # code...
            $row['status'] = 'Nueva Orden';
                break;
            case '2':
                # code...
            $row['status'] = 'Asignada Delivery';
                break;
            case '3':
                # code...
            $row['status'] = 'Entregada Delivery';
                break;
            case '4':
                # code...
            $row['status'] = 'En Tienda';
                break;
            case '5':
                # code...
            $row['status'] = 'Asignada Operador';
                break;
            case '6':
                # code...
            $row['status'] = 'Planchada';
                break;
            case '7':
                # code...
            $row['status'] = 'Pago Pendiente';
                break;
            case '8':
                # code...
            $row['status'] = 'Cancelada';
                break;
            case '9':
                # code...
            $row['status'] = 'Enviada Cliente';
                break;
            case '10':
                # code...
            $row['status'] = 'Entregada Cliente';
                break;
            case '11':
                # code...
            $row['status'] = 'Observación';
                break;
            case '20':
                # code...
            $row['status'] = 'Anulada';
                break;
            
            default:
                # code...
            $row['status'] = 'Error contacte a nuestra oficina.';
                break;
        }

<<<<<<< HEAD
=======
        switch ($row['forma_entrega']) {
            case '1':
                # code...
            $row['forma_entrega'] = 'En tienda';
                break;
            case '2':
                # code...
            $row['forma_entrega'] = 'Delivery';
                break;            
            default:
                # code...
            $row['forma_entrega'] = '';
                break;
        }

>>>>>>> 77cd5ef4d6d1db01d1621b69d26a08f58fc8338e
		$arr[] = $row;	
	}
}


# JSON-encode the response
echo $json_response = json_encode($arr);
?>