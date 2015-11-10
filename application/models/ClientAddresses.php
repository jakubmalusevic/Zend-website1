<?php

    /**
     * @property int $address_id
     * @property string $address
     * @property string $city
     * @property string $state
     * @property string $zip
     * @property float $lat
     * @property float $long
     */
    class ClientAddresses extends Core_ActiveRecord_Row {

        public function __construct($id=null){
            parent::__construct(new ClientAddressesModel(), $id);
        }

    }
    
?>