<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Mypdf extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file1 = FCPATH.'imgpdf/'.'logoKeus.jpg';
        $this->Image($image_file1, 40, 5, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('stsongstdlight', 'B', 18);
        // Title
        $this->SetX(5);
        $this->SetY(3);
        $this->Cell(0, 0, 'KARTU KELUARGA KATOLIK KEUSKUPAN KETAPANG (K5)', 0, 20, 'C', 0, '', 0);
        $this->SetFont('times', 'B', 14);
        $this->SetX(5);
        $this->Cell(0, 0, 'Paroki Paroki St. Yosef Meraban', 0, 20, 'C', 0, '', 0);
        $image_file2 = FCPATH.'imgpdf/'.'logoPar.jpg';
        $this->Image($image_file2, 240, 5, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-10);
        // Set font
        $this->SetFont('times', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Dicetak: '.date('d/m/y H:i'), 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 10, 'Hal '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */
