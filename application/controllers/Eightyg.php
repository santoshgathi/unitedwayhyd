<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH .'third_party/fpdf/fpdf.php');

class Eightyg extends MY_Controller {

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
		$this->headerData['current_url'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$this->load->library('pagination');
		$this->headerData['page_title'] = 'List 80G';
		$this->viewData['size'] = $size = $this->input->get('size') ? $this->input->get('size') : 3;
		$page = $this->input->get('per_page') ? $this->input->get('per_page') : 0;
		$config = $this->pagination_config_array('/index.php/eightyg/index/', $size);
		$config['total_rows'] = $this->eightyg_model->get_entries('count', 0, 0);
		$this->viewData['eightyg_data'] = $this->eightyg_model->get_entries('rows', $page, $config['per_page']);
		//print_r($this->viewData['eightyg_data']);
		$this->pagination->initialize($config);
		$this->viewData['paginationSummary']  = $this->pagination_summary($page, $config['per_page'], $config['total_rows']);
		$this->form_validation->set_rules('eightysubmit', 'Form submit', 'required');
		if ($this->form_validation->run() === FALSE) {
		} else {
			$eightyg_ids = $this->input->post('eightyg_ids');
			//print_r($eightyg_ids);
			for ($i=0; $i < sizeof($eightyg_ids); $i++) { 
				//print_r($this->viewData['eightyg_data'][$i]);
				$this->generate80G_PDF($this->viewData['eightyg_data'][$i]);
			}
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
			foreach($eightyg_data as $k => $v) {
				//print_r($v);
				$data = array('receipt_no'=>$v['A'], 'donor_name'=>$v['C'], 'pan_no'=>$v['D'], 'email'=>$v['E'], 'sum_monthly_contribution'=> str_replace(",", "", $v['F']), 'trns_date'=>date('Y-m-d H:i:s', strtotime($v['H'])), 'ref_details'=>$v['I'], 'bank'=>$v['J']);
				//print_r($data);
				$this->eightyg_model->insert_entry($data);
			}
			$this->session->set_flashdata('success', 'Inserted Successfully');
			redirect('eightyg');
		}
		$this->load->view('header', $this->headerData);
		$this->load->view('eightyg/fileupload', $this->viewData);
		$this->load->view('footer');
	}

	public function update($egithyg_id) {
		$this->headerData['page_title'] = 'Update 80G';
		$this->viewData['eightyg_details'] = $this->eightyg_model->get_details($egithyg_id);
		//print_r($eightyg_details);
		$this->form_validation->set_rules('receipt_no', 'receipt no', 'required');
		$this->form_validation->set_rules('donor_name', 'donor name', 'required');
		$this->form_validation->set_rules('pan_no', 'pan no', 'required');
		$this->form_validation->set_rules('email', 'email', 'required');
		$this->form_validation->set_rules('sum_monthly_contribution', 'sum monthly contribution', 'required');
		$this->form_validation->set_rules('trns_date', 'trns date', 'required');
		$this->form_validation->set_rules('ref_details', 'ref details', 'required');
		$this->form_validation->set_rules('bank', 'bank', 'required');
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
			$data['bank'] = $this->input->post('bank');
			$this->viewData['eightyg_details'] = $this->eightyg_model->update_entry($data, $egithyg_id);
			$this->session->set_flashdata('success', 'Updated Successfully');
            redirect('eightyg');
        }
	}

	public function generatepdf ($data) {
		$details['firstname'] = 'first';
		$details['lastname'] = '';
		$details['city'] = 'hyd';
		$details['state'] = 'ap';
		$details['pan'] = 'pan1';
		$details['amount'] = '321.12';
		$this->generate80G_PDF($details, '123', 'Donation towards COVID-19 Relief Work');
	}
	
	public function generate80G_PDF($details) {
		$city = '';
		$state = '';
		$trans_id = $details->ref_details;
		$donated_for='Donation towards COVID-19 Relief Work';
		$date   =   date('d-M-Y', strtotime($details->trns_date));
		//$name   =   $details['firstname'].'_'.$details['lastname'];
		$name   =   $details->donor_name;
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
		$pdf->Cell(50,0,'Ref No:  '.$trans_id);
		$pdf->SetXY(220,70);
		$pdf->Cell(50,0,'Receipt Date: '.$date);
		$pdf->setFont('Arial','',12);
		$pdf->SetXY(10,80);
		$pdf->Cell(50,0,$name);
		$pdf->SetXY(10,85);
		$pdf->Cell(50,0,$city);
		$pdf->SetXY(10,90);
		$pdf->Cell(50,0,$state);
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
		$pdf->Cell($width_cell[2],10,'We confirm the receipt of donation from '.$name.'  Vide Payu Transfer No: '.$trans_id.' Dated: '.$date,1,1,'C',false);
		$pdf->Cell($width_cell[0],10,'Total Donation Received',1,0,'C',false);
		$pdf->Cell($width_cell[1],10,'Rs. '.$details->sum_monthly_contribution,1,1,'C',false);
		$pdf->Cell($width_cell[0],10,'Amount in Words: ',1,0,'C',false);
		$pdf->Cell($width_cell[1],10,$this->amountInWords((float)$details->sum_monthly_contribution),1,1,'C',false);
		$pdf->Cell($width_cell[2],10,'Towards:  '.$donated_for,1,1,'L',false);
	
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
		$file_path  =  '80g_certificates/';
		if (!is_dir($file_path)) {
			mkdir($file_path, 0777, TRUE);
		}
		$file_name  =   $details->receipt_no.'.pdf';
		$file_path  .=  '/'.$file_name;
		$pdf->output('F',$file_path);
		return $file_name;
	}
	
	public function amountInWords($amount) {
		$amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
		// Check if there is any number after decimal
		$amt_hundred = null;
		$count_length = strlen($num);
		$x = 0;
		$string = array();
		$change_words = array(0 => '', 1 => 'One', 2 => 'Two',
			3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
			7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
			10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
			13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
			16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
			19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
			40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
			70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
		$here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
		while( $x < $count_length ) {
			$get_divider = ($x == 2) ? 10 : 100;
			$amount = floor($num % $get_divider);
			$num = floor($num / $get_divider);
			$x += $get_divider == 10 ? 1 : 2;
			if ($amount) {
				$add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
				$amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
				$string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.'
		   '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. '
		   '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
			}
			else $string[] = null;
		}
		$implode_to_Rupees = implode('', array_reverse($string));
		$get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . "
	   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
		return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
	}

	public function pdfemail () {
		echo "pdf--email";
	}
}
