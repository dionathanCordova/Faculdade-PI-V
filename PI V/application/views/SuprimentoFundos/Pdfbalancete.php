<?php
defined('BASEPATH') OR exit('No direct script access allowed');


//============================================================+
// File name   : example_003.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 003 for TCPDF class
//               Custom Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Custom Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
// require_once('tcpdf/tcpdf.php');


class MYPDF extends TCPDF {

    //Page header
    public function Header() {

        // Logo
        $image_file = K_PATH_IMAGES.'logopdf.jpg';
        $this->Image($image_file, 12, 7, 120, '', 'JPG', '', 'T', false, 10, '', false, false, 0, false, false, false);
        // Set font
        // $this->SetFont('helvetica', 'B', 10);
        // Title
        // $this->Cell(80, 55, 'PROPOSTA DE CONCESSÃO DE DIÁRIAS', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    // public function Footer() {
    //     // Position at 15 mm from bottom
    //     $this->SetY(-15);
    //     // Set font
    //     $this->SetFont('helvetica', 'I', 8);
    //     // Page number
    //     $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    // }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'BI', 12);

// add a page
$pdf->AddPage();


$pdf->Write(0, '', '', 0, 'C', true, 0, false, false, 50);

$pdf->SetFont('helvetica', '', 8);


// -----------------------------------------------------------------------------

$tbl = <<<EOD

<span  style="font-family:arial; text-align:center"> <h2 ><u> BALANCETE DE PRESTAÇÃO DE CONTAS/ADIANTAMENTO </u> </h2><br></span><br>

<table cellspacing="0" cellpadding="4" style=" font-family:arial; font-size:13px; border: 1px solid #000000;" border='1'>
 
    <tr>
        <th style="text-align:center; border-left: 1px solid dark; border-top: 1px solid dark; border-bottom: 1px solid dark; border-right: 1px solid dark; ">Mes $mes_numero</th>
        <th colspan='3' style="text-align:center border-left: 1px solid dark; border-top: 1px solid dark; border-bottom: 1px solid dark; border-right: 1px solid dark; ">Ano $ano</th>
    </tr>

    <tr>
        <td colspan='4' style="padding-left: 200px; border-left: 1px solid dark; border-top: 1px solid dark; border-bottom: 1px solid dark;"> BENEFICIADO:  $servidor</td>
        <td style="border-right: 1px solid dark; border-top: 1px solid dark; border-bottom: 1px solid dark;"></td>
    </tr>
    <tr>
        <td colspan='4' style="padding-left: 200px; border-left: 1px solid dark; border-top:  1px solid dark; border-bottom:  1px solid dark;"> CPF:  $cpf</td>
        <td style="border-right: 1px solid dark; border-top: 1px solid dark; border-bottom:  1px solid dark;"></td>
    </tr>
    <tr colspan='4' >
        <td colspan="2" style="padding-left: 200px; border-left: 1px solid dark; border-top:  1px solid dark; border-bottom:  1px solid dark;"> ENDEREÇO :  $endereco</td>
    </tr>
    <tr>
        <td colspan='4' style="padding-left: 200px; border-left: 1px solid dark; border-top:  1px solid dark; border-bottom:  1px solid dark;"> CEP :  $cep</td>
        <td style="border-right: 1px solid dark; border-top: 1px solid dark; border-bottom:  1px solid dark;"></td>
    </tr>
    <tr>
        <td colspan='4' style="padding-left: 200px; border-left: 1px solid dark; border-top:  1px solid dark; border-bottom:  1px solid dark;"> VALOR :  $valor_total</td>
        <td style="border-right: 1px solid dark; border-top: 1px solid dark; border-bottom:  1px solid dark;"></td>
    </tr>
    <tr>
        <td colspan='4' style="padding-left: 200px; border-left: 1px solid dark; border-top:  1px solid dark; border-bottom:  1px solid dark;"> DATA DEPÓSITO :  $data_deposito</td>
        <td style="border-right: 1px solid dark; border-top: 1px solid dark; border-bottom:  1px solid dark;"></td>
    </tr>
    <tr>
        <td colspan="2" style="border-collapse: collapse; padding-left: 200px; border-left: 1px solid dark; border-top:  1px solid dark; border-bottom:  1px solid dark; border-right: 1px solid dark;"> OBJETIVO: $motivo </td>
    </tr>
  
</table>

EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------
$html = '';

foreach($dados_balancete as $info) {

    // echo '<pre>';
    // var_dump($info);
    $html .= 
    '<tr>
        <td style="text-align:center; border-right: 1px solid dark; padding-left: 200px; border-left: 1px solid dark; border-top:  1px solid dark; border-bottom:  1px solid dark;">'. $info['recibo'] .'</td>
        <td style="text-align:center; border-right: 1px solid dark; border-top: 1px solid dark; border-bottom:  1px solid dark;">'. $info['data'] . '</td>
        <td colspan="2" style="text-align:center; border-right: 1px solid dark; border-top: 1px solid dark; border-bottom:  1px solid dark;">'. $info['razaosocial'] .'</td>
        <td style="text-align:center; border-right: 1px solid dark; border-top: 1px solid dark; border-bottom:  1px solid dark;"> '. number_format($info['pagamento'], '2', ',', '') .'</td>
    </tr>';
}


$tbl = <<<EOD
    <table cellspacing="0" cellpadding="4" style=" font-family:arial; font-size:13px; border: 1px solid #000000;" border='1'>
        <tr>
            <th colspan="2" style="text-align:center; border-left: 1px solid dark; border-top: 1px solid dark; border-bottom: 1px solid dark; border-right: 1px solid dark; ">HISTÓRICO</th>
            <th colspan="2"  style="text-align:center border-left: 1px solid dark; border-top: 1px solid dark; border-bottom: 1px solid dark; border-right: 1px solid dark; ">RECEBIMENTOS</th>
            <th style="text-align:center border-left: 1px solid dark; border-top: 1px solid dark; border-bottom: 1px solid dark; border-right: 1px solid dark; "> </th>
        </tr>
  
        <tr>
            <td colspan="4" style="padding-left: 200px; border-left: 1px solid dark; border-top: 1px solid dark; border-bottom: 1px solid dark;border-right: 1px solid dark;"> </td>
            <td style="text-align:center border-right: 1px solid dark; border-top: 1px solid dark; border-bottom: 1px solid dark;">VALOR: R$ $valor_total </td>
        </tr>

        <tr>
            <td style="text-align:center; border-right: 1px solid dark; padding-left: 200px; border-left: 1px solid dark; border-top:  1px solid dark; border-bottom:  1px solid dark;"> RECIBO</td>
            <td style="text-align:center; border-right: 1px solid dark; border-top: 1px solid dark; border-bottom:  1px solid dark;"> DATA</td>
            <td colspan="2" style="text-align:center; border-right: 1px solid dark; border-top: 1px solid dark; border-bottom:  1px solid dark;"> NOME RAZÃO SOCIAL</td>
            <td style="text-align:center; border-right: 1px solid dark; border-top: 1px solid dark; border-bottom:  1px solid dark;"> PAGAMENTOS</td>
        </tr>

        $html

        <tr>
            <td colspan="4" style="padding-left: 200px; border-left: 1px solid dark; border-top: 1px solid dark; border-bottom: 1px solid dark;border-right: 1px solid dark;">TOTAL: (RECEBIMENTO – PAGAMENTO) DEVOLUÇÃO: R$ $devolucao </td>
            <td style="text-align:center border-right: 1px solid dark; border-top: 1px solid dark; border-bottom: 1px solid dark;">Total: R$ $total_gasto </td>
        </tr>
      
    </table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

$tbl = <<<EOD
    <br><br><br><br><br>
    <table cellspacing="0" cellpadding="4" style=" font-family:arial; font-size:13px;" border='1'>
        <tr>
            <th style="text-align:center"> ________________________ </th>
        </tr>
  
        <tr>
            <td style="text-align:center;"> ASSINATURA </td>
        </tr>

      
    </table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------
//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+


