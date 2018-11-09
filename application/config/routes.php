<?
defined('BASEPATH') OR exit('No direct script access allowed');
//start





// front

$route['default_controller'] = 'Main';

//First
$route['^(en|fr|hy)/about$'] = "Main/about/";
$route['^(en|fr|hy)/partner_university'] = "Main/partner_university/";
$route['^(en|fr|hy)/courses'] = "Main/courses/";
$route['^(en|fr|hy)/requirements'] = "Main/requirements/";
$route['^(en|fr|hy)/testimonials'] = "Main/testimonials/";
$route['^(en|fr|hy)/events'] = "Main/events/";
$route['^(en|fr|hy)/register'] = "Main/register/";
$route['^(en|fr|hy)/contact'] = "Main/contact/";
$route['^(en|fr|hy)/university/(:any)'] = "Main/university/$1";

//admin

//index
$route['^admin$'] = 'admin/User/index/';
$route['^admin/(en|fr|hy)$'] = 'admin/User/index/';



//about_us
$route['^admin/(en|fr|hy)/about_us$'] = 'admin/Sysadmin/about_us/';
$route['^admin/(en|fr|hy)/partner_university'] = 'admin/Sysadmin/partner_university/';
$route['^admin/(en|fr|hy)/grade_converter'] = 'admin/Sysadmin/grade_converter/';
$route['^admin/(en|fr|hy)/courses'] = 'admin/Sysadmin/courses/';
$route['^admin/(en|fr|hy)/requirements'] = 'admin/Sysadmin/requirements/';
$route['^admin/(en|fr|hy)/testimonials'] = 'admin/Sysadmin/testimonials/';
$route['^admin/(en|fr|hy)/events'] = 'admin/Sysadmin/events/';
$route['^admin/(en|fr|hy)/contact'] = 'admin/Sysadmin/contact/';
$route['^admin/(en|fr|hy)/basic_settings'] = 'admin/Sysadmin/basic_settings/';


// login
$route['admin/login'] = 'admin/User/login';

//logout
$route['admin/logout'] = 'admin/User/logout';


//Second
$route['^(en|fr|hy)/(.+)$']        = "$2";
$route['^(en|fr|hy)$'] = $route['default_controller'];


$route['/']='Main/index/$1';






//$route['(:any)/video/(:any)']='$1/Main/video/$1';





$route['video_list/(:any)']='Main/video_list/$1';






$route['video_list']='Main/video_list/';





$route['edit_user/(:num)']='Sysadmin/edit_user';






$route['copy_user/(:num)']='Sysadmin/copy_user';






$route['user_details/(:num)']='Sysadmin/user_details';





$route['sysadmin/user/(:any)']='Sysadmin/user/$1';





$route['sysadmin/user/(:any)/(:any)'] = 'Sysadmin/user/$1/$2';






$route['404_override']='';






$route['translate_uri_dashes']=TRUE;





$route['form']='sysadmin/add_gallery';





$route['upload']='gallery';





//end