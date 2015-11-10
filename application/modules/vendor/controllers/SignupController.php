<?php

class Vendor_SignupController extends Jaycms_Controller_Action
{                                            

 	public function init()
    {
        parent::init();
    }                   
    
    public function indexAction(){
        if( !empty($_POST) ){
            $firstname = $this->_getParam('first_name');
            $lastname = $this->_getParam('last_name');
            $email = $this->_getParam('email');
            
            // email validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->view->firstname = $firstname;
                $this->view->lastname = $lastname;
                $this->view->email = $email;
                $this->view->msg = "Invalid email format!";
                return;
            }
            
            // save vendor information
            $v = new Vendors();
            $v->first_name = $firstname;
            $v->last_name = $lastname;
            $v->email = $email;
            $v->creation_date = date('Y-m-j');
            $v->modification_date = date('Y-m-j');
            $v->save();
            
            // Sending mail
            $subject = "GLAM ME";
            $body = "<p>Thank you for your interest in becoming a vendor. In order to fill your information, please click <br/><a href='http://dev.greatnetsolutions.com" . $this->view->baseUrl() . "/vendor/signup/fill/vid/" . $v->id . "'>This Link</a></p>";
            $mail = Mail::factory();
            $mail->setSubject($subject);
            $mail->addTo($email);
            $mail->setBodyHtml($body);
            $mail->send();
            
            // Set message 
            $msg = "Please check your email and click on the verification link provided to continue the application process.";
            $params = array('msg' => $msg);
            $this->_forward('thankyou', 'signup', 'vendor', $params);
        }
    }
    
    public function fillAction(){         
        $vid = $this->_getParam('vid');
        $v = new Vendors($vid);
        if ( !empty($_POST) ) {
            // get form data
            $lastname = $this->_getParam('last_name');
            $email = $this->_getParam('email');
            $phone = $this->_getParam('phone');
            $addr = $this->_getParam('addr');
            $city = $this->_getParam('city');
            $state = $this->_getParam('state');
            $zip = $this->_getParam('zip');
            $max_miles = intval($this->_getParam('max_miles'));
            $areas_expertise = $this->_getParam('areas_expertise');
            
            // save vendor detail
            $v->last_name = $lastname;
            $v->mobile = $phone;
            $v->email = $email;
            $v->address = $addr;
            $v->city = $city;
            $v->state = $state;
            $v->zip = $zip;
            $v->max_miles = $max_miles;
            $v->areas_expertise = $areas_expertise;
            $v->modification_date = date('Y-m-j');
            $v->save();
            
            // credentials upload
            if ( $_FILES['drivers_license']['tmp_name'] != "" ) {
                $tempFile = $_FILES['drivers_license']['tmp_name'];
                $filename = $_FILES['drivers_license']['name'];
                $cr_driver = $this->upload($tempFile, $filename);
                $vc = new VendorsCredentials();
                $vc->vendor_id = $v->id;
                $vc->cred_id = Constants::CR_DRIVER_LICENSE;
                $vc->filename = $cr_driver;
                $vc->save();
            }
            if ( $_FILES['resume']['tmp_name'] != "" ) {
                $tempFile = $_FILES['resume']['tmp_name'];
                $filename = $_FILES['resume']['name'];
                $cr_resume = $this->upload($tempFile, $filename);
                $vc = new VendorsCredentials();
                $vc->vendor_id = $v->id;
                $vc->cred_id = Constants::CR_RESUME;
                $vc->filename = $cr_resume;
                $vc->save();
            }
            if ( $_FILES['cosmetology_license']['tmp_name'] != "" ) {
                $tempFile = $_FILES['cosmetology_license']['tmp_name'];
                $filename = $_FILES['cosmetology_license']['name'];
                $cr_cosmetology = $this->upload($tempFile, $filename);
                $vc = new VendorsCredentials();
                $vc->vendor_id = $v->id;
                $vc->cred_id = Constants::CR_COSMETOLOGY_LICENSE;
                $vc->filename = $cr_cosmetology;
                $vc->save();
            }
            
            // Sending mail
            $subject = "GLAM ME";
            $body = "<p>Vendor is waiting for your approval, in order to approve, please click <br/><a href='http://dev.greatnetsolutions.com" . $this->view->baseUrl() . "/admin/vendor/approve/vid/" . $v->id . "'>This Link</a></p>";
            $mail = Mail::factory();
            $mail->setSubject($subject);
            $mail->addTo(Constants::ADMIN_EMAIL);
            $mail->setBodyHtml($body);
            $mail->send();
            
            // Set message 
            $msg = "Once an administrator has approved your application we will provide you with the next step.";
            $params = array('msg' => $msg);
            $this->_forward('thankyou', 'signup', 'vendor', $params);
        }
        $this->view->vendor = $v;
    }
    
    public function submissionAction(){
        $vid = $this->_getParam('vid');
        $v = new Vendors($vid);
        if ( !empty($_POST) ) {
            $comment = $this->_getParam('comments');
            $v->application_notes = $comment;
            $v->save();
            
            if ( $_FILES['submission']['tmp_name'] != "" ) {
                $tempFile = $_FILES['submission']['tmp_name'];
                $filename = $_FILES['submission']['name'];
                $cr_submission = $this->upload($tempFile, $filename);
                $vc = new VendorsCredentials();
                $vc->vendor_id = $v->id;
                $vc->cred_id = Constants::CR_ESSAY_SUBMISSION;
                $vc->filename = $cr_submission;
                $vc->save();
            }
            // Set message 
            $msg = "Once an administrator has approved your application we will provide you with the next step.";
            $params = array('msg' => $msg);
            $this->_forward('thankyou', 'signup', 'vendor', $params);
        }
        $this->view->vendor = $v;
    }
    
    public function thankyouAction(){
        // set thank you message
        $this->view->msg = $this->_getParam('msg');
    }
    
    private function upload($tempFile, $filename){
        $basePath = realpath(APPLICATION_PATH . '/../public/');
        $crPath = $basePath;
        $crPath .= DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'credentials';
        $savePath = DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'credentials';

        $crPath = str_replace('//', '/', $crPath);
        $crPath = str_replace('\\\\', '\\', $crPath);
        $savePath = str_replace('//', '/', $savePath);
        $savePath = str_replace('\\\\', '\\', $savePath);

        if(!is_dir($crPath)) mkdir($crPath);

        $targetPath = $crPath . DIRECTORY_SEPARATOR . date('Y-m-d');
        $savePath = $savePath . DIRECTORY_SEPARATOR . date('Y-m-d');

        if(!is_dir($targetPath)) mkdir($targetPath);

        $targetFile =  $targetPath . DIRECTORY_SEPARATOR . $filename;
        $savePath = $savePath . DIRECTORY_SEPARATOR . $filename;

        if(file_exists($targetFile)){
            $path_parts = pathinfo($targetFile);
            $pos = strrpos($path_parts['basename'], ".");
            if ($pos === false) {
                $fname = $path_parts['basename'] . '_bak';
            } else {
                $fname = substr($path_parts['basename'], 0, $pos) . '_bak.' . $path_parts['extension'];
            }
            $bakFile = $path_parts['dirname'] . DIRECTORY_SEPARATOR . $fname;
            rename($targetFile, $bakFile);
        }
        move_uploaded_file($tempFile, $targetFile);
        return $savePath;
    }
    
}