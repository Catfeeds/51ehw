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
echo 123;exit;
// public
$route['client/sitemap.xml'] = 'sitemap/xml';
$route['client/client(/:any)?'] = 'client/load$1';
$route['client(/:any)?'] = 'suites/modules/CLIENT/controllers/home/index$1';
?>