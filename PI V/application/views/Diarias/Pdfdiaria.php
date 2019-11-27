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

<span  style="font-family:arial; text-align:center"> <h2><u> PROPOSTA DE CONCESSÃO DE DIÁRIAS</u> </h2><br> Lei Municipal nº 1142/95 e 2.573/2013</span><br>

<table cellspacing="0" cellpadding="1" style="font-family:arial; font-size:13px; border: 1px solid #000000;" border='1'>
    <tr class='thead-dark'>
        <td class='col-xs-6' colspan="2"><h4> 1. PROPONENTE</h4></td>
        <th></th>
    </tr>
    <tr colspan="4">
        <td class='col-xs-6' colspan="6" style='text-align:center' ><br> Nome: $servidor</td>
        <td></td>
        <td></td>
    </tr>    
    <tr colspan="4">
        <td class='col-xs-6' colspan="6"> Cargo: $cargo</td>
        <td></td>
    </tr>
    <tr colspan="4">
        <td class='col-xs-6'> Matrícula: $portaria_matricula</td>  
        <td></td>
        <th class='col-xs-6'><br> Banco: $banco </th>
    </tr>
    <tr  colspan="4">
        <td class='col-xs-6'> CPF: $cpf</td>
        <td></td>
        <th class='col-xs-6'> Agência: $agencia </th>
    </tr>
    <tr colspan="4">
        <th class='col-xs-6'> Telefone: $telefone </th>
        <td></td>
        <th class='col-xs-6'> Conta corrente: $conta </th>
    </tr>
</table>

EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" style="font-family:arial; font-size:13px; border: 1px solid #000000;" border='1'>
    <tr class='thead-dark'>
        <td class='col-xs-6' colspan="4"><h4> 2. LOCAL/SERVIÇO A SER EXECUTADO E PERÍODO DO AFASTAMENTO</h4></td>
        <th></th>
    </tr>
    <tr colspan="4">
        <td class='col-xs-6' colspan="4"><br> Data e Hora do Egresso: $data_saida</td>       
    </tr>
    <tr colspan="5">
        <td class='col-xs-6' colspan="4"> Data e Hora do Retorno: $data_retorno</td> 
    </tr>
    <tr colspan="4">
        <td class='col-xs-6' colspan="4"> Localidade: $cidade_destino - $estado_destino </td>
    </tr>
    <tr colspan="4">
        <td class='col-xs-6' colspan="4"> Veículo: $veiculo </td>
    </tr>
    <tr  colspan="4">
        <td class='col-xs-6' colspan="5" style='text-align:center' > Motivo: $motivo </td>  
    </tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" style="font-family:arial; font-size:13px; border: 1px solid #000000;" border='1'>
    <tr class='thead-dark'>
        <td class='col-xs-6' colspan="4"><h4> 3. VALOR DA DIÁRIA</h4></td>
        <th></th>
    </tr>
    <tr colspan="4">
        <td class='col-xs-6' colspan="4"><br> Nº de Diárias Concedidas: $tempo_total</td>       
    </tr>
    <tr colspan="4">
        <td class='col-xs-6' colspan="4"> Total: R$ $valor_total </td>
    </tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

// Table with rowspans and THEAD
$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" style="font-family:arial; font-size:13px; border: 1px solid #000000;" border='1'>
    <tr class='thead-dark'>
        <td class='col-xs-6' colspan="4"><h4> 4. CLASSIFICAÇÃO ORÇAMENTÁRIA</h4></td>
        <th></th>
    </tr>
    <tr colspan="4">
        <td class='col-xs-6' colspan="4"><br> Órgão: $orgao - $secretaria_nome</td>       
    </tr>
    <tr colspan="5">
        <td class='col-xs-6' colspan="4"> Código Reduzido: $codigo_reduzido</td> 
    </tr>    
    <tr colspan="5">
        <td class='col-xs-6' colspan="4"> Atividade: $atividade</td> 
    </tr>
    <tr colspan="4">
        <td class='col-xs-6' colspan="4"> Elemento de Despesa: $elemento_despesa  - Diárias de viagem - Pessoa civil</td>
    </tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');


// -----------------------------------------------------------------------------

$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" style="font-family:arial; font-size:13px; border: 1px solid #000000;" border='1'>
    <tr class='thead-dark'>
        <td class='col-xs-6' colspan="4"><h4> 5. ASSINATURAS</h4></td>
        <th></th>
    </tr>
    <tr colspan="4" >
        <td colspan='1'></td>
        <td class='col-xs-6' colspan="2"><br><br><br> Secretário(a)</td>   
        <td class='col-xs-6' colspan="2"><br><br><br> Servidor(a) <br></td>       
    </tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" style="font-family:arial; font-size:13px; border: 1px solid #000000;" border='1'>
    <tr class='thead-dark'>
        <td class='col-xs-6' colspan="4"><h4> 6. AUTORIZAÇÃO</h4></td>
        <th></th>
    </tr>
    <tr colspan="5">
        <td class='col-xs-6' colspan="5" align="center"> CONCEDA-SE, EMPENHA-SE E PAGUE-SE DE ACORDO COM O SOLICITADO</td> 
    </tr>    
    <tr colspan="5">
        <td class='col-xs-6' colspan="5" align="center">Camboriú, $dia de $mes de $ano</td> 
    </tr>
    <tr colspan="5">
        <td class='col-xs-6' colspan="5" align="center"><br><br><br><br> Prefeito(a) Municipal <br></td> 
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


