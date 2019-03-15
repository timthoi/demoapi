<?php
/**
* @version
* @package		Golidays
* @subpackage	Users
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

<?php $fieldSet = $this->form->getFieldset('user.form');?>
<fieldset class="fieldsform form-horizontal">

	<?php
	// First Name
	$field = $fieldSet['jform_joomla_user_id'];
	$code = (isset($this->item->code)) ? $this->item->code : '';
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
    // First Name
    $field = $fieldSet['jform_first_name'];
    $code = (isset($this->item->code)) ? $this->item->code : '';
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
    // Full Name
    $field = $fieldSet['jform_last_name'];
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
    // Address
    $field = $fieldSet['jform_address'];
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
    // Gender
    $field = $fieldSet['jform_gender'];
    ?>
	<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>">
		<div class="control-label">
            <?php echo $field->label; ?>
		</div>

		<div class="controls">
            <?php echo $field->input; ?>
		</div>
	</div>

    <?php
    // Phone
    $field = $fieldSet['jform_phone'];
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
    // Email
    $field = $fieldSet['jform_email'];
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
		<div class="control-group <?php echo 'field-' . $field->id . $field->responsive; ?>" style="display: none">
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