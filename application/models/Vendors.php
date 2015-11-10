<?php

    /**
     * @property int $id
     * @property string $first_name
     * @property string $middle_name
	 * @property string $last_name
     * @property string $email
     * @property string $username
     * @property string $pass
     * @property string $address
	 * @property string $city
	 * @property string $state
     * @property string $zip
     * @property string $mobile
     * @property string $fax
     * @property string $birth_date
     * @property int $max_miles
     * @property string $areas_expertise
	 * @property string $application_notes
     * @property string $creation_date
     * @property string $modification_date
     * @property int $status
     */
    class Vendors extends Core_ActiveRecord_Row {
        protected $_dbModel;
        
        public function __construct($id=null){
            parent::__construct(new VendorsModel(), $id);
        }

        public function setModel($dbTable)
        {
            if (is_string($dbTable)) {
                $dbTable = new $dbTable();
            }
            if (!$dbTable instanceof Zend_Db_Table_Abstract) {
                throw new Exception('Invalid table data gateway provided');
            }
            $this->_dbModel = $dbTable;
            return $this;
        }

        public function getModel()
        {
            if (null === $this->_dbModel) {
                $this->setModel('VendorsModel');
            }
            return $this->_dbModel;
        }
        
        public function getGrid($limit, $offset, $sort, $dir, $filters){
            return Zend_Json::encode(array(
                'results' => $this->getModel()->fetchAllForGrid($limit, $offset, $sort, $dir, $filters), 
                'totalCount' => $this->getModel()->countAllForGrid($filters),
            ));
        }

    }
    
?>