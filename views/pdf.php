<?php
/**
 * Created by PhpStorm.
 * User: bashet
 * Date: 08/08/14
 * Time: 19:39
 */

tcpdf();

$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Abdul Bashet');
$pdf->SetTitle('Report | 360 Leadership CoLab');
$pdf->SetSubject('Offer Letter');


// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
$pdf->SetFont('dejavusans', '', 10);

$logo = $base_url .'addons/shared_addons/modules/survey/img/Colab-Logo.jpg';
// add a page
$pdf->AddPage();

$html = '<img src="'.$logo.'" width="100" border="0" />';
$html .= '
    fghfd fghgfdh
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->AddPage();

$html = '<img src="'.$logo.'" width="100" border="0" />';
$html .= '
    fghfd fghgfdh
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->AddPage();

$html = '<img src="'.$logo.'" width="100" border="0" />';
$html .= '
    fghfd fghgfdh
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->AddPage();

$html = '<img src="'.$logo.'" width="100" border="0" />';
$html .= '
    fghfd fghgfdh
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
//$pdf->lastPage();

//Close and output PDF document
$pdf->Output('Report_360_leadershipCo_Lab.pdf', 'I');

