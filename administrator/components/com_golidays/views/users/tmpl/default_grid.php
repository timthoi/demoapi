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
        'domId' => 'grid-user',
        'listOrder' => $listOrder,
        'listDirn' => $listDirn,
        'formId' => 'adminForm',
        'ctrl' => 'users',
        'proceedSaveOrderButton' => true,)
);
?>

<div class="clearfix"></div>
<div class="">
	<table class='table table-striped' id='grid-user'>
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
                        <?php echo JHTML::_('grid.sort',  "GOLIDAYS_HEADING_ORDERING", 'a.ordering', $listDirn, $listOrder); ?>
					</th>
                <?php endif; ?>

				<th style="text-align:center">
                    <?php echo JHTML::_('grid.sort',  JText::_("GOLIDAYS_FIELD_USERNAME"), 'a.username', $listDirn, $listOrder ); ?>
				</th>

				<th style="text-align:center">
                    <?php echo JText::_("GOLIDAYS_FIELD_FULL_NAME"); ?>
				</th>

				<th style="text-align:center">
                    <?php echo JText::_("GOLIDAYS_FIELD_PHONE"); ?>
				</th>

				<th style="text-align:center">
                    <?php echo JText::_("GOLIDAYS_FIELD_GENDER"); ?>
				</th>

				<th style="text-align:center">
                    <?php echo JText::_("GOLIDAYS_FIELD_ADDRESS"); ?>
				</th>

				<th style="text-align:center">
                    <?php echo JText::_("GOLIDAYS_FIELD_EMAIL"); ?>
				</th>

				<th style="text-align:center">
                    <?php echo JText::_("GOLIDAYS_FIELD_JOOMLA_USER_ID"); ?>
				</th>

				<th style="text-align:left">
					<?php echo JHTML::_('grid.sort',  "GOLIDAYS_FIELD_ID", 'a.id', $listDirn, $listOrder); ?>
				</th>
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
                        'dataKey' => 'username',
                        'dataObject' => $row,
                        'route' => array('view' => 'user','layout' => 'user','cid[]' => $row->id)
                    ));?>
				</td>

				<td style="text-align:left">
					<?php echo $row->last_name . ' ' . $row->first_name?>
				</td>

				<td style="text-align:left;" >
                    <?php $tmp = JDom::_('html.fly', array(
                        'dataKey' => 'phone',
                        'dataObject' => $row
                    ));

                    echo (!empty($row->phone)) ? $tmp : '-';
                    ?>
				</td>


				<td style="text-align:left;" >
					<span class="badge"><?php echo GolidaysHelperEnum::_('gender')[$row->gender]['text'] ?></span>
				</td>

				<td style="text-align:left;" >
                    <?php $tmp = JDom::_('html.fly', array(
                        'dataKey' => 'address',
                        'dataObject' => $row
                    ));

                    echo (!empty($row->address)) ? $tmp : '-';
                    ?>
				</td>

				<td style="text-align:left;" >
                    <?php $tmp = JDom::_('html.fly', array(
                        'dataKey' => 'email',
                        'dataObject' => $row
                    ));

                    echo (!empty($row->email)) ? $tmp : '-';
                    ?>
				</td>


				<td style="text-align:left">
					<?php echo JDom::_('html.fly', array(
						'dataKey' => 'username',
						'dataObject' => $row,
						'route' => array('option' => 'com_users','view' => 'user','layout' => 'edit','id' => $row->joomla_user_id)
					));?>
				</td>

				<td style="text-align:left">
					<?php echo JDom::_('html.fly', array(
						'dataKey' => 'id',
						'dataObject' => $row
					));?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		endfor;
		?>
		</tbody>
	</table>
</div>