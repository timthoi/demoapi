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



/**
* HTML Raw View class for the Golidays component
*
* @package	Golidays
* @subpackage	Class
*/
class GolidaysClassViewRaw extends GolidaysClassView
{
	/**
	* Shared function before to load the layout.
	*
	* @access	public
	* @param	string	$tpl	Template name.
	*
	*
	* @since	Cook 3.0
	*
	* @return	void
	*/
	public function display($tpl = null)
	{
		$jinput = JFactory::getApplication()->input;

		$field = $jinput->get('field', null, 'string');
		if ($field)
			$this->outputField($field);
	}

	/**
	* Output a single field from XML file.
	*
	* @access	public
	* @param	string	$name	Field to render.
	*
	*
	* @since	Cook 3.0
	*
	* @return	void
	*/
	public function outputField($name)
	{
		// Init some vars
		$jinput = JFactory::getApplication()->input;

		$value = $jinput->get('value');
		$control = $jinput->get('control');

		$name = preg_replace('/^(filter)?(jform)?\[/', '', $name);
		$name = preg_replace('/\]$/', '', $name);


		$model = $this->getModel();

		switch($control)
		{
			case 'form':
				// From form
				$xmlFileName = $model->getNameItem();
				break;


			case 'filter':
			default:
				// From filters
				$xmlFileName = 'filter_' . $model->getName();
				break;
		}

		JFormHelper::addFormPath(JPATH_GOLIDAYS .'/models/forms');

		$form = JForm::getInstance($xmlFileName, $xmlFileName);

		$fieldset = $form->getFieldset('ajax');


		if (!isset($fieldset[$name]))
			exit();

		$field = $fieldset[$name];

		if (!$control)
			$control = 'jform';

		$field->name = $control . '[' . $name . ']';

		if ($value)
			$field->setValue($value);

		// Send the Foreign Key Filter to the field
		$field->filterKey = $jinput->get('filterKey', null, 'cmd');
		$field->filterValue = $jinput->get('parent');


		$html = $field->renderField(array(
			'hiddenLabel' => true,
			'class' => 'control-ajax',
		));

		$html = $field->input;

		ob_clean();
		echo($html);
		jexit();
	}


}



