<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:text/html; charset=utf-8');
class Node extends CI_Controller {
	public function index()
	{
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('security');
		$data = Array();
		$node = Array();
		$data['base'] = $this->config->item('base_url');
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh'); 
		}
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 1){
			exit('Access Denied');
		}
		$this->load->view('node',$data);
	}
	public function list_ip()
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
		$sql  = $this->db->query("SELECT * FROM node_info")->result_array();
		echo json_encode($sql);

	}
	public function delect(){
		$data = Array();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('user_agent');
		$this->load->helper('security');
		$data['base'] = $this->config->item('base_url');
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		$domain_id = $_POST['del_id'];
		if(!preg_match('/^[0-9]+(.)+$/',$domain_id) || strlen($domain_id) > 16)
		{
			$data['error'] = 0;
			$data['return'] = '输入参数有误';
			echo json_encode($data);
			exit();
		}
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->library('session');
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 1){
			exit('Access Denied');
		}
		$this->db->query("DELETE FROM `node_info` WHERE NodeIP = '{$domain_id}'");
		$data['error'] = 1;
		$data['return'] = '删除成功';
		$this->afile('R', $domain_id);
		echo json_encode($data);
	}
	public function add(){
		$team = array('NodeIP' => trim($this->input->post('NodeIP', TRUE))
					);
		if(!preg_match('/^[0-9]+(.)+$/',$team['NodeIP']) || strlen($team['NodeIP']) > 16)
		{
			$data['status'] = 0;
			echo json_encode($data);
			exit();
		}	
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->library('session');
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 1){
			exit('Access Denied');
		}
		$this->db->select('NodeIP')->from('node_info')->where('NodeIP', $team['NodeIP']);
		$query = $this->db->get();
		if ($query->num_rows()!= 0)
		{
			$data['ststus'] = 2;
			echo  json_encode($data);
			exit();
		}
		$this->db->insert('node_info',$team);
		if($this->db->affected_rows() == 1)
		{
			$data['status'] = 1;
			$data['ssss'] = $team['NodeIP'];
			echo json_encode($data);
			$this->afile('A', $team['NodeIP']);
			
		}else{
			$data['status'] = 2;
			echo json_encode($data);
		}
	}
	public function afile($catey,$nodeip) {
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->library('session');
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 1){
			exit('Access Denied');
		}
		if (!($this->session->userdata('cdn_Name'))) exit('Access Denied');
		if (""==$nodeip) {
			exit;
		}
		$filePath = "/home/wwwroot/opencdn/opencdn.conf";
		if (!file_exists($filePath)) {
			exit;
		}
		$fh = fopen($filePath, "rb");
		$content = fread($fh, filesize($filePath));
		fclose($fh);
		
		$nodecount = 0;
		if (strstr($content, $nodeip)) {
			$nodeip = "Node".$nodecount."=".$nodeip."\n";
			$content = str_replace($nodeip,"",$content);
		} else {
			if ("A"==$catey) {
				$content .= "Node".($nodecount)."=".$nodeip."\n";
			}
		}		
		$file = fopen($filePath, "w+");
		fwrite($file, $content);
		fclose($file);

	}

}
