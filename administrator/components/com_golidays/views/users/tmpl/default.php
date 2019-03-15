<?php
/**
* @version		v0.0.1
* @package		Golidays
* @subpackage	Email Templates
* @copyright	harvey
* @author		harvey - redweb.com
* @license		
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


GolidaysHelper::headerDeclarations();
//Load the formvalidator scripts requirements.
JDom::_('html.toolbar');
?>

<form action="<?php echo(JRoute::_("index.php")); ?>" method="post" name="adminForm" id="adminForm">
	<div class="row-fluid">
		<div id="sidebar" class="span2">
			<div class="sidebar-nav">

				<!-- BRICK : menu -->

				<?php echo JDom::_('html.menu.submenu', array(
					'list' => $this->menu
				)); ?>

				<div class="nav-filters">
					<!-- BRICK : filters -->


				</div>


			</div>
		</div>
		<div id="contents" class="span10">

			<!-- BRICK : filters -->

			<div class="pull-left">
				<?php echo $this->filters['search_search']->input;?>
			</div>


			<!-- BRICK : display -->

			<div class="pull-right">
				<?php echo $this->filters['sortTable']->input;?>
			</div>


			<div class="pull-right">
				<?php echo $this->filters['directionTable']->input;?>
			</div>


			<div class="pull-right">
				<?php echo $this->filters['limit']->input;?>
			</div>


			<div class="clearfix"></div>

			<!-- BRICK : grid -->

			<?php echo $this->loadTemplate('grid'); ?>

			<!-- BRICK : pagination -->

			<?php echo $this->pagination->getListFooter(); ?>

		</div>
	</div>


	<?php 
		$jinput = JFactory::getApplication()->input;
		echo JDom::_('html.form.footer', array(
		'values' => array(
					'view' => $jinput->get('view', 'user'),
					'layout' => $jinput->get('layout', 'default'),
					'boxchecked' => '0',
					'filter_order' => $this->escape($this->state->get('list.ordering')),
					'filter_order_Dir' => $this->escape($this->state->get('list.direction'))
				)));
	?>
</form>