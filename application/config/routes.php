<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/*
| -------------------------------------------------------------------------
| DEFAULT API RESPONSES
| -------------------------------------------------------------------------
*/
$route['default_controller'] = 'C_DefaultResponses';
$route['404_override'] = '';
$route['translate_uri_dashes'] = true;

/*
| -------------------------------------------------------------------------
| DO GLOBAL API ROUTING
| -------------------------------------------------------------------------
*/

// routes dipake buat nentuin jalur link API

// // ngarahin permintaan http get dengan url get/function yang ada di C_Web dlm controller api/master
// $route['get/(:any)'] = 'api/master/C_Web/$1';
// $route['get/(:any)/(:any)'] = 'api/master/C_Web/$1/$2';

// // ngarahin permintaan http post dengan url post/function yang ada di C_Web dlm controller api/master
// $route['post/(:any)'] = 'api/master/C_Web/$1';
// $route['post/(:any)/(:any)'] = 'api/master/C_Web/$1/$2';

// === VIEW ROUTE (non API) ===
$route['monitoring'] = 'api/master/C_Web/monitoring';

// === API GET ===
$route['api/get/monitoring'] = 'api/master/C_Web/getAllData';
$route['api/get/(:any)'] = 'api/master/C_Web/$1';
$route['api/get/(:any)/(:any)'] = 'api/master/C_Web/$1/$2';

// === API POST ===
$route['api/post/save'] = 'api/master/C_Web/save';
$route['api/post/update'] = 'api/master/C_Web/update';
$route['api/post/(:any)'] = 'api/master/C_Web/$1';
$route['api/post/(:any)/(:any)'] = 'api/master/C_Web/$1/$2';
