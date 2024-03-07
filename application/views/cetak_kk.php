<?php
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Makarius Yuwono');
$pdf->SetTitle('K5 '.$cekkk['nama_paroki']);
$pdf->SetSubject('KARTU KELUARGA KATOLIK KEUSKUPAN KETAPANG (K5)');
$pdf->SetKeywords('addon_statpar,pendataan,katolik,ketapang');

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
$pdf->SetAutoPageBreak(TRUE, 15);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}


// ---------------------------------------------------------

// set array for viewer preferences
$preferences = array(
    'HideToolbar' => true,
    'HideMenubar' => true,
    'HideWindowUI' => true,
    'FitWindow' => true,
    'CenterWindow' => true,
    'DisplayDocTitle' => true,
    'NonFullScreenPageMode' => 'UseNone', // UseNone, UseOutlines, UseThumbs, UseOC
    'ViewArea' => 'CropBox', // CropBox, BleedBox, TrimBox, ArtBox
    'ViewClip' => 'CropBox', // CropBox, BleedBox, TrimBox, ArtBox
    'PrintArea' => 'CropBox', // CropBox, BleedBox, TrimBox, ArtBox
    'PrintClip' => 'CropBox', // CropBox, BleedBox, TrimBox, ArtBox
    'PrintScaling' => 'AppDefault', // None, AppDefault
    'Duplex' => 'DuplexFlipLongEdge', // Simplex, DuplexFlipShortEdge, DuplexFlipLongEdge
    'PickTrayByPDFSize' => true,
    'PrintPageRange' => array(1,1,1,1),
    'NumCopies' => 1
);

// Check the example n. 60 for advanced page settings

// set pdf viewer preferences
$pdf->setViewerPreferences($preferences);

        // add a page
        $pdf->SetMargins(2, 2, 2, true);
        $pdf->AddPage('L', 'A4', false, false);

        $background_text = str_repeat(strtoupper($cekkk['nama_paroki']).' ', 160);
$pdf->SetAlpha(0.02);
$pdf->SetFont('freemono', 'B', 12);
        $pdf->MultiCell(0, 0, $background_text, 0, 'C', 0, 2, '', '', true, 0, false);
        $pdf->SetAlpha(1);


$x = 20;
$y = 18;

$pdf->SetFont('times', 'B', 12);
//$pdf->SetFillColor(120, 0, 0);
//$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell(258, '', $x, $y, 'No KK: '.$cekkk['no_kk'], 0, 0, 0, true, 'C', true);

$pdf->SetFont('', '', 10);
$pdf->SetTextColor(0, 0, 0);
$y = $pdf->getY() + $pdf->getLastH()+1;
$pdf->writeHTMLCell(30, '', $x, $y, 'Kepala Keluarga', 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell(5, '', '', '', ':', 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell(100, '', '', '', $cekkk['nama'], 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell(30, '', $x+165, $y, 'Kecamatan', 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell(5, '', '', '', ':', 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell(70, '', '', '', $cekkk['nama_kecamatan']!=''?$cekkk['nama_kecamatan']:'Simpang Hulu', 0, 0, 0, true, 'L', true);
$pdf->SetFont('', '', 10);
$pdf->SetTextColor(0, 0, 0);
$y = $pdf->getY() + $pdf->getLastH();
$pdf->writeHTMLCell(30, '', $x, $y, 'Stasi/Kring', 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell(5, '', '', '', ':', 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell(100, '', '', '', $cekkk['nama_stasi'], 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell(30, '', $x+165, $y, 'Kabupaten', 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell(5, '', '', '', ':', 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell(70, '', '', '', $cekkk['nama_kota']!=''?$cekkk['nama_kota']:'Ketapang', 0, 0, 0, true, 'L', true);
$pdf->SetFont('', '', 10);
$pdf->SetTextColor(0, 0, 0);
$y = $pdf->getY() + $pdf->getLastH();
$pdf->writeHTMLCell(30, '', $x, $y, 'Desa', 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell(5, '', '', '', ':', 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell(100, '', '', '', $cekkk['nama_desa'], 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell(30, '', $x+165, $y, 'Propinsi', 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell(5, '', '', '', ':', 0, 0, 0, true, 'L', true);
$pdf->writeHTMLCell(70, '', '', '', $cekkk['nama_propinsi']!=''?$cekkk['nama_propinsi']:'Kalimantan Barat', 0, 0, 0, true, 'L', true);
$pdf->Ln(6);

$pdf->SetFont('helvetica', '', 8);

$tbl1 = <<<EOD
<table border="1" cellpadding="0" cellspacing="0" align="center">
<thead>
 <tr nobr="true" style="background-color:#f2d2b4;">
  <th width="2%"><strong>No</strong></th>
  <th width="15%"><strong>Nama Lengkap<br>(Dengan Nama Baptis)</strong></th>
  <th width="6%"><strong>Jenis Kelamin</strong></th>
  <th width="12%"><strong>Tempat Lahir</strong></th>
  <th width="7%"><strong>Tanggal Lahir</strong></th>
  <th width="8%"><strong>Pendidikan</strong></th>
  <th width="12%"><strong>Jenis Pekerjaan</strong></th>
  <th width="8%"><strong>Tempat Baptis</strong></th>
  <th width="8%"><strong>Agama</strong></th>
  <th width="7%"><strong>Tanggal Baptis</strong></th>
  <th width="15%"><strong>Pastor yang membaptis</strong></th>
 </tr>
 <tr nobr="true" style="background-color:#e1d3c2;">
  <th></th>
  <th><strong>1</strong></th>
  <th><strong>2</strong></th>
  <th><strong>3</strong></th>
  <th><strong>4</strong></th>
  <th><strong>5</strong></th>
  <th><strong>6</strong></th>
  <th><strong>7</strong></th>
  <th><strong>8</strong></th>
  <th><strong>9</strong></th>
  <th><strong>10</strong></th>
 </tr>
 </thead>
EOD;
$i=1;
$tbl1 .= <<<EOD
<tbody>
EOD;
foreach ($isiikk as $ikk) {
  $tg_baptis = date('d/m/Y',strtotime($ikk['qi_baptis_tgl']));
  $tg_lahir = date('d/m/Y',strtotime($ikk['qi_tglhr']));
$tbl1 .= <<<EOD
 <tr nobr="true">
  <td width="2%">$i</td>
  <td width="15%" style="text-align:left;">$ikk[qi_nama]</td>
  <td width="6%">$ikk[qi_jkel]</td>
  <td width="12%" style="text-align:left;">$ikk[qi_tplhr]</td>
  <td width="7%">$tg_lahir</td>
  <td width="8%" style="text-align:left;">$ikk[qi_didik]</td>
  <td width="12%" style="text-align:left;">$ikk[qi_kerja]</td>
  <td width="8%" style="text-align:left;">$ikk[qi_baptis_stasi]</td>
  <td width="8%" style="text-align:left;">$ikk[qi_agama]</td>
  <td width="7%">$tg_baptis</td>
  <td width="15%" style="text-align:left;">$ikk[qi_baptis_oleh]</td>
 </tr>
EOD;
$i++;
}
$tbl1 .= <<<EOD
</tbody>
</table>
EOD;

$pdf->writeHTML($tbl1, true, false, false, false, '');
/*

*/
$tbl2 = <<<EOD
<table border="1" cellpadding="1" cellspacing="0" align="center">
<thead>
 <tr nobr="true" style="background-color:#f2d2b4;">
  <th width="2%"><strong>No</strong></th>
  <th width="11%"><strong>Wali Baptis 1</strong></th>
  <th width="11%"><strong>Wali Baptis 2</strong></th>
  <th width="8%"><strong>No. LB</strong></th>
  <th width="7%"><strong>Status Pernikahan</strong></th>
  <th width="10%"><strong>Tempat Menikah</strong></th>
  <th width="7%"><strong>Tgl. Menikah</strong></th>
  <th width="14%"><strong>Pastor yang Menikahkan</strong></th>
  <th width="11%"><strong>Saksi Nikah 1</strong></th>
  <th width="11%"><strong>Saksi Nikah 2</strong></th>
  <th width="8%"><strong>No. LM</strong></th>
 </tr>
 <tr nobr="true" style="background-color:#e1d3c2;">
  <th></th>
  <th><strong>11</strong></th>
  <th><strong>12</strong></th>
  <th><strong>13</strong></th>
  <th><strong>14</strong></th>
  <th><strong>15</strong></th>
  <th><strong>16</strong></th>
  <th><strong>17</strong></th>
  <th><strong>18</strong></th>
  <th><strong>19</strong></th>
  <th><strong>20</strong></th>
 </tr>
 </thead>
EOD;
$i=1;
$tbl1 .= <<<EOD
<tbody>
EOD;
foreach ($isijkk as $jkk) {
  $tglnikah = date('d/m/Y',strtotime($jkk['qi_kawin_tgl']));
  $pastor1 = $jkk['qi_kawin_pastor1']?$jkk['qi_kawin_pastor1']:'';
  $pastor2 = $jkk['qi_kawin_pastor2']?$jkk['qi_kawin_pastor2']:'';
  $vkawin_pastor = 'style="text-align:left;"';
  if($pastor1=='' && $pastor2==''){
    $nama_pastor = '-';
    $vkawin_pastor = 'style="text-align:center;"';
  } elseif ($pastor1=='' && $pastor2!=''){
    $nama_pastor = $pastor2;
  } elseif ($pastor1!='' && $pastor2=='') {
    $nama_pastor = $pastor1;
  } elseif ($pastor1!='' && $pastor2!='') {
    $nama_pastor = $pastor1.'<br>'.$pastor2;
  }
//  $stskawin = $jkk->nomor_perkawinan!=''?'Kawin':'Belum Kawin';
  $stskawin = $jkk['qi_kawin_status'];
  $kawin_tempat = $jkk['qi_kawin_tempat']!=''?$jkk['qi_kawin_tempat']:'-';
  $vkawin_tempat = $jkk['qi_kawin_tempat']!=''?'style="text-align:left;"':'style="text-align:center;"';
  $kawin_saksi1 = $jkk['qi_kawin_saksi1']!=''?$jkk['qi_kawin_saksi1']:'-';
  $vkawin_saksi1 = $jkk['qi_kawin_saksi1']!=''?'style="text-align:left;"':'style="text-align:center;"';
  $kawin_saksi2 = $jkk['qi_kawin_saksi2']!=''?$jkk['qi_kawin_saksi2']:'-';
  $vkawin_saksi2 = $jkk['qi_kawin_saksi2']!=''?'style="text-align:left;"':'style="text-align:center;"';
  $kawin_nomor = $jkk['qi_kawin_nomor']!=''?$jkk['qi_kawin_nomor']:'-';
  $vkawin_nomor = $jkk['qi_kawin_nomor']!=''?'style="text-align:left;"':'style="text-align:center;"';
$tbl2 .= <<<EOD
 <tr nobr="true">
  <td width="2%">$i</td>
  <td width="11%" style="text-align:left;">$jkk[qi_baptis_wali1]</td>
  <td width="11%" style="text-align:left;">$jkk[qi_baptis_wali2]</td>
  <td width="8%" style="text-align:left;">$jkk[qi_baptis_nomor]</td>
  <td width="7%">$stskawin</td>
  <td width="10%" $kawin_tempat>$kawin_tempat</td>
  <td width="7%">$tglnikah</td>
  <td width="14%" $vkawin_pastor>$nama_pastor</td>
  <td width="11%" $vkawin_saksi1>$kawin_saksi1</td>
  <td width="11%" $vkawin_saksi2>$kawin_saksi2</td>
  <td width="8%" $vkawin_nomor>$kawin_nomor</td>
 </tr>
EOD;
$i++;
}
$tbl2 .= <<<EOD
</tbody>
</table>
EOD;

$pdf->writeHTML($tbl2, true, false, false, false, '');

/*

*/

$tbl3	 = <<<EOD
<table border="1" cellpadding="1" cellspacing="0" align="center">
<thead>
 <tr nobr="true" style="background-color:#f2d2b4;">
  <th width="2%"><strong>No</strong></th>
  <th width="12%"><strong>Jenis Perkawinan</strong></th>
  <th width="10%"><strong>Hubungan Dalam Keluarga</strong></th>
  <th width="10%"><strong>Domisili/Non Domisili (D/ND)</strong></th>
  <th width="8%"><strong>Tempat Krisma</strong></th>
  <th width="7%"><strong>Tanggal Krisma</strong></th>
  <th width="7%"><strong>NO. LC<br>No Krisma</strong></th>
  <th width="16%"><strong>Nama Ayah</strong></th>
  <th width="16%"><strong>Nama Ibu </strong></th>
  <th width="12%"><strong>Keterangan</strong></th>
 </tr>
 <tr nobr="true" style="background-color:#e1d3c2;">
  <th></th>
  <th><strong>21</strong></th>
  <th><strong>22</strong></th>
  <th><strong>23</strong></th>
  <th><strong>24</strong></th>
  <th><strong>25</strong></th>
  <th><strong>26</strong></th>
  <th><strong>27</strong></th>
  <th><strong>28</strong></th>
  <th><strong>29</strong></th>
 </tr>
 </thead>
EOD;
$i=1;
$tbl1 .= <<<EOD
<tbody>
EOD;
foreach ($isikkk as $kkk) {
  $tg_krisma=date('d/m/Y',strtotime($kkk['qi_krisma_tgl']));
  $isi_keterangan = $kkk['qi_ket_delete']=='0'?'':$kkk['qi_ket_delete'];
  $jkawin = $kkk['qi_kawin_jenis']!=''?$kkk['qi_kawin_jenis']:'-';
  $krisma_tempat = $kkk['qi_krisma_tempat']!=''?$kkk['qi_krisma_tempat']:'-';
  $vkrisma_tempat = $kkk['qi_krisma_tempat']!=''?'style="text-align:left;"':'style="text-align:center;"';
  $krisma_nomor = $kkk['qi_krisma_nomor']!=''?$kkk['qi_krisma_nomor']:'-';
  $vkrisma_nomor = $kkk['qi_krisma_nomor']!=''?'style="text-align:left;"':'style="text-align:center;"';
$tbl3 .= <<<EOD
 <tr nobr="true">
  <td width="2%">$i</td>
  <td width="12%">$jkawin</td>
  <td width="10%">$kkk[qi_kawin_ket]</td>
  <td width="10%">$kkk[qi_domisili]</td>
  <td width="8%" $vkrisma_tempat>$krisma_tempat</td>
  <td width="7%">$tg_krisma</td>
  <td width="7%" $vkrisma_tempat>$krisma_nomor</td>
  <td width="16%" style="text-align:left;">$kkk[qi_ket_ayah]</td>
  <td width="16%" style="text-align:left;">$kkk[qi_ket_ibu]</td>
  <td width="12%" style="text-align:left;">$isi_keterangan</td>
 </tr>
EOD;
$i++;
}
$tbl3 .= <<<EOD
</tbody>
</table>
EOD;

$pdf->writeHTML($tbl3, true, false, false, false, '');

//$filename = $cekkk->no_kk.'_'.date('YmdHis').'.pdf';
//$filename =
            $path = FCPATH.'propdf/'.strtolower(preg_replace("/[\W\s\/]+/", "_", $cekkk['nama'])).str_replace('.','_',$cekkk['no_kk']).'.pdf';
            //Close and output PDF document
            ob_start();
//            $pdf->Output($filename, 'I');
            $pdf->Output($path, 'F');
            ob_end_clean();
//        }

?>
