<?php

    /**
     * @property int $vendor_id
     * @property int $cred_id
     * @property string $filename
     */
    class VendorsCredentialsAddresses extends Core_ActiveRecord_Row {

        public function __construct($id=null){
            parent::__construct(new VendorsCredentialsModel(), $id);
        }

    }
    
?>