<?php

    /**
     * @property int $service_id
     * @property string $service_name
     * @property string $description
     * @property int $category_id
     */
    class ServicesAddresses extends Core_ActiveRecord_Row {

        public function __construct($id=null){
            parent::__construct(new ServicesModel(), $id);
        }

    }
    
?>