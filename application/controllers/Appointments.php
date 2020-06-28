<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH .'third_party/fpdf/fpdf.php');
require(APPPATH .'third_party/phpmailer/PHPMailerAutoload.php');

class Appointments extends MY_Controller {

	private $headerData = array('page_title'=>'');
	private $viewData=array('view_data'=>'');

	function __construct() { 
		parent::__construct();
		$this->viewData['user_role'] = $this->session->userdata("user_role");
		$this->headerData['menus'] = $this->user_menu($this->viewData['user_role']);
		$this->load->model('appointments_model');		
    } 
	
	public function index() {
		$this->headerData['page_title'] = 'List Appointments';
		$this->load->library('pagination');
		$this->viewData['size'] = $size = $this->input->get('size') ? $this->input->get('size') : 10;
		$page = $this->input->get('per_page') ? $this->input->get('per_page') : 0;
		$config = $this->pagination_config_array('/index.php/appointments/index/', $size);
		$config['total_rows'] = $this->appointments_model->get_appointments('count', 0, 0);
		$this->viewData['view_data']= $this->appointments_model->get_appointments('rows', $page, $config['per_page']);
		$this->pagination->initialize($config);
		$this->viewData['paginationSummary']  = $this->pagination_summary($page, $config['per_page'], $config['total_rows']);
		$this->load->view('header', $this->headerData);
		$this->load->view('appointments/index', $this->viewData);
		$this->load->view('footer');
	}
	
	public function create() {
		$this->headerData['page_title'] = 'Create Appointment';		
		$this->form_validation->set_rules('appointmentdt', 'appointment date', 'required|callback_limit_check'); 
        $this->form_validation->set_rules('purpose', 'Purpose', 'required');     
		if ($this->form_validation->run() === FALSE) {			
			$this->load->view('header', $this->headerData);
			$this->load->view('appointments/create', $this->viewData);
			$this->load->view('footer');
        } else {			
			$data=[
				'appointment_date'=> $this->input->post('appointmentdt'),
				'visit_purpose'=> $this->input->post('purpose'),
				'approval' => 'no',
				'applied_by' => $this->session->userdata("userId"),
				'created_on' => date('Y-m-d H:i:s')
			];			
			$this->appointments_model->insert_entry($data);
			$email_status = $this->sendemail($data);
			redirect('appointments');
		}
	}

	public function limit_check($str)
	{
		$count = $this->appointments_model->limit_check($str);
		if ((int)$count >= 10)
		{
			$this->form_validation->set_message('limit_check', 'Appointments Limit for selected date reached !! please select another date');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function approve($appointment_id) {
		$this->headerData['page_title'] = 'Approve Appointment';	
		$this->viewData['appointment_details'] = $this->appointments_model->get_details($appointment_id);		
		$this->form_validation->set_rules('approve', 'Approve', 'required');
		if ($this->form_validation->run() === FALSE) {			
			$this->load->view('header', $this->headerData);
			$this->load->view('appointments/approve', $this->viewData);
			$this->load->view('footer');
        } else {			
			$data=[
				'approval' => 'yes',
				'approved_by' => $this->session->userdata("userId"),
				'approved_on' => date('Y-m-d H:i:s')
			];			
			$this->appointments_model->update_entry($data, $appointment_id);
			redirect('appointments');
		}
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
			log_message('info', 'Email Success : '.$details->receipt_no);
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
}
?>