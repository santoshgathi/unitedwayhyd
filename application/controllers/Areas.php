<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Areas extends MY_Controller {

	private $headerData = array('page_title'=>'');

	function __construct() { 
        parent::__construct();
		$this->viewData['user_role'] = $this->session->userdata("user_role");
		$this->headerData['menus'] = $this->user_menu($this->viewData['user_role']);
		$this->load->model('areas_model');
    } 
	
	public function index() {
		$data['areas'] = $this->areas_model->getAreas();
		$this->headerData['page_title'] = 'List Areas';
		$this->load->view('header', $this->headerData);
		$this->load->view('areas/index', $data);
		$this->load->view('footer');
	}

	public function create() {
		$this->headerData['page_title'] = 'Create Area';
		$this->form_validation->set_rules('newArea', 'Area Name', 'trim|required|min_length[3]|max_length[100]|is_unique[areas.area_name]');      
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $this->headerData);
			$this->load->view('areas/create');
			$this->load->view('footer');
        } else {
			$data['area_name'] = $this->input->post("newArea");
			$this->areas_model->insertAreas($data);
			$this->session->set_flashdata('success', 'Inserted Successfully');
            redirect('areas');
        }
	}
	
	public function update($area_id) {
		
		$this->headerData['page_title'] = 'Edit Area';
		$this->areas['area'] = $this->areas_model->get_details($area_id);
		
		$this->form_validation->set_rules('area_name', 'Area name', 'trim|required|min_length[3]|max_length[100]|unique_exclude[areas,area_name,area_id,'.$area_id.']');
	
		if ($this->form_validation->run() === FALSE) {
         	$this->load->view('header', $this->headerData);
			$this->load->view('areas/update', $this->areas);
			$this->load->view('footer');
        } else {
			$area['area_name'] = $this->input->post('area_name');
			$this->viewData['area_d'] = $this->areas_model->update_area($area, $area_id);
			$this->session->set_flashdata('success', 'Updated Successfully');
            redirect('areas');
        }
	}
	
	
}
