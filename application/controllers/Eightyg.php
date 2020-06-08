<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH .'third_party/fpdf/fpdf.php');
require(APPPATH .'third_party/phpmailer/PHPMailerAutoload.php');;
//Import PHPMailer classes into the global namespace
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;

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
		$this->viewData['size'] = $size = $this->input->get('size') ? $this->input->get('size') : 10;
		$page = $this->input->get('per_page') ? $this->input->get('per_page') : 0;
		$config = $this->pagination_config_array('/index.php/eightyg/index/', $size);
		$config['total_rows'] = $this->eightyg_model->get_entries('count', 0, 0);
		$this->viewData['eightyg_data'] = $this->eightyg_model->get_entries('rows', $page, $config['per_page']);
		//print_r($this->viewData['eightyg_data']);
		$this->pagination->initialize($config);
		$this->viewData['paginationSummary']  = $this->pagination_summary($page, $config['per_page'], $config['total_rows']);

		$this->viewData['email_status'] = '';
		$this->form_validation->set_rules('eightysubmit', 'Form submit', 'required');
		if ($this->form_validation->run() === FALSE) {
		} else {
			// form submit
			// get the check boxes ids
			$eightyg_ids = $this->input->post('eightyg_ids');
			//print_r($eightyg_ids);
			$count_ids = count((array)$eightyg_ids);
			for ($i=0; $i < $count_ids; $i++) { 
				//print_r($this->viewData['eightyg_data'][$i]);
				$file_80g = $this->generate80G_PDF($this->viewData['eightyg_data'][$i]);				
				$this->eightyg_model->update_80g_file_status($this->viewData['eightyg_data'][$i]->id,$file_80g);
				$email_status = $this->sendemail($this->viewData['eightyg_data'][$i]);
				if($email_status) {
					$this->eightyg_model->update_80g_email_status($this->viewData['eightyg_data'][$i]->id);
					$this->viewData['email_status'] = 'Email Sent';
				}				
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
					$excel_receipt_no = $v['A'];
					$excel_donor_name = $v['C'];
					$excel_address1 = $v['D'];
					$excel_address2 = $v['E'];
					$excel_city = $v['F'];
					$excel_pan_no = $v['G'];
					$excel_email = $v['H'];
					$excel_sum_monthly_contribution=str_replace(",", "", $v['I']);
					$excel_amount_in_words = $v['J'];
					$excel_trns_date = date('Y-m-d H:i:s', strtotime($v['K']));
					$excel_ref_details = $v['L'];
					$excel_bank = $v['M'];
					$excel_donation_cause = $v['N'];
					$created_on = date('Y-m-d H:i:s');

					$excel_data = array('receipt_no' => $excel_receipt_no, 'donor_name' => $excel_donor_name, 'pan_no'=> $excel_pan_no, 'email' => $excel_email, 'sum_monthly_contribution' => $excel_sum_monthly_contribution, 'amount_in_words' => $excel_amount_in_words, 'trns_date' => $excel_trns_date, 'ref_details' => $excel_ref_details, 'bank' => $excel_bank, 'pdf_80g' => 'NA', 'address1' => $excel_address1, 'address2' => $excel_address2, 'city' => $excel_city, 'donation_cause' => $excel_donation_cause, 'sent_email' => 'No', 'created_on' => $created_on);
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

	// public function generatepdf ($data) {
	// 	$details['firstname'] = 'first';
	// 	$details['lastname'] = '';
	// 	$details['city'] = 'hyd';
	// 	$details['state'] = 'ap';
	// 	$details['pan'] = 'pan1';
	// 	$details['amount'] = '321.12';
	// 	$this->generate80G_PDF($details, '123', 'Donation towards COVID-19 Relief Work');
	// }
	
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
		$pdf->Cell(50,0,'Ref No:  '.$details->ref_details);
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
		return $file_name;
	}

	public function sendemail($details) {
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
		/*
		* This example shows settings to use when sending via Google's Gmail servers.
		* The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
		*/

		//SMTP needs accurate times, and the PHP time zone MUST be set
		//This should be done in your php.ini, but this is how to do it if you don't have access to that
		//date_default_timezone_set('Etc/UTC');

		//Create a new PHPMailer instance
		$mail = new PHPMailer;

		//Tell PHPMailer to use SMTP
		$mail->isSMTP();

		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;

		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';

		//Set the hostname of the mail server
		$mail->Host = 'smtp.gmail.com';
		// use
		// $mail->Host = gethostbyname('smtp.gmail.com');
		// if your network does not support SMTP over IPv6

		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->Port = 587;

		//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPSecure = 'tls';

		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;

		//Username to use for SMTP authentication - use full email address for gmail
		$mail->Username = "noreply@unitedwayhyderabad.org";

		//Password to use for SMTP authentication
		$mail->Password = "<>3rPEr421";

		//Set who the message is to be sent from
		$mail->setFrom('noreply@unitedwayhyderabad.org', 'UWH');

		//Set an alternative reply-to address
		$mail->addReplyTo('admin@unitedwayhyderabad.org', 'UWH');

		//$mail->addCC('suresh@unitedwayhyderabad.org');

		//Set who the message is to be sent to
		$mail->addAddress($details->email, $details->donor_name);
		
		//Set the subject line
		$mail->Subject = "Thank you for your Donation to United Way of Hyderabad";

		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML($message);

		//Replace the plain text body with one created manually
		//$mail->AltBody = 'This is a plain-text message body';

		//Attach an image file
		$mail->addAttachment('80g_certificates/'.$details->receipt_no.'.pdf');

		$email_status = false;

		//send the message, check for errors
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			$email_status =  true;
			//Section 2: IMAP
			//$path = "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail";
			//Tell your server to open an IMAP connection using the same username and password as you used for SMTP
			//$imapStream = imap_open($path, $mail->Username, $mail->Password);
			//$result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
			//imap_close($imapStream);
			//$email_status =  $email_status."Message saved status : ".$result;
		}
		return $email_status;
	}

	//Section 2: IMAP
	//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
	//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
	//You can use imap_getmailboxes($imapStream, '/imap/ssl') to get a list of available folders or labels, this can
	//be useful if you are trying to get this working on a non-Gmail IMAP server.
	public function save_mail($mail) {
		//You can change 'Sent Mail' to any other folder or tag
		$path = "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail";

		//Tell your server to open an IMAP connection using the same username and password as you used for SMTP
		$imapStream = imap_open($path, $mail->Username, $mail->Password);

		$result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
		imap_close($imapStream);

		return $result;
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
