<?php

    /**
     * @property int $id
     * @property string $code
     * @property string $description
     */
    class CredentialsMapAddresses extends Core_ActiveRecord_Row {

        public function __construct($id=null){
            parent::__construct(new CredentialsMapModel(), $id);
        }

    }
    
?>