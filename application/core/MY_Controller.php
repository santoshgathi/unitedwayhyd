<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        // check login
        if (!$this->session->userdata('loggedin')) {
            redirect('login/logout');
        }
        // for ajox ignore authorization
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            //ajax call
        } else {
            // This is not an ajax call 
            // check authorization
            if (!$this->check_access($this->router->fetch_class() . '/' . $this->router->fetch_method())) {
                //echo $this->check_access($this->router->fetch_class() . '/' . $this->router->fetch_method());
                redirect('login/logout');
                exit;
            }
        }
    }

    public function user_menu($role) {

        $menu = array(
            // menu for admin role          
            'admin' =>  array(
                'eightyg'=> '80G',
                'donors' => 'Donors',
                //'hyperledger_fabric/design' => 'Fabric Design',
                //'hyperledger_fabric/workflow' => 'Workflow',
                'areas' => 'Areas',
                'expenditures' => 'Expenditures',
                'appointments' => 'Appiontments',
                'users' => 'Users',
                'users/updatemypwd' => 'My Account'
            ),
            // menu for student role
            'employee' => array(
                'appointments' => 'Appiontments',
                'users/updatemypwd' => 'My Account'
                //'#' => 'Blockchain problem solving',
                //'#' => 'Use cases',
            )    
        );
        //return $menu[$role];
        return $this->build_menu($menu[$role]);
    }

    private function build_menu($menu_items) {
        $menu = "";
        $icon = ['eightyg' => 'copy', 'donors' => 'user-friends', 'areas' => 'map-marker-alt', 'expenditures' => 'money-bill-alt', 'appointments' => 'clock', 'users' => 'users', 'users/updatemypwd' => 'user'];
        foreach($menu_items as $k => $v) {
            $menu = $menu.'<li class="nav-item">';
            $menu = $menu.anchor($k, '<i class="nav-icon fas fa-'.$icon[$k].'"></i><p>'.$v.'</p>', 'class="nav-link"');
            $menu = $menu.'</li>';
        }
        return $menu;
    }

    private function check_access($resource) {
        $acl = array(
            'admin' => array(
                'welcome/index',
                'eightyg/index', 'eightyg/create', 'eightyg/update', 'eightyg/fileupload', 'eightyg/do_upload',
                'eightyg/delete', 
                'donors/index', 'donors/create', 'donors/update', 
                'areas/index', 'areas/create', 'areas/update', 
                'expenditures/index', 'expenditures/create', 'expenditures/update', 'expenditures/delete', 
                'appointments/index', 'appointments/approve', 'appointments/create',
                'users/index', 'users/create', 'users/update', 'users/updateuserpwd', 'users/updatemypwd',               
            ),
            'employee' => array(
                'welcome/index',
                'appointments/index', 'appointments/create', 
                'users/updatemypwd',
            ),
            'student' => array(
                'welcome/index',
                'myaccount/index', 'myaccount/password',
                'blockchain/index', 'blockchain/distributed_network', 'blockchain/introduction',
                'blockchain/how_works', 'blockchain/types','blockchain/risks',
                'blockchain/cryptography',
            ),
        );
        return in_array($resource, $acl[$this->session->userdata('user_role')]);
    }

    public function pagination_config_array($url, $per_page = 25) {
        return array('base_url' => base_url() . $url,
            'page_query_string' => TRUE,
            'reuse_query_string' => TRUE,
            //'use_page_numbers' => TRUE,
            'full_tag_open' => '<ul class="pagination justify-content-center animation">',
            'full_tag_close' => '</ul>',
            'first_tag_open' => '<li class="page-item rounded-2">',
            'first_tag_close' => '</li>',
            'last_tag_open' => '<li class="page-item rounded-2">',
            'last_tag_close' => '</li>',
            'next_tag_open' => '<li class="page-item rounded-2">',
            'next_tag_close' => '</li>',
            'prev_tag_open' => '<li class="page-item rounded-2">',
            'prev_tag_close' => '</li>',
            'cur_tag_open' => '<li  class="page-item rounded-2 active"><a href="#" class="page-link">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>',
            'attributes' => array('class' => 'page-link'),
            'per_page' => $per_page);
    }

    public function pagination_summary($startRow, $perPage, $totalRows) {

        if ((int) ($totalRows) > 0) {
            $endRow = 0;
            if ((int) ($startRow + $perPage) > (int) $totalRows) {
                $endRow = $totalRows;
            } else {
                $endRow = $startRow + $perPage;
            }
            return 'Showing ' . ($startRow + 1) . ' to ' . $endRow . ' of ' . $totalRows . ' entries';
        } else {
            return 'No Records';
        }
    }

    public function send_email($message, $to_address, $to_username, $subject, $attachment = "") {
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
		//$mail->addReplyTo('admin@unitedwayhyderabad.org', 'UWH');

		//$mail->addCC('suresh@unitedwayhyderabad.org');
        
		//Set who the message is to be sent to
		$mail->addAddress($to_address, $to_username);
		
		//Set the subject line
		$mail->Subject = $subject;

		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML($message);

		//Replace the plain text body with one created manually
		//$mail->AltBody = 'This is a plain-text message body';

        //Attach an image file
        if($attachment) {            
            $mail->addAttachment($attachment);
        }

		$email_status = false;

		//send the message, check for errors
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			$email_status =  true;
			//log_message('info', 'Appointment Email Success : '.$details->appointment_date);
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
}