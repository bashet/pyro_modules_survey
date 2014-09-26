<?php
/**
 * Created by PhpStorm.
 * User: bashet
 * Date: 21/07/14
 * Time: 00:52
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('get_programme_info')){
    function get_programme_info(){
        return 'This programme information';
    }
}

if ( ! function_exists('user_logged_in')){
    function user_logged_in(){
        $ci =& get_instance();
        if( ! $ci->current_user->id){
            return true;
        }else{
            return false;
        }
    }
}
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

if(! function_exists('get_survey_by_id')){
    function get_survey_by_id($id){
        $ci =& get_instance();

        $query = $ci->db->get_where('survey', array('id'=> $id));
        return $query->row();
    }
}

if(! function_exists('get_questions_by_survey_id')){
    function get_questions_by_survey_id($id){
        $ci =& get_instance();

        $query = $ci->db->get_where('survey_questions', array('survey_id'=> $id));
        return $query->result();
    }
}

if(! function_exists('get_category_by_id')){
    function get_category_by_id($id){
        $ci =& get_instance();

        $query = $ci->db->get_where('survey_question_categories', array('id'=> $id));
        return $query->row();
    }
}

if(! function_exists('get_questions_by_category')){
    function get_questions_by_category($id){
        $ci =& get_instance();

        $query = $ci->db->get_where('survey_questions', array('cat_id'=> $id));
        return $query->result();
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

if(! function_exists('get_current_attempt_by_id')){
    function get_current_attempt_by_id($id = ''){
        $ci =& get_instance();

        $query = $ci->db->get_where('survey_attempt', array('id' => $id));
        return $query->row();
    }
}

if(! function_exists('get_current_attempt_by_user_id')){
    function get_current_attempt_by_user_id($id = ''){
        $ci =& get_instance();

        $ci->db->limit(1);
        $ci->db->order_by("id", "desc");
        $query = $ci->db->get_where('survey_attempt', array('user_id' => $id));
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

if(! function_exists('get_total_question_in_survey')){
    function get_total_question_in_survey($survey_id){
        $ci =& get_instance();
        $total = 0;
        $query = $ci->db->get_where('survey', array('id' => $survey_id));
        $survey = $query->row();
        $categories = json_decode($survey->q_cat);
        foreach($categories as $cat){
            $query = $ci->db->get_where('survey_question_categories', array('id' => $cat));
            $questions = $query->row();
            $total = $total + count(json_decode($questions->questions, true));
        }
        return $total;
    }
}

if(! function_exists('get_answers_by_q_id')){
    function get_answers_by_q_id($id = ''){
        $ci =& get_instance();

        $query = $ci->db->get_where('survey_answer_options', array('question_id'=>$id));
        return $query->row();
    }
}

if(! function_exists('get_question_by_id')){
    function get_question_by_id($id = ''){
        $ci =& get_instance();

        $query =  $ci->db->get_where('survey_questions', array('id' => $id));
        return $query->row();
    }
}

if(! function_exists('get_first_question')){
    function get_first_question($survey_id){
        $ci =& get_instance();

        $ci->db->limit(1);
        $query =  $ci->db->get_where('survey_questions', array('survey_id' => $survey_id));
        return $query->row();
    }
}

if(! function_exists('get_q_cat_name')){
    function get_q_cat_name($cat_id){
        $ci =& get_instance();

        $query  =  $ci->db->get_where('survey_question_categories', array('id' => $cat_id));
        $row    = $query->row();
        return $row->name;
    }
}

if(! function_exists('get_existing_answer')){
    function get_existing_answer($answer){
        $ci =& get_instance();

        $query  =  $ci->db->get_where(
                                        'survey_user_answer',
                                        array(
                                            'user_id' => $answer->user_id,
                                            'attempt_id' => $answer->attempt_id,
                                            'survey_id' =>$answer->survey_id
                                        )
                                    );
        return $query->row();
    }
}
/*
if(! function_exists('get_existing_answer_evaluator')){
    function get_existing_answer_evaluator($answer){
        $ci =& get_instance();

        $query  =  $ci->db->get_where(
            'survey_evaluators_answer',
            array(
                'evaluator_id' => $answer->evaluator_id,
                'attempt_id' => $answer->attempt_id,
                'survey_id' =>$answer->survey_id
            )
        );
        return $query->row();
    }
}
*/
if(! function_exists('rebuild_answer')){
    function rebuild_answer($data, $ex_ans){
        $answers = json_decode($ex_ans, true);

        if($answers){
            $answers[$data['q_id']] = $data['value'];
        }else{
            $answers = array($data['q_id'] => $data['value']);
        }

        return json_encode($answers);
    }
}

if(! function_exists('get_user_answer_history')){
    function get_user_answer_history($user_id = ''){
        if($user_id){
            $ci =& get_instance();

            $sql = "SELECT atm.id as id, atm.user_id as user_id, atm.survey_id as survey_id, atm.create_date as start_date, ans.finished as finished,
                        ans.submitted as submitted, ans.submit_date as submit_date,
                        ans.answers as answers, atm.programme_id as programme_id, pro.name as programme_name
                    from default_survey_attempt atm
                    left join default_survey_user_answer ans
                    on ans.attempt_id = atm.id
                    join default_survey_programme pro
                    on pro.id = atm.programme_id
                    where atm.user_id = $user_id";

            $query = $ci->db->query($sql);
            return $query->result();
        }
    }
}

if(! function_exists('get_report_pdf')){
    function get_report_pdf($data){
        // $data has all the fields from user_answer table

        $attempt = get_current_attempt_by_id($data->id);
        if($attempt->report_ready){
            $result = '<a
                            href="{{ url:site }}survey/report_viewer/'.$data->id.'"
                            target="_blank"
                        >
                        <span class="glyphicon glyphicon-list-alt"></span>
                        &nbsp;&nbsp;&nbsp;View this report
                        </a>';
        }else{
            $result = 'Report is not ready yet';
        }
        return $result;
    }
}

if(! function_exists('get_submitted_evaluators')){
    function get_submitted_evaluators($attempt_id){
        $ci =& get_instance();

        $query  = $ci->db->query("SELECT count(id)as total FROM default_survey_evaluators where attempt_id=$attempt_id and !isnull(answers)");
        $record = $query->row();
        return $record->total;
    }
}

if( ! function_exists('get_email_template') ){
    function get_email_template($slug = ''){
        if($slug){
            $ci =& get_instance();

            $query = $ci->db->get_where('email_templates', array('slug' => $slug));
            return $query->row();
        }else{
            return '';
        }
    }
}

if( ! function_exists('generate_email_template_for_evaluator')){
    function generate_email_template_for_evaluator($data, $evaluator){
        $ci =& get_instance();

        $email_template = get_email_template('email-to-evaluators');
        $user = get_profile_by_user_id($ci->current_user->id);

        $participation   = $ci->survey_m->get_current_participation($ci->current_user->id);

        $client          = get_client_by_id($participation->cid);


        $email_body = '<p>Dear '.$evaluator->name.',</p>';
        $email_body .= $data['email_body']. '<br>';
        $email_body .= '<p>Please click to the link below:</p>';
        $link        = $ci->config->base_url().'index.php/survey/evaluator_response/'.$evaluator->link_md5;
        $email_body .= '<a href="'.$link.'">'.$link.'</a>';
        $email_body .= '<br><br><p>Yours faithfully,<br>';
        $email_body .= $user->first_name . ' ' . $user->last_name.'<br>';
        $email_body .= 'Leadership Colab on behalf of '.$client->name.'</p>';

        $ci->db->where('id', $email_template->id);
        if($ci->db->update('email_templates', array('body' => $email_body))){
            return true;
        }else{
            return false;
        }


    }
}

if( ! function_exists('get_evaluator_by_link') ){
    function get_evaluator_by_link($link = ''){
        if($link){
            $ci =& get_instance();

            $query = $ci->db->get_where('survey_evaluators', array('link_md5' => $link));
            return $query->row();
        }else{
            return '';
        }
    }
}

if( ! function_exists('get_evaluator_by_id') ){
    function get_evaluator_by_id($id = ''){
        if($id){
            $ci =& get_instance();

            $query = $ci->db->get_where('survey_evaluators', array('id' => $id));
            return $query->row();
        }else{
            return '';
        }
    }
}

if( ! function_exists('get_evaluator_progress') ){
    function get_evaluator_progress($id){
        $ci =& get_instance();

        $evaluator = get_evaluator_by_id($id);

        $total_questions = get_total_question_in_survey($ci->session->userdata('survey_id'));

        $my_answer = json_decode($evaluator->answers);

        $answered = count((array)$my_answer);

        return (($answered/$total_questions) * 100).'%';

    }
}

if( ! function_exists('duplicate_entry')){
    function duplicate_entry($field, $value, $data){
        $error = '';
        foreach($data as $f=>$v){
            if(substr($f, 0, 5) == 'email'){
                if($f != $field){
                    if($v == $value){
                        $error = 'Duplicate email address entered';
                    }
                }
            }
        }

        return $error;
    }
}

if( ! function_exists('numToText')){
    function numToText($num){
        if($num == '1'){
            return '1st';
        }elseif($num == '2'){
            return '2nd';
        }elseif($num == '3'){
            return '3rd';
        }elseif($num == '4'){
            return '4th';
        }elseif($num == '5'){
            return '5th';
        }elseif($num == '6'){
            return '6th';
        }elseif($num == '7'){
            return '7th';
        }elseif($num == '8'){
            return '8th';
        }elseif($num == '9'){
            return '9th';
        }
    }
}


if( ! function_exists('get_all_attempts_by_user_n_programme') ){
    function get_all_attempts_by_user_n_programme($user_id = '', $programme_id){
        if($user_id){
            $ci =& get_instance();
            //$ci->db->order_by('id', 'desc');
            $query = $ci->db->get_where('survey_attempt', array('user_id' => $user_id, 'programme_id' => $programme_id));
            return $query->result();
        }else{
            return '';
        }
    }
}

if( ! function_exists('get_all_attempts_by_user') ){
    function get_all_attempts_by_user($user_id = ''){
        if($user_id){
            $ci =& get_instance();
            //$ci->db->order_by('id', 'desc');
            $query = $ci->db->get_where('survey_attempt', array('user_id' => $user_id));
            return $query->result();
        }else{
            return '';
        }
    }
}

if( ! function_exists('get_total_attempts_by_user_n_programme') ){
    function get_total_attempts_by_user_n_programme($user_id = '', $programme_id){
        $ci =& get_instance();
        $ci->db->where('user_id', $user_id);
        $ci->db->where('programme_id', $programme_id);
        $ci->db->from('survey_attempt');
        return $ci->db->count_all_results();
    }
}

if( ! function_exists('re_build_cat') ){
    function re_build_cat($survey, $data){
        $categories = json_decode($survey->q_cat, true);

        if($categories){
            $i = 1;
            $exist = false;
            foreach($categories as $key => $value){
                if($value == $data['category']){
                    $categories[$key] = $data['category'];
                    $exist = true;
                }
                $i++;
            }

            if(! $exist ){
                $categories[$i] = $data['category'];
            }
        }else{
            $categories[1] = $data['category'];
        }

        return json_encode($categories);
    }
}

if( ! function_exists('re_build_question_serial') ){
    function re_build_question_serial($category, $data){
        $questions = json_decode($category->questions, true);

        if($questions){
            $i = 1;
            $exist = false;
            foreach($questions as $key => $value){
                if($value == $data){
                    $questions[$key] = $data;
                    $exist = true;
                }
                $i++;
            }

            if(! $exist ){
                $questions[$i] = $data;
            }
        }else{
            $questions[1] = $data;
        }

        return json_encode($questions);
    }
}

if( ! function_exists('is_valid_cat_for_survey') ){
    function is_valid_cat_for_survey($survey_id, $cat_id){
        $ci =& get_instance();

        $query  = $ci->db->get_where('survey', array('id' => $survey_id));
        $result = $query->row();

        $ex_cat = json_decode($result->q_cat, true);

        if (in_array($cat_id, $ex_cat)){
            return false;
        }else{
            return true;
        }
    }
}

if( !function_exists('get_self_marking') ){
    function get_self_marking($answers, $q_id){
        // 90 will be considered as 100%

        $my_answer = json_decode($answers->answers, true);

        return ((90*$my_answer[$q_id])/4);
    }
}

if( ! function_exists('get_evaluators_total') ){
    function get_evaluators_total($evaluators, $q_id){

        $total_answer       = 0;
        $total_evaluator    = 0;
        foreach($evaluators as $ev){
            $answers = json_decode($ev->answers, true);
            $total_answer = $total_answer + $answers[$q_id];
            $total_evaluator = $total_evaluator + 1;
        }

        return ((90*($total_answer/$total_evaluator))/4);
    }
}

if( ! function_exists('get_evaluators_total_avg') ){
    function get_evaluators_total_avg($evaluators, $q_id){

        $total_answer = 0;
        $total_evaluator    = 0;
        foreach($evaluators as $ev){
            $answers = json_decode($ev->answers, true);
            $total_answer = $total_answer + $answers[$q_id];
            $total_evaluator = $total_evaluator + 1;
        }

        return round($total_answer/$total_evaluator,2);
    }
}

if( ! function_exists('get_answer_top_5') ){
    function get_answer_top_5($evaluators){
        $questions = array();
        foreach($evaluators as $ev){
            $answers = json_decode($ev->answers, true);
            foreach($answers as $key => $value){
                if(isset($questions[$key])){
                    $questions[$key] = $questions[$key] + $value;
                }else{
                    $questions[$key] = $value;
                }

            }

        }
        arsort($questions);
        return $questions;
    }
}

if( ! function_exists('get_answer_bottom_5') ){
    function get_answer_bottom_5($evaluators){
        $questions = array();
        foreach($evaluators as $ev){
            $answers = json_decode($ev->answers, true);
            foreach($answers as $key => $value){
                if(isset($questions[$key])){
                    $questions[$key] = $questions[$key] + $value;
                }else{
                    $questions[$key] = $value;
                }

            }

        }
        asort($questions);
        return $questions;
    }
}

if( ! function_exists('get_question_title') ){
    function get_question_title($questions, $q_no){
        $title = '';

        foreach($questions as $q){
            if($q_no == $q->id){
                $title = $q->title;
                break;
            }
        }
        return $title;
    }
}

if( ! function_exists('get_question_title_by_q_id') ){
    function get_question_title_by_q_id($q_no){
        //var_dump($q_no);
        $ci =& get_instance();
        $query = $ci->db->get_where('survey_questions', array('id' => $q_no));
        $row = $query->row();
        return $row->title;
    }
}

if( !function_exists('get_self_marking_details') ){
    function get_self_marking_details($answers, $q_id){
        // 90 will be considered as 100%

        $my_answer = json_decode($answers->answers, true);

        return ((56*$my_answer[$q_id])/4);
    }
}

if( ! function_exists('get_evaluators_total_details') ){
    function get_evaluators_total_details($evaluators, $q_id){

        $total_answer       = 0;
        $total_evaluator    = 0;
        foreach($evaluators as $ev){
            $answers = json_decode($ev->answers, true);
            $total_answer = $total_answer + $answers[$q_id];
            $total_evaluator = $total_evaluator + 1;
        }

        return ((56*($total_answer/$total_evaluator))/4);
    }
}

if( !function_exists('get_self_marking_table') ){
    function get_self_marking_table($answers, $q_id, $pos = ''){
        // 90 will be considered as 100%

        $my_answer = json_decode($answers->answers, true);

        if($pos == $my_answer[$q_id]){
            return 1;
        }else{
            return '';
        }


    }
}

if( ! function_exists('get_evaluators_total_table') ){
    function get_evaluators_total_table($evaluators, $q_id, $pos = 1){

        $result             = 0;
        foreach($evaluators as $ev){
            $answers = json_decode($ev->answers, true);

            if($pos == $answers[$q_id]){
                $result =  $result + 1;
            }
        }
        if($result){
            return $result;
        }else{
            return '';
        }
    }
}
if( ! function_exists('get_evaluators_total_num') ){
    function get_evaluators_total_num($evaluators, $q_id, $pos = 1){

        $result             = 0;
        foreach($evaluators as $ev){
            $answers = json_decode($ev->answers, true);

            if($pos == $answers[$q_id]){
                $result =  $result + 1;
            }
        }
        return $result;
    }
}
if( ! function_exists('get_all_participation')){
    function get_all_participation($user_id = ''){
        $ci =& get_instance();
        $query = $ci->db->get_where('survey_participant', array('uid'=>$user_id)); // expected to get only one row

        return $query->result();

    }
}

if( ! function_exists('get_current_participation_by_user') ){
    function get_current_participation_by_user($user_id){
        $ci =& get_instance();
        $query = $ci->db->get_where('survey_participant', array('uid'=>$user_id, 'active'=>1)); // expected to get only one row

        return $query->row();

    }
}

if( ! function_exists('get_participation_by_programme') ){
    function get_participation_by_programme($pid){
        $ci =& get_instance();
        $query = $ci->db->get_where('survey_participant', array('pid'=>$pid)); // expected to get only one row

        return $query->row();

    }
}

if( ! function_exists('is_programme_used') ){
    function is_programme_used($id = '', $participation){
        $status = false;
        foreach($participation as $p){
            if($p->pid == $id){
                $status = true;
            }
        }
        return $status;
    }
}

if( ! function_exists('get_active_application') ){
    function get_active_application($user_id){
        $ci =& get_instance();
        $query = $ci->db->get_where('survey_new_application', array('uid'=>$user_id, 'status'=>1)); // expected to get only one row

        return $query->row();
    }
}

if( ! function_exists('get_all_active_requests_for_admin') ){
    function get_all_active_requests_for_admin(){
        $ci =& get_instance();
        $sql = "select
                    new_app.id as id,
                    new_app.uid as user_id,
                    CONCAT(u.first_name, ' ', u.last_name) as name,
                    c.name as org_name,
                    prog.name as new_prog_name,
                    new_app.create_date as date_applied,
                    new_app.status as status
                from default_survey_new_application new_app
                join default_profiles u
                on u.user_id = new_app.uid
                join default_survey_clients c
                on c.id = new_app.cid
                join default_survey_programme prog
                on prog.id = new_app.pid
                where new_app.status=1";
        $query = $ci->db->query($sql); // expected to get only one row
        // $this->db->count_all_results();

        return $query->result();
    }
}

if( ! function_exists('get_all_approved_requests_for_admin') ){
    function get_all_approved_requests_for_admin(){
        $ci =& get_instance();
        $sql = "select
                    new_app.id as id,
                    new_app.uid as user_id,
                    CONCAT(u.first_name, ' ', u.last_name) as name,
                    c.name as org_name,
                    prog.name as new_prog_name,
                    new_app.create_date as date_applied,
                    new_app.approval_date as approval_date,
                    new_app.status as status
                from default_survey_new_application new_app
                join default_profiles u
                on u.user_id = new_app.uid
                join default_survey_clients c
                on c.id = new_app.cid
                join default_survey_programme prog
                on prog.id = new_app.pid
                where new_app.status=0";
        $query = $ci->db->query($sql); // expected to get only one row
        // $this->db->count_all_results();

        return $query->result();
    }
}

if( ! function_exists('get_all_active_requests_for_client') ){
    function get_all_active_requests_for_client($cid){
        $ci =& get_instance();
        $sql = "select
                    new_app.id as id,
                    new_app.uid as user_id,
                    CONCAT(u.first_name, ' ', u.last_name) as name,
                    c.name as org_name,
                    prog.name as new_prog_name,
                    new_app.create_date as date_applied,
                    new_app.status as status
                from default_survey_new_application new_app
                join default_profiles u
                on u.user_id = new_app.uid
                join default_survey_clients c
                on c.id = new_app.cid
                join default_survey_programme prog
                on prog.id = new_app.pid
                where new_app.status=1 and c.id = ".$cid;
        $query = $ci->db->query($sql); // expected to get only one row
        // $this->db->count_all_results();

        return $query->result();
    }
}

if( ! function_exists('get_all_approved_requests_for_client') ){
    function get_all_approved_requests_for_client($cid){
        $ci =& get_instance();
        $sql = "select
                    new_app.id as id,
                    new_app.uid as user_id,
                    CONCAT(u.first_name, ' ', u.last_name) as name,
                    c.name as org_name,
                    prog.name as new_prog_name,
                    new_app.create_date as date_applied,
                    new_app.approval_date as approval_date,
                    new_app.status as status
                from default_survey_new_application new_app
                join default_profiles u
                on u.user_id = new_app.uid
                join default_survey_clients c
                on c.id = new_app.cid
                join default_survey_programme prog
                on prog.id = new_app.pid
                where new_app.status=0 and c.id = ". $cid;
        $query = $ci->db->query($sql); // expected to get only one row
        // $this->db->count_all_results();

        return $query->result();
    }
}

if( ! function_exists('get_programme_request_by_id') ){
    function get_programme_request_by_id($request_id){
        $ci =& get_instance();
        $query = $ci->db->get_where('survey_new_application', array('id'=>$request_id)); // expected to get only one row

        return $query->row();
    }
}

