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
        $image_file = K_PATH_IMAGES.'Colab-Logo.jpg';
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
/*
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
$html = get_page_5();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 6 ===========================================*/
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
                                <td style="text-align: center"><br><br>'.get_evaluators_total_avg($attempt->id, $q->id).'</td>
                                <td>
                                    <img src="'.$pl_image.'" width="350px" height="60px">
                                </td>
                            </tr>';

                    $params = TCPDF_STATIC::serializeTCPDFtagParameters(array(108, $y, get_evaluators_total($attempt->id, $q->id), 4, 'DF', array(0,0,0,0), array(245,237,22)));
                    $html .= '<tcpdf method="Rect" params="'.$params.'" />';

                    $params = TCPDF_STATIC::serializeTCPDFtagParameters(array(108, $y+4, get_self_marking($user_id, $attempt->id,$survey->id, $q->id), 4, 'DF', array(0,0,0,0), array(90,167,61)));
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
                    <td><span style="background-color: #ffff00">&nbsp;&nbsp;&nbsp;</span>&nbsp;Total others</td>
                    <td><span style="background-color: #5AA73D">&nbsp;&nbsp;&nbsp;</span>&nbsp;Selft</td>
                </tr>
            </table>';

    $pdf->writeHTML($html, true, false, true, false, '');
}


/*

//======================================= page 9 ===========================================
$pdf->AddPage();
$html = get_page_9();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 10 ===========================================
$pdf->AddPage();
$html = get_page_10();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 11 ===========================================
$pdf->AddPage();
$html = get_page_11();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 12 ===========================================
$pdf->AddPage();
$html = get_page_12();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 13 ===========================================
$pdf->AddPage();
$html = get_page_13();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 14 ===========================================
$pdf->AddPage();
$html = get_page_14();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 15 ===========================================
$pdf->AddPage();
$html = get_page_15();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 16 ===========================================
$pdf->AddPage();
$html = get_page_16();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 17 ===========================================
$pdf->AddPage();
$html = get_page_17();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 18 ===========================================
$pdf->AddPage();
$html = get_page_18();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 19 ===========================================
$pdf->AddPage();
$html = get_page_19();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 20 ===========================================
$pdf->AddPage();
$html = get_page_20();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 21 ===========================================
$pdf->AddPage();
$html = get_page_21();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 22 ===========================================
$pdf->AddPage();
$html = get_page_22();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 23 ===========================================
$pdf->AddPage();
$html = get_page_23();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 24 ===========================================
$pdf->AddPage();
$html = get_page_24();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 25 ===========================================
$pdf->AddPage();
$html = get_page_25();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 26 ===========================================
$pdf->AddPage();
$html = get_page_26();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 27 ===========================================
$pdf->AddPage();
$html = get_page_27();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 28 ===========================================
$pdf->AddPage();
$html = get_page_28();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 29 ===========================================
$pdf->AddPage();
$html = get_page_29();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 30 ===========================================
$pdf->AddPage();
$html = get_page_30();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 31 ===========================================
$pdf->AddPage();
$html = get_page_31();
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 32 ===========================================
$pdf->AddPage();
$html = get_page_32();
$pdf->writeHTML($html, true, false, true, false, '');
*/

// reset pointer to the last page
$pdf->lastPage();

//Close and output PDF document
$pdf->Output('Report_360_leadershipCo_Lab.pdf', 'I');

