<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:text/html; charset=utf-8');
class Register extends CI_Controller {
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
		$this->load->view('register',$data);
	}
	/*用户注册验证*/
	/*public function check(){
	//	session_start();	
		$this->load->library('session');	
		$data = Array();
		$data['base'] = $this->config->item('base_url');
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->database();
		$result = Array();
		$yanzheng = Array();
		$yanzheng = array('cdn_Pass_again'=> $this->input->post('password_again', TRUE)
		);
		$data = array('user_mail'=> trim($this->input->post('username', TRUE)),
					'tell' => 1,
					'user_keycode' => $this->input->post('password', TRUE)
		);
		$this->db->select('user_mail')->from('users')->where('user_mail',$data['user_mail']);
		$query = $this->db->get();
		if ($query->num_rows() != 0)
		{
			$result['result'] = 0;
			$result['error'] = '用户名已存在,换用户名吧!';
			echo  json_encode($result);
			exit();
		}
		if($data['user_keycode'] != $yanzheng['cdn_Pass_again']){
			$result['result'] = 0;
			$result['error'] = '2次密码输入不同!';
			echo  json_encode($result);
			exit();
		}
		$data['user_keycode'] = sha1(md5($data['user_keycode']));
		$this->db->insert('users',$data);
		if($this->db->affected_rows() == 1)
		{
			$result['error'] = '恭喜!注册成功~O(∩_∩)O';
			$result['result'] = 1;
			$this->session->set_userdata('cdn_Name',$data['user_mail']);
			echo  json_encode($result);
		}else{
			$result['result'] = 0;
			$result['error'] = '注册失败~请联系管理员,稍后再尝试吧!';
			echo json_encode($result);
			}
	}*/
	/*用户注册验证*/
	public function check_t(){
		$this->load->library('session');	
		$data = Array();
		$data['base'] = $this->config->item('base_url');
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->database();
		$result = Array();
		$yanzheng = Array();
		$yanzheng = array('cdn_Pass_again'=> $this->input->post('password_again_t', TRUE)
		);
		$data = array('user_mail'=> trim($this->input->post('username_t', TRUE)),
					'tell' => 0,
					'user_keycode' => $this->input->post('password_t', TRUE)
		);
		$this->db->select('user_mail')->from('users')->where('user_mail',$data['user_mail']);
		$query = $this->db->get();
		if ($query->num_rows() != 0)
		{
			$result['result'] = 0;
			$result['error'] = '用户名已存在,换用户名吧!';
			echo  json_encode($result);
			exit();
		}
		if($data['user_keycode'] != $yanzheng['cdn_Pass_again']){
			$result['result'] = 0;
			$result['error'] = '2次密码输入不同!';
			echo  json_encode($result);
			exit();
		}
		$data['user_keycode'] = sha1(md5($data['user_keycode']));
		$this->db->insert('users',$data);
		if($this->db->affected_rows() == 1)
		{
			$result['error'] = '恭喜!注册成功~O(∩_∩)O';
			$result['result'] = 1;
			$this->session->set_userdata('cdn_Name',$data['user_mail']);
			echo  json_encode($result);		
		}else{
			$result['result'] = 0;
			$result['error'] = '注册失败~请联系管理员,稍后再尝试吧!';
			echo json_encode($result);
			}
	}	
}
