<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth,User-Agent, X-File-Size, X-Requested-With, If-Modified-Since,X-File-Name, Cache-Control");

//defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian extends CI_Controller {


  function __construct() {
    parent::__construct();
    $this->load->model('dbcore1','',TRUE);
    $this->load->model('dbnilai','',TRUE);
    $this->load->helper('url','form','parse');
    $this->dbmain = $this->load->database('default',TRUE);
  }

    function index() {

    }

    function getreg(){
      $frmkel = $this->dbnilai->getregio($this->input->post('searchTerm'));
      echo json_encode($frmkel);
    }

    function getpar(){
      $frmkel = $this->dbnilai->getparoki($this->input->post('searchTerm'),$this->input->post('prm'));
      echo json_encode($frmkel);
    }

    function getparnl(){
      $frmpar = $this->dbnilai->getparnil($this->input->post('searchTerm'),$this->input->post('prm'));
      echo json_encode($frmpar);
    }

    function getnilpar(){
      $detnilpar = $this->dbnilai->getparnildet($this->input->post('param1'),$this->input->post('param2'));
      echo json_encode($detnilpar);
    }

    function ckategori(){
      $pindi = $this->input->post('param');
      $lstindi = $this->dbnilai->gkategori($pindi);
      if($lstindi){
        $hslarr = array();
        foreach ($lstindi as $sar) {
          $detarr = array(
            'text'=>$sar->qnilb_nama,
            'min'=>'0',

            'max'=>200
          );
          $hslarr[] = $detarr;
        }
        echo json_encode($hslarr);
      }
    }

    function ckelompok(){
      $prm = $this->input->post('param1');
      $hslkode = $this->dbnilai->gkode($prm);
      echo json_encode($hslkode);
    }


    function setindikator(){
      $coknil = $this->session->userdata('pilnil');
      $cokdnil = $this->session->userdata('pilnild1');
      $hslarrisi2 = array();
      if($coknil == 'detparoki'){
        $lstisi = $this->dbnilai->getparoki();
      }else {
        $lstisi = $this->dbnilai->getregio();
      }
      $cmax = array();

      if($coknil == 'global'){

        $lstisid1 = $this->dbnilai->gisi();
        if($lstisid1){
          $arrval1 = array();
          foreach ($lstisid1 as $isid1) {
            $arrval1[] = number_format($isid1->dettot,2);
          }
          $cmax = array_merge($arrval1,$cmax);
          $hslarrisi1[]=array(
            'value'=>$arrval1,
            'name'=>'Keuskupan Ketapang'
          );
        }

      } else {
//        $cokdnil = $this->dbcore1->routekey($this->dbcore1->getcok('pilnild1'),'d');

          if($lstisi){
            foreach ($lstisi as $isi1) {

//              if($isi1['varid'] == $cokdnil){
                $lstisid1 = $this->dbnilai->gisi($isi1['varid']);
                if($lstisid1){
                  $arrval1 = array();
                  foreach ($lstisid1 as $isid1) {
                    $arrval1[] = number_format($isid1->dettot,2);
                  }
                  if(substr($isi1['varid'],-2)!='00'){
                    $cmax = array_merge($arrval1,$cmax);
                    $hslarrisi1[]=array(
                      'value'=>$arrval1,
                      'name'=>$isi1['varnama']
                    );
                    $hslarrisi2[]=$isi1['varnama'];
                  }
                }
//              }

            }
          }
        }
      $lstindi = $this->dbnilai->gindikator();
      foreach ($lstindi as $sar) {
        $detarr = array(
          'text'=>(isset($sar->qnilb_nama)?$sar->qnilb_nama:$sar->qnilc_nama),
          'min'=>'0',

          'max'=>max($cmax)
        );
        $hslarr[] = $detarr;
      }
      $hslarrkir = array(
        'indi'=> $hslarr,
        'isi1'=> $hslarrisi1,
        'isi2'=> $hslarrisi2,
        'isi3'=>$cmax
      );
      $this->deludata('pilnil');
      $this->deludata('pilnild1');
      echo json_encode($hslarrkir);
    }

    function cindikator($pindi = false,$pindipar = FALSE){
      $coknil = $this->session->userdata('pilnil');
      $cokdnil = $this->session->userdata('pilnild1');
      if(!$pindi){
        $pindi = $cokdnil;
        $pindipar = $this->input->post('param2');
      }

      $cmax = array();

      $lstisi = $this->dbnilai->getparoki();

        if($lstisi){
          foreach ($lstisi as $isi1) {

            $lstisid1 = $this->dbnilai->gisi2($isi1['varid'],$pindipar);
            if($lstisid1){
              $arrval1 = array();
              foreach ($lstisid1 as $isid1) {
                $arrval1[] = number_format($isid1->dettot,2);

              }
              if(substr($isi1['varid'],-2)!='00'){
                $cmax = array_merge($arrval1,$cmax);
                $hslarrisi1[]=array(
                  'value'=>$arrval1,
                  'name'=>$isi1['varnama']
                );
                $hslarrisi2[]=$isi1['varnama'];
              }
            }

          }
        }
        $lstindi = $this->dbnilai->gindikator2($pindipar);
        foreach ($lstindi as $sar) {
          $detarr = array(
            'text'=>(isset($sar->qnilb_nama)?$sar->qnilb_nama:$sar->qnilc_nama),
            'min'=>'0',

            'max'=>max($cmax)
          );
          $hslarr[] = $detarr;
        }
        $hslarrkir = array(
          'indi'=> $hslarr,
          'isi1'=> $hslarrisi1,
          'isi2'=> $hslarrisi2,
          'isi3'=>$cmax
        );
        echo json_encode($hslarrkir);

      }

      public function deludata($nmudata = FALSE){
        if(!$nmudata){
          $nmudata = $this->input->post('nmu');
        }
        $sess_array = array(
            'set_value' => ''
        );

        $this->session->unset_userdata($nmudata, $sess_array);
      //  session_destroy();
      $konfudata = $this->session->userdata($nmudata);
      if($konfudata != ''){
        echo $konfudata;
      }

      }
      function setdashboard(){
        $hslgraf_fin = array();
        $hslgraf = array();
        $hslgraf1 = array();
        $hslgraf2 = array();
        $hslgraf3 = array();
        $gdbreg = array();
        $gdbval = array();
        $cekmax = array();
        $hmax = array();
        $cperiode = $this->dbnilai->getperiode();
        foreach ($cperiode as $gdp) {
          $gdbper[] = $gdp->qnil_periode;
        }
        $hslgraf['periode'] = $gdbper;

        foreach ($this->dbnilai->getregio() as $gdr) {
          $gdbisir = $this->dbnilai->gisi3(FALSE,$gdr['varid']);
          $hslgraf1 = array();
          for ($i = 0; $i <= count($gdbisir)-1; $i++) {
            $gdbreg[] = array(
              'name'=>str_replace('Regio ','Reg.',$gdbisir[$i]->nmreg),
              'value'=>number_format($gdbisir[$i]->dettot,2)
            );
            $gdbval[]=number_format($gdbisir[$i]->dettot,2);
            if(array_search(str_replace('Regio ','Reg.',$gdbisir[$i]->nmreg),$hslgraf2) === false){
              $hslgraf2[] = str_replace('Regio ','Reg.',$gdbisir[$i]->nmreg);
            }
          }
          $hslgraf3[] = $gdbreg;
          $gdbreg = array();
        }
        $setmin = min($gdbval);
        $setmax = max($gdbval);
        $hslgraf['kelompok'] = $hslgraf2;
        $hslgraf['detail'] = $hslgraf3;
        $hslgraf['min'] = $setmin;
        $hslgraf['max'] = $setmax;
        echo json_encode($hslgraf);
      }

      function setdashboard2(){
        $hslgraf = array();
        $hslgraf1 = array();
        $hslgraf2 = array();
        $hslgraf3 = array();
        $gdbreg = array();
        $cekmax = array();
        $hmax = array();
        $cperiode = $this->dbnilai->getperiode();

        foreach ($this->dbnilai->getparoki() as $gdr) {
          $gdbisir = $this->dbnilai->gisi3(FALSE,$gdr['varid']);
          $hslgraf1 = array();
          for ($i = 0; $i <= count($gdbisir)-1; $i++) {
              $gdbreg['name']=str_replace('Regio ','Reg.',$gdbisir[$i]->nmpar);
              $gdbreg['value']=number_format($gdbisir[$i]->dettot*10,2);
            if($i == count($gdbisir)-1){
              $hslgraf[] = $gdbreg;
              $gdbreg = array();
            }
          }
        }
        echo json_encode($hslgraf);
      }

      public function simnilai(){
        $cokdnil = $this->session->userdata('pilnild1');
        $ckdpar = $this->session->userdata('tmppar');
        $valpost = $this->input->post();
        $valpart = $valpost['datut'];
        $valsimpan = array();
        foreach ($valpart as $vpt) {
          $creg = $this->dbnilai->getparoki($ckdpar,'paroki');
          if($creg){
            $kdnil = '';
            $kdreg = $creg[0]['vartggjwb'];
            for ($i = 0; $i <= mb_strlen($vpt['name'])-1 ; $i++) {
              $kdnil .= substr($vpt['name'],$i+1,1).'.';
            }
            do {
              $a = $this->dbcore1->rdnum(2);
            } while ($a >= 10);
            $valsimpan = array(
              'qnil_kode'=>strtoupper(substr($kdnil,0,7)),
//              'qnil_nilai'=>$vpt['value'],
              'qnil_nilai'=>$a,
              'qnil_periode'=>$valpost['perut'],
              'qnil_kodepar'=>$ckdpar,
              'qnil_kodereg'=>$kdreg
            );
          }
$this->dbnilai->tambah_nil($valsimpan);
        }

//        echo json_encode($valsimpan);
      }

      function tjx(){
        $trr1 = '';
        $trr = array();
        $trr1 = "
        [
        {
        title : {text: '浏览器占比变化',subtext: '纯属虚构'},
        tooltip : {trigger: 'item',formatter: \"{a} <br/>{b} : {c} ({d}%)\"},
        legend: {data:['Chrome','Firefox','Safari','IE9+','IE8-']},
        toolbox: {show : true,feature : {mark : {show: true},dataView : {show: true, readOnly: false},
        magicType : {show: true,type: ['pie', 'funnel'],option: {funnel: {x: '25%',width: '50%',funnelAlign: 'left',max: 1700}}},
        restore : {show: true},saveAsImage : {show: true}}},
        series : [
        {
        name:'浏览器（数据纯属虚构）',
        type:'pie',
        center: ['50%', '45%'],
        radius: '50%',
        data:[
        {value: idx * 128 + 80,  name:'Chrome'},
        {value: idx * 64  + 160,  name:'Firefox'},
        {value: idx * 32  + 320,  name:'Safari'},
        {value: idx * 16  + 640,  name:'IE9+'},
        {value: idx++ * 8  + 1280, name:'IE8-'}
        ]
        }
        ]
        }
        ]";
        $trr = json_decode($trr1);
        echo $trr;
      }

}
