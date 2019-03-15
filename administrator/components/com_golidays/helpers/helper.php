<?php
/**
 * @version
 * @package        Golidays
 * @subpackage     Golidays
 * @copyright
 * @author         Harvey - timthoi
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
 * Golidays Helper functions.
 *
 * @package       Golidays
 * @subpackage    Helper
 */
class GolidaysHelper
{
	/**
	 * Cache for ACL actions
	 *
	 * @var object
	 */
	protected static $acl = null;

	/**
	 * Directories aliases.
	 *
	 * @var array
	 */
	protected static $directories;

	/**
	 * Determines when requirements have been loaded.
	 *
	 * @var boolean
	 */
	protected static $loaded = null;

	/**
	 * Call a JS file. Manage fork files.
	 *
	 * @access    protected static
	 *
	 * @param    string  $base    Component base from site root.
	 * @param    string  $file    Script file.
	 * @param    boolean $replace Replace the file or override. (Default : Replace)
	 *
	 *
	 * @since     Cook 2.0
	 *
	 * @return    void
	 */
	protected static function addScript($base, $file, $replace = true)
	{
		$doc = JFactory::getDocument();

		$url = JURI::root(true) . '/' . $base . '/' . $file;
		$url = str_replace(DS, '/', $url);

		$urlFork = null;
		if (file_exists(JPATH_SITE . DS . $base . DS . 'fork' . DS . $file))
		{
			$urlFork = JURI::root(true) . '/' . $base . '/fork/' . $file;
			$urlFork = str_replace(DS, '/', $urlFork);
		}

		if ($replace && $urlFork)
			$url = $urlFork;

		$doc->addScript($url);

		if (!$replace && $urlFork)
			$doc->addScript($urlFork);
	}

	/**
	 * Call a CSS file. Manage fork files.
	 *
	 * @access    protected static
	 *
	 * @param    string  $base    Component base from site root.
	 * @param    string  $file    Stylesheet file.
	 * @param    boolean $replace Replace the file or override. (Default : Override)
	 *
	 *
	 * @since     Cook 2.0
	 *
	 * @return    void
	 */
	protected static function addStyleSheet($base, $file, $replace = false)
	{
		$doc = JFactory::getDocument();

		$url = JURI::root(true) . '/' . $base . '/' . $file;
		$url = str_replace(DS, '/', $url);

		$urlFork = null;
		if (file_exists(JPATH_SITE . '/' . $base . '/fork/' . $file))
		{
			$urlFork = JURI::root(true) . '/' . $base . '/fork/' . $file;
			$urlFork = str_replace(DS, '/', $urlFork);
		}

		if ($replace && $urlFork)
			$url = $urlFork;

		$doc->addStyleSheet($url);

		if (!$replace && $urlFork)
			$doc->addStyleSheet($urlFork);
	}

	/**
	 * Configure the Linkbar
	 *
	 * @access    public static
	 *
	 * @param    varchar $view   The name of the active view.
	 * @param    varchar $layout The name of the active layout.
	 * @param    varchar $alias  The name of the menu. Default : 'menu'
	 *
	 *
	 * @since     1.6
	 *
	 * @return    void
	 */
	public static function addSubmenu($view, $layout, $alias = 'menu')
	{
		$items = static::getMenuItems();

		// Will be handled in XML in future (or/and with the Joomla native menus)
		// -> give your opinion on j-cook.pro/forum


		$client = 'admin';
		if (JFactory::getApplication()->isSite())
			$client = 'site';

		$links = array();
		switch ($client)
		{
			case 'admin':
				switch ($alias)
				{
					case 'cpanel':
					case 'menu':
					default:
						$links = array(
							'admin.users.default',
							'admin.usercoupons.default',
							'admin.coupons.default'
						);

						if ($alias != 'cpanel')
							array_unshift($links, 'admin.cpanel');

						break;
				}
				break;

			case 'site':
				switch ($alias)
				{
					case 'cpanel':
					case 'menu':
					default:
						$links = array(
							'site.usercoupons.default'
						);

						if ($alias != 'cpanel')
							array_unshift($links, 'site.cpanel');

						break;
				}
				break;
		}


		//Compile with selected items in the right order
		$menu = array();
		foreach ($links as $link)
		{
			if (!isset($items[$link]))
				continue;    // Not found

			$item = $items[$link];

			// Menu link
			$extension = 'com_golidays';
			if (isset($item['extension']))
				$extension = $item['extension'];

			$url = 'index.php?option=' . $extension;
			if (isset($item['view']))
				$url .= '&view=' . $item['view'];
			if (isset($item['layout']))
				$url .= '&layout=' . $item['layout'];

			// Is active
			$active = ($item['view'] == $view);
			if (isset($item['layout']))
				$active = $active && ($item['layout'] == $layout);

			// Reconstruct it the Joomla format
			$menu[] = array(JText::_($item['label']), $url, $active, $item['icon']);

		}

		return $menu;
	}

	/**
	 * Method to a model from a namespace.
	 *
	 * @access    public static
	 *
	 * @param    string  $model The namespaced model.
	 * @param    boolean $item  Sibling model. true: return ITEM model. false: return LIST model.
	 *
	 *
	 * @since     Cook 3.0.10
	 *
	 * @return    JModel    The model.
	 */
	public static function componentModel($model, $item = null)
	{
		$extension = 'golidays';

		$parts = explode('.', $model);
		if (count($parts) > 1)
		{
			if ($parts[0] != $extension)
			{
				$extension = $parts[0];
				self::loadComponentModels($extension);
			}
			$model = $parts[1];
		}

		$model = CkJModel::getInstance($model, ucfirst($extension) . 'Model');

		// Return a sibling model
		if ($item === true && method_exists($model, 'getNameItem'))
			$model = JModelLegacy::getInstance($model->getNameItem(), ucfirst($extension) . 'Model');
		else if ($item === false && method_exists($model, 'getNameList'))
			$model = JModelLegacy::getInstance($model->getNameList(), ucfirst($extension) . 'Model');

		return $model;
	}

	/**
	 * Deprecated function. Prepare the enumeration static lists.
	 * Use Instead : XxxxHelperEnum::_('my_list')
	 *
	 * @access    public static
	 *
	 * @param    string $ctrl      The model in wich to find the list.
	 * @param    string $fieldName The field reference for this list.
	 *
	 * @return    array    Prepared arrays to fill lists.
	 */
	public static function enumList($ctrl, $fieldName)
	{
		// Proxy to the enumeration helper
		return GolidaysHelperEnum::_($ctrl . '_' . $fieldName);
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @access        public static
	 *
	 *
	 * @deprecated    Cook 2.0
	 *
	 * @return    JObject    An ACL object containing authorizations
	 */
	public static function getAcl()
	{
		return self::getActions();
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @access    public static
	 *
	 * @param    integer $itemId The item ID.
	 *
	 *
	 * @since     1.6
	 *
	 * @return    JObject    An ACL object containing authorizations
	 */
	public static function getActions($itemId = 0)
	{
		if (isset(self::$acl))
			return self::$acl;

		$user   = JFactory::getUser();
		$result = new JObject;

		$actions = array(
			'core.enter',
			'core.admin',
			'core.manage',
			'core.create',
			'core.edit',
			'core.edit.state',
			'core.edit.own',
			'core.delete',
			'core.delete.own',
			'core.view.own',
		);

		foreach ($actions as $action)
			$result->set($action, $user->authorise($action, COM_GOLIDAYS));

		self::$acl = $result;

		return $result;
	}

	/**
	 * Return the directories aliases full paths
	 *
	 * @access    public static
	 *
	 *
	 * @since     Cook 2.6.4
	 *
	 * @return    array    Arrays of aliases relative path from site root.
	 */
	public static function getDirectories()
	{
		if (!empty(self::$directories))
			return self::$directories;

		$comAlias     = "com_golidays";
		$configMedias = JComponentHelper::getParams('com_media');
		$config       = JComponentHelper::getParams($comAlias);

		$directories = array(

			'DIR_FILES' => "[COM_SITE]" . DS . "files",
			'DIR_TRASH' => $config->get("trash_dir", 'images' . DS . "trash"),
			'IMAGES'    => '[IMAGES]',
		);

		$bases = array(
			'COM_ADMIN' => "administrator" . DS . 'components' . DS . $comAlias,
			'ADMIN'     => "administrator",
			'COM_SITE'  => 'components' . DS . $comAlias,
			'IMAGES'    => $config->get('image_path', 'images'),
			'MEDIAS'    => $configMedias->get('file_path', 'images'),
			'ROOT'      => '',

		);


		// Parse the directory aliases
		foreach ($directories as $alias => $directory)
		{
			// Parse the component base folders
			foreach ($bases as $aliasBase => $directoryBase)
				$directories[$alias] = preg_replace("/\[" . $aliasBase . "\]/", $directoryBase, $directories[$alias]);

			// Clean tags if remains
			$directories[$alias] = preg_replace("/\[.+\]/", "", $directories[$alias]);
		}

		self::$directories = $directories;

		return self::$directories;

	}

	/**
	 * JDom helper. Get a file path or url depending of the method
	 *
	 * @access    public static
	 *
	 * @param    string $path    File path. Can contain directories aliases.
	 * @param    string $method  Method to access the file : [direct,indirect,physical]
	 * @param    array  $attribs Image thumb attributes. Can handle legacy array options.
	 *
	 *
	 * @since     Cook 2.9
	 *
	 * @return    string    File path or url
	 */
	public static function getFile($path, $method = 'physical', $attribs = null)
	{
		if (is_array($attribs))
			$attribs = GolidaysHelperFile::getAttributesFromLegacy($attribs);

		return GolidaysHelperFile::getFileUrl($path, $method, $attribs);
	}

	/**
	 * Load all menu items.
	 *
	 * @access    public static
	 *
	 *
	 * @since     Cook 2.0
	 *
	 * @return    void
	 */
	public static function getMenuItems()
	{
		// Will be handled in XML in future (or/and with the Joomla native menus)
		// -> give your opinion on j-cook.pro/forum

		$items = array();

		$items['admin.users.default'] = array(
			'label'  => 'GOLIDAYS_LAYOUT_USERS',
			'view'   => 'users',
			'layout' => 'default',
			'icon'   => 'golidays_users'
		);

		$items['admin.usercoupons.default'] = array(
			'label'  => 'GOLIDAYS_LAYOUT_RESERVATIONS',
			'view'   => 'usercoupons',
			'layout' => 'default',
			'icon'   => 'golidays_usercoupons'
		);

		$items['admin.coupons.default'] = array(
			'label'  => 'GOLIDAYS_LAYOUT_COUPONS',
			'view'   => 'coupons',
			'layout' => 'default',
			'icon'   => 'golidays_coupons'
		);

		$items['admin.cpanel.default'] = array(
			'label'  => 'GOLIDAYS_LAYOUT_CONTROL_PANEL',
			'view'   => 'cpanel',
			'layout' => 'default',
			'icon'   => 'golidays_cpanel'
		);

		return $items;
	}

	/**
	 * Defines the headers of your template.
	 *
	 * @access    public static
	 *
	 * @return    void
	 */
	public static function headerDeclarations()
	{
		if (self::$loaded)
			return;

		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();

		$siteUrl = JURI::root(true);

		$baseSite  = 'components/' . COM_GOLIDAYS;
		$baseAdmin = 'administrator/components/' . COM_GOLIDAYS;

		$componentUrl      = $siteUrl . '/' . $baseSite;
		$componentUrlAdmin = $siteUrl . '/' . $baseAdmin;

		JHtml::_('jquery.framework');
		JHtml::_('formbehavior.chosen', 'select');

		//JDom::_('framework.hook');
		JDom::_('html.icon.glyphicon');


		//Load the jQuery-Validation-Engine (MIT License, Copyright(c) 2011 Cedric Dugas http://www.position-absolute.com)
		self::addScript($baseAdmin, 'js/jquery.validationEngine.js');
		self::addStyleSheet($baseAdmin, 'css/validationEngine.jquery.css');
		GolidaysHelperHtmlValidator::loadLanguageScript();
		GolidaysHelperHtmlValidator::attachForm();


		//CSS
		if ($app->isAdmin())
		{


			self::addStyleSheet($baseAdmin, 'css/golidays.css');
			self::addStyleSheet($baseAdmin, 'css/toolbar.css');

		}
		else if ($app->isSite())
		{
			self::addStyleSheet($baseSite, 'css/golidays.css');
			self::addStyleSheet($baseSite, 'css/toolbar.css');

		}


		self::$loaded = true;
	}

	/**
	 * Method to include the model paths in the loader.
	 *
	 * @access    public static
	 *
	 * @param    string $extension The component alias.
	 *
	 *
	 * @since     Cook 3.0.10
	 *
	 * @return    void
	 */
	public static function loadComponentModels($extension)
	{
		$basePath = (JFactory::getApplication()->isSite() ? JPATH_SITE : JPATH_ADMINISTRATOR);
		CkJModel::addIncludePath($basePath . '/components/com_' . $extension . '/models');
	}

	/**
	 * Load the fork file. (Cook Self Service concept)
	 *
	 * @access    public static
	 *
	 * @param    string $file Current file to fork.
	 *
	 *
	 * @since     Cook 2.6.3
	 *
	 * @return    void
	 */
	public static function loadFork($file)
	{
		//Transform the file path to reach the fork directory
		$file = preg_replace("#com_golidays#", 'com_golidays/fork', $file);

		// Load the fork file.
		if (!empty($file) && file_exists($file))
			include_once($file);
	}

	/**
	 * Method to parse a field value.
	 *
	 * @access    public static
	 *
	 * @param    Object $item     The item data object.
	 * @param    string $labelKey The field key. For concat : {field1} {field2}.
	 *
	 *
	 * @since     Cook 3.0.10
	 *
	 * @return    mixed    Parsed value.
	 */
	public static function parseValue($item, $labelKey)
	{
		preg_match_all('/{([a-zA-Z0-9_]+)}/', $labelKey, $matches);

		if (!count($matches[0]))
			return $item->$labelKey;

		$replaceFrom = array();
		$replaceTo   = array();

		foreach ($matches[1] as $key)
		{
			$replaceFrom[] = '{' . $key . '}';
			$replaceTo[]   = $item->$key;
		}

		$text = str_replace($replaceFrom, $replaceTo, $labelKey);

		return $text;
	}

	/**
	 * Recreate the URL with a redirect in order to : -> keep an good SEF ->
	 * always kill the post -> precisely control the request
	 *
	 * @access    public static
	 *
	 * @param    array $vars The array to override the current request.
	 *
	 * @return    string    Routed URL.
	 */
	public static function urlRequest($vars = array())
	{
		$parts = array();

		// Authorisated followers
		$authorizedInUrl = array(
			'option' => null,
			'view'   => null,
			'layout' => null,
			'format' => null,
			'Itemid' => null,
			'tmpl'   => null,
			'object' => null,
			'lang'   => null,
			'field'  => null,
		);

		$jinput = JFactory::getApplication()->input;

		$request = $jinput->getArray($authorizedInUrl);

		foreach ($request as $key => $value)
			if (!empty($value))
				$parts[] = $key . '=' . $value;

		$cid = $jinput->get('cid', array(), 'ARRAY');
		if (!empty($cid))
		{
			$cidVals = implode(",", $cid);
			if ($cidVals != '0')
				$parts[] = 'cid[]=' . $cidVals;
		}

		if (count($vars))
			foreach ($vars as $key => $value)
				$parts[] = $key . '=' . $value;

		return JRoute::_("index.php?" . implode("&", $parts), false);
	}

	/**
	 * Method to get price of one ticket
	 *
	 * @access    public static
	 *
	 * @param    int    $ticketTypeId    Ticket type item.
	 * @param    int    $departureCityId Departure City ID
	 * @param    string $departureDate   Departure Date
	 *
	 *
	 * @since     Cook 3.0.10
	 *
	 * @return    float    Ticket PRice.
	 */
	public static function getTicketPrice($ticketTypeId, $departureCityId, $departureDate)
	{
		$modelTicketTypeId = CkJModel::getInstance('Tickettype', 'GolidaysModel');
		$ticketType        = $modelTicketTypeId->getItem($ticketTypeId);

		$config   = JFactory::getConfig();
		$fromname = $config->get('offset');
		$timezone = new DateTimeZone($fromname);

		$date = new JDate(strtotime($departureDate));
		$date->setTimezone($timezone);

		//$dayOfWeek = $date->format('l');
		$day = intval($date->format('d'));
		//$monthYear = $date->format('F');
		$month = intval($date->format('m'));
		$year  = intval($date->format('Y'));

		$pricelist = json_decode($ticketType->pricelist);
		foreach ($pricelist as $price)
		{
			//var_dump($price);
		}

		$priceFilterArr = array_filter(
			$pricelist,
			function ($e) use ($departureCityId, $month, $year) {
				return ($e->departure_city_id == $departureCityId && $e->month_id == $month && $e->year == $year);
			}
		);

		if (!empty($priceFilterArr))
		{
			$priceOject = reset($priceFilterArr);
			// 1st forthnight

			if ($day < 16 && $day >= 1)
			{
				return $priceOject->price_1;
			}

			if ($day >= 16 && $day <= 31)
			{
				return $priceOject->price_2;
			}
		}

		return 0;
	}

	/**
	 * Method to get type Flight
	 *
	 * @access    public static
	 *
	 * @param    int    $ticketTypeId    Ticket type item.
	 * @param    int    $departureCityId Departure City ID
	 * @param    string $departureDate   Departure Date
	 *
	 *
	 * @since     Cook 3.0.10
	 *
	 * @return    float    Ticket PRice.
	 */
	public static function getTicketFlight($ticketTypeId, $departureCityId, $departureDate)
	{
		$modelTicketTypeId = CkJModel::getInstance('Tickettype', 'GolidaysModel');
		$ticketType        = $modelTicketTypeId->getItem($ticketTypeId);

		$config   = JFactory::getConfig();
		$fromname = $config->get('offset');
		$timezone = new DateTimeZone($fromname);

		$date = new JDate(strtotime($departureDate));
		$date->setTimezone($timezone);

		//$dayOfWeek = $date->format('l');
		$day = intval($date->format('d'));
		//$monthYear = $date->format('F');
		$month = intval($date->format('m'));
		$year  = intval($date->format('Y'));

		$pricelist = json_decode($ticketType->pricelist);

		$priceFilterArr = array_filter(
			$pricelist,
			function ($e) use ($departureCityId, $month, $year) {
				return ($e->departure_city_id == $departureCityId && $e->month_id == $month && $e->year == $year && $e->type_flight);
			}
		);

		if (!empty($priceFilterArr))
		{
			$tmp = array();
			foreach ($priceFilterArr as $item) $tmp[] = (int)$item->type_flight;
			return $tmp;
		}

		return 0;
	}

	/**
	 * Method to calculate ticket pirce, ticket total, discount
	 *
	 * @access    public static
	 *
	 * @param    int    $ticketTypeId    Ticket type item.
	 * @param    int    $departureCityId Departure City ID
	 * @param    string $departureDate   Departure Date
	 *
	 *
	 * @since     Cook 3.0.10
	 *
	 * @return    array    (ticket_price, ticket_total, discount).
	 */
	public static function calculateTicketPrice($ticketTypeId, $departureCityId, $departureDate, $numberAdultTicket, $numberChildrentTicket1, $numberChildrentTicket2)
	{
		if (!$ticketTypeId || !$departureCityId || empty($departureDate) || !$numberAdultTicket)
		{
			return array('ticket_price' => 0, 'ticket_total' => 0, 'discount' => 0);
		}


		$ticketPrice = self::getTicketPrice($ticketTypeId, $departureCityId, $departureDate);
		$ticketTotal = round($ticketPrice * $numberAdultTicket + $ticketPrice * $numberChildrentTicket1 + $ticketPrice * $numberChildrentTicket1 * 0.75, 2);
		$discount    = round($ticketPrice * $numberChildrentTicket1 * 0.15, 2);

		return array('ticket_price' => $ticketPrice, 'ticket_total' => $ticketTotal, 'discount' => $discount);
	}

	/**
	 * Get Avatar Image
	 *
	 * @access    public static
	 *
	 * @param    int $userId user id
	 *
	 *
	 * @since     v.1.0
	 *
	 * @return    intg
	 */
	public static function getAvatarImage($path)
	{
		$path = json_decode($path);

		$avatars = JFolder::files($path, '.jpg|.png|.jpeg', false, false, array());
		//$avatars = json_encode($avatars);
		if (!empty($avatars))
		{
			return $path . '/' . $avatars[0];
		}

		return '';
	}

	/**
	 * Send Email
	 *
	 * @access    public static
	 *
	 * @param    int    $mailto
	 * @param    string $subject
	 * @param    string $body
	 * @param    string $attachFileName
	 *
	 *
	 *
	 * @since     v.1.0
	 *
	 * @return    boolean
	 */
	public static function sendMail($mailto, $subject, $body, $attachFileName = "")
	{
		$app    = JFactory::getApplication();
		$mailer = JFactory::getMailer();
		$config = JFactory::getConfig();

		$sender = array(
			$config->get('mailfrom'),
			$config->get('fromname')
		);

		if ($mailto)
		{
			$recipient = explode(',', $mailto);
		}
		else
		{
			$recipient = array($mailto); //$user->email;
		}

		$mailer->setSubject($subject);
		$mailer->isHTML(true);
		$mailer->setBody($body);
		if (!empty($attachFileName))
		{
			$mailer->addAttachment($attachFileName);
		}

		$mailer->addRecipient($recipient);
		$mailer->setSender($sender);
		$send = $mailer->Send();

		if ($send !== true)
		{
			//$app->enqueueMessage('Error Sending email:<br/>'.$send->message,'error');
			return false;
		}

		return true;
	}

	/**
	 * replaceTags
	 *
	 * @access    public static
	 *
	 * @param    string $msg
	 * @param    string $search
	 * @param    string $replaces
	 *
	 *
	 *
	 * @since     v.1.0
	 *
	 * @return    string
	 */
	public static function replaceTags($msg, $search, $replaces)
	{
		$msg = str_replace($search, $replaces, $msg);

		return $msg;
	}

	/**
	 * Get Super User Group
	 *
	 * @access    public
	 *
	 * @return    void
	 */
	public static function getSuperUserGroup()
	{
		$superUsers   = JAccess::getUsersByGroup(8);
		$superUserIds = array();

		foreach ($superUsers as $superUserId)
		{
			$tmpUser = JFactory::getUser($superUserId);
			if (!$tmpUser->block)
			{
				$superUserIds[] = JFactory::getUser($superUserId);
			}
		}

		return $superUserIds;
	}

	/**
	 * Get Admin Group
	 *
	 * @access    public
	 *
	 * @return    void
	 */
	public static function getAdminGroup()
	{
		$adminUsers = JAccess::getUsersByGroup(7);
		$adminIds   = array();

		foreach ($adminUsers as $adminId)
		{
			$tmpUser = JFactory::getUser($adminId);
			if (!$tmpUser->block)
			{
				$adminIds[] = JFactory::getUser($adminId);
			}
		}

		return $adminIds;
	}

	/**
	 * getIdHotelOfUser
	 *
	 * @access    public static
	 *
	 * @param    int $userId user id
	 *
	 *
	 * @since     v.1.0
	 *
	 * @return    int
	 */
	public static function getUserId($joomlaUserId)
	{
		$db = JFactory::getDbo();

		$query = $db->getQuery(true)
			->select($db->qn('a.id'))
			->from($db->qn('#__demo_users', 'a'))
			->where($db->qn('a.joomla_user_id') . " = " . $joomlaUserId);

		$result = $db->setQuery($query)->loadResult();

		return $result;
	}
}



