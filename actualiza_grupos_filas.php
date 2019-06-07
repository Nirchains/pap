<?php
<tr class="fabrik_row actualiza-grupos"><td><b>Actualizando campo fila de la tabla grupos</b></td></tr>

$sql_grupos = "select id as grupo from t_grupos where grupo_grande = 0";
$stmt_grupos = $con->prepare($sql_grupos);
$stmt_grupos->execute();

$result_grupos = $stmt_grupos->get_result();

while ($row = $result_grupos->fetch_assoc()) {
  $grupo = $row["grupo"];

    //Obtenemos la suma de creditos asignados, la diferencia y el balance
  $sql_cuenta = "select count(g.id) as cuenta
  from t_grupos g 
  where g.grupo_grande = ?";

  $stmt_cuenta = $con->prepare($sql_cuenta);
  $stmt_cuenta->bind_param('i',$grupo);
  $stmt_cuenta->execute();

  $result_cuenta = $stmt_cuenta->get_result();

  if ($result_cuenta->num_rows > 0) {
    $row = $result_cuenta->fetch_assoc();
    $cuenta = (int)($row["cuenta"]);   
  } else {
    $cuenta = 0;
  }
  $stmt_cuenta->close();

  $update_query = "update t_grupos 
  set filas = ?
  where id = ?";
  $stmt_update_grupos = $con->prepare($update_query);
  $stmt_update_grupos->bind_param('ii',$cuenta,$grupo);
  $stmt_update_grupos->execute();
    //print_r($stmt_update_usuarios);
  if ($stmt_update_grupos->affected_rows) {
    echo "<tr class='fabrik_row'><td>Grupo ".$grupo." actualizado.</td></tr>";
  }

  $stmt_update_grupos->close();

} 

$stmt_grupos->close();

<tr class="fabrik_row actualiza-grupos"><td><b>Campo filas de la tabla grupos actualizado</b></td></tr>
?>