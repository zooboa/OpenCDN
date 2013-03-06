<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:text/html; charset=utf-8');
class Out extends CI_Controller {
	public function index()
	{
		$this->load->library('session');
		$this->session->sess_destroy();
		$this->load->helper('url');
		redirect($this->config->item('base_url').'index.php/', 'refresh');
	}
}
