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
* Form field for Golidays.
*
* @package	Golidays
* @subpackage	Form
*/
class GolidaysClassFormFieldModal extends JFormField
{
	/**
	* The modal height in pixels
	*
	* @var integer
	*/
	protected $height = 450;

	/**
	* The modal width in pixels
	*
	* @var integer
	*/
	protected $width = 400;

	/**
	* Method to get the field input markup.
	*
	* @access	protected
	*
	*
	* @since	11.1
	*
	* @return	string	The field input markup.
	*/
	protected function getInput()
	{
		$dom = JDom::getInstance();
		$dom->set('extension', 'com_golidays');


		$html =  JDom::_('html.form.input.select.modalpicker', array(
			'dataKey' => $this->id,
			'domName' => $this->name,
			'dataValue' => $this->value,
			'nullLabel' => $this->_nullLabel,
			'title' => $this->_title,

			'width' => $this->width,
			'height' => $this->height,

			'route' => array(
				'option' => $this->_option,
				'view' => $this->_view,
				'layout' => 'modal',
				'object' => $this->id

			),

			'tasks' => $this->getTasks(),

		));

		return $html;
	}

	/**
	* Method to extend the buttons in the picker.
	*
	* @access	protected
	*
	*
	* @since	Cook 2.5.8
	*
	* @return	array	An array of tasks
	*/
	protected function getTasks()
	{
		return array();

	}


}



