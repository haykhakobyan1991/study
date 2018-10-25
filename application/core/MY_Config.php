<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'third_party/MX/Config.php';
/*
	Class: MY_Config
	
	This is how I used to store my config items in the database, hopefully it will be found useful.
		
	Extends:
		MX_Config
		
	Package:
		MY_Config
*/
class MY_Config extends MX_Config
{
	/*
		Method: database( $module = 'core' )
		
		A method to extend the settings library into CodeIgniter's Config Library, optional param
		for module config to pull.  Defaults to core, will set all config items.
		
		Paremeters:
			$module	- The module name to pull config items for.
			
		Return:
			Will set config_item's on success or FALSE on failure or empty set.
	*/        
  public function database( $module = 'core' )
  {
    if (function_exists('get_instance'))
    {
      $CI =& get_instance();
      
      $CI->load->model('settings/settings_model');
      $settings = $CI->settings_model->find_all_by('module', $module );      
      
      if ( !is_array( $settings ) && count ( $settings ) > 0 )
        return false;
      
      foreach ( $settings as $key=>$value )
      {
        $CI->config->set_item( $key, $value );
      }
      
    }
  }
  
}