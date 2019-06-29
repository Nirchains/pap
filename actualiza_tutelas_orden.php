<tr class="fabrik_row actualiza-tutelas-orden"><td><b>Actualizando tutelas-orden</b></td></tr>
<?php

$sql_grupos = "select id
from t_tutelas
order by asignatura, unidad_docente, zona, id";
$stmt_grupos = $con->prepare($sql_grupos);
$stmt_grupos->execute();

$result_grupos = $stmt_grupos->get_result();

$orden = 1;
while ($row = $result_grupos->fetch_assoc()) {
	$id_g = $row["id"];

	//Actualizamos el grupo
	$query_update_grupo = "UPDATE t_tutelas 
		SET orden = ?
		WHERE id = ?";

	$stmt_update_grupo = $con->prepare($query_update_grupo);
	$stmt_update_grupo->bind_param('ii',$orden,$id_g);
	$stmt_update_grupo->execute();
  	
	if ($stmt_update_grupo->affected_rows) {
		echo "<tr class='fabrik_row'><td>Tutelas-orden ".$id_g." actualizado con el orden ".$orden.". </td></tr>";	
	}
	$stmt_update_grupo->close(); 
	
	$orden+=1;
}
$stmt_grupos->close();
?>
<tr class="fabrik_row actualiza-tutelas-orden"><td><b>Tutelas-orden actualizados</b></td></tr>