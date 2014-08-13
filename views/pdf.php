<?php
/**
 * Created by PhpStorm.
 * User: bashet
 * Date: 08/08/14
 * Time: 19:39
 */
tcpdf();

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'CoLab-Logo.jpg';
        $this->Image($image_file, 175, 2, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        //$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', '', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'l', 0, '', 0, false, 'T', 'M');
    }
}



$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Abdul Bashet');
$pdf->SetTitle('Report | 360 Leadership CoLab');
$pdf->SetSubject('Report | 360 Leadership CoLab');


// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 8);
$pl_image = $base_url .'addons/shared_addons/modules/survey/img/performance_level.jpg';
$pl_dtl1  = $base_url .'addons/shared_addons/modules/survey/img/details1.jpg';
$pl_dtl2  = $base_url .'addons/shared_addons/modules/survey/img/details2.jpg';

//======================================= page 1 ===========================================
$pdf->AddPage();
$html = get_page_1($all_attempt, $programme, $attempt);
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 2 ===========================================
$pdf->AddPage();
$html = get_page_2();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 3 ===========================================
$pdf->AddPage();
$html = get_page_3();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 4 ===========================================
$pdf->AddPage();
$html = get_page_4();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 5 ===========================================
$pdf->AddPage();
$html = get_page_5($total_evaluators);
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 6 ===========================================
foreach($categories as $cat_id){
    $cat = get_category_by_id($cat_id);
    $sort_order = json_decode($cat->questions);
    $questions = get_questions_by_category($cat_id);

    $pdf->AddPage();
    $html = '

        <style>
            th {
                text-align: center;
                border: 2px solid #ffffff;
                color: #ffffff;
            }
            td {
                border: 2px solid #ffffff;
            }
            .performance_level {
                border: 1px solid #000000;
                top: 20px;
                position: absolute;
            }
            .level_index{
                width:25%;
            }
        </style>

        <p><strong>Your competency summary table</strong></p>
        <table border="1" cellpadding="4" cellspacing="1">
            <tr bgcolor="#5AA73D">
                <th width="30%">Cluster/Competency</th>
                <th width="20%">Avg Total Other Rating</th>
                <th width="50%">Level of Performance</th>
            </tr>
            <tr bgcolor="#f5f5f5">
                <td colspan="3">'.$cat->name.'</td>
            </tr>';
    if($questions){
        $y = 58;
        foreach($sort_order as $order){
            foreach($questions as $q){
                if($order == $q->id){
                    $html.= '<tr height="200">
                                <td><br><br>'.$q->title.'</td>
                                <td style="text-align: center"><br><br>'.get_evaluators_total_avg($evaluators, $q->id).'</td>
                                <td>
                                    <img src="'.$pl_image.'" width="350px" height="60px">
                                </td>
                            </tr>';

                    $params = TCPDF_STATIC::serializeTCPDFtagParameters(array(108, $y, get_evaluators_total($evaluators, $q->id), 4, 'DF', array(0,0,0,0), array(245,237,22)));
                    $html .= '<tcpdf method="Rect" params="'.$params.'" />';

                    $params = TCPDF_STATIC::serializeTCPDFtagParameters(array(108, $y+4, get_self_marking($user_answer, $q->id), 4, 'DF', array(0,0,0,0), array(90,167,61)));
                    $html .= '<tcpdf method="Rect" params="'.$params.'" />';
                    $y = $y+19;
                }
            }

        }
    }

    $html .='</table>';

    $html .= '<p></p>';

    $html .='<table width="180px" border="1" cellpadding="4" cellspacing="1">
                <tr bgcolor="#f5f5f5">
                    <td><span style="background-color: rgb(245,237,22)">&nbsp;&nbsp;&nbsp;</span>&nbsp;Total others</td>
                    <td><span style="background-color: rgb(90,167,61)">&nbsp;&nbsp;&nbsp;</span>&nbsp;Selft</td>
                </tr>
            </table>';

    $pdf->writeHTML($html, true, false, true, false, '');
}




//======================================= page 9 ===========================================
$pdf->AddPage();
$html  = '<style>
            th {
                text-align: center;
                border: 2px solid #ffffff;
                color: #ffffff;
            }
            td {
                border: 2px solid #ffffff;
            }
        </style>';
$html .= '<p><strong>Your strengths</strong></p>';
$html .= '<p>Highest scoring competencies</p>';
$html .=    '<table border="1" cellpadding="4" cellspacing="1">
                <tr bgcolor="rgb(90,167,61)">
                    <th width="5%"></th>
                    <th width="55%">Competency</th>
                    <th width="25%">Total Others</th>
                    <th width="15%">Self</th>
                </tr>';
            $top_answers = get_answer_top_5($evaluators);
            $my_answer = json_decode($user_answer->answers, true);
            $i = 1;
            foreach($top_answers as $q_no => $ans){
                $html .= '<tr>';
                $html .= '<td>'.$i.'</td>';
                $html .= '<td>'.get_question_title_by_q_id($q_no).'</td>';
                $html .= '<td style="text-align:center">'.round($ans/$total_evaluators,2).'</td>';
                $html .= '<td style="text-align:center">'.$my_answer[$q_no].'</td>';
                $html .= '</tr>';
                $i++;
                if($i == 6){
                    break;
                }
            }

$html .= '</table>';

$html .= '<p><strong>Areas for development</strong></p>';
$html .= '<p>Lowest scoring competencies</p>';
$html .=    '<table border="1" cellpadding="4" cellspacing="1">
                <tr bgcolor="rgb(90,167,61)">
                    <th width="5%"></th>
                    <th width="55%">Competency</th>
                    <th width="25%">Total Others</th>
                    <th width="15%">Self</th>
                </tr>';
$top_answers = get_answer_bottom_5($evaluators);
$my_answer = json_decode($user_answer->answers, true);
$i = 1;
foreach($top_answers as $q_no => $ans){
    $html .= '<tr>';
    $html .= '<td>'.$i.'</td>';
    $html .= '<td>'.get_question_title_by_q_id($q_no).'</td>';
    $html .= '<td style="text-align:center">'.round($ans/$total_evaluators,2).'</td>';
    $html .= '<td style="text-align:center">'.$my_answer[$q_no].'</td>';
    $html .= '</tr>';
    $i++;
    if($i == 6){
        break;
    }
}

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');

//======================================= page 10 ===========================================
$pdf->AddPage();
$html = '<style>
            th {
                text-align: center;
                border: 2px solid #ffffff;
                color: #ffffff;
            }
            td {
                border: 2px solid #ffffff;
            }
        </style>';
$html .= '<p><strong>'.$programme->name.' competency clusters</strong></p>';
$html .= '<table border="1" cellpadding="1" cellspacing="1">
            <tr>';
foreach($categories as $key=>$cat_id){
    $html .= '<td>';
    $category  = get_category_by_id($cat_id);
    //var_dump($category);
    $sort_order = json_decode($category->questions);
    $questions = get_questions_by_category($cat_id);
    $html .= '<table cellpadding="15" cellspacing="1">';
    $html .= '<tr bgcolor="rgb(90,167,61)">';
    $html .= '<th>'.$category->name.'</th>';
    $html .= '</tr>';
    if($questions){

        $i = 1;
        foreach($sort_order as $order){
            foreach($questions as $q){
                if($order == $q->id){
                    $html .= '<tr>';
                    $html .= '<td>';
                    $html .= $q->title;
                    $html .= '</td>';
                    $html .= '</tr>';
                }
            }
            $i++;
        }

    }

    $html .= '</table>';
    $html .= '</td>';
}
$html .= '</tr>';
$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 11 ===========================================
$pdf->AddPage();
$html = get_page_10();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 12 ===========================================
foreach($categories as $cat_id){
    $cat = get_category_by_id($cat_id);
    $sort_order = json_decode($cat->questions);
    $questions = get_questions_by_category($cat_id);

    if($questions){
        foreach($sort_order as $order){
            foreach($questions as $q){
                if($order == $q->id){
                    $answer = get_answers_by_q_id($q->id);
                    $pdf->AddPage();
                    $html = '
                            <style>
                                td {
                                    border: 2px solid #ffffff;
                                }
                            </style>';

                    $html .= '<table border="0" cellpadding="6" cellspacing="1">';
                    $html .= '<tr>';
                    $html .= '<td>';
                    $html .= '<p><strong>'.$cat->name.'</strong></p>';
                    $html .= '<p>Category: '.$q->title.'</p>';
                    $html .= '</td>';
                    $html .= '<td>';
                    $html .= '</td>';
                    $html .= '</tr>';
                    $html .= '<tr>';
                    $html .= '<td>';
                    $html .= '<img src="'.$pl_dtl1.'" height="245">';
                    $html .= '</td>';
                    $html .= '<td>';
                    $html .= '<br><br><p><strong>Number of ratings at each level</strong><br>
                                                <br>Response 4 x '.get_evaluators_total_num($evaluators, $q->id, 4).'<br>
                                                <br>Response 3 x '.get_evaluators_total_num($evaluators, $q->id, 3).'<br>
                                                <br>Response 2 x '.get_evaluators_total_num($evaluators, $q->id, 2).'<br>
                                                <br>Response 1 x '.get_evaluators_total_num($evaluators, $q->id, 1).'</p>';
                    $html .= '</td>';
                    $html .= '</tr>';
                    $html .= '<tr>';
                    $html .= '<td width="45%">';
                    $html .= '<p><strong>'.$q->title.'</strong></p>';
                    $html .= '<strong>Definition</strong>'.$q->description;
                    $html .= '<strong>Why it matters</strong>'.$q->matter;
                    $html .= '<strong>Key question:</strong>'.$q->text2;
                    $html .= '</td>';
                    $html .= '<td width="55%">';
                    $html .= '<strong>Response 4 - '.$answer->option_4_label.'</strong>';
                    $html .= $answer->option_4;
                    $html .= '<strong>Response 3 - '.$answer->option_3_label.'</strong>';
                    $html .= $answer->option_3;
                    $html .= '<strong>Response 2 - '.$answer->option_2_label.'</strong>';
                    $html .= $answer->option_2;
                    $html .= '<strong>Response 1 - '.$answer->option_1_label.'</strong>';
                    $html .= $answer->option_1;
                    $html .= '</td>';
                    $html .= '</tr>';

                    $html .= '</table>';
                    $params = TCPDF_STATIC::serializeTCPDFtagParameters(array(28, 110.8, 20, -get_evaluators_total_details($evaluators, $q->id), 'DF', array(0,0,0,0), array(0,128,225)));
                    $html .= '<tcpdf method="Rect" params="'.$params.'"/>';

                    $params = TCPDF_STATIC::serializeTCPDFtagParameters(array(65, 110.8, 20, -get_self_marking_details($user_answer, $q->id), 'DF', array(0,0,0,0), array(0,128,225)));
                    $html .= '<tcpdf method="Rect" params="'.$params.'"/>';

                    $pdf->writeHTML($html, true, false, true, false, '');

                }
            }

        }
    }

}


//======================================= page 32 ===========================================
$pdf->AddPage();
$html = '<style>
            th {
                text-align: center;
                border: 2px solid #ffffff;
                color: #ffffff;
            }
            td {
                border: 2px solid #ffffff;
                text-align: center;
            }
        </style>';
foreach($categories as $cat_id){
    $cat = get_category_by_id($cat_id);
    $sort_order = json_decode($cat->questions);
    $questions = get_questions_by_category($cat_id);

    $html .= '<table border="1" cellpadding="4" cellspacing="1">';
    $html .= '<tr bgcolor="rgb(90,167,61)">';
    $html .= '<th width="28%" rowspan="2">'.$cat->name.' Cluster</th>';
    $html .= '<th width="36%" colspan="4">Self</th>';
    $html .= '<th width="36%" colspan="4">Peer</th>';
    $html .= '</tr>';
    $html .= '<tr bgcolor="rgb(90,167,61)">';
    $html .= '<th width="9%">1</th>';
    $html .= '<th width="9%">2</th>';
    $html .= '<th width="9%">3</th>';
    $html .= '<th width="9%">4</th>';
    $html .= '<th width="9%">1</th>';
    $html .= '<th width="9%">2</th>';
    $html .= '<th width="9%">3</th>';
    $html .= '<th width="9%">4</th>';
    $html .= '</tr>';

    if($questions){
        foreach($sort_order as $order){
            foreach($questions as $q){
                if($order == $q->id){
                    $html .= '<tr bgcolor="#f5f5f5">';
                    $html .= '<td>'.$q->title.'</td>';
                    $html .= '<td>'.get_self_marking_table($user_answer, $q->id, 1).'</td>';
                    $html .= '<td>'.get_self_marking_table($user_answer, $q->id, 2).'</td>';
                    $html .= '<td>'.get_self_marking_table($user_answer, $q->id, 3).'</td>';
                    $html .= '<td>'.get_self_marking_table($user_answer, $q->id, 4).'</td>';
                    $html .= '<td>'.get_evaluators_total_table($evaluators, $q->id, 1).'</td>';
                    $html .= '<td>'.get_evaluators_total_table($evaluators, $q->id, 2).'</td>';
                    $html .= '<td>'.get_evaluators_total_table($evaluators, $q->id, 3).'</td>';
                    $html .= '<td>'.get_evaluators_total_table($evaluators, $q->id, 4).'</td>';
                    $html .= '</tr>';
                }
            }
        }
    }


    $html .= '</table>';
    $html .= '<br>';
    $html .= '<br>';
    $html .= '<br>';
}

$pdf->writeHTML($html, true, false, true, false, '');


// reset pointer to the last page
$pdf->lastPage();

//Close and output PDF document
$pdf->Output('Report_360_leadershipCo_Lab.pdf', 'I');

