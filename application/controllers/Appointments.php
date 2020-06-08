<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointments extends CI_Controller {

	private $headerData = array('page_title'=>'');
	private $viewData=array('view_data'=>'');

	function __construct() { 
        parent::__construct();         
        // User login status 
		$isUserLoggedIn = $this->session->userdata('isUserLoggedIn');
		if(!$isUserLoggedIn) { 
            redirect('login'); 
		}
		$this->load->model('appointments_model');
		
    } 
	
	public function index() {
		
		$this->viewData['view_data']= $this->appointments_model->return_users();
		$this->headerData['page_title'] = 'List Appointment';
		$this->load->view('header', $this->headerData);
		$this->load->view('appointments/index', $this->viewData);
		$this->load->view('footer');
    }
}
?>