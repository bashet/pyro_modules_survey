<?php
/**
 * Created by PhpStorm.
 * User: bashet
 * Date: 21/07/14
 * Time: 00:52
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('get_page_1')){
    function get_page_1($attempt_id = ''){
        $ci =& get_instance();

        $user = get_profile_by_user_id($ci->current_user->id);

        $html = '<span style="font-size:2em">'.$user->first_name . ' ' . $user->last_name.'</span>';
        $html .= $attempt_id;

        return $html;
    }
}