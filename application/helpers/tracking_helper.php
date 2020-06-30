<?php 

$CI='';

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('tracking'))
{
    function tracking()
    {
		$CI =& get_instance();
		$CI->load->model("model_visitor");
		return $CI->model_visitor->start_tracking_visitors();
    }
}