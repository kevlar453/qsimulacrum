<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");

class Oper extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(array(
          'cookie',
          'url',
          'file',
          'download'
      ));
//        $this->load->model('modproses', '', true);
    }

    public function index(){
      $this->load->view('mlebet');
    }

    public function authenticate() {
      $sethost = $this->input->post('qhost');
      $setuser = $this->input->post('quser');
      $setpass = $this->input->post('qpass');
        $this->session->set_userdata('qs_host', $sethost);
        $this->session->set_userdata('qs_user', $setuser);
        $this->session->set_userdata('qs_pass', $setpass);
        $this->session->set_userdata('qs_lock', 'buka');
//        redirect(base_url('data'));
echo 'SIAP';
    }

    public function logout() {
      $this->session->unset_userdata('qs_host');
      $this->session->unset_userdata('qs_user');
      $this->session->unset_userdata('qs_pass');
      $this->session->unset_userdata('qs_lock');
        redirect(base_url('oper'));
    }


        public function routekey($string = false, $action = 'e', $tbkey = false)
        {
            $secret_key = '12345abcdeCDE';
            $main_key = hash('sha256', $secret_key);
            $output = false;
            $encrypt_method = "AES-256-CBC";
            $key = $main_key;
            $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
            if ($action=='e') {
                $output=base64_encode(openssl_encrypt($string, $encrypt_method, $tbkey?$tbkey:$key, 0, $iv));
            } elseif ($action=='d') {
                $output=openssl_decrypt(base64_decode($string), $encrypt_method, $tbkey?$tbkey:$key, 0, $iv);
            }
            echo $output;
        }

}
