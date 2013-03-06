<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('content-type:text/html; charset=utf-8');
class Login extends CI_Controller {
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
		if (!($this->session->userdata('cdn_Name'))){
			$this->load->view('login',$data);
		}else{
		$this->load->database();
		$boss_check = $this->db->query("SELECT tell from users where user_mail = '{$this->session->userdata('cdn_Name')}'")->row()->tell;
		if($boss_check != 1){
			redirect($this->config->item('base_url').'index.php/domain_user', 'refresh');		
		}else{
			redirect($this->config->item('base_url').'index.php/node', 'refresh');		
			}
		}
	}
	/*用户登入验证*/
	public function check(){
		//session_start();		
		$data = Array();
		$data['base'] = $this->config->item('base_url');
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->database();
		$result = Array();
		$yanzheng = Array();
		$yanzheng = array('yanzheng'=> trim($this->input->post('Verdivcation', TRUE))
		);
		$data = array('cdn_Name'=> trim($this->input->post('username', TRUE)),
					'cdn_Pass' => $this->input->post('password', TRUE)
		);
		$this->db->select('*')->from('users')->where('user_mail',$data['cdn_Name']);
		$query = $this->db->get();
		if ($query->num_rows() != 1)
		{
			$result['result'] = 0;
			$result['error'] = '账号不存在出现异常';
			echo  json_encode($result);
		}else{
			if((sha1(md5(($data['cdn_Pass']))) == $query->row()->user_keycode) and ($data['cdn_Name'] == $query->row()->user_mail))
			{
				date_default_timezone_set('PRC');
				$this->load->library('session');
				$this->session->set_userdata('cdn_id',$query->row()->user_id);
				$this->session->set_userdata('cdn_Name',$query->row()->user_mail);
				if($query->row()->tell == 1){
					$result['result'] = 2;
					echo json_encode($result);
				}else{
					$result['result'] = 1;
					echo json_encode($result);
				}
			} else {						
				$result['result'] = 0;
				$result['error'] = '用户名或密码错误!';
				echo json_encode($result);
			}
		}
	}
		
}
