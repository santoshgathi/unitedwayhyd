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
		$this->load->model('Eightyg_model');
		$data['areas'] = $this->Eightyg_model->getAreas();
		$this->headerData['page_title'] = 'List Areas';
		$this->load->view('header', $this->headerData);
		$this->load->view('areas/index', $data);
		$this->load->view('footer');
	}

	public function create() {
		$this->headerData['page_title'] = 'Create Area';
		$this->load->view('header', $this->headerData);
		$this->load->view('areas/create');
		$this->load->view('footer');
		$data="";
		$data = $this->input->post("newArea");
	}
	
	public function toDatabase(){
	    $data="";
		$mes['message'] = 'Area Saved';
		$data = $this->input->post("newArea");
		if($data){
		$this->load->database();
		$res = $this->db->query("INSERT INTO `areas`(`area_name`) VALUES ('$data')");
		}
		$this->headerData['page_title'] = 'Create Area';
		$this->load->view('header', $this->headerData);
		$this->load->view('areas/create', $mes);
		$this->load->view('footer');
	}
}
