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
* Form validator rule for Golidays.
*
* @package	Golidays
* @subpackage	Form
*/
class JFormRuleFile extends GolidaysClassFormRule
{
	/**
	* Indicates that this class contains special methods (ie: get()).
	*
	* @var boolean
	*/
	public $extended = true;

	/**
	* Unique name for this rule.
	*
	* @var string
	*/
	protected $handler = 'file';

	/**
	* Use this function to customize your own javascript rule.
	* $this->regex must be null if you want to customize here.
	*
	* @access	public
	* @param	JFormField	$field	The form field object.
	*
	* @return	string	A JSON string representing the javascript rules validation.
	*/
	public function getJsonRule($field)
	{
		$regex = '';
		$allowedExtensionsText = '*.*';
		if ($allowedExtensions = $field->getAttribute('allowedExtensions'))
		{
			$allowedExtensionsText = preg_replace("/\|/", "<br/>", $allowedExtensions);
			//Remove eventual '*.'
			$allowedExtensions = preg_replace("/\*\./", "", $allowedExtensions);

			$regex = '\.(' . $allowedExtensions . ')$';
		}

		$values = array(
			"#regex" => 'new RegExp("' . $regex . '", \'i\')'
		);

		if ($msgIncorrect = $field->getAttribute('msg-incorrect'))
			$values["alertText"] = LI_PREFIX . JText::_($msgIncorrect);
		else
			$values["alertText"] = LI_PREFIX . JText::sprintf('GOLIDAYS_ERROR_ALLOWED_FILES', $allowedExtensionsText);

		$json = GolidaysHelperHtmlValidator::jsonFromArray($values);
		return "{" . LN . $json . LN . "}";
	}


}



