<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eightyg extends CI_Controller {

	private $headerData = array('page_title'=>'');
	private $viewData;

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
		$this->load->view('eightyg/index', $this->viewData);
		$this->load->view('footer');
	}

	public function fileupload() {
		$this->headerData['page_title'] = 'Upload 80G';
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 10024;
		$this->load->library('upload', $config);

		if ($this->form_validation->run() === FALSE) {
              
        } else {
			if ($this->upload->do_upload('userfile')) {
				$upload_data = $this->upload->data();
				
			} else {
				$this->viewData['error'] = $this->upload->display_errors();
			}
		}

		$this->load->view('header', $this->headerData);
		$this->load->view('eightyg/fileupload', $this->viewData);
		$this->load->view('footer');
	}
}
