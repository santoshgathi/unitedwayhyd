<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donors extends CI_Controller {

	private $headerData = array('page_title'=>'');
	private $viewData=array('view_data'=>'');

	function __construct() { 
        parent::__construct();         
        // User login status 
		$isUserLoggedIn = $this->session->userdata('isUserLoggedIn');
		if(!$isUserLoggedIn) { 
            redirect('login'); 
        } 
    } 
	
	public function index() {
		$this->load->model('donordb');
		
		$this->viewData['view_data']=$this->donordb->return_users();
		$this->headerData['page_title'] = 'List Donors';
		$this->load->view('header', $this->headerData);
		$this->load->view('donors/index', $this->viewData);
		$this->load->view('footer');
    }
    
    public function create() {
		$this->headerData['page_title'] = 'Create Donor';
		$this->load->view('header', $this->headerData);
		$this->load->view('donors/create', $this->viewData);
		$this->load->view('footer');
	}
	public function save(){
		$message='';
		
		$donorname = $this->input->post('Donorname');
		$pho = $this->input->post('Pho');
		$ph1=$pho;

		$data=[
			'donor_name'=>$donorname,
			'donor_phone'=>$pho
		];
		
		$this->load->model('donordb');
		$message=$this->donordb->add('donors',$data);
		
		$this->viewData['view_data']=$this->donordb->return_users();
		
		
		$this->headerData['page_title'] = 'List Donors';
		$this->load->view('header', $this->headerData);
		$this->load->view('donors/index',$this->viewData);
		$this->load->view('footer');
	
	
	
	
		

	}
}
