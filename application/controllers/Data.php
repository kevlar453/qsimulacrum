<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");

class Data extends CI_Controller
{
    public function __construct()
    {
      parent::__construct();
      $this->load->helper(array(
        'cookie',
        'url',
        'file',
        'download'
      ));
      if($this->session->userdata('qs_lock')=='buka'){
        $this->load->model('modproses', '', true);
      } else {
        redirect(base_url('oper'));
      }
      $this->load->library('mypdf');
      $this->load->library('mergepdf');
      $this->load->library('zip');
    }

    public function index()
    {
      $this->setdepan('0');
    }

    public function setdepan($vmn = false){
      $hit_tot = $this->modproses->cekjum();
      $hit_lak = $this->modproses->cekjum('L');
      $hit_per = $this->modproses->cekjum('P');
      $hit_not = $this->modproses->cekjum('not');
      $hit_stasi = $this->modproses->liststasi();
      $hit_lkg = $this->modproses->listlkg();
      switch ($vmn) {
        case '2':
        $kjudul = 'Detail';
        break;

        case '1':
        $kjudul = 'Statistik';
        break;

        default:
        $kjudul = 'Dashboard';
        break;
      }
      $data = array(
        'mnv'=> array(0=>($vmn=='0')?'active':'',1=>($vmn=='1')?'active':'',2=>($vmn=='2')?'active':''),
        'judul'=> $kjudul,
        'jtot'=> $hit_tot,
        'jlak'=> $hit_lak,
        'jper'=> $hit_per,
        'jnot'=> $hit_not,
        'lstasi'=> $hit_stasi,
        'lslkg'=> $hit_lkg
      );
      $this->load->view('gocetak', $data);
    }

    public function sethal($gohal = false){
      if($this->session->userdata('qs_lock')=='buka'){
        switch ($gohal) {
          case 'detstat':
          $this->setdepan('2');
          break;

          case 'stat':
          $this->setdepan('1');
          break;

          default:
          $this->setdepan('0');
          break;
        }
      } else {
        redirect(base_url('oper'));
      }
    }

    public function chartbesar()
    {
      $sethasil = [];
      $setgroup = $this->modproses->grtotal();
      $setlak = $this->modproses->grnilai('lak');
      $setper = $this->modproses->grnilai('per');
      $setnot = $this->modproses->grnilai('not');
      $gonilai = $setlak+$setper+$setnot;
      foreach ($setgroup as $sg) {
        $gogroup[]=$sg->kelompok;
      }
      foreach ($setlak as $slak) {
        $golak[]=$slak->nillak;
      }
      foreach ($setper as $sper) {
        $goper[]=$sper->nilper;
      }
      foreach ($setnot as $snot) {
        $gonot[]=$snot->nilnot;
      }
      array_push($sethasil, $gonot);
      array_push($sethasil, $goper);
      array_push($sethasil, $golak);
      if ($setgroup) {
        echo json_encode(array('kel'=>$gogroup,'nil'=>$sethasil));
      }
    }

    public function ggrb()
    {
      if($this->session->userdata('qs_lock')=='buka'){
        $dataarea = $this->modproses->clarea();
        header('Content-Type: application/json');
        echo json_encode($dataarea);
      } else {
        redirect(base_url('oper'));
      }
    }

    public function gstat()
    {
      if($this->session->userdata('qs_lock')=='buka'){
        $dataarea = $this->modproses->clstat();
        echo json_encode($dataarea);
      } else {
        redirect(base_url('oper'));
      }
    }



    public function setpdf()
    {
      if($this->session->userdata('qs_lock')=='buka'){
        $cdKateg = $this->input->post('kodeper');
        $cdStasi = $this->input->post('kodestasi');
        if ($cdStasi != '') {
          $files = glob(FCPATH.'propdf/*');
          foreach ($files as $file) {
            if (is_file($file)) {
              unlink($file);
            }
          }
          $cariKepKel = $this->modproses->sarkeluarga($cdKateg, $cdStasi);
          $arpdf = array();
          foreach ($cariKepKel as $setstasi) {
            $getAngI = [];
            $getAngJ = [];
            $getAngK = [];
            $getAngKel = $this->modproses->privkeluarga($setstasi['id_mst_umat']);
            //     if($getAngKel){
            foreach ($getAngKel as $partKel) {
              $getDetKel_i = $this->modproses->detkeluarga('ikk', $partKel->id_umat);
              if ($getDetKel_i) {
                $getAngI[] = array(
                  "qi_nama"=>$getDetKel_i['nama'],
                  "qi_jkel"=>$getDetKel_i['jenis_kelamin'],
                  "qi_tplhr"=>$getDetKel_i['tempat_lahir'],
                  "qi_tglhr"=>$getDetKel_i['tanggal_lahir'],
                  "qi_didik"=>$getDetKel_i['pendidikan_terakhir'],
                  "qi_kerja"=>$getDetKel_i['pekerjaan'],
                  "qi_agama"=>$getDetKel_i['agama'],
                  "qi_baptis_tgl"=>$getDetKel_i['tanggal_baptis'],
                  "qi_baptis_stasi"=>$getDetKel_i['nama_stasi_baptis'],
                  "qi_baptis_oleh"=>$getDetKel_i['nama_pastor_baptis'],
                );
              }

              $getDetKel_j = $this->modproses->detkeluarga('jkk', $partKel->id_umat, $partKel->jenis_kelamin);
              if ($getDetKel_j) {
                $getAngJ[] = array(
                  "qi_kawin_tgl"=>$getDetKel_j['tgl_perkawinan'],
                  "qi_kawin_pastor1"=>$getDetKel_j['nama_pastor'],
                  "qi_kawin_pastor2"=>$getDetKel_j['pastor_luar_paroki'],
                  "qi_kawin_status"=>$getDetKel_j['status_perkawinan'],
                  "qi_kawin_tempat"=>$getDetKel_j['tempat_perkawinan'],
                  "qi_kawin_saksi1"=>$getDetKel_j['saksi_1'],
                  "qi_kawin_saksi2"=>$getDetKel_j['saksi_2'],
                  "qi_kawin_nomor"=>$getDetKel_j['nomor_perkawinan'],
                  "qi_baptis_wali1"=>$getDetKel_j['wali_baptis_1'],
                  "qi_baptis_wali2"=>$getDetKel_j['wali_baptis_2'],
                  "qi_baptis_nomor"=>$getDetKel_j['nomor_baptis'],
                  );
                }

                $getDetKel_k = $this->modproses->detkeluarga('kkk', $partKel->id_umat, $partKel->jenis_kelamin);
                if ($getDetKel_k) {
                  $getAngK[] = array(
                  "qi_kawin_jenis"=>$getDetKel_k['jenis_perkawinan'],
                  //             "qi_kawin_jenis"=>'',
                  "qi_kawin_ket"=>$getDetKel_k['keterangan'],
                  "qi_domisili"=>$getDetKel_k['status_domisili'],
                  "qi_krisma_tgl"=>$getDetKel_k['tanggal_krisma'],
                  "qi_krisma_tempat"=>$getDetKel_k['tempat_krisma'],
                  "qi_krisma_nomor"=>$getDetKel_k['nomor_krisma'],
                  "qi_ket_ayah"=>$getDetKel_k['nama_ayah'],
                  "qi_ket_ibu"=>$getDetKel_k['nama_ibu'],
                  "qi_ket_delete"=>$getDetKel_k['is_deleted'],
                  );
                }
              }

              $data = array(
              'cekkk' => $setstasi,
              'isiikk' => $getAngI,
              'isijkk' => $getAngJ,
              'isikkk' => $getAngK,
              );
              $this->load->view('cetak_kk', $data);
              //           header('Content-Type: application/json');
              //           echo json_encode($data);

              //     } else {
              //       echo print_r($getAngKel);
              //     }
              if ($setstasi['no_kk']!='') {
                //       $filename = strtolower(preg_replace("/\s+/", "_", $cekkk->nama)).'.pdf';
                $arpdf[]=FCPATH.'propdf/'.strtolower(preg_replace("/[\W\s\/]+/", "_", $setstasi['nama'])).str_replace('.', '_', $setstasi['no_kk']).'.pdf';
              }
            }

            $filename = $cdStasi.".zip";
            $path = 'propdf';
            $this->zip->read_dir($path);
            $this->zip->archive(FCPATH.'prozip/'.$filename);
            echo json_encode($arpdf);
          } else {
            echo 'GAGAL';
          }
        } else {
          redirect(base_url('oper'));
        }
      }

    public function ambilzip()
    {
      $gazip = $this->input->post('kdstasi');
      $filename = pathinfo('prozip/'.$gazip.'.zip', PATHINFO_BASENAME);

      if (file_exists($this->input->server('DOCUMENT_ROOT').'/prozip/'.$gazip.'.zip')) {
        $data = file_get_contents($filename);
        force_download($gazip.'.zip', $filename);
      } else {
        echo "GAGAL";
      }
      //$this->zip->read_file($filename);
      //force_download($filename,NULL);
      //$this->zip->download($filename);
    }

    public function gabungpdf()
    {
      $argopdf = $this->input->post('setarpdf');
      MergePdf::merge($argopdf, MergePdf::DESTINATION__DISK_INLINE);
    }

    public function check_valid(){
      $detstasi = $this->input->post('goparam');
      if($detstasi != ''){
        switch ($detstasi) {
          case '7':
          $cek001 = $this->modproses->cekvalid($detstasi,'id_stasi');
          $cek002 = $this->modproses->cekvalid($detstasi,'tanggal_komuni_pertama');
          $laporcek = '<strong>Data Kurang</strong><br>';
          $laporcek .= $cek001!=''?'Kode Stasi= '.$cek001.' data<br>':'';
          $laporcek .= $cek002!=''?'Tanggal Komuni= '.$cek002.' data':'';
          break;

          case '6':
          $cek001 = $this->modproses->cekvalid($detstasi,'id_stasi');
          $cek002 = $this->modproses->cekvalid($detstasi,'tanggal_krisma');
          $laporcek = '<strong>Data Kurang</strong><br>';
          $laporcek .= $cek001!=''?'Kode Stasi= '.$cek001.' data<br>':'';
          $laporcek .= $cek002!=''?'Tanggal Krisma= '.$cek002.' data':'';
          break;

          case '5':
          $cek001 = $this->modproses->cekvalid($detstasi,'id_stasi');
          $cek002 = $this->modproses->cekvalid($detstasi,'nomor_baptis');
          $cek003 = $this->modproses->cekvalid($detstasi,'tanggal_baptis');
          $laporcek = '<strong>Data Kurang</strong><br>';
          $laporcek .= $cek001!=''?'Kode Stasi= '.$cek001.' data<br>':'';
          $laporcek .= $cek002!=''?'Nomor Baptis= '.$cek002.' data<br>':'';
          $laporcek .= $cek003!=''?'Tanggal Baptis= '.$cek003.' data':'';
          break;

          case '4':
          $cek001 = $this->modproses->cekvalid($detstasi,'tgl_perkawinan');
          $cek002 = $this->modproses->cekvalid($detstasi,'nomor_perkawinan');
          $laporcek = '<strong>Data Kurang</strong><br>';
          $laporcek .= $cek001!=''?'Tanggal perkawinan= '.$cek001.' data'.'<br>':'';
          $laporcek .= $cek002!=''?'Nomor perkawinan= '.$cek002.' data':'';
          break;

          case '3':
          $cek001 = $this->modproses->cekvalid($detstasi,'id_lingkungan');
          $cek002 = $this->modproses->cekvalid($detstasi,'id_mst_umat');
          $laporcek = '<strong>Data Kurang</strong><br>';
          $laporcek .= $cek001!=''?'Kode Lingkungan= '.$cek001.' data'.'<br>':'';
          $laporcek .= $cek002!=''?'Nomor KK= '.$cek002.' data':'';
          break;

          case '2':
          $cek001 = $this->modproses->cekvalid($detstasi,'id_stasi');
          $cek002 = $this->modproses->cekvalid($detstasi,'id_mst_umat');
          $laporcek = '<strong>Data Kurang</strong><br>';
          $laporcek .= $cek001!=''?'Kode Stasi= '.$cek001.' data'.'<br>':'';
          $laporcek .= $cek002!=''?'Nomor KK= '.$cek002.' data':'';
          break;

          case '1':
          $cek001 = $this->modproses->cekvalid($detstasi,'id_stasi');
          $cek002 = $this->modproses->cekvalid($detstasi,'jenis_kelamin');
          $cek003 = $this->modproses->cekvalid($detstasi,'id_status_umat');
          $laporcek = '<strong>Data Kurang</strong><br>';
          $laporcek .= $cek001!=''?'Kode Stasi= '.$cek001.' data'.'<br>':'';
          $laporcek .= $cek002!=''?'Jenis Kelamin= '.$cek002.' data'.'<br>':'';
          $laporcek .= $cek003!=''?'Status Umat= '.$cek003.' data':'';
          break;

          default:
          $cek001 = $this->modproses->cekvalid($detstasi,'id_stasi');
          $cek002 = $this->modproses->cekvalid($detstasi,'jenis_kelamin');
          $cek003 = $this->modproses->cekvalid($detstasi,'tanggal_lahir');
          $laporcek = '<strong>Data Kurang</strong><br>';
          $laporcek .= $cek001!=''?'Kode Stasi= '.$cek001.' data'.'<br>':'';
          $laporcek .= $cek002!=''?'Jenis Kelamin= '.$cek002.' data'.'<br>':'';
          $laporcek .= $cek003!=''?'Tanggal Lahir= '.$cek003.' data':'';
          break;
        }
        echo $laporcek=='<strong>Data Kurang</strong><br>'?'':$laporcek;
      } else {
        echo 'Error!!!';
      }
    }

    public function ambilstasi(){
      $detstasi = $this->input->post('setkat');
      $detct1 = $this->input->post('setct1');
      $detct2 = $this->input->post('setct2');
      if($detstasi != ''){
        switch (substr($detstasi,-1)) {
          case '8':
          $hit_stasi = $this->modproses->listmatith($ct1,$ct2);
          foreach ($hit_stasi as $hsts) {
            $lst_stasi[] = trim(strtoupper($hsts['namakat']));
          }
          break;
          case '4':
          $hit_stasi = $this->modproses->listkawinth($ct1,$ct2);
          foreach ($hit_stasi as $hsts) {
            $lst_stasi[] = trim(strtoupper($hsts['namakat']));
          }
          break;
          case '7':
          case '6':
          case '5':
          case '3':
          case '2':
          $hit_stasi = $this->modproses->liststasi($ct1,$ct2);
          foreach ($hit_stasi as $hsts) {
            $lst_stasi[] = trim(strtoupper($hsts['namakat']));
          }
          break;

          default:
          $hit_stasi = $this->modproses->liststasi($ct1,$ct2);
          foreach ($hit_stasi as $hsts) {
            $lst_stasi[] = trim(strtoupper($hsts['namakat'])).'[L]';
            $lst_stasi[] = trim(strtoupper($hsts['namakat'])).'[P]';
          }
          break;
        }
        echo json_encode($lst_stasi);
      } else {
        echo 'Error!!!';
      }
    }


    public function umurstasi(){
      $jenstasi = $this->input->post('setkat');
      $ct1 = $this->input->post('setct1');
      $ct2 = $this->input->post('setct2');
      $sdet_stasi = [];
      switch (substr($jenstasi,-1)) {
        case '8':
        $hit_stasi = $this->modproses->listmatith($ct1,$ct2);
        if($hit_stasi){
          foreach ($hit_stasi as $hsts) {
            $sdet_stasi[] = $this->setdetlst($jenstasi,$hsts['id_umat'],FALSE,$ct1,$ct2);
          }
        }
        break;
        case '4':
        $hit_stasi = $this->modproses->listkawinth($ct1,$ct2);
        if($hit_stasi){
          foreach ($hit_stasi as $hsts) {
            $sdet_stasi[] = $this->setdetlst($jenstasi,$hsts['tgl_perkawinan'],FALSE,$ct1,$ct2);
          }
        }
        break;
        case '3':
        $hit_stasi = $this->modproses->listlkg($ct1,$ct2);
        if($hit_stasi){
          foreach ($hit_stasi as $hsts) {
            $sdet_stasi[] = $this->setdetlst($jenstasi,$hsts['id_lingkungan'],FALSE,$ct1,$ct2);
          }
        }
        break;
        case '8':
        case '7':
        case '6':
        case '5':
        case '2':
        $hit_stasi = $this->modproses->liststasi($ct1,$ct2);
        if($hit_stasi){
          foreach ($hit_stasi as $hsts) {
            $sdet_stasi[] = $this->setdetlst($jenstasi,$hsts['id_stasi'],FALSE,$ct1,$ct2);
          }
        }
        break;

        default:
        $hit_stasi = $this->modproses->liststasi($ct1,$ct2);
        if($hit_stasi){
          foreach ($hit_stasi as $hsts) {
            $sdet_stasi[] = $this->setdetlst($jenstasi,$hsts['id_stasi'],'L',$ct1,$ct2);
            $sdet_stasi[] = $this->setdetlst($jenstasi,$hsts['id_stasi'],'P',$ct1,$ct2);
          }
        }
        break;
      }
      echo json_encode($sdet_stasi);
    }

    public function setdetlst($jensts = FALSE,$parlst = FALSE,$keljen = FALSE,$ctu1 = FALSE,$ctu2 = FALSE){
      $getlst = $this->modproses->detlstdata($jensts,$parlst,$ctu1,$ctu2);
      $htstasi = '';
      $htjenkel = '';
      $htstatus = '';
      $htnstatus = '';
      $htumur0 = 0;
      $htumur1 = 0;
      $htumur2 = 0;
      $htumur3 = 0;
      $htumur4 = 0;
      $htumur5 = 0;
      $htumur6 = 0;
      $htumur7 = 0;
      $htumur8 = 0;
      $htumur9 = 0;
      if($getlst){
        switch (substr($jensts,-1)) {
          case '8':
          case '7':
          case '6':
          case '5':
          case '4':
          case '3':
          case '2':
          foreach ($getlst as $grstasi) {
            $htstasi = strtoupper($grstasi['namakat']);
            $htumur0 = (int)$grstasi['jkaka'];
          }
          $krmlst = array(
            'stsnm' => $htstasi,
            'stsjum' => $htumur0
          );
          break;

          case '1':
          foreach ($getlst as $grstasi) {
            if(strtoupper($grstasi['jenis_kelamin']) == $keljen){
              $htstasi = strtoupper($grstasi['jenis_kelamin'])=='L'?strtoupper($grstasi['namakat']):'';
              $htjenkel = strtoupper($grstasi['jenis_kelamin']);
              $astatus = intval($grstasi['status']);
              if($astatus == 1){
                $htumur1 = $htumur1 + 1;
              } elseif($astatus == 2){
                $htumur2 = $htumur2 + 1;
              } elseif($astatus == 3){
                $htumur3 = $htumur3 + 1;
              } elseif($astatus == 4){
                $htumur4 = $htumur4 + 1;
              } elseif($astatus == 5){
                $htumur5 = $htumur5 + 1;
              } else {
                $htumur0 = $htumur0 + 1;
              }
            }
          }
          $krmlst = array(
          'stsnm' => $htstasi,
          'stsjk' => $htjenkel,
          'stsmr0' => $htumur0,
          'stsmr1' => $htumur1,
          'stsmr2' => $htumur2,
          'stsmr3' => $htumur3,
          'stsmr4' => $htumur4,
          'stsmr5' => $htumur5,
          'stsjum' => $htumur0+$htumur1+$htumur2+$htumur3+$htumur4+$htumur5
          );
          break;

          default:
          foreach ($getlst as $grstasi) {
            if(strtoupper($grstasi['jenis_kelamin']) == $keljen){
              $htstasi = strtoupper($grstasi['jenis_kelamin'])=='L'?strtoupper($grstasi['namakat']):'';
              $htjenkel = strtoupper($grstasi['jenis_kelamin']);
              $aumur = (int)$grstasi['umur'];
              if($aumur >= 0 && $aumur <= 5){
                $htumur1 = $htumur1 + 1;
              } elseif($aumur >= 6 && $aumur <= 11){
                $htumur2 = $htumur2 + 1;
              } elseif($aumur >= 12 && $aumur <= 16){
                $htumur3 = $htumur3 + 1;
              } elseif($aumur >= 17 && $aumur <= 25){
                $htumur4 = $htumur4 + 1;
              } elseif($aumur >= 26 && $aumur <= 35){
                $htumur5 = $htumur5 + 1;
              } elseif($aumur >= 36 && $aumur <= 45){
                $htumur6 = $htumur6 + 1;
              } elseif($aumur >= 46 && $aumur <= 55){
                $htumur7 = $htumur7 + 1;
              } elseif($aumur >= 56 && $aumur <= 65){
                $htumur8 = $htumur8 + 1;
              } elseif($aumur >= 66){
                $htumur9 = $htumur9 + 1;
              } else {
                $htumur0 = $htumur0 + 1;
              }
            }
          }
          $krmlst = array(
          'stsnm' => $htstasi,
          'stsjk' => $htjenkel,
          'stsmr0' => $htumur0,
          'stsmr1' => $htumur1,
          'stsmr2' => $htumur2,
          'stsmr3' => $htumur3,
          'stsmr4' => $htumur4,
          'stsmr5' => $htumur5,
          'stsmr6' => $htumur6,
          'stsmr7' => $htumur7,
          'stsmr8' => $htumur8,
          'stsmr9' => $htumur9,
          'stsjum' => $htumur0+$htumur1+$htumur2+$htumur3+$htumur4+$htumur5+$htumur6+$htumur7+$htumur8+$htumur9
          );
          break;
        }
      }
      return $krmlst;
    }

    public function setlst(){
      $varlst = $this->input->post('setdata');
      $getlst = $this->modproses->modlstdata($varlst);
      echo json_encode($getlst);
    }

    public function cekdatazip()
    {
      $files = glob('./prozip/*zip');
      $sekarang=[];
      foreach ($files as $file) {
        $cbaru =  basename(str_replace('.zip', '', $file));
        $sekarang[]=$cbaru;
      }
      header('Content-Type: application/json');
      echo json_encode($sekarang);
    }

    public function check_database()
    {
      ini_set('display_errors', 'Off');

      //  Load the database config file.
      if (file_exists($file_path = APPPATH.'config/database.php')) {
        include($file_path);
      }

      $config = $db[$active_group];

      //  Check database connection if using mysqli driver
      if ($config['dbdriver'] === 'mysqli') {
        $mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);
        $mysqli->close();
        if (!$mysqli->connect_error) {
          echo 'AMAN';
        }

      }

      return false;
    }

    public function kuncimon(){
      $this->load->view('mypdf');
    }

    public function simcok($coknm = false, $cokisi = false)
    {
      if (!$coknm) {
        $coknm = $this->input->post('nmcok');
        $cokisi = $this->input->post('nlcok');
      }
      $name   = $coknm;
      $value  = $cokisi;
      $expire = time()+1000;
      $path  = '/';
      $secure = FALSE;
      $http = FALSE;
      $cekcok = $this->getcok($coknm);
      if ($cekcok != '') {
        set_cookie($name, $value, $expire,'', $path,$secure,$http);
      } else {
        $this->delcok($coknm);
        set_cookie($name, $value, $expire,'', $path,$secure,$http);
      }
    }

    public function getcok($coknm = false)
    {
      if (!$coknm) {
        $coknm = $this->input->post('nmcok');
      }
      get_cookie($coknm);
    }

    public function delcok($coknm = false)
    {
      if (!$coknm) {
        $coknm = $this->input->post('nmcok');
      }
      delete_cookie($coknm);
    }

    public function gonampat(){
      $imgurl = $this->input->post('gbr');
      echo base64_encode(file_get_contents($imgurl));
    }
  }
