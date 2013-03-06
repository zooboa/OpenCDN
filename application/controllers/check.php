<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:text/html; charset=utf-8');
class Check extends CI_Controller {
	public function index($ip)
	{
		$data = Array();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('user_agent');
		$this->load->helper('security');
		$data['base'] = $this->config->item('base_url');
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		$data['base'] = $this->config->item('base_url');
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh'); 
		}
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
		if(!preg_match('/^[0-9]+(.)+$/',$ip) || strlen($ip) > 16)
		{
			echo '输入参数有误';
			exit();
		}
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 1){
			exit('Access Denied');
		}
		$data['logsResult'] = $this->db->query("SELECT * FROM node_info where NodeIP = '{$ip}'")->result_array();
		$this->load->view('check',$data);
	}
	public function get_url()
	{
		$data = Array();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('user_agent');
		$this->load->helper('security');
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 1){
			exit('Access Denied');
		}
		$data['base'] = $this->config->item('base_url');
		$this->load->helper('file');
		$string = read_file('./code/1.txt');
		$array = explode("\r\n",$string);
		for($i = 0;$i < count($array);$i++)
		{
			file_get_contents($array[$i]);
		}
	}
	public function get_thing()
	{
		$name = $_POST['name'];
		if(!preg_match('/^[0-9]+(.)+$/',$name))
			{
				exit();
			}
		$data = Array();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('user_agent');
		$this->load->helper('security');
		$data['base'] = $this->config->item('base_url');
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 1){
			exit('Access Denied');
		}
		$sql = $this->db->query("SELECT * FROM node_info where NodeIP = '{$name}'")->result_array();
		echo json_encode($sql);
	}
	public function NodeIP()
	{
		$data = Array();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('user_agent');
		$this->load->helper('security');
		$data['base'] = $this->config->item('base_url');
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 1){
			exit('Access Denied');
		}
		$sql = $this->db->query("SELECT NodeIP FROM node_info")->result_array();
		echo json_encode($sql);
	}
}
