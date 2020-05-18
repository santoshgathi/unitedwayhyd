<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donors extends CI_Controller {

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
		$this->headerData['page_title'] = 'List Donors';
		$this->load->view('header', $this->headerData);
		$this->load->view('donors/index');
		$this->load->view('footer');
    }
    
    public function create() {
		$this->headerData['page_title'] = 'Create Donor';
		$this->load->view('header', $this->headerData);
		$this->load->view('donors/create');
		$this->load->view('footer');
	}
}
