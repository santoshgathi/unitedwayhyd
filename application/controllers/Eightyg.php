<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH .'third_party/fpdf/fpdf.php');
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

	public function generatepdf () {
		$details['firstname'] = 'first';
		$details['lastname'] = 'last';
		$details['city'] = 'hyd';
		$details['state'] = 'ap';
		$details['pan'] = 'pan1';
		$details['amount'] = '321.12';
		$this->generate80G_PDF($details, '123', 'Donation towards COVID-19 Relief Work');
	}
	
	public function generate80G_PDF($details=array(),$trans_id='',$donated_for=''){
		$date   =   date('d-M-Y');
		$name   =   $details['firstname'].'_'.$details['lastname'];
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
		$pdf->Cell(50,0,$details['city']);
		$pdf->SetXY(10,90);
		$pdf->Cell(50,0,$details['state']);
		$pdf->setFont('Arial','B',12);
		$pdf->SetXY(10,95);
		$pdf->Cell(50,0,'PAN: '.$details['pan']);
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
		$pdf->Cell($width_cell[1],10,'Rs. '.$details['amount'],1,1,'C',false);
		$pdf->Cell($width_cell[0],10,'Amount in Words: ',1,0,'C',false);
		$pdf->Cell($width_cell[1],10,$this->amountInWords((float)$details['amount']),1,1,'C',false);
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
		$file_name  =   $name.$date.$trans_id.'.pdf';
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
}
