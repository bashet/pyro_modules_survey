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
$pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);
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

//======================================= page 1 ===========================================
$pdf->AddPage();
$html = get_page_1($all_attempt, $programme, $attempt);
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 2 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 3 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 4 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 5 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 6 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 7 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 8 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 9 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 10 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 11 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 12 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 13 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 14 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 15 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 16 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 17 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 18 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 19 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 20 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 21 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 22 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 23 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 24 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 25 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 26 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 27 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 28 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 29 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 30 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 31 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');
//======================================= page 32 ===========================================
$pdf->AddPage();
$html = '';
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
//$pdf->lastPage();

//Close and output PDF document
$pdf->Output('Report_360_leadershipCo_Lab.pdf', 'I');

