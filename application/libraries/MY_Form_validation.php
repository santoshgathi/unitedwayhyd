<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

    protected $CI;

    function __construct() {
        parent::__construct();

        $this->CI = & get_instance();
    }

    /*
     * Validations on attributes
     */
    function validate_attributes($k, $attributeInfo){
        $pVal = $_POST[$k];
        if(empty($attributeInfo)){
            return false;
        }
        
        if(!isset($attributeInfo['attribute_name'])){
            return false;
        }
        
        $name = $attributeInfo['attribute_name'];
        $value = $attributeInfo['attribute_value'];
        $default_value = $attributeInfo['attribute_default_value'];
        $fid = $attributeInfo['feature_id'];
        $mandatory = $attributeInfo['mandatory'];
        $type = $attributeInfo['attribute_type'];
        $label = $attributeInfo['attribute_label'];
        $profile = $attributeInfo['profile_type'];
        
        /*
         * Check for mandatory.
         */
        if($mandatory == '1'){
            if(empty($pVal) && $pVal != "0"){
                return $label." is required.";
            }
        }
        
        if(empty($pVal)){
            return "";
        }
        
        switch($name){
            case 'DISPLAYNAME':
                if($this->alpha_numeric_spaces($pVal) == false){
                    return $label." allows only alpha-numeric and spaces.";
                }
                
                if(strlen($pVal) > 30 || strlen($pVal) <3){
                    return "Please enter ".$label." between 3 to 30 characters.";
                }
                break;
            case 'USERNAME':
            case 'CALLERID':
            case 'AUTHNAME':
            case 'XMPPUSERNAME':
            case 'XMPPPROXYUSERNAME':
            case 'XMPPPROXYPASSWORD':
            case 'VMACCOUNT':
            case 'APIUSER':
                if($this->alpha_numeric_underscore($pVal) == false){
                    return $label." allows only alpha-numeric and underscore.";
                }
                
                if(strlen($pVal) > 30 || strlen($pVal) <3){
                    return "Please enter ".$label." between 3 to 30 characters.";
                }
                break;
            case 'KEEPALIVEEXP':
                if($this->is_natural_no_zero($pVal) == false){
                    return "Keep Alive must be an integer.";
                }
                break;
            case 'XMPPPASSWORD':
            case 'PASSWORD':
            case 'APIPASSWORD':
                if(strlen($pVal) > 30 || strlen($pVal) <3){
                    return "Please enter ".$label." between 3 to 30 characters.";
                }
                break;
            case 'XMPPDOMAIN':
            case 'XMPPPROXYHOST':
            case 'DOMAINPROXY':
            case 'STUNSERVER':
                $split = explode(':', $pVal);
                
                if($this->check_valid_ip($split[0]) == false){
                    return $label." is invalid.";
                }
                
                if(isset($split[1])){
                    if(!is_numeric($split[1])){
                        return $label." is invalid port.";
                    }
                    $xport = (int)$split[1];

                    if(strlen($xport) > 65535 || strlen($xport) < 1){
                        return $label." invalid port range.";
                    }
                }
                break;
            case 'VMACCESSCODE':
                if(!preg_match("/^\*([0-9])+$/", $pVal)){
                    return $label." is invalid format. (Ex: *97)";
                }
                
                if(strlen($pVal) > 6 || strlen($pVal) < 1){
                    return "Please enter ".$label." between 3 to 30 digits.";
                }
                break;
            case 'APIURL':
            case 'PUSHURL':
            case 'SIPDOMAIN':
            case 'XMPPFILETRANSDOMAIN':
                if(!$this->check_valid_domain($pVal)){
                    return $label." is invalid format.";
                }
                break;
            default:
                return "";
        }
    }
    
    /**
     * Alpha-numeric-space
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    public function alpha_numeric_underscore($str) {
        $this->CI->form_validation->set_message('alpha_numeric_underscore', 'The %s allows only alpha-numeric and underscore.');
        return (!preg_match("/^([a-z0-9\_])+$/i", $str)) ? FALSE : TRUE;
    }
    
    public function alpha_numeric_space($str) {
        $this->CI->form_validation->set_message('alpha_numeric_underscore', 'The %s allows only alpha-numeric and underscore.');
        return (!preg_match("/^([a-z0-9 ])+$/i", $str)) ? FALSE : TRUE;
    }

    /**
     * Unique except. Check if a specific value is in use except when the value is attached to a specific row ID
     *
     * @param	string
     * @param	field
     * @return	bool
     */
    public function unique_exclude($str, $field) {
        list($table, $column, $fld, $id) = explode(',', $field, 4);

        $this->CI->form_validation->set_message('unique_exclude', 'The %s that you requested is already in use.');

        $query = $this->CI->db->query("SELECT COUNT(*) AS dupe FROM {$this->CI->db->dbprefix($table)} WHERE {$column} = '$str' AND {$fld} <> '{$id}'");
        $row = $query->row();

        return ($row->dupe > 0) ? FALSE : TRUE;
    }

    /**
     * Fraction
     *
     * @access  public
     * @param   string  $str
     * @return  bool
     */
    public function fraction($str) {
        $this->CI->form_validation->set_message('fraction', 'The %s field must be a valid fraction.');

        return (!preg_match("/^(\d++(?! */))? *-? *(?:(\d+) */ *(\d+))?.*$/", $str)) ? FALSE : TRUE;
    }

    /**
     * PCI compliance password
     *
     * @access  public
     * @param   $str
     * @return  bool
     */
    public function pci_password($str) {
        $special = '!@#$%*-_=+.';

        $this->CI->form_validation->set_message('pci_password', 'For PCI compliance, %s must be between 6 and 99 characters in length, must not contain two consecutively repeating characters, contain at least one upper-case letter, at least one lower-case letter, at least one number, and at least one special character (' . $special . ')');

        return (preg_match('/^(?=^.{6,99}$)(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[' . $special . '])(?!.*?(.)\1{1,})^.*$/', $str)) ? TRUE : FALSE;
    }

    /**
     * Required if another field has a value (related fields) or if a field has a certain value
     *
     * @access  public
     * @param   string  $str
     * @param   string  $field
     * @return  bool
     */
    public function required_if($str, $field) {
        list($fld, $val) = explode(',', $field, 2);

        $this->CI->form_validation->set_message('required_if', 'The %s field is required.');

        // $fld is filled out
        if (isset($_POST[$fld])) {
            // Must have specific value
            if ($val) {
                // Not the specific value we are looking for
                if ($_POST[$fld] == $val AND ! $str) {
                    return FALSE;
                }
            }

            return TRUE;
        }

        return FALSE;
    }

    /*
      function to check valid date formar i.e yyyy-mm-dd
     */

    function date_check($date) {
        $yyymmdd = '(19|20)[0-9]{2}[- \/.](0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])';
        if (preg_match("/$yyymmdd$/", $date)) {
            //return TRUE;
            if ($date < date('Y-m-d')) {
                $this->CI->form_validation->set_message('date_check', '%s must be greater than or equal to present date.');
                return FALSE;
            }
            return TRUE;
        } else {
            $this->CI->form_validation->set_message('date_check', 'Please enter yyyy-mm-dd format for %s.');
            return FALSE;
        }
    }

    /*
      function to check the date difference i.e start date < end date
     */

    function compare_dates($StartDate, $EndDate) {
        $date1 = date('Y-m-d', strtotime($StartDate));
        $date2 = date('Y-m-d', strtotime($EndDate));
        if ($date1 > $date2) {
            $this->CI->form_validation->set_message('compare_dates', 'StartDate must be less than EndDate');
            return FALSE;
        }
        return TRUE;
    }

    function set_rules($field, $label = '', $rules = '', $errors = array()) {
        if (count($_POST) === 0 AND count($_FILES) > 0) {//it will prevent the form_validation from working
            //add a dummy $_POST
            $_POST['DUMMY_ITEM'] = '';
            parent::set_rules($field, $label, $rules, $errors = array());
            unset($_POST['DUMMY_ITEM']);
        } else {
            //we are safe just run as is
            parent::set_rules($field, $label, $rules, $errors = array());
        }
    }

    function run($group = '') {
        $rc = FALSE;
        log_message('DEBUG', 'called MY_form_validation:run()');
        if (count($_POST) === 0 AND count($_FILES) > 0) {//does it have a file only form?
            //add a dummy $_POST
            $_POST['DUMMY_ITEM'] = '';
            $rc = parent::run($group);
            unset($_POST['DUMMY_ITEM']);
        } else {
            //we are safe just run as is
            $rc = parent::run($group);
        }

        return $rc;
    }

    /*
     * check valid ip/domain
    */
    public function check_valid_domain($domain)
    { 
        $this->CI->form_validation->set_message('check_valid_domain', 'The %s is invalid.');
        
        $pattern = "/(?:https?:\/\/)?(?:[a-zA-Z0-9.-]+?\.(?:[a-zA-Z])|\d+\.\d+\.\d+\.\d+)/";
        if (!preg_match($pattern, $domain)){
            return FALSE;
        }else
        return TRUE;
    }
    
    /*
     * check valid ip
    */
    public function check_valid_ip($ip)
    { 
        $this->CI->form_validation->set_message('check_valid_ip', 'The %s is invalid.');
        
        if($this->valid_ip($ip)){
            return TRUE;
        }
        return FALSE;
    }

}
