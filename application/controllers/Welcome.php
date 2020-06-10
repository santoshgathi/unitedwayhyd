<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	private $headerData = array('page_title'=>'');
	private $viewData;

	function __construct() { 
        parent::__construct();         
        // User login status 
		$isUserLoggedIn = $this->session->userdata('isUserLoggedIn');
		if(!$isUserLoggedIn) { 
            redirect('login'); 
		}
		$this->load->model('appointments_model');
		$this->load->model('donor_model');
    } 
	
	public function index() {
		$this->headerData['page_title'] = 'Dashboard';
		$this->viewData['week_appointments']= $this->appointments_model->week_appointments();
		$this->viewData['today_appointments']= $this->appointments_model->today_appointments();
		$this->viewData['total_donors']= $this->donor_model->total_donors();
		$this->load->view('header', $this->headerData);
		$this->load->view('welcome_message', $this->viewData);
		$this->load->view('footer');
	}

	
}
