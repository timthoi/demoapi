-- - 8< - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
-- Create table : user_coupon
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - >8 -

CREATE TABLE IF NOT EXISTS `#__demo_user_coupon` (
																									 `id` int(11) NOT NULL AUTO_INCREMENT,
																									 `user_id` int(11) DEFAULT NULL,
																									 `coupon_id` int(11) DEFAULT NULL,
																									 `status` int(11) DEFAULT NULL,
																									 `creation_date` datetime DEFAULT NULL,
																									 `modification_date` datetime DEFAULT NULL,
																									 `published` int(11) NOT NULL DEFAULT '1',
																									 PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- - 8< - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
-- Create table : countries
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - >8 -

CREATE TABLE IF NOT EXISTS `#__demo_coupons` (
																							 `id` int(11) NOT NULL AUTO_INCREMENT,
																							 `created_by` int(11) DEFAULT NULL,
																							 `modified_by` int(11) DEFAULT NULL,
																							 `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
																							 `quantity` int(11) DEFAULT NULL,
																							 `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
																							 `expired_date` datetime DEFAULT NULL,
																							 `published` int(11) NOT NULL DEFAULT '1',
																							 `creation_date` datetime DEFAULT NULL,
																							 `modification_date` datetime DEFAULT NULL,
																							 `ordering` int(11) DEFAULT '0',
																							 PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;


-- - 8< - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
-- Create table : countries
-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - >8 -

CREATE TABLE IF NOT EXISTS `#__demo_users` (
																						 `id` int(11) NOT NULL AUTO_INCREMENT,
																						 `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
																						 `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
																						 `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
																						 `gender` int(11) NOT NULL DEFAULT '1',
																						 `joomla_user_id` int(11) NOT NULL,
																						 `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
																						 `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
																						 `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
																						 `published` int(11) NOT NULL DEFAULT '1',
																						 `creation_date` datetime DEFAULT NULL,
																						 `modification_date` datetime DEFAULT NULL,
																						 `ordering` int(11) DEFAULT '0',
																						 PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
