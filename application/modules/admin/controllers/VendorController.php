<?php

class Admin_VendorController extends Jaycms_Controller_Action
{                                            

 	public function init()
    {
        parent::init();
    }                   
    
    public function indexAction(){
        // disable access if not ajax request
        if (!$this->getRequest()->isXmlHttpRequest()) {
            return $this->_disableIfNotAjaxRequest();
        }

        // disable auto rendering for this action
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        
        $request = $this->getRequest();
        $limit = (int) $request->getParam('limit');
        $start = (int) $request->getParam('start');
        $sorta = json_decode((string) $this->_getParam('sort'));
        $sort = (isset($sorta[1]) ? ((string)$sorta[1]->property) : 'id');
        $dir = (isset($sorta[1]) ? ((string)$sorta[1]->direction) : 'desc');
        $filters = (array) $this->_getParam('filter');
        
        $vendorModel = new Vendors();
        echo $vendorModel->getGrid($limit, $start, $sort, $dir, $filters);
    }
    
    public function approveAction(){         
        $vid = $this->_getParam('vid');
        $v = new Vendors($vid);
        $v->status = Constants::VENDOR_STATUS_APPROVED;
        $v->save();
            
        // Sending mail
        $subject = "GLAM ME";
        $body = "<p>Congratulations! You have been approved! for next step, please click <br/><a href='http://dev.greatnetsolutions.com" . $this->view->baseUrl() . "/vendor/signup/submission/vid/" . $v->id . "'>This Link</a></p>";
        $mail = Mail::factory();
        $mail->setSubject($subject);
        $mail->addTo($v->email);
        $mail->setBodyHtml($body);
        $mail->send();
        
        // Set message 
        $msg = "You approved!";
        $params = array('msg' => $msg);
        $this->_forward('thankyou', 'signup', 'vendor', $params);
    }
    
}