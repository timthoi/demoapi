<?php
/** 
* @package		Golidays
* @subpackage	Golidays
* @copyright	
* @author		 -  - 
* @license		
*
*             .oooO  Oooo.
*             (   )  (   )
* -------------\ (----) /----------------------------------------------------------- +
*               \_)  (_/
*/

defined('_JEXEC') or die;


/**
 * Build the route for the com_golidays component
 *
 * @param	array	An array of URL arguments
 *
 * @return	array	The URL arguments to use to assemble the subsequent URL.
 */
function GolidaysBuildRoute(&$query){

	$segments = array();
	if(isset($query['view']))
	{
		$view = $query['view'];
		$segments[] = $view;
		unset( $query['view'] );
	}

	if(isset($query['layout']))
	{
		$segments[] = $query['layout'];
		unset( $query['layout'] );
	}


	if(isset($query['id']))
	{
		if(in_array($view, array('reservation')))
		{
			$segments[] = (is_array($query['id'])?implode(',', $query['id']):$query['id']);
			unset( $query['id'] );
		}
	};


	return $segments;
}


/**
 * Parse the segments of a URL.
 *
 * @param	array	The segments of the URL to parse.
 *
 * @return	array	The URL attributes to be used by the application.
 */
function GolidaysParseRoute($segments)
{
	$vars = array();


	$vars['view'] = $segments[0];

	$nextPos = 1;
	if (isset($segments[$nextPos]))
	{
		$vars['layout'] = $segments[$nextPos];
		$nextPos++;
	}

	//Item layout : get the cid value
	if(in_array($vars['view'], array('reservation')) && isset($segments[$nextPos]))
	{
		$slug = $segments[$nextPos];
		$id = explode( ':', $slug );
		$vars['id'] = (int) $id[0];

		$nextPos++;
	}

	return $vars;
}

