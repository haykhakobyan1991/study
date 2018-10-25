<?
defined('BASEPATH') OR exit('No direct script access allowed');
//start


//index
$route['admin'] = 'admin/User/index';
$route['admin/dashboard'] = 'admin/User/dashboard';


//user
$route['admin/sysadmin/user'] = 'admin/Sysadmin/user/';
$route['admin/sysadmin/add_user'] = 'admin/Sysadmin/add_user/';
$route['admin/sysadmin/edit_user'] = 'admin/Sysadmin/edit_user/';
$route['admin/sysadmin/user_details'] = 'admin/Sysadmin/user_details/';

//permission
$route['admin/sysadmin/permission'] = 'admin/Sysadmin/permission/';
$route['admin/sysadmin/add_permission'] = 'admin/Sysadmin/add_permission/';
$route['admin/sysadmin/edit_permission'] = 'admin/Sysadmin/edit_permission/';
$route['admin/sysadmin/permission_details'] = 'admin/Sysadmin/permission_details/';

//role
$route['admin/sysadmin/role'] = 'admin/Sysadmin/role/';
$route['admin/sysadmin/add_role'] = 'admin/Sysadmin/add_role/';
$route['admin/sysadmin/edit_role'] = 'admin/Sysadmin/edit_role/';
$route['admin/sysadmin/role_details'] = 'admin/Sysadmin/role_details/';

//video
$route['admin/sysadmin/video'] = 'admin/Sysadmin/video/';
$route['admin/sysadmin/video/(:num)'] = 'admin/Sysadmin/video/$1';
$route['admin/sysadmin/add_video'] = 'admin/Sysadmin/add_video/';
$route['admin/sysadmin/edit_video'] = 'admin/Sysadmin/edit_video/';
$route['admin/sysadmin/edit_video/(:num)'] = 'admin/Sysadmin/edit_video/$1';
$route['admin/sysadmin/video_details'] = 'admin/Sysadmin/video_details/';

//video_list
$route['admin/sysadmin/video_list'] = 'admin/Sysadmin/video_list/';
$route['admin/sysadmin/add_video_list'] = 'admin/Sysadmin/add_video_list/';
$route['admin/sysadmin/edit_video_list'] = 'admin/Sysadmin/edit_video_list/$1';
$route['admin/sysadmin/video_list_details'] = 'admin/Sysadmin/video_list_details/';


//news
$route['admin/sysadmin/news'] = 'admin/Sysadmin/news/';
$route['admin/sysadmin/add_news'] = 'admin/Sysadmin/add_news/';
$route['admin/sysadmin/edit_news'] = 'admin/Sysadmin/edit_news/$1';
$route['admin/sysadmin/news_details'] = 'admin/Sysadmin/news_details/';

//menu
$route['admin/sysadmin/edit_menu'] = 'admin/Sysadmin/edit_menu/';

//config
$route['admin/sysadmin/config'] = 'admin/Sysadmin/config/';

// login
$route['admin/login'] = 'admin/User/login';

//logout
$route['admin/logout'] = 'admin/User/logout';


// front

$route['default_controller'] = 'Main';

//First
$route['^(en|fr|hy)/about$'] = "Main/about/";
$route['^(en|fr|hy)/partner_university'] = "Main/partner_university/";


$route['^(en|fr|hy)/video_list/(.+)$'] = "Main/video_list/$1";
//$route['^(en|ru|hy)/results$']     = "fetch/results$2";
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