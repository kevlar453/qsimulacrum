<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$ci = get_instance();
if (!isset($ci->session->userdata['clientdb'])){
		 $ci->session->set_userdata('clientdb','database1');
}

$active_group = 'default';
$query_builder = TRUE;


$db['default'] = array(
	'dsn'	=> '',
	'hostname' => $ci->session->userdata['qs_host'],
	'username' => $ci->session->userdata['qs_user'],
	'password' => $ci->session->userdata['qs_pass'],
	'database' => 'db_umat_ketapang',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
