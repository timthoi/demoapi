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


if (!$this->form)
	return;

$fieldSets = $this->form->getFieldsets();
?>

<?php $fieldSet = $this->form->getFieldset('coupon.form');?>
<fieldset class="fieldsform form-horizontal">

	<?php
	// Token
	$field = $fieldSet['jform_token'];
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
	// Quantity
	$field = $fieldSet['jform_quantity'];
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
	// Description
	$field = $fieldSet['jform_description'];
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
	// Expired date
	$field = $fieldSet['jform_expired_date'];
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