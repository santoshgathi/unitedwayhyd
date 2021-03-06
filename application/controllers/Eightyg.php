<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH .'third_party/fpdf/fpdf.php');
require(APPPATH .'third_party/phpmailer/PHPMailerAutoload.php');
//Import PHPMailer classes into the global namespace
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;

class Eightyg extends MY_Controller {

	private $headerData = array('page_title'=>'');
	private $viewData;

	function __construct() { 
        parent::__construct();
		$this->viewData['user_role'] = $this->session->userdata("user_role");
		$this->headerData['menus'] = $this->user_menu($this->viewData['user_role']);
		$this->load->model('eightyg_model');
    } 
	
	public function index() {
		$this->viewData['current_url'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$this->load->library('pagination');
		$this->headerData['page_title'] = 'List 80G';
		$this->viewData['donor'] = $donor = $this->input->get('donor') ? $this->input->get('donor') : '';
		$this->viewData['email'] = $email = $this->input->get('email') ? $this->input->get('email') : '';
		$this->viewData['trns_date'] = $trns_date = $this->input->get('trns_date') ? $this->input->get('trns_date') : '';
		$this->viewData['size'] = $size = $this->input->get('size') ? $this->input->get('size') : 10;
		$page = $this->input->get('per_page') ? $this->input->get('per_page') : 0;
		$config = $this->pagination_config_array('/index.php/eightyg/index/', $size);
		$config['total_rows'] = $this->eightyg_model->get_entries('count', 0, 0, $donor, $email, $trns_date);
		$this->viewData['eightyg_data'] = $this->eightyg_model->get_entries('rows', $page, $config['per_page'], $donor, $email, $trns_date);
		//print_r($this->viewData['eightyg_data']);
		$this->pagination->initialize($config);
		$this->viewData['paginationSummary']  = $this->pagination_summary($page, $config['per_page'], $config['total_rows']);

		$this->form_validation->set_rules('eightysubmit', 'Form submit', 'required');
		$this->form_validation->set_rules('eightyg_action', 'Select Action', 'required');
		if ($this->form_validation->run() === FALSE) {
		} else {
			// form submit
			// get the check boxes ids
			$eightyg_ids = $this->input->post('eightyg_ids');
			$eightyg_action = $this->input->post('eightyg_action');
			//print_r($eightyg_ids);exit;
			//$count_ids = count((array)$eightyg_ids);
			foreach ($eightyg_ids as  $k => $v) { 
				//print_r($this->viewData['eightyg_data'][$v]);
				if($eightyg_action === 'gen80g' || $eightyg_action === 'gen80gsendemail') {
					$file_80g = $this->generate80G_PDF($this->viewData['eightyg_data'][$v]);
					$this->eightyg_model->update_80g_file_status($this->viewData['eightyg_data'][$v]->id,$file_80g);
				}				
				if($eightyg_action === 'sendemail' || $eightyg_action === 'gen80gsendemail') {
					$email_status = $this->sendemail($this->viewData['eightyg_data'][$v]);
					if($email_status) {
						$this->eightyg_model->update_80g_email_status($this->viewData['eightyg_data'][$v]->id);
					}
				}								
			}
			redirect($this->viewData['current_url']);
		}		

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
			// check records whether already exists
			$count_receipts = 0;
			$this->viewData['receipts_error'] = 'Records Alreadt exists : ';
			foreach($eightyg_data as $k => $v) {		
				$result = $this->eightyg_model->validate_entry($v['A']);
				if($result) {
					$count_receipts = $count_receipts + (int)$result;
					$this->viewData['receipts_error'] .= $v['A'].', ';
				}					
			}
			// insert records
			if($count_receipts == 0) {
				foreach($eightyg_data as $k => $v) {
					//print_r($v);

					$excel_receipt_no = trim($v['A']);
					$excel_donor_name = trim($v['C']);
					$excel_address1 = trim($v['D']);
					$excel_address2 = trim($v['E']);
					$excel_city = trim($v['F']);
					$excel_pan_no = trim($v['G']);
					$excel_email = trim($v['H']);
					$excel_sum_monthly_contribution = trim(str_replace(",", "", $v['I']));
					$excel_amount_in_words = $this->amountInWords($excel_sum_monthly_contribution);
					$excel_trns_date = date('Y-m-d H:i:s', strtotime($v['J']));
					$excel_ref_details = trim($v['K']);
					$excel_bank = trim($v['L']);
					$excel_donation_cause = trim($v['M']);

					$excel_data = array('receipt_no' => $excel_receipt_no, 'donor_name' => $excel_donor_name, 'pan_no'=> $excel_pan_no, 'email' => $excel_email, 'sum_monthly_contribution' => $excel_sum_monthly_contribution, 'amount_in_words' => $excel_amount_in_words, 'trns_date' => $excel_trns_date, 'ref_details' => $excel_ref_details, 'bank' => $excel_bank, 'pdf_80g' => 'NA', 'address1' => $excel_address1, 'address2' => $excel_address2, 'city' => $excel_city, 'donation_cause' => $excel_donation_cause, 'sent_email' => 'No', 'created_by' => $this->session->userdata("userId"), 'created_on' => date('Y-m-d H:i:s'));
					//print_r($data);
					$this->eightyg_model->insert_entry($excel_data);			
				}
				$this->session->set_flashdata('success', 'Inserted Successfully');
				redirect('eightyg');
			}
		}
		$this->load->view('header', $this->headerData);
		$this->load->view('eightyg/fileupload', $this->viewData);
		$this->load->view('footer');
	}
	
	public function generate80G_PDF($details) {
		$trns_date   =   date('d-M-Y', strtotime($details->trns_date));
		//$name   =   $details['firstname'].'_'.$details['lastname'];
		$pdf    =   new FPDF();
		$pdf->AddPage('P','A3');
		$pdf->SetTitle('80g Certificate');
		$pdf->Image('img/logo_united.png',230,10);
		$pdf->setFont('Arial','',12);
		$pdf->SetXY(10,35);
		$pdf->Cell(50,0,'United Way of Hyderabad');
		$pdf->SetXY(10,40);
		$pdf->Cell(50,0,'Regd Office: Plot No 54, Road No 2,');
		$pdf->SetXY(10,45);
		$pdf->Cell(50,0,'Sagar Society,Banjara Hills,');
		$pdf->SetXY(10,50);
		$pdf->Cell(50,0,'Hyderabad -500034');
		$pdf->setFont('Arial','B',12);
		$pdf->SetXY(10,70);
		$pdf->Cell(50,0,'Ref No:  '.$details->receipt_no);
		$pdf->SetXY(220,70);
		$pdf->Cell(50,0,'Receipt Date: '.$trns_date);
		$pdf->setFont('Arial','',12);
		$pdf->SetXY(10,80);
		$pdf->Cell(50,0,$details->donor_name);
		$pdf->SetXY(10,85);
		$pdf->Cell(50,0,$details->address1);
		$pdf->SetXY(10,90);
		$pdf->Cell(50,0,$details->city);
		$pdf->setFont('Arial','B',12);
		$pdf->SetXY(10,95);
		$pdf->Cell(50,0,'PAN: '.$details->pan_no);
		$pdf->setFont('Arial','',12);
		$pdf->SetXY(10,105);
		$pdf->Cell(50,0,'Thank you for your thoughtful donation to United Way of Hyderabad. Your generous contributions will help us work towards helping the needy.');
		$pdf->SetXY(10,115);
		$pdf->Cell(50,0,'Kindly find enclosed your 80G Certificate to enable you to claim 50% Tax exemption under 80G (5) (vi) of Income Tax Act, 1961.');
		$pdf->SetXY(10,120);
		$pdf->Cell(50,0,'For any queries related to 80G certificate, please call us on 040-23287679/74 or write to us at ');
		$pdf->setFont('Arial','U',12);
		$pdf->SetTextColor(0,0,255);
		$pdf->SetXY(187,120);
		$pdf->Cell(50,0,'www.unitedwayhyderabad.org');
		$pdf->setFont('Arial','',12);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetXY(10,130);
		$pdf->Cell(50,0,'Request you to visit our website');
		$pdf->setFont('Arial','U',12);
		$pdf->SetTextColor(0,0,255);
		$pdf->SetXY(71,130);
		$pdf->Cell(50,0,'www.unitedwayhyderabad.org');
		$pdf->setFont('Arial','',12);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetXY(130,130);
		$pdf->Cell(50,0,'to know about our initiatives.');
		$pdf->SetXY(10,140);
		$pdf->Cell(50,0,'We appreciate your generosity. ');
		$pdf->SetXY(10,150);
		$pdf->Cell(50,0,'Regards,');
		$pdf->SetXY(10,156);
		$pdf->Cell(50,0,'Rekha Srinivasan');
		$pdf->SetXY(10,162);
		$pdf->Cell(50,0,'CEO');
		$pdf->SetXY(10,168);
		$pdf->setFont('Arial','U',12);
		$pdf->SetTextColor(0,0,255);
		$pdf->Cell(50,0,'rekha@unitedwayhyderabad.org');
		$pdf->setFont('Arial','',12);
		$pdf->SetTextColor(0,0,0);
		$pdf->Line(10,182,280,182);
		$pdf->SetXY(10,187);
		$pdf->Cell(50,0,'Please find the details below:');
	
		$pdf->SetXY(10,200);
		$width_cell=array(80,188,268);
		$pdf->setFont('Arial','B',13);
		$pdf->Cell($width_cell[2],10,'80G Certificate',1,1,'C',false);
		$pdf->setFont('Arial','',12);
		$pdf->Cell($width_cell[2],10,'We confirm the receipt of donation from '.$details->donor_name.' Transfer No: '.$details->ref_details.' Dated: '.$trns_date,1,1,'C',false);
		$pdf->Cell($width_cell[0],10,'Total Donation Received',1,0,'C',false);
		$pdf->Cell($width_cell[1],10,'Rs. '.$details->sum_monthly_contribution,1,1,'C',false);
		$pdf->Cell($width_cell[0],10,'Amount in Words: ',1,0,'C',false);
		$pdf->Cell($width_cell[1],10,$details->amount_in_words,1,1,'C',false);
		$pdf->Cell($width_cell[2],10,'Towards:  '.$details->donation_cause,1,1,'L',false);
	
		$pdf->SetXY(10,255);
		$pdf->Cell(50,0,'Receipt is valid subject to the realization of Cheque/ECS/Credit card Only');
		$pdf->SetXY(10,265);
		$pdf->Cell(50,0,'Society Regd. No.878/10');
		$pdf->SetXY(10,270);
		$pdf->Cell(50,0,'PAN Card No : AAAAU3174C');
	
		$pdf->Image('img/80g_seal.png',190,275);
	
		$pdf->SetXY(70,340);
		$pdf->Cell(50,0,'Donation exempt under section 80G of the Income Tax Act 1961 vide regd No');
		$pdf->SetXY(90,345);
		$pdf->Cell(50,0,'F. NO. DIT (E)/HYD/80G/34(04)/11-12; Dated: 20/10/2011');
		$file_path  =  '80g_certificates';
		if (!is_dir($file_path)) {
			mkdir($file_path, 0777, TRUE);
		}
		$file_name  =   $details->receipt_no.'.pdf';
		$file_path  .=  '/'.$file_name;
		// if file exists delete it
		if (file_exists($file_path)) {
			unlink($file_path);
		}
		$pdf->output('F',$file_path);
		log_message('info', '80G PDF generation : '.$details->receipt_no);
		return $file_name;
	}

	public function sendemail($details) {
		//check for file
		if (!file_exists('80g_certificates/'.$details->receipt_no.'.pdf')) {
			return false;
		}

		$message ="Hello ".$details->donor_name.",<br/><br/>
Thanks for your donation.<br/><br/>
<strong>Your Donation Details:</strong><br/>
Amount: ".$details->sum_monthly_contribution."<br/>
Transaction ID: ".$details->ref_details."<br/><br/>
Please find the attachment for <strong>80G Certificate</strong>,

Looking forward for your continued support.<br/><br/>
-------------------------------<br/>
Thanks and Regards,<br/>
Manager - Accounts<br/>
United Way of Hyderabad<br/>
Phone : 040 40042010/11<br/>
email : accounts@unitedwayhyderabad.org<br/>
web: www.unitedwayhyderabad.org";
		
		$to_address = $details->email;
		$to_username = $details->donor_name;
		$subject = "Thank you for your Donation to United Way of Hyderabad";
		$attachment = '80g_certificates/'.$details->receipt_no.'.pdf';
		return $this->send_email($message, $to_address, $to_username, $subject, $attachment);
	}
	

	public function create() {
		$this->headerData['page_title'] = 'Create 80G';
		$this->form_validation->set_rules('receipt_no', 'receipt no', 'trim|required|is_unique[80guploads.receipt_no]');
		$this->form_validation->set_rules('donor_name', 'donor name', 'trim|required');
		$this->form_validation->set_rules('pan_no', 'pan no', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required');
		$this->form_validation->set_rules('sum_monthly_contribution', 'sum monthly contribution', 'trim|required');
		$this->form_validation->set_rules('trns_date', 'trns date', 'trim|required');
		$this->form_validation->set_rules('ref_details', 'ref details', 'trim|required');
		$this->form_validation->set_rules('bank', 'bank', 'trim|required');
		if ($this->form_validation->run() === FALSE) {
         	$this->load->view('header', $this->headerData);
			$this->load->view('eightyg/create', $this->viewData);
			$this->load->view('footer');
        } else {
			// form submit
			// db save -- list page redirect 
			$data['receipt_no'] = $this->input->post('receipt_no');
			$data['donor_name'] = $this->input->post('donor_name');
			$data['pan_no'] = $this->input->post('pan_no');
			$data['email'] = $this->input->post('email');
			$data['sum_monthly_contribution'] = $this->input->post('sum_monthly_contribution');
			$data['trns_date'] = $this->input->post('trns_date');
			$data['ref_details'] = $this->input->post('ref_details');
			$data['amount_in_words'] = $this->amountInWords($data['sum_monthly_contribution']);
			$data['address1'] = $this->input->post('address1');
			$data['address2'] = $this->input->post('address2');
			$data['bank'] = $this->input->post('bank');
			$data['city'] = $this->input->post('city');
			$data['donation_cause'] = $this->input->post('donation_cause');
			$data['pdf_80g'] = 'NA';
			$data['sent_email'] = 'No';
			$data['created_by'] = $this->session->userdata("userId");
			$data['created_on'] = date('Y-m-d H:i:s');
			$resultId = $this->eightyg_model->insert_entry($data);
			$this->session->set_flashdata('success', 'Created Successfully');
			redirect('eightyg');
			if ($resultId) {
                $this->session->set_flashdata('success', 'Created Successfully');
                //$this->session->set_flashdata('msg', array('success' => 'Platforms data has been created successfully.'));
                redirect('eightyg');
            } else {
                $this->session->set_flashdata('error', 'Error while adding new entry. Try again!');
                redirect('eightyg/Create');
            }
        }
	}

	public function update($egithyg_id) {
		$this->headerData['page_title'] = 'Update 80G';
		$this->viewData['eightyg_details'] = $this->eightyg_model->get_details($egithyg_id);
		//print_r($eightyg_details);
		$this->form_validation->set_rules('receipt_no', 'receipt no', 'trim|required|unique_exclude[80guploads,receipt_no,id,'.$egithyg_id.']');
		$this->form_validation->set_rules('donor_name', 'donor name', 'trim|required');
		$this->form_validation->set_rules('pan_no', 'pan no', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required');
		$this->form_validation->set_rules('sum_monthly_contribution', 'sum monthly contribution', 'trim|required');
		$this->form_validation->set_rules('trns_date', 'trns date', 'trim|required');
		$this->form_validation->set_rules('ref_details', 'ref details', 'trim|required');
		$this->form_validation->set_rules('bank', 'bank', 'trim|required');
		if ($this->form_validation->run() === FALSE) {
         	$this->load->view('header', $this->headerData);
			$this->load->view('eightyg/update', $this->viewData);
			$this->load->view('footer');
        } else {
			// form submit
			// db save -- list page redirect 
			$data['receipt_no'] = $this->input->post('receipt_no');
			$data['donor_name'] = $this->input->post('donor_name');
			$data['pan_no'] = $this->input->post('pan_no');
			$data['email'] = $this->input->post('email');
			$data['sum_monthly_contribution'] = $this->input->post('sum_monthly_contribution');
			$data['trns_date'] = $this->input->post('trns_date');
			$data['ref_details'] = $this->input->post('ref_details');
			$data['amount_in_words'] = $this->amountInWords($data['sum_monthly_contribution']);
			$data['address1'] = $this->input->post('address1');
			$data['address2'] = $this->input->post('address2');
			$data['bank'] = $this->input->post('bank');
			$data['city'] = $this->input->post('city');
			$data['donation_cause'] = $this->input->post('donation_cause');
			$this->viewData['eightyg_details'] = $this->eightyg_model->update_entry($data, $egithyg_id);
			$this->session->set_flashdata('success', 'Updated Successfully');
            redirect('eightyg');
        }
	}	

	public function delete($egithyg_id = NULL) {
		$this->headerData['page_title'] = 'Delete 80G';
        // $this->viewHeaderData['breadcrumbs'] = array(
        //     'admin' => array(anchor('gateways', 'Gateways', ''), 'Delete')
        // );
        // $this->viewHeaderData['page_heading'] = 'Delete Gateway';
		// $this->viewData['gateway_ip'] = $gateway_ip;
		$this->viewData['eightyg_details'] = $this->eightyg_model->get_details($egithyg_id);
        $this->form_validation->set_rules('confirm', 'confirm', 'required');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            if ('no' == $this->input->post('confirm')) {
                redirect('eightyg');
            }
			$result = $this->eightyg_model->delete_entry($egithyg_id);
			if ($result) {
                $this->session->set_flashdata('success', 'Deleted Successfully');
                redirect('eightyg');
            } else {
                $this->session->set_flashdata('error', 'Error while deleting entry. Try again!');
                redirect('eightyg/delete/'.$egithyg_id);
            }
        }
        // views - header, body, footer
        $this->load->view('header', $this->headerData);
        $this->load->view('eightyg/delete', $this->viewData);
        $this->load->view('footer');
	}	

	public function pdfemail () {
		echo "pdf--email";
	}
}
