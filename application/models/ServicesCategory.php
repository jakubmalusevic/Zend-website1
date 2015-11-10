<?php

    /**
     * @property int $category_id
     * @property string $category_name
     */
    class ServicesCategory extends Core_ActiveRecord_Row {

        public function __construct($id=null){
            parent::__construct(new ServicesCategoryModel(), $id);
        }

    }
    
?>