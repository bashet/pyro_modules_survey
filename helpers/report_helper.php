<?php
/**
 * Created by PhpStorm.
 * User: bashet
 * Date: 21/07/14
 * Time: 00:52
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('get_page_1')){
    function get_page_1($all_attempt, $programme, $attempt){
        $ci =& get_instance();

        $user       = get_profile_by_user_id($ci->current_user->id);

        $i = 0;
        foreach($all_attempt as $atm){
            if($attempt->id == $atm->id){
                $i = $i+1;
            }
        }

        $html   = '<br>';
        $html  .= '<br>';
        $html  .= '<br>';
        $html  .= '<br>';
        $html  .= '<br>';
        $html  .= '<br>';
        $html  .= '<br>';
        $html  .= '<br>';
        $html  .= '<br>';
        $html  .= '<br>';
        $html  .= '<br>';
        $html  .= '<span style="font-size:2em">'.$user->first_name . ' ' . $user->last_name.'</span>';
        $html  .= '<br>';
        $html  .= '<span>'.$programme->name.' - '.numToText($i).' attempt</span>';
        $html  .= '<br>';
        $html  .= '<span>'.date('M d, Y', $attempt->finished_date).'</span>';
        $html  .= '<br>';
        $html  .= 'Personal Feedback Report';

        return $html;
    }
}

if( ! function_exists('get_page_2') ){
    function get_page_2(){
        $html = '

        <p><strong>Introduction</strong></p>

        <p>The purpose of this report is to provide information on your own ratings across the nineteen competencies in the
        diagnostic and to compare those with the ratings from the other people you nominated. It will provide you with
        information to help you determine your learning journey within the context of your current leadership development at
        the National College.</p>

        <p><strong>What’s in the report?</strong></p>

        <p>This report summarises your responses to the 360 degree leadership diagnostic and compares them with the
        responses provided by your evaluators.</p>

        <p>Within this report, we have compared how you rated your performance against the competencies assessed in the
        survey with the responses provided by other people against the same competencies. The information provided
        covers the following themes:</p>

        <p>The information provided will help you compare your own view of your current leadership ability as well as the views
        of your raters. This will help you to make informed choices regarding your leadership development focussing on your
        strengths and areas for development.</p>

        <p>This report is organised into a number of sections:</p>
        <ul>
            <li>Your raters - this shows how many people completed rating of your competencies</li>
            <li>Your competency summary tables - these show your overall rating for each competency</li>
            <li>Your strengths – detail on your five highest scoring competencies</li>
            <li>Your areas for development - detail on your five lowest scoring competencies</li>
            <li>Competency detail - this provides definitions, levels, and a breakdown of responses by rater group for each
                individual competency</li>
            <li>Competency frequency table - this shows the frequency of specific scoring of each competency, broken down by
                type of rater</li>
        </ul>


        <p><strong>What is a competency?</strong></p>

        <p>A competency is a measurable behaviour, attitude or preference of a person that is related to effective performance in
        a specific job role. It is what we do regularly and how we do it, rather than just what we know or have been trained in.
        Skills and knowledge are important, but this feedback is focused on competencies.</p>

        <p>In the diagnostic and in this report, each individual competency section has the same structure:</p>
        <ul>
            <li>An example description of someone who is strong on that competency</li>
            <li>A paragraph about why that competency matters</li>
            <li>A key question to ask yourself about that competency</li>
            <li>Sets of descriptions of the competency at four different levels.</li>
        </ul>

        ';

        return $html;
    }
}

if( ! function_exists('get_page_3') ){
    function get_page_3(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_4') ){
    function get_page_4(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_5') ){
    function get_page_5(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_6') ){
    function get_page_6(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_7') ){
    function get_page_7(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_8') ){
    function get_page_8(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_9') ){
    function get_page_9(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_10') ){
    function get_page_10(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_11') ){
    function get_page_11(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_12') ){
    function get_page_12(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_13') ){
    function get_page_13(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_14') ){
    function get_page_14(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_15') ){
    function get_page_15(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_16') ){
    function get_page_16(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_17') ){
    function get_page_17(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_18') ){
    function get_page_18(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_19') ){
    function get_page_19(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_20') ){
    function get_page_20(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_21') ){
    function get_page_21(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_22') ){
    function get_page_22(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_23') ){
    function get_page_23(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_24') ){
    function get_page_24(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_25') ){
    function get_page_25(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_26') ){
    function get_page_26(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_27') ){
    function get_page_27(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_28') ){
    function get_page_28(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_29') ){
    function get_page_29(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_30') ){
    function get_page_30(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_31') ){
    function get_page_31(){
        $html = '';
        return $html;
    }
}

if( ! function_exists('get_page_32') ){
    function get_page_32(){
        $html = '';
        return $html;
    }
}
