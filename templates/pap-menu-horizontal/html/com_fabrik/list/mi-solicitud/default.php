<?php
/**
 * Bootstrap List Template - Default
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2016  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @since       3.1
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

$pageClass = $this->params->get('pageclass_sfx', '');

if ($pageClass !== '') :
	echo '<div class="' . $pageClass . '">';
endif;

if ($this->tablePicker != '') : ?>
	<div style="text-align:right"><?php echo FText::_('COM_FABRIK_LIST') ?>: <?php echo $this->tablePicker; ?></div>
<?php
endif;

if ($this->params->get('show_page_heading')) :
	echo '<h1>' . $this->params->get('page_heading') . '</h1>';
endif;

if ($this->showTitle == 1) : ?>
	<div class="page-header">
		<h1>Mi Solicitud</h1>
	</div>
<?php
endif;



if(empty($this->rows[0])){ 
	?>
	<div class="row">
		<div class="span12 text-center">
	    <h3>A&uacute;n no tienes hecha tu solicitud. </h3>
	    <h3>Haz clic en <a href="mi-solicitud/form/3/" alt="Realizar solicitud"><b>"Realizar solicitud"</b></a> para comenzar. <br/><br/></h3>
		</div>
	</div>
	<div class="row">
		<div class="span12">
			<a class="btn span12" href="mi-solicitud/form/3/" alt="Realizar solicitud">
			<i class=" fa fa-file-alt fa-3x"></i>
			<h3>Realizar solicitud <i class="fa fa-arrow-right"></i></h3>
		</a>
		</div>
	</div>
<?php 
}
else
{ 
	// Intro outside of form to allow for other lists/forms to be injected.
	echo $this->table->intro;
	
	?>
	Estados de la solicitud:
<table class="estados">
	<tbody><tr>
		<td class="enviada">Enviada</td>
		<td class="validada">Validada</td>
		<td class="abierta">Abierta</td>
	</tr>
	</tbody></table>
	<form class="fabrikForm form-search" action="<?php echo $this->table->action;?>" method="post" id="<?php echo $this->formid;?>" name="fabrikList">
	
	<?php

	if ($this->showFilters && $this->bootShowFilters) :
		echo $this->layoutFilters();
	endif;
	//for some really ODD reason loading the headings template inside the group
	//template causes an error as $this->_path['template'] doesn't contain the correct
	// path to this template - go figure!
	$headingsHtml = $this->loadTemplate('headings');
	echo $this->loadTemplate('tabs');
	
	
	?>
	
	<div class="fabrikDataContainer">
	
	<?php foreach ($this->pluginBeforeList as $c) :
		echo $c;
	endforeach;	
	?>
	<table class="<?php echo $this->list->class;?>" id="list_<?php echo $this->table->renderid;?>" >
		 <thead><?php echo $headingsHtml?></thead>
		 <tfoot>
			<tr class="fabrik___heading">
				<td colspan="<?php echo count($this->headings);?>">
					<?php echo $this->nav;?>
				</td>
			</tr>
		 </tfoot>
		<?php
		if ($this->isGrouped && empty($this->rows)) :
			?>
			<tbody style="<?php echo $this->emptyStyle?>">
				<tr>
					<td class="groupdataMsg emptyDataMessage" style="<?php echo $this->emptyStyle?>" colspan="<?php echo count($this->headings)?>">
						<div class="emptyDataMessage" style="<?php echo $this->emptyStyle?>">
							<?php echo $this->emptyDataMessage; ?> 1
						</div>
					</td>
				</tr>
			</tbody>
			<?php
		endif;
		$gCounter = 0;
		foreach ($this->rows as $groupedBy => $group) :
			if ($this->isGrouped) : ?>
			<tbody>
				<tr class="fabrik_groupheading info">
					<td colspan="<?php echo $this->colCount;?>">
						<?php echo $this->layoutGroupHeading($groupedBy, $group); ?>
					</td>
				</tr>
			</tbody>
			<?php endif ?>
			<tbody class="fabrik_groupdata">
				<tr style="<?php echo $this->emptyStyle?>">
					<td class="groupdataMsg emptyDataMessage" style="<?php echo $this->emptyStyle?>" colspan="<?php echo count($this->headings)?>">
						<div class="emptyDataMessage" style="<?php echo $this->emptyStyle?>">
							<?php echo $this->emptyDataMessage; ?> 2
						</div>
					</td>
				</tr>
			<?php
			foreach ($group as $this->_row) :
				echo $this->loadTemplate('row');
		 	endforeach
		 	?>
		 	</tbody>
			<?php if ($this->hasCalculations) : ?>
			<tfoot>
				<tr class="fabrik_calculations">

				<?php
				foreach ($this->headings as $key => $heading) :
					$h = $this->headingClass[$key];
					$style = empty($h['style']) ? '' : 'style="' . $h['style'] . '"';?>
					<td class="<?php echo $h['class']?>" <?php echo $style?>>
						<?php
						$cal = $this->calculations[$key];
						echo array_key_exists($groupedBy, $cal->grouped) ? $cal->grouped[$groupedBy] : $cal->calc;
						?>
					</td>
				<?php
				endforeach;
				?>

				</tr>
			</tfoot>
			<?php endif ?>
		<?php
		$gCounter++;
		endforeach?>
	</table>
	<?php 
}	
print_r($this->hiddenFields);?>
</div>
</form>
<?php
echo $this->table->outro;
if ($pageClass !== '') :
	echo '</div>';
endif;
?>
