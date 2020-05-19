<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenditures extends CI_Controller {

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
		$this->viewData['view_data']= $this->donordb->return_expend();
		$this->headerData['page_title'] = 'List Expenditures';
		$this->load->view('header', $this->headerData);
		$this->load->view('expenditures/index', $this->viewData);
		$this->load->view('footer');
	}

	public function create() {
		$this->load->model('donordb');
		$this->viewData['donor_name']= $this->donordb->return_donors();
		$this->viewData['area']=$this->donordb->return_area();

		$this->headerData['page_title'] = 'Create Expenditure';
		$this->load->view('header', $this->headerData);
		$this->load->view('expenditures/create', $this->viewData);
		$this->load->view('footer');
	}
	public function save(){
		$date = $this->input->post('date');
		$donor = $this->input->post('donor_name');
		$area=$this->input->post('area');
		$nutriton=$this->input->post('nutrition');
		$meals=$this->input->post('meals');
		
		$data=[
			'donor_id'=>$donor,
			'expenditure_dt'=>$date,
			'area_id'=>$area,
			'nutrition_hygiene_kit'=>$nutriton,
			'meals'=>$meals,
		];
		
		$this->load->model('donordb');
		$message=$this->donordb->add('expenditures',$data);
		$this->load->model('donordb');
		$this->viewData['view_data']= $this->donordb->return_expend();



		$this->headerData['page_title'] = 'List Expenditures';
		$this->load->view('header', $this->headerData);
		$this->load->view('expenditures/index',$this->viewData);

		$this->load->view('footer');
		
	
	
	}
}
