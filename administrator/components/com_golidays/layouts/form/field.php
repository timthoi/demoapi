<?php
/**
* @version		
* @package		Golidays
* @subpackage	Golidays
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



?>

<?php
// Initialize variables
$field = $displayData['field'];
?>

<?php if (GolidaysHelperForm::canView($field)): ?>

	<?php if ($field->hidden): ?>
		<?php echo $field->input; ?>

	<?php else: ?>
		<div class="control-group field-<?php echo $field->id . $field->responsive; ?>">

			<div class="control-label">
				<?php echo $field->label; ?>
			</div>

			<?php $selectors = (($field->type == 'Editor') ? ' style="clear: both; margin: 0;"' : ''); ?>
			<div class="controls"<?php echo $selectors; ?>>
				<?php echo $field->input; ?>
			</div>

		</div>

		<?php echo(GolidaysHelperHtmlValidator::loadValidator($field)); ?>

	<?php endif; ?>


<?php endif; ?>