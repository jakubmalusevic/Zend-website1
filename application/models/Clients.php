<?php

    /**
     * @property int $id
     * @property string $first_name
     * @property string $last_name
     * @property string $email
     * @property string $username
     * @property string $pass
     * @property string $home_phone
     * @property string $mobile_phone
     * @property int $default_address_id
     */
    class Clients extends Core_ActiveRecord_Row {

        public function __construct($id=null){
            parent::__construct(new ClientsModel(), $id);
        }

    }
    
?>