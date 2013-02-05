<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:text/html; charset=utf-8');
class Revise extends CI_Controller {
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
		$this->load->view('revise',$data);
	}
	/*用户修改密码*/
	public function check(){
		//session_start();		
		$data = Array();
		$data['base'] = $this->config->item('base_url');
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->database();
		$result = Array();
		$yanzheng = Array();
		$yanzheng = array('yanzheng'=> $this->input->post('password', TRUE)
		);
		$data = array('cdn_Pass'=> $this->input->post('password_new', TRUE),
					'cdn_Pass_again' => $this->input->post('password_again', TRUE),
					'user' => $this->input->post('user', TRUE)
		);
		/*$yanzheng = array('yanzheng'=> "csxcsxx"
		);
		$data = array('cdn_Pass'=> "csxcsxx",
					'cdn_Pass_again' => "csxcsxx",
					'user' => "csx"
		);*/
		$this->db->select('user_mail')->from('users')->where('user_mail',$data['user']);
		$query = $this->db->get();
		if ($query->num_rows() == 0)
		{
			$result['result'] = 1;
			$result['error'] = '用户名不存在';
			echo  json_encode($result);
			exit();
		}
		if($data['cdn_Pass'] != $data['cdn_Pass_again']){
			$result['result'] = 2;
			$result['error'] = '2次密码输入不同!';
			echo  json_encode($result);
			exit();
		}
		//next
		$this->db->select('user_keycode')->from('users')->where('user_mail',$data['user']);
		$query = $this->db->get();

		if((sha1(md5(($yanzheng['yanzheng']))) == $query->row()->user_keycode))
		{
			date_default_timezone_set('PRC');
			$this->load->library('session');
			$data['cdn_Pass'] = sha1(md5(($data['cdn_Pass'])));
			$this->db->query("UPDATE users SET user_keycode='{$data['cdn_Pass']}' where user_mail ='{$data['user']}'");		
			if($this->db->affected_rows() <= 1)
			{
				$result['error'] = '恭喜!修改成功~O(∩_∩)O';
				$result['result'] = 3;
				$this->db->select('user_mail')->from('users')->where('user_mail',$data['user']);
				$set = $this->db->get();
				$this->session->set_userdata('cdn_Name',$set->row()->user_mail);
				//$this->session->set_userdata('cdn_Name',$data['user_mail']);
				echo  json_encode($result);
			}else{
				$result['result'] = 4;
				$result['error'] = '修改失败~请联系管理员,稍后再尝试吧!';
				echo json_encode($result);
				}
		} else {						
			$result['result'] = 5;
			$result['error'] = '旧密码错误!';
			echo json_encode($result);
		}
	}
		
}
