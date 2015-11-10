<?php

class Admin_IndexController extends Jaycms_Controller_Action
{                                            

 	public function init()
    {
        parent::init();
        $layout = $this->_helper->layout();
        $layout->setLayout('layout-admin');
    }                   
    
    public function indexAction(){         
        if( Utils::adminuser() == null ){
            $this->_redirect('admin/index/login');
        }
    }
    
    public function loginAction(){
        $this->_helper->layout->disableLayout();
        if ( !empty($_POST) ) {
            // disable auto rendering for this action
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->layout->disableLayout();
            
            $username = $this->_getParam('username');
            $pass = $this->_getParam('pass');
            
            $adminModel = new Adminusers();
            $admin = $adminModel->authenticate($username, $pass);
            // if valid user
            if (!empty($admin)) {
                // get session
                $user = new Zend_Session_Namespace('adminuser');
                $user->id = $admin->id;
                $user->username = $admin->username;
                $result["success"] = true;
            } else {
                $result["success"] = false;
                $result["errors"]["reason"] = "Login failed. Try again.";
            }
            echo Zend_Json::encode($result);
        }
    }
    
    public function logoutAction(){
        $user = new Zend_Session_Namespace('adminuser');
        $user->id = null;
        $this->_redirect('admin/index/login');
    }
    
}
