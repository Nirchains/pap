<?php

// No direct access
defined('_JEXEC') or die('Restricted access');

//Recogemos los datos de conexión a la BD
$app= JFactory::getApplication();
$host = $app->getCfg('host');
$userbd = $app->getCfg('user');
$passbd = $app->getCfg('password');
$fabrikdb =  $app->getCfg('db2');

$con=mysqli_connect($host,$userbd,$passbd,$fabrikdb);

if (mysqli_connect_errno()) {
    $formModel->getForm()->error = "Failed to connect to MySQL: " . mysqli_connect_error();
}

$grupo_grande = (int)($formModel->getElementData('t_grupos___grupo_grande')[0]);


$sql_grupos = "select id
from t_grupos
where grupo_grande = ?
order by asignatura, grupo";
$stmt_grupos = $con->prepare($sql_grupos);
$stmt_grupos->bind_param('i',$grupo_grande);
$stmt_grupos->execute();

$result_grupos = $stmt_grupos->get_result();

$orden = 1;
while ($row = $result_grupos->fetch_assoc()) {
	$id_gg = $row["id"];

	//Actualizamos el grupo
	$query_update_grupo = "UPDATE t_grupos 
		SET orden = ?
		WHERE id = ?";

	$stmt_update_grupo_gr = $con->prepare($query_update_grupo);
	$stmt_update_grupo_gr->bind_param('ii',$orden,$id_gg);
	$stmt_update_grupo_gr->execute();
  	
	if ($stmt_update_grupo_gr->affected_rows) {
		//echo "<tr class='fabrik_row'><td>Grupos-orden ".$id_gg." actualizado con el orden ".$orden.". </td></tr>";	
	}
	$stmt_update_grupo_gr->close(); 
	
	$sql_grupos_p = "select id
					from t_grupos
					where grupo_grande = ?
					order by grupo";

	$stmt_grupo_p = $con->prepare($sql_grupos_p);
	$stmt_grupo_p->bind_param('i',$id_gg);
	$stmt_grupo_p->execute();

	$result_grupos_p = $stmt_grupo_p->get_result();

	while ($rowp = $result_grupos_p->fetch_assoc()) {
		$orden+=1;
		$id_gp = $rowp["id"];

		$stmt_update_grupo_p = $con->prepare($query_update_grupo);
		$stmt_update_grupo_p->bind_param('ii',$orden,$id_gp);
		$stmt_update_grupo_p->execute();
	  	
		if ($stmt_update_grupo_p->affected_rows) {
			//echo "<tr class='fabrik_row'><td>Grupos-orden ".$id_gp." actualizado con el orden ".$orden.". </td></tr>";	
		}

		$stmt_update_grupo_p->close(); 
	}
	$stmt_grupo_p->close(); 

	$orden+=1;
}

$stmt_grupos->close();
