<?php	
class show extends CI_Controller {
	
	function __construct()
    {	
		@session_start();
		header("Content-type: text/html; charset=utf-8");
        parent::__construct();
    }
	
	function index(){
		$data["base"] = $this->config->item('base_url');
		
		$this->load->view("show/index",$data);
	}
	
	function demo(){
		$data["base"] = $this->config->item('base_url');
		
		$this->load->view("show/demo",$data);
	}
	
	function discuss(){
		$data["base"] = $this->config->item('base_url');
		
		$this->load->view("show/discuss",$data);
	}
	
	function func(){
		$data["base"] = $this->config->item('base_url');
		
		$this->load->view("show/func",$data);
	}
	
	function userguide(){
		$data["base"] = $this->config->item('base_url');
		
		$this->load->view("show/userguide",$data);
	}
	
	function version(){
		$data["base"] = $this->config->item('base_url');
		
		$this->load->view("show/version",$data);
	}
}
?>