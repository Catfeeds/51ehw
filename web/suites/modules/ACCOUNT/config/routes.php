<?php  defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CRM module
 *
 */

// admin
/*
$route['articles/admin/articles(/:any)?'] = 'admin_articles$1';
$route['articles/admin/settings(/:any)?'] = 'admin_settings$1';
$route['articles/admin/fields(/:any)?'] = 'admin_fields$1';
$route['articles/admin(/:any)?'] = 'admin_articles$1';
*/
// public
$route['account/sitemap.xml'] = 'sitemap/xml';
$route['account/install(/:any)?'] = 'account/load$1';
$route['account(/:any)?'] = 'suites/modules/ACCOUNT/controllers/account/index$1';
?>