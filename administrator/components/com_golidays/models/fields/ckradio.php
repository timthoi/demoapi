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

if (!class_exists('GolidaysHelper'))
	require_once(JPATH_ADMINISTRATOR . '/components/com_golidays/helpers/loader.php');


/**
* Form field for Golidays.
*
* @package	Golidays
* @subpackage	Form
*/
class JFormFieldCkradio extends GolidaysClassFormField
{
	/**
	* The form field type.
	*
	* @var string
	*/
	public $type = 'ckradio';

	/**
	* Method to get the field input markup.
	*
	* @access	public
	*
	*
	* @since	11.1
	*
	* @return	string	The field input markup.
	*/
	public function getInput()
	{
		$options = array();
		if (!isset($this->jdomOptions['list']))
		{
			//Get the options from XML
			foreach ($this->element->children() as $option)
			{
				if ($option->getName() != 'option')
					continue;

				$opt = new stdClass();
				foreach($option->attributes() as $attr => $value)
					$opt->$attr = (string)$value;

				$opt->text = JText::_(trim((string) $option));
				$options[] = $opt;
			}
		}
		$this->input = JDom::_('html.form.input.radio', array_merge(array(
				'dataKey' => $this->getOption('name'),
				'domClass' => $this->getOption('class'),
				'domId' => $this->id,
				'domName' => $this->name,
				'applyAccess' => $this->getOption('applyAccess'),
				'dataValue' => (string)$this->value,
				'labelKey' => $this->getOption('labelKey'),
				'list' => $options,
				'listKey' => $this->getOption('listKey'),
				'nullLabel' => $this->getOption('nullLabel'),
				'prefix' => $this->getOption('prefix'),
				'responsive' => $this->getOption('responsive'),
				'submitEventName' => ($this->getOption('submit') == 'true'?'onclick':null),
				'suffix' => $this->getOption('suffix'),
				'viewType' => $this->getOption('viewType')
			), $this->jdomOptions));

		return parent::getInput();
	}


}



