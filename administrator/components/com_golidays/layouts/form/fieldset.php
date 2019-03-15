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
$fieldset = $displayData['fieldset'];
?>

<?php foreach($fieldset as $field): ?>

	<?php echo(JLayoutHelper::render('form.field', array(
		'field' => $field
	)));?>

<?php endforeach; ?>