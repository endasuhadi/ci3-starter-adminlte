<?php 

$CI='';


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('check_menu1'))
{
    function Check_menu1($menu = '')
    {
		$CI =& get_instance();
		if(in_array($menu,$CI->session->roles)){
			return true;
		}else{
            return false;
        }
    }

    function Check_menu2($menu = array())
    {
		$CI =& get_instance();
		foreach ($menu as $key => $value) {
			if(in_array($value,$CI->session->roles)){
				return true;
			}else{
	            return false;
	        }
		}
		
    }

    function Active_menu($segment, $menu)
    {
		$CI =& get_instance();
		if($CI->uri->segment($segment)==$menu){
			return true;
		}		
    }
}