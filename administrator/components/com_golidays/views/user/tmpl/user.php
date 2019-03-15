<?php
/**
* @version		
* @package		Golidays
* @subpackage	Users
* @copyright	
* @author		 Harvey - timthoi
* @license
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


GolidaysHelper::headerDeclarations();
//Load the formvalidator scripts requirements.
JDom::_('html.toolbar');
?>

<script language="javascript" type="text/javascript">
	//Secure the user navigation on the page, in order preserve datas.
	var holdForm = true;
	window.onbeforeunload = function closeIt(){	if (holdForm) return false;};
</script>

<form action="<?php echo(JRoute::_("index.php")); ?>" method="post" name="adminForm" id="adminForm" class='form-validate' enctype='multipart/form-data'>
	<div class="row-fluid">
		<div id="contents" class="span12">
			<!-- BRICK : toolbar_sing -->
			<?php echo $this->renderToolbar();?>
			<!-- BRICK : form -->
			<?php echo $this->loadTemplate('form'); ?>
		</div>
	</div>


	<?php
		$jinput = JFactory::getApplication()->input;
		echo JDom::_('html.form.footer', array(
		'dataObject' => $this->item,
		'values' => array(
					'id' => $this->state->get('user.id')
				)));
	?>
</form>
<div class="toolbar"></div>
<script type="text/javascript">
    jQuery(function($){
        var $toolbar = $('#toolbar').clone();
        $('.toolbar').html($toolbar);
    });
</script>