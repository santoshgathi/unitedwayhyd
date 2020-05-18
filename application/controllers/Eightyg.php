<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eightyg extends CI_Controller {

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
		$this->headerData['page_title'] = 'List 80G';
		$this->load->view('header', $this->headerData);
		$this->load->view('eightyg/index');
		$this->load->view('footer');
	}

	public function fileupload() {
		$this->headerData['page_title'] = 'Upload 80G';
		$this->load->view('header', $this->headerData);
		$this->load->view('eightyg/fileupload');
		$this->load->view('footer');
	}
}
