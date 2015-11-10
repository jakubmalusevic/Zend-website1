<?php

    /**
     * @property int $id
     * @property string $username
     * @property string $pass
     * @property string $first_name
     * @property string $last_name
     */
    class Adminusers extends Core_ActiveRecord_Row {

        public function __construct($id=null){
            parent::__construct(new AdminusersModel(), $id);
        }
        
        // for login
        public function authenticate($username, $pass){
            $db = Zend_Db_Table::getDefaultAdapter();
            $result = $db->query('SELECT * FROM `adminusers` WHERE username = ? AND pass = ?', array($username, md5($pass)))->fetch();
            $user = null;
            if ( !empty($result) ) {
                $user = new Adminusers($result['id']);
            }
            return $user;
        }

    }
    
?>