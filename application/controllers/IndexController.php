<?php

class IndexController extends Jaycms_Controller_Action
{

 	public function init()
    {
    	parent::init();
    	$this->redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
    }

    public function indexAction()
    {   
    	$this->_redirect('vendor/signup');
    }
    
}

