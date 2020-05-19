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
		$this->load->model('eightyg_model');
    } 
	
	public function index() {
		$this->headerData['page_title'] = 'List 80G';
		$this->viewData['eightyg_data']  = $this->eightyg_model->get_entries();
		$this->load->view('header', $this->headerData);
		$this->load->view('eightyg/index', $this->viewData);
		$this->load->view('footer');
	}

	public function fileupload() {
		$this->headerData['page_title'] = 'Upload 80G';
		//$this->form_validation->set_rules('userfile', 'File', 'required');
		// $config['upload_path']          = './uploads/';
		// $config['allowed_types']        = 'gif|jpg|png';
		// $config['max_size']             = 10024;
		// $this->load->library('upload', $config);

		// if ($this->upload->do_upload('userfile')) {
		// 	$upload_data = $this->upload->data();
		// 	print_r($upload_data);				
		// } else {
		// 	$this->viewData['error'] = $this->upload->display_errors();
		// }

		$this->load->view('header', $this->headerData);
		$this->load->view('eightyg/fileupload', $this->viewData);
		$this->load->view('footer');
	}

	public function do_upload() {
		$this->headerData['page_title'] = 'Upload 80G';
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'xlsx';
		$config['max_size']             = 10024;
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('userfile')) {
			$this->viewData['error'] = $this->upload->display_errors();
		} else {
			$upload_data = $this->upload->data();
			//print_r($upload_data);
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			$spreadsheet = $reader->load('./uploads/'.$upload_data['file_name']);
			$data = array(1,$spreadsheet->getActiveSheet()->toArray(null,true,true,true));  
			// Display the sheet content 
			//echo '<pre>';print_r($data);echo '</pre>';exit;
			array_shift($data);
			$eightyg_data = $data[0];
			array_shift($eightyg_data);
			//echo '<pre>';print_r($eightyg_data);echo '</pre>';			
			foreach($eightyg_data as $k => $v) {
				//print_r($v);
				$data = array('receipt_no'=>$v['A'], 'donor_name'=>$v['C'], 'pan_no'=>$v['D'], 'email'=>$v['E'], 'sum_monthly_contribution'=> str_replace(",", "", $v['F']), 'trns_date'=>date('Y-m-d H:i:s', strtotime($v['H'])), 'ref_details'=>$v['I'], 'bank'=>$v['J']);
				//print_r($data);
				$this->eightyg_model->insert_entry($data);
			}
			$this->session->set_flashdata('error', 'Inserted Successfully');
			redirect('eightyg');
		}
		$this->load->view('header', $this->headerData);
		$this->load->view('eightyg/fileupload', $this->viewData);
		$this->load->view('footer');
    }
}
