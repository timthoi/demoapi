<?php
/**
* @version		
* @package		Golidays
* @subpackage	Usercoupons
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


if (!$this->form)
	return;

$fieldSets = $this->form->getFieldsets();

JHtml::_('behavior.calendar')
?>

<?php $fieldSet = $this->form->getFieldset('usercoupon.form');?>
<fieldset class="fieldsform form-horizontal">
    <?php /*
	<?php
	// User > Name
	$field = $fieldSet['jform_created_by'];
	$field->jdomOptions = array(
		'list' => $this->lists['fk']['user_id']
			);
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

		<div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo (GolidaysHelperHtmlValidator::loadValidator($field)); ?>

   */ ?>
	<?php
	// User id
	$field = $fieldSet['jform_user_id'];
	$field->jdomOptions = array(
		'list' => $this->lists['fk']['user_id']
			);
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(GolidaysHelperHtmlValidator::loadValidator($field)); ?>

	<?php
	// coupon_id
	$field = $fieldSet['jform_coupon_id'];
	$field->jdomOptions = array(
		'list' => $this->lists['fk']['coupon_id']
			);
	?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
			<?php echo $field->label; ?>
		</div>

	    <div class="controls">
			<?php echo $field->input; ?>
		</div>
	</div>
	<?php echo(GolidaysHelperHtmlValidator::loadValidator($field)); ?>

	<?php
	//  Status
	$field = $fieldSet['jform_status'];
	?>
    <div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
        <div class="control-label">
			<?php echo $field->label; ?>
        </div>

        <div class="controls">
			<?php echo $field->input; ?>
        </div>
    </div>
	<?php echo(GolidaysHelperHtmlValidator::loadValidator($field)); ?>


	<?php
	// Published
	$field = $fieldSet['jform_published'];
	?>
		<?php if (!method_exists($field, 'canView') || $field->canView()): ?>
		<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
			<div class="control-label">
				<?php echo $field->label; ?>
			</div>

		    <div class="controls">
				<?php echo $field->input; ?>
			</div>
		</div>
		<?php echo(GolidaysHelperHtmlValidator::loadValidator($field)); ?>
		<?php endif; ?>

</fieldset>