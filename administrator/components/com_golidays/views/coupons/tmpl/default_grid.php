<?php
/**
* @version		
* @package		Golidays
* @subpackage	coupons
* @copyright	
* @author		 Harvey - timthoi
* @license		
*
*             .oooO  Oooo.
*             (   )  (   )
* -------------\ (----) /----------------------------------------------------------- +
*               \_)  (_/
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


JHtml::addIncludePath(JPATH_ADMIN_GOLIDAYS.'/helpers/html');
JHtml::_('behavior.tooltip');
//JHtml::_('behavior.multiselect');

$model		= $this->model;
$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$saveOrder	= $listOrder == 'a.ordering' && $listDirn != 'desc';
JDom::_('framework.sortablelist', array(
	'domId' => 'grid-coupons',
	'listOrder' => $listOrder,
	'listDirn' => $listDirn,
	'formId' => 'adminForm',
	'ctrl' => 'coupons',
	'proceedSaveOrderButton' => true,
));
?>

<div class="clearfix"></div>
<div class="">
	<table class='table' id='grid-coupons'>
		<thead>
			<tr>
				<?php if ($model->canSelect()): ?>
				<th>
					<?php echo JDom::_('html.form.input.checkbox', array(
						'dataKey' => 'checkall-toggle',
						'title' => JText::_('JGLOBAL_CHECK_ALL'),
						'selectors' => array(
							'onclick' => 'Joomla.checkAll(this);'
						)
					)); ?>
				</th>
				<?php endif; ?>

				<?php if ($model->canEditState()): ?>
				<th style="text-align:center">
					<?php echo JHTML::_('grid.sort',  "GOLIDAYS_HEADING_ORDERING", 'a.ordering', $listDirn, $listOrder ); ?>
				</th>
				<?php endif; ?>

				<th style="text-align:left">
					<?php echo JHTML::_('grid.sort',  "GOLIDAYS_FIELD_TOKEN", 'a.token', $listDirn, $listOrder ); ?>
				</th>

                <th style="text-align:left">
	                <?php echo JText::_('GOLIDAYS_FIELD_QUANTITY'); ?>
                </th>

                <th style="text-align:left">
					<?php echo JText::_('GOLIDAYS_FIELD_DESCRIPTION'); ?>
                </th>

				<th style="text-align:left">
					<?php echo JHTML::_('grid.sort',  "GOLIDAYS_FIELD_EXPIRED_DATE", 'a.expired_date', $listDirn, $listOrder ); ?>
				</th>

				<?php if ($model->canEditState()): ?>
				<th style="text-align:center">
					<?php echo JText::_("GOLIDAYS_FIELD_PUBLISHED"); ?>
				</th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
		<?php
		$k = 0;
		for ($i=0, $n=count( $this->items ); $i < $n; $i++):
			$row = $this->items[$i];

			?>

			<tr class="<?php echo "row$k"; ?>">
				<?php if ($model->canSelect()): ?>
				<td>
					<?php if ($row->params->get('access-edit') || $row->params->get('tag-checkedout')): ?>
						<?php echo JDom::_('html.grid.checkedout', array(
													'dataObject' => $row,
													'num' => $i
														));
						?>
					<?php endif; ?>
				</td>
				<?php endif; ?>

				<?php if ($model->canEditState()): ?>
				<td style="text-align:center">
					<?php echo JDom::_('html.grid.ordering', array(
						'aclAccess' => 'core.edit.state',
						'dataKey' => 'ordering',
						'dataObject' => $row,
						'enabled' => $saveOrder
					));?>
				</td>
				<?php endif; ?>

				<td style="text-align:left">
					<?php echo JDom::_('html.fly', array(
						'dataKey' => 'token',
						'dataObject' => $row,
						'route' => array('view' => 'coupon','layout' => 'coupon','cid[]' => $row->id)
					));?>
				</td>

                <td style="text-align:left">
					<?php

                    echo JDom::_('html.fly', array(
						'dataKey' => 'quantity',
						'dataObject' => $row
					));?>
                </td>

                <td style="text-align:left">
	                <?php

	                echo JDom::_('html.fly', array(
		                'dataKey' => 'description',
		                'dataObject' => $row
	                ));?>
                </td>

				<td style="text-align:left">
					<?php echo JDom::_('html.fly.datetime', array(
						'dataKey' => 'expired_date',
						'dataObject' => $row,
						'dateFormat' => 'd-m-Y H:i:s'
					));?>
				</td>


				<?php if ($model->canEditState()): ?>
				<td style="text-align:center">
					<?php echo JDom::_('html.grid.publish', array(
						'ctrl' => 'coupons',
						'dataKey' => 'published',
						'dataObject' => $row,
						'num' => $i
					));?>
				</td>
				<?php endif; ?>
			</tr>
			<?php
			$k = 1 - $k;
		endfor;
		?>
		</tbody>
	</table>
</div>