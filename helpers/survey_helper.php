<?php
/**
 * Created by PhpStorm.
 * User: bashet
 * Date: 21/07/14
 * Time: 00:52
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_option_by_question_id') ){
    function get_option_by_question_id($q_id = ''){

        $ci =& get_instance();

        $query = $ci->db->get_where('survey_answer_options', array('question_id'=>$q_id));

        return $query->row();

    }
}

if ( ! function_exists('get_manager') ){
    function get_manager($u_id = ''){
        $ci =& get_instance();
        if($u_id){
            $query = $ci->db->get_where('profiles', array('user_id'=>$u_id));
            $manager = $query->row();
            return $manager->display_name;
        }else{
            return '';
        }
    }
}

if(! function_exists('get_all_manager')){
    function get_all_manager(){
        $ci =& get_instance();

        $sql = 'select p.display_name as display_name, u.id as id
                from default_users u
                join default_profiles p
                on p.user_id = u.id
                where u.group_id = 3';

        $query = $ci->db->query($sql);

        return $query->result();
    }
}

if(! function_exists('get_all_clients')){
    function get_all_clients(){
        $ci =& get_instance();

        $query = $ci->db->get_where('survey_clients', array('active'=>1));

        return $query->result();
    }
}