<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	
	protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }

    protected function _initRegistry(){
        $appConfig = $this->getOption('app');
        Zend_Registry::set('config', $appConfig);
    }
    
	protected function _initDatabase ()
    {
        $resource = $this->getPluginResource('multidb');
        $resource->init();
 
        Zend_Registry::set('db1', $resource->getDb('db1'));       
    }
    
	protected function _initAutoload()
	{
        Zend_Loader_Autoloader::getInstance()->registerNamespace('PHPExcel');
		Zend_Controller_Action_HelperBroker::addPath(
        APPLICATION_PATH .'/helpers');		
		 $autoloader = new Zend_Loader_Autoloader_Resource(array(
            'namespace' => 'Default',
            'basePath' => APPLICATION_PATH,
            'resourceTypes' => array(
                'form' => array(
                    'path' => 'forms',
                    'namespace' => 'Form',
                ),
                'model' => array(
                    'path' => 'models',
                    'namespace' => 'Model',
                )
                ,
                'service' => array(
                    'path' => 'services',
                    'namespace' => 'Service',
                ),
            )
        ));
		return $autoloader;
	}
	
	
	protected function _initViewHelpers()
	{
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();
		$view->doctype('XHTML1_STRICT');
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
	}	
	
	
	protected function _initRouting()
   	{
    	 //ROUTES FROM CONFIG FILE
  	}
  	
	protected function _initLocale() {
		//get locale from session
	}
	
	protected function _initTranslate() {
	    // Get Locale
	}
	
	protected function _initCache(){
    	$resource = $this->getPluginResource('cachemanager');
    	$cachemanager = $resource->init();
    	
    	Zend_Registry::set('cachemanager', $cachemanager);
    	Zend_Registry::set('cache', $cachemanager->getCache('general'));
    }
}

function stringify($data){
    if( is_scalar($data) || $data === null ){
        return (string) $data;
    }

    if( is_array($data) ){
        foreach( $data as $key => $val ){
            $data[$key] = stringify($val);
        }
    }

    if( is_object($data) ){
        foreach( $data as $prop => $val ){
            $data->{$prop} = stringify($val);
        }
    }

    return $data;
}

function _t($messageId, $params=array(), $locale = null){
    $module = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
    $filename = dirname(APPLICATION_PATH) . "/cache/" . $module . ".tr.php";

    if( !file_exists($filename) ){
        file_put_contents($filename, serialize(array()));
    }

    $tr = unserialize(file_get_contents($filename));
    $tr[$messageId] = $messageId;
    file_put_contents($filename, serialize($tr));

    return vsprintf(Zend_Registry::get('Zend_Translate')->getAdapter()->translate($messageId), $params);
}

