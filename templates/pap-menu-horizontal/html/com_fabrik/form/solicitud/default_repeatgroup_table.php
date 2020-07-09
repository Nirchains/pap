<?php
/**
 * Default Form Template: Repeat group rendered as a table
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2016  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       3.0.7
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

$group = $this->group;
?>
<table class="table repeatGroupTable" id="table<?php echo $group->id ?>">
	<thead>
		<tr>
	<?php
	// Add in the table heading
	$firstGroup = $group->subgroups[0];
	foreach ($firstGroup as $el) :
		$style = $el->hidden ? 'style="display:none"' : '';
		?>
		<th <?php echo $style; ?> class="<?php echo $el->containerClass?>">
			<?php echo $el->label_raw?>
		</th>
		<?php
	endforeach;

	// This column will contain the add/delete buttons
	if ($group->editable) : ?>
	<th data-role="fabrik-group-repeaters"></th>
	<?php
	endif;
	?>
	</tr>
	</thead>
	<tbody>
		<?php

		// Load each repeated group in a <tr>
		$this->i = 0;
		foreach ($group->subgroups as $subgroup) :
			$this->elements = $subgroup;
			echo $this->loadTemplate('repeatgroup_row');
			$this->i ++;
		endforeach;
		?>
	</tbody>
</table>


<script type="text/javascript">
function sortTable(tableid) {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById(tableid);
  switching = true;
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("td")[2];
      x = x.getElementsByTagName("select")[0];
      x = x.options[x.selectedIndex].text;
      
      y = rows[i + 1].getElementsByTagName("td")[2];
      y = y.getElementsByTagName("select")[0];
      y = y.options[y.selectedIndex].text;

      // Check if the two rows should switch place:
      if (x.toLowerCase() > y.toLowerCase()) {
        // If so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}

//sortTable("table4");
//sortTable("table25");
//sortTable("table28");



</script>
