<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Areas extends CI_Controller {

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
		$this->headerData['page_title'] = 'List Areas';
		$this->load->view('header', $this->headerData);
		$this->load->view('areas/index');
		$this->load->view('footer');
	}

	public function create() {
		$this->headerData['page_title'] = 'Create Area';
		$this->load->view('header', $this->headerData);
		$this->load->view('areas/create');
		$this->load->view('footer');
	}
}
