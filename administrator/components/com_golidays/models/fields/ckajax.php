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
class JFormFieldCkajax extends GolidaysClassFormField
{
	/**
	* The form field type.
	*
	* @var string
	*/
	public $type = 'ckajax';

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

		$this->input = JDom::_('html.form.input.ajax', array_merge(array(
				'dataKey' => $this->getOption('name'),
				'domClass' => $this->getOption('class'),
				'domId' => $this->id,
				'domName' => $this->name,
				'ajaxContext' => $this->getOption('ajaxContext'),
				'ajaxVars' => array('values' => array($this->value)),
				'ajaxWrapper' => null,
				'dataValue' => $this->value,
				'prefix' => $this->getOption('prefix'),
				'responsive' => $this->getOption('responsive'),
				'suffix' => $this->getOption('suffix')
			), $this->jdomOptions));

		return parent::getInput();
	}


}



