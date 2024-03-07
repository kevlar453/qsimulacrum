<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Modproses extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('cookie', 'url'));
    }

    public function modlstdata($varlst = false,$vparam = FALSE){
      $this->dbmain = $this->load->database('default', true);
      $this->dbmain->select('id_paroki');
      $this->dbmain->from('tbl_info_client');
      $gparoki = $this->dbmain->get();
      $setpar = $gparoki->row_array();
      switch ($varlst) {
        case 'baptis':
        $this->dbmain->select('mst_umat.id_umat,mst_umat.nama,mst_umat.tempat_lahir,mst_umat.tanggal_lahir,tbl_stasi.nama_stasi,tbl_lingkungan.nama_lingkungan,mst_umat.is_deleted,mst_umat.nama_ayah,mst_umat.nama_ibu');
        $this->dbmain->from('mst_umat');
        $this->dbmain->join('tbl_stasi','tbl_stasi.id_stasi=mst_umat.id_stasi_baptis','left');
        $this->dbmain->join('tbl_lingkungan','tbl_lingkungan.id_lingkungan=mst_umat.id_lingkungan','left');
        $this->dbmain->where('mst_umat.id_paroki_baptis',$setpar['id_paroki']);
        $this->dbmain->order_by('mst_umat.nama','asc');
          break;

        case 'meninggal':
        $this->dbmain->select('tbl_kematian.id_umat,mst_umat.nama,mst_umat.tempat_lahir,mst_umat.tanggal_lahir,tbl_stasi.nama_stasi,tbl_lingkungan.nama_lingkungan,mst_umat.is_deleted,mst_umat.nama_ayah,mst_umat.nama_ibu');
        $this->dbmain->from('tbl_kematian');
        $this->dbmain->join('mst_umat','mst_umat.id_umat=tbl_kematian.id_umat','left');
        $this->dbmain->join('tbl_stasi','tbl_stasi.id_stasi=mst_umat.id_stasi','left');
        $this->dbmain->join('tbl_lingkungan','tbl_lingkungan.id_lingkungan=mst_umat.id_lingkungan','left');
        $this->dbmain->where('tbl_kematian.id_umat<>',null);
        $this->dbmain->where('mst_umat.id_stasi<>', null);
        $this->dbmain->where('mst_umat.id_stasi<>', '');
        $this->dbmain->order_by('mst_umat.nama','asc');
          break;

        case 'kategori0':
        $this->dbmain->select('tbl_stasi.nama_stasi,mst_umat.jenis_kelamin,YEAR(CURDATE()) - YEAR(mst_umat.tanggal_lahir) as umur');
        $this->dbmain->from('mst_umat');
        $this->dbmain->join('tbl_stasi','tbl_stasi.id_stasi=mst_umat.id_stasi_baptis','left');
        $this->dbmain->where('tbl_stasi.id_stasi',$vparam);
//        $this->dbmain->join('tbl_lingkungan','tbl_lingkungan.id_lingkungan=mst_umat.id_lingkungan','left');
        $this->dbmain->where('mst_umat.id_paroki_baptis',$setpar['id_paroki']);
        $this->dbmain->order_by('tbl_stasi.id_stasi','asc');
          break;

        default:
        $this->dbmain->select('mst_umat.id_umat,mst_umat.nama,mst_umat.tempat_lahir,mst_umat.tanggal_lahir,tbl_stasi.nama_stasi,tbl_lingkungan.nama_lingkungan,mst_umat.is_deleted,mst_umat.nama_ayah,mst_umat.nama_ibu');
        $this->dbmain->from('mst_umat');
        $this->dbmain->join('tbl_stasi','tbl_stasi.id_stasi=mst_umat.id_stasi','left');
        $this->dbmain->join('tbl_lingkungan','tbl_lingkungan.id_lingkungan=mst_umat.id_lingkungan','left');
        $this->dbmain->where('mst_umat.id_paroki',$setpar['id_paroki']);
        $this->dbmain->where('mst_umat.id_stasi<>', null);
        $this->dbmain->where('mst_umat.id_stasi<>', '');
        $this->dbmain->order_by('mst_umat.nama','asc');
          break;
      }
      $glst = $this->dbmain->get();
      if($glst->result()){
        return $glst->result_array();
      }
    }

            public function cekvalid($jenval = FALSE,$vparam = FALSE){
              $this->dbmain = $this->load->database('default', true);
              $this->dbmain->select('id_paroki');
              $this->dbmain->from('tbl_info_client');
              $gparoki = $this->dbmain->get();
              $setpar = $gparoki->row_array();
              switch ($jenval) {
                case '8':
                $this->dbmain->select('tbl_kematian.id_umat as namakat,count(mst_umat.id_umat) as jkaka');
                $this->dbmain->from('mst_umat');
                $this->dbmain->join('tbl_kematian','tbl_kematian.id_umat=mst_umat.id_umat','left');
                $this->dbmain->where('mst_umat.id_umat<>',null);
                $this->dbmain->where('mst_umat.id_umat<>','');
                $this->dbmain->where('mst_umat.is_deleted', 0);
                $this->dbmain->where('mst_umat.id_paroki',$setpar['id_paroki']);
                $this->dbmain->order_by('tbl_kematian.id_kematian','asc');
                  break;
                case '4':
                $this->dbmain->select('*');
                $this->dbmain->from('tr_perkawinan');
                $this->dbmain->where($vparam,null);
                $this->dbmain->or_where($vparam,'');
                  break;

                case '0':
                $this->dbmain->select('*');
                $this->dbmain->from('mst_umat');
                $this->dbmain->where($vparam,null);
                $this->dbmain->or_where($vparam,'');
                  break;

                default:
                $this->dbmain->select('*');
                $this->dbmain->from('mst_umat');
                $this->dbmain->where('mst_umat.id_paroki',$setpar['id_paroki']);
                $this->dbmain->where($vparam,null);
                $this->dbmain->or_where($vparam,'');
                  break;
              }
              $glst = $this->dbmain->get();
              if($glst->result()){
                return $glst->num_rows();
              }
            }

        public function detlstdata($varlst = false,$vparam = FALSE,$ct1 = FALSE,$ct2 = FALSE){
          $this->dbmain = $this->load->database('default', true);
          $this->dbmain->select('id_paroki');
          $this->dbmain->from('tbl_info_client');
          $gparoki = $this->dbmain->get();
          $setpar = $gparoki->row_array();
          switch (substr($varlst,-1)) {
            case '8':
            $this->dbmain->select('tbl_kematian.id_umat as namakat,count(mst_umat.id_umat) as jkaka');
            $this->dbmain->from('mst_umat');
            $this->dbmain->join('tbl_kematian','tbl_kematian.id_umat=mst_umat.id_umat','left');
            $this->dbmain->where('mst_umat.id_umat<>',null);
            $this->dbmain->where('mst_umat.id_umat<>','');
            $this->dbmain->where('mst_umat.is_deleted', 0);
            $this->dbmain->where('mst_umat.id_paroki',$setpar['id_paroki']);
            $this->dbmain->where('YEAR(tbl_kematian.tanggal_meninggal) BETWEEN \''. $ct1.'\' and \''. $ct2 .'\'', NULL, FALSE);
            $this->dbmain->order_by('tbl_kematian.id_kematian','asc');
              break;
            case '7':
            $this->dbmain->select('tbl_stasi.nama_stasi as namakat,count(mst_umat.tanggal_komuni_pertama) as jkaka');
            $this->dbmain->from('mst_umat');
            $this->dbmain->join('tbl_stasi','tbl_stasi.id_stasi=mst_umat.id_stasi_baptis','left');
            $this->dbmain->where('tbl_stasi.id_stasi',$vparam);
            $this->dbmain->where('mst_umat.tanggal_komuni_pertama<>',null);
            $this->dbmain->where('mst_umat.tanggal_komuni_pertama<>','');
            $this->dbmain->where('mst_umat.id_paroki',$setpar['id_paroki']);
            $this->dbmain->where('mst_umat.is_deleted', 0);
            $this->dbmain->where('YEAR(tanggal_komuni_pertama) BETWEEN \''. $ct1.'\' and \''. $ct2 .'\'', NULL, FALSE);
            $this->dbmain->order_by('tbl_stasi.id_stasi','asc');
              break;
            case '6':
            $this->dbmain->select('tbl_stasi.nama_stasi as namakat,count(mst_umat.tanggal_krisma) as jkaka');
            $this->dbmain->from('mst_umat');
            $this->dbmain->join('tbl_stasi','tbl_stasi.id_stasi=mst_umat.id_stasi_baptis','left');
            $this->dbmain->where('tbl_stasi.id_stasi',$vparam);
            $this->dbmain->where('mst_umat.tanggal_krisma<>',null);
            $this->dbmain->where('mst_umat.tanggal_krisma<>','');
            $this->dbmain->where('mst_umat.id_paroki',$setpar['id_paroki']);
            $this->dbmain->where('mst_umat.is_deleted', 0);
            $this->dbmain->where('YEAR(tanggal_krisma) BETWEEN \''. $ct1.'\' and \''. $ct2 .'\'', NULL, FALSE);
            $this->dbmain->order_by('tbl_stasi.id_stasi','asc');
              break;
            case '5':
            $this->dbmain->select('tbl_stasi.nama_stasi as namakat,count(mst_umat.nomor_baptis) as jkaka');
            $this->dbmain->from('mst_umat');
            $this->dbmain->join('tbl_stasi','tbl_stasi.id_stasi=mst_umat.id_stasi_baptis','left');
            $this->dbmain->where('tbl_stasi.id_stasi',$vparam);
            $this->dbmain->where('mst_umat.nomor_baptis<>',null);
            $this->dbmain->where('mst_umat.nomor_baptis<>','');
            $this->dbmain->where('mst_umat.id_paroki',$setpar['id_paroki']);
            $this->dbmain->where('mst_umat.is_deleted', 0);
            $this->dbmain->where('YEAR(tanggal_baptis) BETWEEN \''. $ct1.'\' and \''. $ct2 .'\'', NULL, FALSE);
            $this->dbmain->order_by('tbl_stasi.id_stasi','asc');
              break;
            case '4':
            $this->dbmain->select('YEAR(tr_perkawinan.tgl_perkawinan) as namakat,count(tr_perkawinan.nomor_perkawinan) as jkaka');
            $this->dbmain->from('tr_perkawinan');
            $this->dbmain->where('tr_perkawinan.tgl_perkawinan<>',null);
            $this->dbmain->where('tr_perkawinan.tgl_perkawinan<>','');
            $this->dbmain->where('tr_perkawinan.nomor_perkawinan<>',null);
            $this->dbmain->where('tr_perkawinan.nomor_perkawinan<>','');
            $this->dbmain->where('YEAR(tr_perkawinan.tgl_perkawinan)',$vparam);
            $this->dbmain->where('tr_perkawinan.id_paroki',$setpar['id_paroki']);
            $this->dbmain->where('YEAR(tgl_perkawinan) BETWEEN \''. $ct1.'\' and \''. $ct2 .'\'', NULL, FALSE);
            $this->dbmain->group_by('YEAR(tr_perkawinan.tgl_perkawinan)');
            $this->dbmain->order_by('tr_perkawinan.tgl_perkawinan','asc');
              break;
            case '3':
            $this->dbmain->select('tbl_lingkungan.nama_lingkungan as namakat,count(mst_umat.no_kk) as jkaka');
            $this->dbmain->from('mst_umat');
            $this->dbmain->join('tbl_lingkungan','tbl_lingkungan.id_lingkungan=mst_umat.id_lingkungan','left');
            $this->dbmain->where('tbl_lingkungan.id_lingkungan',$vparam);
            $this->dbmain->where('mst_umat.no_kk<>','');
            $this->dbmain->where('mst_umat.is_deleted', 0);
            $this->dbmain->where('mst_umat.id_paroki',$setpar['id_paroki']);
            $this->dbmain->where('YEAR(mst_umat.tanggal_input) BETWEEN \''. $ct1.'\' and \''. $ct2 .'\'', NULL, FALSE);
            $this->dbmain->order_by('tbl_lingkungan.id_lingkungan','asc');
              break;
            case '2':
            $this->dbmain->select('tbl_stasi.nama_stasi as namakat,count(mst_umat.no_kk) as jkaka');
            $this->dbmain->from('mst_umat');
            $this->dbmain->join('tbl_stasi','tbl_stasi.id_stasi=mst_umat.id_stasi_baptis','left');
            $this->dbmain->where('tbl_stasi.id_stasi',$vparam);
            $this->dbmain->where('mst_umat.no_kk<>','');
            $this->dbmain->where('mst_umat.id_paroki',$setpar['id_paroki']);
            $this->dbmain->where('YEAR(mst_umat.tanggal_input) BETWEEN \''. $ct1.'\' and \''. $ct2 .'\'', NULL, FALSE);
            $this->dbmain->order_by('tbl_stasi.id_stasi','asc');
              break;
            case '1':
            $this->dbmain->select('tbl_stasi.nama_stasi as namakat,mst_umat.jenis_kelamin,mst_umat.id_status_umat as status,ref_status_umat.status_umat as nstatus');
            $this->dbmain->from('mst_umat');
            $this->dbmain->join('tbl_stasi','tbl_stasi.id_stasi=mst_umat.id_stasi_baptis','left');
            $this->dbmain->join('ref_status_umat','ref_status_umat.id_status_umat=mst_umat.id_status_umat','left');
            $this->dbmain->where('tbl_stasi.id_stasi',$vparam);
            $this->dbmain->where('mst_umat.id_paroki',$setpar['id_paroki']);
            $this->dbmain->where('mst_umat.id_status_umat<>', '');
            $this->dbmain->where('mst_umat.id_status_umat<>', null);
            $this->dbmain->where('mst_umat.jenis_kelamin<>', '');
            $this->dbmain->where('mst_umat.jenis_kelamin<>', null);
            $this->dbmain->where('YEAR(mst_umat.tanggal_input) BETWEEN \''. $ct1.'\' and \''. $ct2 .'\'', NULL, FALSE);
            $this->dbmain->order_by('tbl_stasi.id_stasi','asc');
              break;

            default:
            $this->dbmain->select('tbl_stasi.nama_stasi as namakat,mst_umat.jenis_kelamin,YEAR(CURDATE()) - YEAR(mst_umat.tanggal_lahir) as umur');
            $this->dbmain->from('mst_umat');
            $this->dbmain->join('tbl_stasi','tbl_stasi.id_stasi=mst_umat.id_stasi_baptis','left');
            $this->dbmain->where('tbl_stasi.id_stasi',$vparam);
            $this->dbmain->where('mst_umat.is_deleted', 0);
            $this->dbmain->where('mst_umat.tanggal_lahir<>', '');
            $this->dbmain->where('mst_umat.tanggal_lahir<>', null);
            $this->dbmain->where('mst_umat.jenis_kelamin<>', '');
            $this->dbmain->where('mst_umat.jenis_kelamin<>', null);
            $this->dbmain->where('YEAR(mst_umat.tanggal_input) BETWEEN \''. $ct1.'\' and \''. $ct2 .'\'', NULL, FALSE);
            $this->dbmain->order_by('tbl_stasi.id_stasi','asc');
              break;
          }
          $glst = $this->dbmain->get();
          if($glst->result()){
            return $glst->result_array();
          }
        }

        public function clstat()
        {
            $this->dbmain = $this->load->database('default', true);
            $this->dbmain->select('id_paroki');
            $this->dbmain->from('tbl_info_client');
            $gparoki = $this->dbmain->get();
            $setpar = $gparoki->row_array();

            $this->dbmain->select('id_stasi,nama_stasi');
            $this->dbmain->from('tbl_stasi');
            $this->dbmain->where('id_paroki', $setpar['id_paroki']);
            $this->dbmain->where('id_stasi<>', null);
            $this->dbmain->where('id_stasi<>', '');
            $this->dbmain->order_by('id_stasi', 'asc');
            $gstasi = $this->dbmain->get();
            $setstasi = $gstasi->result_array();
            foreach ($setstasi as $stas) {
                $arstasi[]=$stas['nama_stasi'];
            }
            $gethasil[] = $arstasi;

            $this->dbmain->select('count(id_umat) as jumbaptis');
            $this->dbmain->from('mst_umat');
            $this->dbmain->join('tbl_stasi','tbl_stasi.id_stasi=mst_umat.id_stasi_baptis','left');
            $this->dbmain->join('tbl_lingkungan','tbl_lingkungan.id_lingkungan=mst_umat.id_lingkungan','left');
            $this->dbmain->where('mst_umat.id_paroki_baptis',$setpar['id_paroki']);
            $this->dbmain->group_by('mst_umat.id_stasi_baptis');
            $this->dbmain->order_by('mst_umat.id_stasi_baptis', 'asc');
            $gbaptis = $this->dbmain->get();
            $setbaptis = $gbaptis->result_array();
            foreach ($setbaptis as $bapt) {
                $arbaptis[]=$bapt['jumbaptis'];
            }
            $gethasil[] = $arbaptis;

            $this->dbmain->select('count(id_umat) as jumumat');
            $this->dbmain->from('mst_umat');
            $this->dbmain->join('tbl_stasi','tbl_stasi.id_stasi=mst_umat.id_stasi','left');
            $this->dbmain->join('tbl_lingkungan','tbl_lingkungan.id_lingkungan=mst_umat.id_lingkungan','left');
            $this->dbmain->where('mst_umat.id_paroki',$setpar['id_paroki']);
            $this->dbmain->where('mst_umat.id_stasi<>', null);
            $this->dbmain->where('mst_umat.id_stasi<>', '');
            $this->dbmain->group_by('mst_umat.id_stasi');
            $this->dbmain->order_by('mst_umat.id_stasi', 'asc');
            $gumat = $this->dbmain->get();
            $setumat = $gumat->result_array();
            foreach ($setumat as $umat) {
                $arumat[]=$umat['jumumat'];
            }
            $gethasil[] = $arumat;

            $this->dbmain->select('count(tbl_kematian.id_umat) as jumumat');
            $this->dbmain->from('tbl_kematian');
            $this->dbmain->join('mst_umat', 'mst_umat.id_umat=tbl_kematian.id_umat');
            $this->dbmain->where('mst_umat.id_stasi<>', null);
            $this->dbmain->where('mst_umat.id_stasi<>', '');
            $this->dbmain->group_by('mst_umat.id_stasi');
            $this->dbmain->order_by('mst_umat.id_stasi', 'asc');
            $gmati = $this->dbmain->get();
            $setmati = $gmati->result_array();
            foreach ($setmati as $mati) {
                $armati[]='-'.$mati['jumumat'];
            }
            $gethasil[] = $armati;

            return $gethasil;
        }

    public function cekjum($varcek = false)
    {
        $this->dbmain = $this->load->database('default', true);
        $this->dbmain->select('id_umat,nama');
        $this->dbmain->from('mst_umat');
        $this->dbmain->where('mst_umat.is_deleted', 0);
        if ($varcek) {
            if ($varcek!='not') {
                $this->dbmain->where('jenis_kelamin', $varcek);
            } else {
                $this->dbmain->where('jenis_kelamin', null);
            }
        }
        $cekum = $this->dbmain->get();
        if ($cekum->num_rows()>0) {
            return $cekum->num_rows();
        } else {
            return false;
        }
    }

    public function sarkeluarga($kdjenis = false, $kdstasi = false)
    {
        $this->dbmain = $this->load->database('default', true);

        $getcari = $kdjenis=='sts'?'nama_stasi':'nama_stasi,nama_lingkungan';

        $this->dbmain->select('no_kk,id_umat,id_mst_umat,nama,mst_umat.alamat as alamat,'.$getcari.',nama_paroki,nama_propinsi,nama_kota,nama_kecamatan,nama_desa');
        $this->dbmain->from('mst_umat');
        if ($kdjenis == 'sts') {
            $this->dbmain->join('tbl_stasi', 'tbl_stasi.id_stasi=mst_umat.id_stasi', '');
        } else {
            $this->dbmain->join('tbl_stasi', 'tbl_stasi.id_stasi=mst_umat.id_stasi', '');
            $this->dbmain->join('tbl_lingkungan', 'tbl_lingkungan.id_lingkungan=mst_umat.id_lingkungan', '');
        }
        $this->dbmain->join('tbl_paroki', 'tbl_paroki.id_paroki=mst_umat.id_paroki', '');
        $this->dbmain->join('ref_desa', 'ref_desa.id_desa=mst_umat.id_desa', '');
        $this->dbmain->join('ref_kecamatan', 'ref_kecamatan.id_kecamatan=ref_desa.id_kecamatan', '');
        $this->dbmain->join('ref_kab_kota', 'ref_kab_kota.id_kota=ref_kecamatan.id_kota', '');
        $this->dbmain->join('ref_propinsi', 'ref_propinsi.id_propinsi=ref_kab_kota.id_propinsi', '');
        if ($kdjenis == 'sts') {
            $this->dbmain->where('mst_umat.id_stasi', $kdstasi);
        } else {
            $this->dbmain->where('mst_umat.id_lingkungan', $kdstasi);
        }
        $this->dbmain->where('mst_umat.no_kk<>', '');
        $this->dbmain->where('mst_umat.is_deleted', 0);
        $this->dbmain->group_by('mst_umat.no_kk');
//        $this->dbmain->limit(1);
        $qimp = $this->dbmain->get();
        if ($qimp->result()) {
            return $qimp->result_array();
        }
    }


    public function privkeluarga($kodekk = false)
    {
        $this->dbmain = $this->load->database('default', true);
        $this->dbmain->select('id_umat,jenis_kelamin');
        $this->dbmain->from('mst_umat');
        $this->dbmain->where('id_mst_umat', $kodekk);
        $this->dbmain->where('mst_umat.is_deleted', 0);
        $this->dbmain->order_by('mst_umat.id_hubungan', 'asc');
        $qimp = $this->dbmain->get();
        if ($qimp->result()) {
            return $qimp->result();
        }
    }

    public function detkeluarga($jndet = false, $kodekk = false, $vkode = false)
    {
        $this->dbmain = $this->load->database('default', true);
        $this->dbmain->select('*');
        $this->dbmain->from('mst_umat');
        $this->dbmain->where('id_umat', $kodekk);
        if ($jndet != 'ikk') {
            if ($vkode == 'P') {
                $this->dbmain->join('tr_perkawinan', 'tr_perkawinan.id_istri=mst_umat.id_umat', 'left');
            } else {
                $this->dbmain->join('tr_perkawinan', 'tr_perkawinan.id_suami=mst_umat.id_umat', 'left');
            }
            $this->dbmain->join('mst_pastor', 'mst_pastor.id_pastor=tr_perkawinan.id_pastor', 'left');
            $this->dbmain->join('ref_jenis_perkawinan', 'ref_jenis_perkawinan.id_jenis_perkawinan=tr_perkawinan.id_jenis_perkawinan', 'left');
        }
        $this->dbmain->join('ref_pekerjaan', 'ref_pekerjaan.id_ref_pekerjaan=mst_umat.id_ref_pekerjaan', 'left');
        $this->dbmain->join('ref_agama', 'ref_agama.id_agama=mst_umat.id_agama', 'left');
        $this->dbmain->join('ref_hubungan_keluarga', 'ref_hubungan_keluarga.id_hubungan=mst_umat.id_hubungan', '');
        $this->dbmain->order_by('mst_umat.id_hubungan', 'asc');
        $qimp = $this->dbmain->get();
        if ($qimp->result()) {
            return $qimp->row_array();
        }
    }

    public function liststasi($vpar = false,$ct1 = false,$ct2 = false)
    {
        $this->dbmain = $this->load->database('default', true);
        $setstasi = array();
        $this->dbmain->select('id_paroki');
        $this->dbmain->from('tbl_info_client');
        $gparoki = $this->dbmain->get();
        $setpar = $gparoki->row_array();
        $this->dbmain->select('id_stasi,nama_stasi');
        $this->dbmain->from('tbl_stasi');
        $this->dbmain->where('id_paroki', $setpar['id_paroki']);
        $gstasi = $this->dbmain->get();
        $arstasi = $gstasi->result_array();
        foreach ($arstasi as $ast) {
            $this->dbmain->select('count(id_mst_umat) as jumkk');
            $this->dbmain->from('mst_umat');
            $this->dbmain->where('id_stasi', $ast['id_stasi']);
            $this->dbmain->where('id_stasi<>', '');
            $this->dbmain->where('id_stasi<>', null);
            $this->dbmain->where('id_desa<>', '');
            $this->dbmain->where('id_desa<>', null);
            $this->dbmain->where('no_kk<>', '');
            $this->dbmain->where('mst_umat.is_deleted', 0);
            if($ct1 && $ct2){
              $this->dbmain->where('YEAR(mst_umat.tanggal_input) BETWEEN \''. $ct1.'\' and \''. $ct2 .'\'', NULL, FALSE);
            }
            $this->dbmain->order_by('id_stasi', 'asc');
            $gnokk = $this->dbmain->get();
            $setnokk = $gnokk->row_array();
            $setstasi[] = array(
      'id_stasi'=>$ast['id_stasi'],
      'namakat'=>$ast['nama_stasi'],
      'jumkk'=>$setnokk['jumkk']
    );
        }
        return $setstasi;
    }

    public function listlkg($vstasi = false)
    {
        $this->dbmain = $this->load->database('default', true);
        $setlkg = array();
        $this->dbmain->select('id_paroki');
        $this->dbmain->from('tbl_info_client');
        $gparoki = $this->dbmain->get();
        $setpar = $gparoki->row_array();
        $this->dbmain->select('id_lingkungan,nama_lingkungan');
        $this->dbmain->from('tbl_lingkungan');
        $this->dbmain->where('id_paroki', $setpar['id_paroki']);
        $glkg = $this->dbmain->get();
        $arlkg = $glkg->result_array();
        foreach ($arlkg as $alk) {
            $this->dbmain->select('count(id_mst_umat) as jumkk');
            $this->dbmain->from('mst_umat');
            $this->dbmain->where('id_lingkungan', $alk['id_lingkungan']);
            $this->dbmain->where('id_lingkungan<>', '');
            $this->dbmain->where('id_lingkungan<>', null);
            $this->dbmain->where('id_desa<>', '');
            $this->dbmain->where('id_desa<>', null);
            $this->dbmain->where('no_kk<>', '');
            $this->dbmain->where('mst_umat.is_deleted', 0);
            $this->dbmain->where('YEAR(mst_umat.tanggal_input) BETWEEN \''. $ct1.'\' and \''. $ct2 .'\'', NULL, FALSE);
            $gnokk = $this->dbmain->get();
            $setnokk = $gnokk->row_array();
            $setlkg[] = array(
      'id_lingkungan'=>$alk['id_lingkungan'],
      'nama_lingkungan'=>$alk['nama_lingkungan'],
      'jumkk'=>$setnokk['jumkk']
    );
        }
        return $setlkg;
    }

    public function listmatith($ct1 = false,$ct2 = false)
    {
        $this->dbmain = $this->load->database('default', true);
        $setlkg = array();
        $this->dbmain->select('id_paroki');
        $this->dbmain->from('tbl_info_client');
        $gparoki = $this->dbmain->get();
        $setpar = $gparoki->row_array();
        $this->dbmain->select('YEAR(tanggal_meninggal) as tanggal_meninggal,id_umat');
        $this->dbmain->from('tbl_kematian');
        $this->dbmain->where('tanggal_meninggal<>', '');
        $this->dbmain->where('tanggal_meninggal<>', null);
        $this->dbmain->where('YEAR(tanggal_meninggal) BETWEEN \''. $ct1.'\' and \''. $ct2 .'\'', NULL, FALSE);
//        $this->dbmain->where('id_paroki', $setpar['id_paroki']);
        $this->dbmain->group_by('YEAR(tanggal_meninggal)');
        $this->dbmain->order_by('YEAR(tanggal_meninggal)','asc');
        $glkg = $this->dbmain->get();
        $arlkg = $glkg->result_array();
        foreach ($arlkg as $alk) {
            $setlkg[] = array(
              'tanggal_meninggal'=>$alk['tanggal_meninggal'],
              'namakat'=>$alk['tanggal_meninggal'],
      'id_umat'=>$alk['id_umat']
    );
        }
        return $setlkg;
    }

    public function listkawinth($ct1 = FALSE, $ct2 = FALSE)
    {
        $this->dbmain = $this->load->database('default', true);
        $setlkg = array();
        $this->dbmain->select('id_paroki');
        $this->dbmain->from('tbl_info_client');
        $gparoki = $this->dbmain->get();
        $setpar = $gparoki->row_array();
        $this->dbmain->select('YEAR(tgl_perkawinan) as tgl_perkawinan,nomor_perkawinan');
        $this->dbmain->from('tr_perkawinan');
        $this->dbmain->where('tgl_perkawinan<>', '');
        $this->dbmain->where('tgl_perkawinan<>', null);
        $this->dbmain->where('YEAR(tgl_perkawinan) BETWEEN \''. $ct1.'\' and \''. $ct2 .'\'', NULL, FALSE);
        $this->dbmain->where('id_paroki', $setpar['id_paroki']);
        $this->dbmain->group_by('YEAR(tgl_perkawinan)');
        $this->dbmain->order_by('YEAR(tgl_perkawinan)','asc');
        $glkg = $this->dbmain->get();
        $arlkg = $glkg->result_array();
        foreach ($arlkg as $alk) {
            $setlkg[] = array(
              'tgl_perkawinan'=>$alk['tgl_perkawinan'],
              'namakat'=>$alk['tgl_perkawinan'],
      'no_perkawinan'=>$alk['nomor_perkawinan']
    );
        }
        return $setlkg;
    }

    /* chartss*/

    public function grtotal()
    {
        $this->dbmain = $this->load->database('default', true);
        $this->dbmain->select('concat(MONTH(tanggal_lahir),"/",YEAR(tanggal_lahir)) as kelompok,LEFT(tanggal_lahir,7) as vtgl');
        $this->dbmain->from('mst_umat');
        $this->dbmain->group_by('LEFT(tanggal_lahir,7)');
        $this->dbmain->order_by('tanggal_lahir');
        $gtot = $this->dbmain->get();
        if ($gtot->num_rows()>0) {
            return $gtot->result();
        }
    }

    public function grnilai($vcari = false)
    {
        $this->dbmain = $this->load->database('default', true);
        $this->dbmain->select('count(tanggal_lahir) as nil'.$vcari);
        $this->dbmain->from('mst_umat');
        if ($vcari!='not') {
            $this->dbmain->where('jenis_kelamin', strtoupper(substr($vcari, 0, 1)));
        } else {
            $this->dbmain->where('jenis_kelamin', null);
        }
//      $this->dbmain->where('LEFT(tanggal_input,7)',$vtgl);
        $this->dbmain->group_by('LEFT(tanggal_lahir,7)');
        $this->dbmain->order_by('tanggal_lahir');
        $glak = $this->dbmain->get();
        if ($glak->num_rows()>0) {
            return $glak->result();
        }
    }


    public function clarea1()
    {
        $this->dbmain = $this->load->database('default', true);
        $this->dbmain->select('MAX(tanggal_lahir) as tglmx,MIN(tanggal_lahir) as tglmn');
        $this->dbmain->from('mst_umat');
//            $this->dbmain->where('MONTH(tanggal_input)', date('m'));
        $qtgl = $this->dbmain->get();
        if ($qtgl->result_array()) {
            foreach ($qtgl->result_array() as $dbtgl) {
                $tangmax = $dbtgl['tglmx'];
                $tangmin = $dbtgl['tglmn'];
                $jumhar = (strtotime($tangmax) - strtotime($tangmin))/60/60/24+1;
            }
        }

        $area = array();
        $this->dbmain->select('jenis_kelamin, count(jenis_kelamin) as jumkel');
        $this->dbmain->from('mst_umat');
        $this->dbmain->group_by('YEAR(tanggal_lahir)');
        $this->dbmain->order_by('tanggal_lahir', 'asc');
        $qdbt = $this->dbmain->get();
        if ($qdbt->result_array()) {
            $isidar = $qdbt->result_array();
            foreach ($isidar as $dar) {
                $detket = ($dar['jenis_kelamin']=='L'||$dar['jenis_kelamin']=='P')?$dar['jenis_kelamin']:'K';

                $area[] = array(
                      'area' => $detket,
                      'Total'=>$this->cekjum(),
                    'jumkel' => (int)$dar['jumkel'],
                    'jhari' => $jumhar,
                    'tgmin' => date("d-m-Y", strtotime($tangmin)),
                    'tgmax' => date("d-m-Y", strtotime($tangmax))
                  );
            }
            return $area;
        } else {
            return false;
        }
    }

    public function clarea()
    {
        $this->dbmain = $this->load->database('default', true);
        $this->dbmain->select('id_paroki');
        $this->dbmain->from('tbl_info_client');
        $gparoki = $this->dbmain->get();
        $setpar = $gparoki->row_array();

        $this->dbmain->select('YEAR(tanggal_baptis) as taun');
        $this->dbmain->from('mst_umat');
        $this->dbmain->where('id_paroki', $setpar['id_paroki']);
        $this->dbmain->group_by('YEAR(tanggal_baptis)');
        $gtahun = $this->dbmain->get();
        $settahun = $gtahun->result_array();
        foreach ($settahun as $thn) {
            $arthn[]=$thn['taun'];
        }
        $gethasil[] = array('tahun')+$arthn;
        foreach ($settahun as $sthnlak) {
            $this->dbmain->select('COUNT(id_umat) as jumlak');
            $this->dbmain->from('mst_umat');
            $this->dbmain->where('id_paroki', $setpar['id_paroki']);
            $this->dbmain->where('jenis_kelamin', 'L');
            $this->dbmain->where('YEAR(tanggal_baptis)', $sthnlak['taun']);
            $glak = $this->dbmain->get();
            $setlak[] = $glak->row_array()['jumlak'];
        }
        $gethasil[] = array('laki-laki')+$setlak;
        foreach ($settahun as $sthnper) {
            $this->dbmain->select('COUNT(id_umat) as jumper');
            $this->dbmain->from('mst_umat');
            $this->dbmain->where('id_paroki', $setpar['id_paroki']);
            $this->dbmain->where('jenis_kelamin', 'P');
            $this->dbmain->where('YEAR(tanggal_baptis)', $sthnper['taun']);
            $gper = $this->dbmain->get();
            $setper[] = $gper->row_array()['jumper'];
        }
        $gethasil[] = array('perempuan')+$setper;
        return $gethasil;
    }
}
