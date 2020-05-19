<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	private $headerData = array('page_title'=>'');

	function __construct() { 
        parent::__construct();         
        // User login status 
		$isUserLoggedIn = $this->session->userdata('isUserLoggedIn');
		if(!$isUserLoggedIn) { 
            redirect('login'); 
        } 
    } 
	
	public function index() {
		$this->headerData['page_title'] = 'Dashboard';
		$this->load->view('header', $this->headerData);
		$this->load->view('welcome_message');
		$this->load->view('footer');
	}

	
}
