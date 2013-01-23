<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	public function run()
	{
		parent::run();
	}
	
	protected function _initDoctype() {
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->doctype('HTML5');
	}
	
	protected function _initEncoding() {
		mb_internal_encoding("UTF-8");
	}
	
	protected function _initConfig()
	{
		Zend_Registry::set('configs', new Zend_Config($this->getOptions()));
	}
	
	protected function _initSession()
	{
		$session = new Zend_Session_Namespace('inssetAirline', true);
		return $session;
	}

    protected function _initPagination(){
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('drh/pagination.phtml');
    }

	protected function _initDb()
	{
		$db = Zend_Db::factory(Zend_Registry::get('configs')->database);
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
		Zend_Registry::set('db', $db);
	}
	
	
}


