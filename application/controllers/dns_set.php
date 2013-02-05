<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:text/html; charset=utf-8');
class Dns_set extends CI_Controller {
	public function index()
	{
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('security');
		$data = Array();
		$data['base'] = $this->config->item('base_url');
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh'); 
		}
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7.0')){
			redirect($this->config->item('base_url').'index.php/error', 'refresh');
		}
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 1){
			exit('Access Denied');
		}
		$this->load->view('Dns_set',$data);
	}
	/*Dnspod*/
	public function check(){	
		$this->load->library('session');	
		$data = Array();
		$data['base'] = $this->config->item('base_url');
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 1){
			exit('Access Denied');
		}
		$result = Array();
		$yanzheng = Array();
		$date = Array();
		$yanzheng = array('cdn_Pass_again'=> $this->input->post('password_again', TRUE)
		);
		$data = array('user_mail'=> trim($this->input->post('username', TRUE)),
					'user_keycode' => $this->input->post('password', TRUE)
		);
		if($data['user_keycode'] != $yanzheng['cdn_Pass_again']){
			$result['result'] = 0;
			$result['error'] = '2次密码输入不同!';
			echo  json_encode($result);
			exit();
		}
		if($data['user_keycode'] == '' or $data['user_mail'] == ''){
			$result['result'] = 0;
			$result['error'] = '填写不能为空!';
			echo  json_encode($result);
			exit();
		}
		$tell= $this->db->query("SELECT tell FROM users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($tell != 1){
			$result['result'] = 0;
			$result['error'] = '普通用户不能填写Dnspod账户!';
			echo  json_encode($result);
			exit();			
		}
		$this->db->query("UPDATE users SET dnspod_user='{$data['user_mail']}' , dnspod_pass='{$data['user_keycode']}'where user_mail = '{$this->session->userdata('cdn_Name')}'");		
		if($this->db->affected_rows() <= 1)
		{
			$result['error'] = '恭喜!添加成功~O(∩_∩)O';
			$result['result'] = 1;
			//$this->session->set_userdata('cdn_Name',$data['user_mail']);
			echo  json_encode($result);
		}else{
			$result['result'] = 0;
			$result['error'] = '添加失败~请联系管理员,稍后再尝试吧!';
			echo json_encode($result);
			}
	}
}
