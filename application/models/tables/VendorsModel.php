<?php

    class VendorsModel extends Jaycms_Db_Model {

        protected $_name = 'vendors';
        
        public function fetchAllForGrid($limit, $offset, $sort, $dir, $filters)
        {
            $select = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name)
                ->limit($limit, $offset);

            // ext.js sort feature
            //$select->order(new Zend_Db_Expr($sort . ' ' . $dir));

            // prepare ext.js filtering
            $select = $this->_prepareFiltering($filters, $select);

            return $select->query(Zend_Db::FETCH_OBJ)->fetchAll();
        }

        public function countAllForGrid($filters)
        {
            $select = $this->select()
                ->setIntegrityCheck(false)
                ->from($this->_name, array('count' => new Zend_Db_Expr('COUNT(*)')))
                ->limit(1);

            // prepare filtering
            $select = $this->_prepareFiltering($filters, $select);

            $row = $this->fetchRow($select);

            return $row['count'];
        }
        
    }
    
?>