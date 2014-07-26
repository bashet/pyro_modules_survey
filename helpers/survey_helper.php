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
            if($manager){
                return $manager->display_name;
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
}

if ( ! function_exists('get_user_full_name') ){
    function get_user_full_name($u_id = ''){
        $ci =& get_instance();
        if($u_id){
            $query = $ci->db->get_where('profiles', array('user_id'=>$u_id));
            $user = $query->row();
            if($user){
                return $user->first_name . ' ' . $user->last_name;
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
}

if ( ! function_exists('get_user_by_id') ){
    function get_user_by_id($id = ''){
        $ci =& get_instance();
        if($id){
            $query = $ci->db->get_where('users', array('id'=>$id));
            $user = $query->row();
            return $user;
        }else{
            return '';
        }
    }
}

if ( ! function_exists('get_profile_by_user_id') ){
    function get_profile_by_user_id($id = ''){
        $ci =& get_instance();
        if($id){
            $query = $ci->db->get_where('profiles', array('user_id'=>$id));
            $user = $query->row();
            return $user;
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

if(! function_exists('get_all_clients_all')){
    function get_all_clients_all(){
        $ci =& get_instance();

        $query = $ci->db->get('survey_clients');

        return $query->result();
    }
}

if(! function_exists('get_all_programme')){ // programme is called programme
    function get_all_programme(){
        $ci =& get_instance();

        $query = $ci->db->get_where('survey_programme', array('active'=>1));

        return $query->result();
    }
}

if(! function_exists('get_client_by_id')){
    function get_client_by_id($id){
        $ci =& get_instance();

        $query = $ci->db->get_where('survey_clients', array('id'=> $id));
        return $query->row();
    }
}

if(! function_exists('get_programme_by_id')){
    function get_programme_by_id($id){
        $ci =& get_instance();

        $query = $ci->db->get_where('survey_programme', array('id'=> $id));
        return $query->row();
    }
}

if(! function_exists('get_survey_by_programme_id')){
    function get_survey_by_programme_id($id){
        $ci =& get_instance();

        $query = $ci->db->get_where('survey', array('id'=> $id));
        return $query->row();
    }
}

if(! function_exists('get_questions_by_survey_id')){
    function get_questions_by_survey_id($id){
        $ci =& get_instance();

        $query = $ci->db->get_where('survey_questions', array('survey_id'=> $id));
        return $query->row();
    }
}

if(! function_exists('get_manager_by_uni')){
    function get_manager_by_uni($client_id){
        $ci =& get_instance();

        $client         = get_client_by_id($client_id);
        $manager_name   = get_manager($client->manager_uid);
        $user           = get_user_by_id($client->manager_uid);

        $manager = array(
            'name'  => $manager_name,
            'email' => $user->email,
        );

        return $manager;
    }
}

if(! function_exists('register_user_for_specific_uni')){
    function register_user_for_specific_uni($uid, $data){
        $participant = array(
            'uid'   => $uid,
            'cid'   => $data['uni'],
            'pid'   => $data['programme']
        );
        $ci =& get_instance();

        if($ci->db->insert('survey_participant', $participant)){
            $manager = get_manager_by_uni($data['uni']);

            // now send email to manager about new registration.

            $mail = array();
            $mail['subject']			= Settings::get('site_name') . ' - Registration Approval'; // No translation needed as this is merely a fallback to Email Template subject
            $mail['slug'] 				= 'email-to-manager-for-approval';
            $mail['to'] 				= $manager['email'];
            $mail['manager_name']       = $manager['name'];
            $mail['from'] 				= Settings::get('server_email');
            $mail['name']				= Settings::get('site_name');
            $mail['reply-to']			= Settings::get('contact_email');

            Events::trigger('email', $mail, 'array');

            $user   = get_user_by_id($uid);
            $client = get_client_by_id($data['uni']);
            $user_email = array();

            $user_email['subject']			= Settings::get('site_name') . ' - Registration Approval'; // No translation needed as this is merely a fallback to Email Template subject
            $user_email['slug'] 		    = 'first-registration';
            $user_email['to'] 				= $user->email;
            $user_email['user_name']        = get_user_full_name($uid);
            $user_email['client']           = $client->name;
            $user_email['from'] 			= Settings::get('server_email');
            $user_email['name']				= Settings::get('site_name');
            $user_email['reply-to']			= Settings::get('contact_email');

            Events::trigger('email', $user_email, 'array');

        }

    }
}

if ( ! function_exists('get_survey_name_by_id') ){
    function get_survey_name_by_id($id = ''){
        $ci =& get_instance();
        if($id){
            $query = $ci->db->get_where('survey', array('id'=>$id));
            $survey = $query->row();
            if($survey){
                return $survey->name;
            }else{
                return '';
            }
        }else{
            return '';
        }
    }
}

if(! function_exists('is_valid_manager')){
    function is_valid_manager($id = ''){
        $clients = get_all_clients_all();
        $valid = true;
        foreach($clients as $client){
            if($id == $client->manager_uid){
                $valid = false;
            }
        }

        return $valid;
    }
}

if(! function_exists('get_current_attempt_by_user_id')){
    function get_current_attempt_by_user_id($id = ''){
        $ci =& get_instance();

        $query = $ci->db->get_where('survey_attempt', array('id' => $id,'finished_date' => 0));
        return $query->row();
    }
}

if(! function_exists('get_evaluators_by_attempt_id')){
    function get_evaluators_by_attempt_id($attempt_id){
        $ci =& get_instance();

        $query = $ci->db->get_where('survey_evaluators', array('attempt_id' => $attempt_id));
        return $query->result();
    }
}

if(! function_exists('get_total_evaluators_by_attempt_id')){
    function get_total_evaluators_by_attempt_id($attempt_id){
        $ci =& get_instance();

        $ci->db->where('attempt_id', $attempt_id);
        return $ci->db->count_all_results('survey_evaluators');
    }
}