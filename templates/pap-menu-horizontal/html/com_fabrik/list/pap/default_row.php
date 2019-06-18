<?php
/**
 * Fabrik List Template: Admin Row
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2016  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

?>
<?php
//Obtenemos la página actual
$active = JFactory::getApplication()->getMenu()->getActive();
if ($active->id == 139) {
	$table = "t_grupos";
} elseif ($active->id == 140) {
	$table = "t_seminarios";
} else {
	$table = "t_tutelas";
}



$heading_id_asignatura = "t_asignaturas___id";
$id_asignatura_siguiente = (int)($this->_row->data->$heading_id_asignatura);

if ($GLOBALS['id_asignatura'] != $id_asignatura_siguiente) {
	$GLOBALS['id_asignatura'] = $id_asignatura_siguiente;
?>
<tr class="info-titulacion">
	<td colspan="<?php echo $this->colCount;?>">
		<?php
		$heading_asignatura = $table . "___asignatura";
		$heading_titulacion = "t_titulaciones___titulacion";
		$heading_curso = "t_asignaturas___curso";
		$heading_cuatrimestre = "t_asignaturas___cuatrimestre";
		$heading_coordinador = "t_asignaturas___coordinador";
		
		$asignatura = (string)($this->_row->data->$heading_asignatura);
		$titulacion = (string)($this->_row->data->$heading_titulacion);
		$curso = (string)($this->_row->data->$heading_curso);
		$cuatrimestre = (string)($this->_row->data->$heading_cuatrimestre);
		$coordinador = (string)($this->_row->data->$heading_coordinador);

		if (isset($_GET['group_by'])) {
		    echo $asignatura ." - ";
		} 
		echo $titulacion. " - " . $curso . " - " . $cuatrimestre . " - Coordinador: " . $coordinador;
		
		?>
	</td>
</tr>

<?php 
}
?>


<?php
	$active = JFactory::getApplication()->getMenu()->getActive();
	if ($active->id == 139) {
?>

<tr id="<?php echo $this->_row->id;?>" class="<?php echo $this->_row->class;?>">
	<?php
	$heading_grupo_grande = "t_grupos___grupo_grande";
	$grupo_grande = (int)($this->_row->data->$heading_grupo_grande) || 0;

	foreach ($this->headings as $heading => $label) {
		$style = empty($this->cellClass[$heading]['style']) ? '' : 'style="'.$this->cellClass[$heading]['style'].'"';
		if ($grupo_grande==0 && (strpos($heading, "___unidad_docente") || strpos($heading, "___grupo")) ) {
			$tdclass = "tdgrey";
		} else {
			$tdclass = "";
		}
		?>
		<td class="<?php echo $tdclass;?> <?php echo $this->cellClass[$heading]['class']?>" <?php echo $style?>>
			<?php echo isset($this->_row->data) ? $this->_row->data->$heading : '';?>
		</td>
	<?php 
	}
	?>
</tr>

<?php 
	} else {
?>

<tr id="<?php echo $this->_row->id;?>" class="<?php echo $this->_row->class;?>">
	<?php foreach ($this->headings as $heading => $label) {
		$style = empty($this->cellClass[$heading]['style']) ? '' : 'style="'.$this->cellClass[$heading]['style'].'"';
		?>
		<td class="<?php echo $this->cellClass[$heading]['class']?>" <?php echo $style?>>
			<?php echo isset($this->_row->data) ? $this->_row->data->$heading : '';?>
		</td>
	<?php }?>
</tr>

<?php
	}
?>

