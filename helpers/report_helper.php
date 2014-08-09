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
        $html = '
        <style>
            th {
                border: 2px solid #ffffff;
                text-align: center;
                padding: 5px;
                color: #ffffff;
            }
            td {
                border: 2px solid #ffffff;
            }
        </style>

        <P><strong>Competency levels</strong><br><br>Over all, levels are defined as follows:</P>
        <table border="1" cellpadding="4" cellspacing="1">
            <tr bgcolor="#5AA73D">
                <th style="width: 10%">Level</th>
                <th style="width: 90%">Definition</th>
            </tr>
            <tr>
                <td>1.</td>
                <td>Indicates the competency is being applied at a level which requires development.</td>
            </tr>
            <tr bgcolor="#f5f5dc">
                <td>2.</td>
                <td>Indicates the competency is being applied at an emergent level.</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Indicates the competency is being applied at a relatively effective level.</td>
            </tr>
            <tr bgcolor="#f5f5dc">
                <td>4.</td>
                <td>Indicates the competency is being applied at a level which is a strength level.</td>
            </tr>
        </table>

        <p>For each competency, the first level illustrates positive yet basic types of behaviour and successive levels (2-4)
        outline more advanced behaviours.</p>

        <p>In the report we show the detailed behavioural indicators for each competency at each level. These are not intended
        as a comprehensive checklist, but give an indication of the types of behaviours you would expect.</p>

        <p>The levels are cumulative, which means that in order to be rated as ‘strength’, there is an expectation that you would
        typically already be demonstrating the behaviours at the lower levels as well. The ratings per competency in the later
        part of the report are based on these levels.</p>

        <p>Although each of the competencies is important, it is not realistic or necessary at this stage to demonstrate every
        competency as a strength in order to be a successful school leader. It is expected that you will have a range of
        competencies at different levels.</p>

        <p>Your particular ratings are designed to provide you with a broad indication of where your strengths as a leader lie,
        and where there might be areas for you to develop.They are not like an examination result or performance
        assessment.</p>
        <p><strong>Competency clusters</strong></p>
        <p>The 16 competencies in the 360 leadership diagnostic are structured into three clusters:</p>
        <ul>
            <li>Educational Excellence</li>
            <li>Operational Management</li>
            <li>Strategic leadership</li>
        </ul>

        <p>All the competencies measured in this report are presented and organised these clusters. When interpreting your
        feedback it may be worthwhile for you to consider whether some clusters are more important to you in your
        development than others.</p>

        <p><strong>What the diagnostic measures</strong></p>

        <p>This diagnostic measures a group of competencies that are linked directly to successful headship. The competencies
        were defined after careful analysis and consultation with headteachers as the behaviours that are essential for
        effective school leadership. The diagnostic is designed to help aspirant heads identify their strengths and areas for
        future development. The competencies in the NPQH diagnostic reflect the Assessment framework for the
        qualification.</p>

        <p><strong>Receiving feedback</strong></p>
        <p>When participants first receive behavioural feedback from their colleagues, people react in many different ways. You
        might feel anything from elation and joy through to denial, despair and anger, or you might not feel anything at all for
        a while. However you react to your data, this is absolutely normal. There is no ‘right way’ to react to feedback. Just
        remember that often your emotions will be triggered before your more cognitive processes get to work. To manage
        this, take note of your reactions, acknowledge them and take your time to work through them before you attempt to
        re-engage with the reports and begin to process the data.You may find it helpful to discuss the findings and your response with a coach or mentor.</p>

        <p>The reports are designed specifically to help you understand and make the most of your data. We recommend that
        you go page by page through the reports . this will help you to understand the data as well as what has been
        measured in the report and who has contributed. As you read through the reports it might be useful to have a pad and
        pen to hand to make notes of your reactions, questions and comments. You can then talk these through with your
        coach, mentor or manager when you meet.</p>

        ';
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
