<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

	private $headerData = array('page_title'=>'');
	private $viewData=array('view_data'=>'');

	function __construct() { 
        parent::__construct();
		$this->viewData['user_role'] = $this->session->userdata("user_role");
		$this->headerData['menus'] = $this->user_menu($this->viewData['user_role']);
		$this->load->model('user_model');
    } 
	
	public function index() {
		
		$this->viewData['view_data']=$this->user_model->get_users();
		$this->headerData['page_title'] = 'List Users';
		$this->load->view('header', $this->headerData);
		$this->load->view('users/index', $this->viewData);
		$this->load->view('footer');
    }
    
    public function create() {
		$this->headerData['page_title'] = 'Create User';		
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]'); 
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('full_name', 'Full Name', 'required|is_unique[users.full_name]');
		if ($this->form_validation->run() === FALSE) {			
			$this->load->view('header', $this->headerData);
			$this->load->view('users/create', $this->viewData);
			$this->load->view('footer');
        } else {			
			$data=[
				'username'=> $this->input->post('username'),
				'password'=> $this->input->post('password'),
				'full_name' => $this->input->post('full_name'),
				'user_role' => $this->input->post('user_role'),
				'status' => '1',
				'created_on' => date('Y-m-d H:i:s'),
			];			
			$this->user_model->insert_entry($data);
			redirect('users');
		}
	}
	
	public function update($user_id) {
		
		$this->headerData['page_title'] = 'Update User';
		$this->viewData['user_details'] = $this->user_model->get_details($user_id);		
		$this->form_validation->set_rules('full_name', 'Full Name', 'required|unique_exclude[users,full_name,id,'.$user_id.']');
		$this->form_validation->set_rules('status', 'Status', 'required');
	
		if ($this->form_validation->run() === FALSE) {
         	$this->load->view('header', $this->headerData);
			$this->load->view('users/update', $this->viewData);
			$this->load->view('footer');
        } else {
			// form submit
			// db save -- list page redirect 
			$data=[
				'full_name'=> $this->input->post('full_name'),
				'status'=> $this->input->post('status')
			];
			$this->user_model->update_entry($data,$user_id);
			$this->session->set_flashdata('success', 'Updated Successfully');
            redirect('users');
        }
	}


}
