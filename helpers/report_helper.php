<?php
/**
 * Created by PhpStorm.
 * User: bashet
 * Date: 21/07/14
 * Time: 00:52
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('get_page_1')){
    function get_page_1($programme, $attempt){
        $ci =& get_instance();

        $user       = get_profile_by_user_id($ci->current_user->id);
        $all_attempt    = get_all_attempts_by_user_n_programme($ci->current_user->id, $programme->id);

        $i = 0;
        foreach($all_attempt as $atm){
            if($attempt->id == $atm->id){
                $i = $i+1;
            }
        }

        $html = '<span style="font-size:2em">'.$user->first_name . ' ' . $user->last_name.'</span>';
        $html .= '<br>';
        $html .= '<span>'.$programme->name.' - '.numToText($i).' attempt</span>';
        $html .= '<br>';
        $html .= '<span>'.date('M d, Y', $attempt->finished_date).'</span>';
        $html .= '<br>';
        $html .= 'Personal Feedback Report';

        return $html;
    }
}